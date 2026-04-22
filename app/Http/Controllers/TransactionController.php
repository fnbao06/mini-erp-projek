<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function Transaction(){
        $transactions = Transaction::latest('trans_date')->get();

        $categories = Category::all();

        return view('transactions', compact('transactions', 'categories'));
    }

    public function Store(Request $request){
        $validated = $request->validate([
            'trans_date' => 'required|date',
            'desc' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'category_id' => 'required|exists:categories,id'
        ]);

        Transaction::create($validated);

        return redirect()->route('transactions')->with('success', 'Transaksi Berhasil Ditambahkan!');
    }
}
