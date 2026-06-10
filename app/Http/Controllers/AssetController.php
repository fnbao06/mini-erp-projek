<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::latest('purchase_date')->get();

        // Calculate summary statistics
        $nilai_aset_aktif = Asset::where('status', 'owned')->sum('purchase_price');
        $total_penjualan = Asset::where('status', 'sold')->sum('sale_price');
        
        // Sum (sale_price - purchase_price) for all sold assets
        $total_keuntungan = Asset::where('status', 'sold')->get()->sum(function ($asset) {
            return $asset->sale_price - $asset->purchase_price;
        });

        return view('assets', compact('assets', 'nilai_aset_aktif', 'total_penjualan', 'total_keuntungan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validateWithBag('create', [
            'name'           => 'required|string|max:255',
            'purchase_date'  => 'required|date',
            'purchase_price' => 'required|numeric|min:1',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // 1. Get or create the expense category "Pembelian Aset"
                $category = Category::firstOrCreate(
                    ['cat_name' => 'Pembelian Aset'],
                    ['type' => 'expense']
                );

                // 2. Create the associated cash outflow transaction
                $transaction = Transaction::create([
                    'trans_date'  => $validated['purchase_date'],
                    'desc'        => 'Pembelian Aset: ' . $validated['name'],
                    'amount'      => $validated['purchase_price'],
                    'category_id' => $category->id,
                ]);

                // 3. Create the asset in inventory
                Asset::create([
                    'name'                    => $validated['name'],
                    'purchase_date'           => $validated['purchase_date'],
                    'purchase_price'          => $validated['purchase_price'],
                    'purchase_transaction_id' => $transaction->id,
                    'status'                  => 'owned',
                ]);
            });

            return redirect()->back()->with('success', 'Aset baru berhasil ditambahkan ke inventory dan kas berkurang!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors(['db_error' => 'Terjadi kesalahan sistem saat menyimpan aset.'], 'create');
        }
    }

    public function sell(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

        $validated = $request->validateWithBag('sell', [
            'sale_date'  => 'required|date|after_or_equal:' . $asset->purchase_date,
            'sale_price' => 'required|numeric|min:1',
        ]);

        try {
            DB::transaction(function () use ($validated, $asset) {
                // 1. Get or create the income category "Penjualan Aset"
                $category = Category::firstOrCreate(
                    ['cat_name' => 'Penjualan Aset'],
                    ['type' => 'income']
                );

                // 2. Create the associated cash inflow transaction
                $transaction = Transaction::create([
                    'trans_date'  => $validated['sale_date'],
                    'desc'        => 'Penjualan Aset: ' . $asset->name,
                    'amount'      => $validated['sale_price'],
                    'category_id' => $category->id,
                ]);

                // 3. Update the asset details
                $asset->update([
                    'sale_date'           => $validated['sale_date'],
                    'sale_price'          => $validated['sale_price'],
                    'sale_transaction_id' => $transaction->id,
                    'status'              => 'sold',
                ]);
            });

            return redirect()->back()->with('success', 'Aset berhasil terjual dan kas bertambah!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors(['db_error' => 'Terjadi kesalahan sistem saat memproses penjualan.'], 'sell');
        }
    }

    public function destroy($id)
    {
        try {
            $asset = Asset::findOrFail($id);

            DB::transaction(function () use ($asset) {
                // Delete associated transactions if they exist
                if ($asset->purchaseTransaction) {
                    $asset->purchaseTransaction->delete();
                }
                if ($asset->saleTransaction) {
                    $asset->saleTransaction->delete();
                }
                
                $asset->delete();
            });

            return redirect()->back()->with('success', 'Aset dan transaksi terkait berhasil dihapus dari sistem!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus aset dari sistem.');
        }
    }
}
