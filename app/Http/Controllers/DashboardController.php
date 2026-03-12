<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $data = [
            'total_saldo' => 5000000,
            'pemasukkan' => 10000000,
            'pengeluaran' => 50000,
            'recent_transaction' => [
                ['Tanggal' => '01 Mar 2026', 'Deskripsi' => 'Gaji Bulanan','Nominal' => 50000, 'Kategori' => 'Gaji', 'Tipe' => 'Income'],
                ['Tanggal' => '02 Mar 2026', 'Deskripsi' => 'Makan Nasi Padang','Nominal' => 15000, 'Kategori' => 'Makan', 'Tipe' => 'Expense'],
                ['Tanggal' => '03 Mar 2026', 'Deskripsi' => 'Donasi Wilbert Poke','Nominal' => 1000000, 'Kategori' => 'Sumbangan', 'Tipe' => 'Expense']
            ]
        ];
        return view('dashboard', $data);
    }
}
