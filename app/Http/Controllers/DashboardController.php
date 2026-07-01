<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $pemasukkan = Transaction::whereHas('category', function($q){
            $q->where('type', 'income');
        })->sum('amount');

        $pengeluaran = Transaction::whereHas('category', function($q){
            $q->where('type', 'expense');
        })->sum('amount');

        $total_saldo = $pemasukkan - $pengeluaran;

        $recent_transaction = Transaction::with('category')->latest()->take(5)->get();

        // Ambil semua transaksi dengan relasi kategorinya untuk dikelompokkan oleh JS di frontend
        $allTransactions = Transaction::with('category')->orderBy('trans_date', 'asc')->get();

        return view('dashboard', compact('total_saldo', 'pemasukkan', 'pengeluaran', 'recent_transaction', 'allTransactions'));
    }
}
