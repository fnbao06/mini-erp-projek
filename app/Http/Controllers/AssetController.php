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
        $validator = Validator::make($request->all(), [
            'name'           => 'required|string|max:255',
            'purchase_date'  => 'required|date',
            'purchase_price' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_mode', 'create');
        }

        try {
            DB::transaction(function () use ($request) {
                // 1. Get or create the expense category "Pembelian Aset"
                $category = Category::firstOrCreate(
                    ['cat_name' => 'Pembelian Aset'],
                    ['type' => 'expense']
                );

                // 2. Create the associated cash outflow transaction
                $transaction = Transaction::create([
                    'trans_date'  => $request->purchase_date,
                    'desc'        => 'Pembelian Aset: ' . $request->name,
                    'amount'      => $request->purchase_price,
                    'category_id' => $category->id,
                ]);

                // 3. Create the asset in inventory
                Asset::create([
                    'name'                    => $request->name,
                    'purchase_date'           => $request->purchase_date,
                    'purchase_price'          => $request->purchase_price,
                    'purchase_transaction_id' => $transaction->id,
                    'status'                  => 'owned',
                ]);
            });

            return redirect()->back()->with('success', 'Aset baru berhasil ditambahkan ke inventory dan kas berkurang!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan sistem saat menyimpan aset.')
                ->with('error_mode', 'create');
        }
    }

    public function sell(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'sale_date'  => 'required|date|after_or_equal:' . $asset->purchase_date,
            'sale_price' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_mode', 'sell')
                ->with('sell_id', $id);
        }

        try {
            DB::transaction(function () use ($request, $asset) {
                // 1. Get or create the income category "Penjualan Aset"
                $category = Category::firstOrCreate(
                    ['cat_name' => 'Penjualan Aset'],
                    ['type' => 'income']
                );

                // 2. Create the associated cash inflow transaction
                $transaction = Transaction::create([
                    'trans_date'  => $request->sale_date,
                    'desc'        => 'Penjualan Aset: ' . $asset->name,
                    'amount'      => $request->sale_price,
                    'category_id' => $category->id,
                ]);

                // 3. Update the asset details
                $asset->update([
                    'sale_date'           => $request->sale_date,
                    'sale_price'          => $request->sale_price,
                    'sale_transaction_id' => $transaction->id,
                    'status'              => 'sold',
                ]);
            });

            return redirect()->back()->with('success', 'Aset berhasil terjual dan kas bertambah!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan sistem saat memproses penjualan.')
                ->with('error_mode', 'sell')
                ->with('sell_id', $id);
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
