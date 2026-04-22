<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class DashboardController extends Controller
{
    public function index(){
        // $data = [
        //     'total_saldo' => 5000000,
        //     'pemasukkan' => 10000000,
        //     'pengeluaran' => 50000,
        //     'recent_transaction' => [
        //         ['Tanggal' => '01 Mar 2026', 'Deskripsi' => 'Gaji Bulanan','Nominal' => 50000, 'Kategori' => 'Gaji', 'Tipe' => 'Income'],
        //         ['Tanggal' => '02 Mar 2026', 'Deskripsi' => 'Makan Nasi Padang','Nominal' => 15000, 'Kategori' => 'Makan', 'Tipe' => 'Expense'],
        //         ['Tanggal' => '03 Mar 2026', 'Deskripsi' => 'Donasi Wilbert Poke','Nominal' => 1000000, 'Kategori' => 'Sumbangan', 'Tipe' => 'Expense']
        //     ]
        // ];
        $pemasukkan = Transaction::whereHas('category', function($q){
            $q->where('type', 'income');
        })->sum('amount');

        $pengeluaran = Transaction::whereHas('category', function($q){
            $q->where('type', 'expense');
        })->sum('amount');

        $total_saldo = $pemasukkan - $pengeluaran;

        $recent_transaction = Transaction::with('category')->latest()->take(5)->get();

        // Ambil semua transaksi untuk Python
        $allTransactions = Transaction::join('categories', 'transactions.category_id', '=', 'categories.id')
            ->select('transactions.amount', 'transactions.trans_date', 'categories.type', 'categories.cat_name as category')
            ->get();

        $process = new Process([
            'python',
            base_path('app/Scripts/dashboard_analytics.py'),
            json_encode($allTransactions)
        ]);

        $process->setEnv(['HOME' => base_path('storage/framework/cache')]);
        $process->run();

        $output = $process->getOutput();
        $charts = json_decode($output, true);

        return view('dashboard', [
            'total_saldo' => $total_saldo,
            'pemasukkan' => $pemasukkan,
            'pengeluaran' => $pengeluaran,
            'recent_transaction' => $recent_transaction,
            'flowChart' => $charts['flow'] ?? '',
            'categoryChart' => $charts['category'] ?? ''
        ]);

    }
}
