@extends('layouts.app')
@section('title', 'Dashboard - ')
@section('header', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm font-semibold border border-gray-100">
            <p class="text-sm text-gray-500 uppercase font-semibold text mb-2">Total Saldo</p>
            <h3 class="text-2xl font-bold text-blue-400">Rp {{ number_format($total_saldo, 2, ',', '.') }}</h3>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm font-semibold border border-gray-100">
            <p class="text-sm text-green-500 uppercase font-semibold text mb-2">Pemasukkan</p>
            <h3 class="text-2xl font-bold text-green-600">Rp {{ number_format($pemasukkan, 2, ',', '.') }}</h3>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm font-semibold border border-gray-100">
            <p class="text-sm text-red-500 uppercase font-semibold text mb-2">Pengeluaran</p>
            <h3 class="text-2xl font-bold text-red-600">Rp {{ number_format($pengeluaran, 2, ',', '.') }}</h3>
        </div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm font-semibold border border-gray-100">
        <h3 class="text-sm text-gray-500 uppercase font-semibold text mb-2">Transaksi Terakhir</h3>
        @if ($recent_transaction)
            @foreach ($recent_transaction as $trx)
            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                <div>
                    <p  class="font-medium text-gray-700">{{ $trx['Deskripsi'] }}</p>
                    <p class="text-xs text-gray-400">{{ $trx['Tanggal'] }}</p>
                </div>
                <p class="font-bold text-{{ $trx['Tipe'] == 'Income' ? 'green' : 'red'}}-600">
                    Rp {{ number_format($trx['Nominal'], 2, ',', '.') }}
                </p>
            </div>
        @endforeach
        @else
            <p class="text-2xl font-bold text-gray-900">Belum ada histori</p>
        @endif
    </div>
@endsection
