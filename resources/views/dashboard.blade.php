@extends('layouts.app')
@section('title', 'Dashboard - ')
@section('header', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm font-semibold border border-gray-100">
            <p class="text-sm text-gray-500 uppercase font-semibold text mb-2">Total Saldo</p>
            <h3 class="text-2xl font-bold text-blue-400">Rp 5,000,000</h3>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm font-semibold border border-gray-100">
            <p class="text-sm text-green-500 uppercase font-semibold text mb-2">Pemasukkan</p>
            <h3 class="text-2xl font-bold text-green-600">Rp 50,000,000</h3>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm font-semibold border border-gray-100">
            <p class="text-sm text-red-500 uppercase font-semibold text mb-2">Pengeluaran</p>
            <h3 class="text-2xl font-bold text-red-600">Rp 5,000,000</h3>
        </div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm font-semibold border border-gray-100">
        <h3 class="text-sm text-gray-500 uppercase font-semibold text mb-2">Transaksi Terakhir</h3>
        <p class="text-2xl font-bold text-gray-900">Belum ada histori</p>
    </div>
@endsection
