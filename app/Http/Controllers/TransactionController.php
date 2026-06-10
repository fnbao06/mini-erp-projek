<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        ]);

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
        ]);

        try {
            $transaction = Transaction::findOrFail($id);
            $transaction->update($validated);

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
        $transaction->delete();

        return redirect()->back()
                         ->with('success', 'Transaksi berhasil dihapus!');
    }
}
