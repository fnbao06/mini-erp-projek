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
}
