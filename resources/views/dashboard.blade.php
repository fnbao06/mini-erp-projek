@extends('layouts.app')
@section('title', 'Dashboard - ')
@section('header', 'Dashboard Utama')

@section('content')
<div class="w-full max-w-7xl mx-auto py-4 space-y-6">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-2">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Selamat datang kembali, Sifen! 👋</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Berikut adalah ringkasan keuangan Anda saat ini.</p>
        </div>
        <button class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-sm font-semibold rounded-xl shadow-sm hover:bg-gray-800 dark:hover:bg-gray-100 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
            Unduh Laporan
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-6 text-white shadow-xl shadow-blue-500/20 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white/10 blur-2xl"></div>
            <div class="relative z-10">
                <p class="text-blue-100 font-medium mb-1">Total Saldo Saat Ini</p>
                <h3 class="text-3xl lg:text-4xl font-bold tracking-tight mb-4">Rp {{ number_format($total_saldo, 2, ',', '.') }}</h3>
                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/20 backdrop-blur-md text-xs font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5 text-emerald-300">
                        <path fill-rule="evenodd" d="M10 17a.75.75 0 0 1-.75-.75V5.612L5.29 9.77a.75.75 0 0 1-1.08-1.04l5.25-5.5a.75.75 0 0 1 1.08 0l5.25 5.5a.75.75 0 1 1-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0 1 10 17Z" clip-rule="evenodd" />
                    </svg>
                    <span>Ter-update</span>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-center">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pemasukan</p>
                <div class="p-2 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 4.5l-15 15m0 0h11.25m-11.25 0V8.25" /></svg>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($pemasukkan, 2, ',', '.') }}</h3>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-center">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pengeluaran</p>
                <div class="p-2 bg-red-50 dark:bg-red-500/10 text-red-600 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25" /></svg>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($pengeluaran, 2, ',', '.') }}</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Arus Kas</h3>
                    <select class="text-sm bg-gray-50 dark:bg-gray-700 border-none rounded-lg focus:ring-0 text-gray-600 dark:text-gray-300 py-1.5 px-3">
                        <option>Bulan Ini</option>
                        <option>Tahun Ini</option>
                    </select>
                </div>
                <div class="w-full h-64 bg-gray-50/50 dark:bg-gray-700/20 rounded-xl border border-dashed border-gray-200 dark:border-gray-600 flex items-center justify-center">
                    <p class="text-sm text-gray-400 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" /></svg>
                        Area Chart (Chart.js / ApexCharts)
                    </p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Transaksi Terakhir</h3>
                    <a href="{{ route('transactions') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">Lihat Semua &rarr;</a>
                </div>
                
                <div class="space-y-2">
                    @forelse ($recent_transaction as $trx)
                        <div class="flex items-center justify-between p-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-xl transition-colors">
                            <div class="flex items-center gap-4">
                                @if(strtolower($trx['Tipe']) == 'income')
                                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                @else
                                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.999 2.999 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.999 2.999 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" /></svg>
                                    </div>
                                @endif
                                
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $trx['Deskripsi'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $trx['Tanggal'] }}</p>
                                </div>
                            </div>
                            
                            <span class="text-sm font-bold {{ strtolower($trx['Tipe']) == 'income' ? 'text-emerald-600' : 'text-gray-900 dark:text-white' }}">
                                {{ strtolower($trx['Tipe']) == 'income' ? '+' : '-' }} Rp {{ number_format($trx['Nominal'], 2, ',', '.') }}
                            </span>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-8">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada histori transaksi.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 h-fit">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Pengeluaran Terbesar</h3>
            
            <div class="space-y-5">
                <div>
                    <div class="flex justify-between text-sm mb-1.5">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Makanan</span>
                        <span class="text-gray-500">Rp 300.000</span>
                    </div>
                    <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: 60%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-sm mb-1.5">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Transportasi</span>
                        <span class="text-gray-500">Rp 150.000</span>
                    </div>
                    <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-indigo-500 h-2 rounded-full" style="width: 30%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-sm mb-1.5">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Sewa Rumah</span>
                        <span class="text-gray-500">Rp 50.000</span>
                    </div>
                    <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-purple-500 h-2 rounded-full" style="width: 10%"></div>
                    </div>
                </div>
            </div>

            <div class="mt-8 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800">
                <p class="text-sm text-blue-800 dark:text-blue-300">
                    <span class="font-bold">Tips:</span> Alokasi keuangan yang baik akan membantu Anda mencapai tujuan lebih cepat!
                </p>
            </div>
        </div>

    </div>
</div>
@endsection