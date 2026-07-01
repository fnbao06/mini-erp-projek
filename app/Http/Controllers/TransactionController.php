<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function Transaction(){
        $transactions = Transaction::latest('trans_date')->get();

        $categories = Category::all();

        return view('transactions', compact('transactions', 'categories'));
    }

    public function Store(Request $request){
        // 1. Validasi menggunakan validateWithBag
        $validated = $request->validateWithBag('transaction', [
            'trans_date'  => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'desc'        => 'required|string|max:255',
            'amount'      => 'required|numeric|min:1',
            'receipt'     => 'nullable|file|mimes:png,jpeg,jpg,pdf|max:5120'
        ]);

        if ($request->hasFile('receipt')){
            $path = $request->file('receipt')->store('receipts');

            $validated['receipt_path'] = $path;
        }

        try {
            // 2. Simpan data
            Transaction::create($validated);

            return redirect()->back()
                            ->with('success', 'Transaksi baru berhasil ditambahkan!');

        } catch (\Exception $e) {
            return back()->withInput()
                        ->withErrors(['db_error' => 'Terjadi kesalahan sistem saat menyimpan data.'], 'transaction');
        }
    }

    public function Edit($id)
    {
        $transactions = Transaction::findOrFail($id);
        return response()->json($transactions);
    }

    public function Update(Request $request, $id)
    {
        // 1. Validasi menggunakan validateWithBag
        $validated = $request->validateWithBag('transaction', [
            'trans_date'  => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'desc'        => 'required|string|max:255',
            'amount'      => 'required|numeric|min:1',
            'receipt'     => 'nullable|file|mimes:png,jpeg,jpg,pdf|max:5120'
        ]);

        try {
            $transaction = Transaction::findOrFail($id);

            if ($request->hasFile('receipt')){
                if ($transaction->receipt_path && Storage::exists($transaction->receipt_path)){
                    Storage::delete($transaction->receipt_path);
                }
                $path = $request->file('receipt')->store('receipts');
                $validated['receipt_path'] = $path;
            }

            DB::transaction(function () use ($transaction, $validated) {
                $transaction->update($validated);

                if ($transaction->purchaseAsset) {
                    $transaction->purchaseAsset->update([
                        'purchase_price' => $validated['amount'],
                        'purchase_date'  => $validated['trans_date'],
                    ]);
                }

                if ($transaction->saleAsset) {
                    $transaction->saleAsset->update([
                        'sale_price' => $validated['amount'],
                        'sale_date'  => $validated['trans_date'],
                    ]);
                }
            });

            // Ubah dari redirect()->route(...) menjadi redirect()->back()
            return redirect()->back()
                            ->with('success', 'Transaksi berhasil diperbarui!');
                                
        } catch (\Exception $e) {
            return back()->withInput()
                        ->withErrors(['db_error' => 'Terjadi kesalahan sistem saat memperbarui data.'], 'transaction');
        }
    }

    public function Destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        
        try {
            DB::transaction(function () use ($transaction) {
                // If deleting the purchase transaction, delete the asset too
                if ($transaction->purchaseAsset) {
                    $asset = $transaction->purchaseAsset;
                    if ($asset->saleTransaction) {
                        $asset->saleTransaction->delete();
                    }
                    $asset->delete();
                }

                // If deleting the sale transaction, revert the asset status to 'owned'
                if ($transaction->saleAsset) {
                    $transaction->saleAsset->update([
                        'sale_date'           => null,
                        'sale_price'          => null,
                        'sale_transaction_id' => null,
                        'status'              => 'owned',
                    ]);
                }

                if ($transaction->receipt_path && Storage::exists($transaction->receipt_path)){
                    Storage::delete($transaction->receipt_path);
                }
                
                $transaction->delete();
            });

            return redirect()->back()
                             ->with('success', 'Transaksi berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', 'Terjadi kesalahan sistem saat menghapus transaksi.');
        }
    }

    public function showReceipt(Transaction $transaction){
        if(!$transaction->receipt_path || !Storage::exists($transaction->receipt_path)){
            abort(404);
        }

        return response()->file(Storage::path($transaction->receipt_path));
    }
}
