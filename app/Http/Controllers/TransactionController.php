<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function Transaction(){
        $transactions = Transaction::all();

        return view('transactions', compact('transactions'));
    }

    public function Store(Request $request){
        $validated = $request->validate([
            'trans_date' => 'required|date',
            'desc' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'category_id' => 'required|exist:categories,id'
        ]);

        Transaction::create($validated);

        return redirect()->route('dashboard')->with('success', 'Transaksi Berhasil Ditambahkan!');
    }
}
