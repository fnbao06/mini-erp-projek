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
        // 1. Validasi input secara manual
        $validator = Validator::make($request->all(), [
            'trans_date'  => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'desc'        => 'required|string|max:255',
            'amount'      => 'required|numeric|min:1',
        ]);

        // 2. Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_mode', 'create'); // Sinyal agar modal "Create" terbuka lagi
        }

        try {
            // 3. Simpan data
            Transaction::create($validator->validated());

            return redirect()->back()
                            ->with('success', 'Transaksi baru berhasil ditambahkan!');

        } catch (\Exception $e) {
            return back()->withInput()
                        ->with('error', 'Terjadi kesalahan sistem saat menyimpan data.')
                        ->with('error_mode', 'create');
        }
    }

    public function Edit($id)
    {
        $transactions = Transaction::findOrFail($id);
        return response()->json($transactions);
    }

    public function Update(Request $request, $id)
    {
        // 1. Gunakan Validator manual agar kita bisa menangkap kegagalan validasi
        $validator = Validator::make($request->all(), [
            'trans_date'  => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'desc'        => 'required|string|max:255',
            'amount'      => 'required|numeric|min:1',
        ]);

        // 2. Jika validasi gagal, kirimkan 'error_mode' dan 'edit_id'
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_mode', 'edit') // Sinyal untuk JS
                ->with('edit_id', $id);      // ID agar data di-fetch ulang
            }

        try {
            $transaction = Transaction::findOrFail($id);
            $transaction->update($validator->validated());

            return redirect()->route('transactions.index')
                            ->with('success', 'Transaksi berhasil diperbarui!');
                                
        } catch (\Exception $e) {
            // Ini untuk error sistem (misal: database down)
            return back()->withInput()
                        ->with('error', 'Terjadi kesalahan sistem.')
                        ->with('error_mode', 'edit')
                        ->with('edit_id', $id);
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
