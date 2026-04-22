@extends('layouts.app')

@section('title', 'Dashboard - MoneyTrack')
@section('header', 'Dashboard Overview')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Saldo</p>
                <div class="p-2 bg-gray-900 rounded-lg text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                        </path>
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-black text-gray-900 leading-none">Rp {{ number_format($total_saldo, 0, ',', '.') }}
            </h3>
            <p class="text-[10px] text-gray-400 mt-2 font-medium">Update terakhir: {{ now()->format('d M Y') }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pemasukkan</p>
                <div class="p-2 bg-gray-100 rounded-lg text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12">
                        </path>
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-black text-gray-900">Rp {{ number_format($pemasukkan, 0, ',', '.') }}</h3>
            <p class="text-[10px] text-emerald-500 mt-2 font-bold flex items-center">
                <span class="mr-1">↑</span> Trend bulan ini
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pengeluaran</p>
                <div class="p-2 bg-gray-100 rounded-lg text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-black text-gray-900">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</h3>
            <p class="text-[10px] text-rose-500 mt-2 font-bold flex items-center">
                <span class="mr-1">↓</span> Efisiensi biaya
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-sm font-bold text-gray-900 uppercase">Analisis Arus Kas</h3>
                <select class="text-xs border-none bg-gray-100 rounded-lg focus:ring-0">
                    <option>7 Hari Terakhir</option>
                    <option>30 Hari Terakhir</option>
                </select>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                    <h3 class="text-sm font-bold text-gray-900 uppercase mb-4">Arus Kas (Income vs Expense)</h3>
                    <div class="h-64">
                        <canvas id="cashFlowChart"></canvas>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                    <h3 class="text-sm font-bold text-gray-900 uppercase mb-4">Pengeluaran per Kategori</h3>
                    <div class="h-64 flex justify-center">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>

            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
            <h3 class="text-sm font-bold text-gray-900 uppercase mb-6">Transaksi Terakhir</h3>
            <div class="space-y-4">
                @forelse ($recent_transaction as $trx)
                    <div class="flex items-center justify-between group">
                        <div class="flex items-center">
                            <div
                                class="w-10 h-10 rounded-full {{ $trx->category->cat_name == 'Income' ? 'bg-gray-100' : 'bg-gray-900' }} flex items-center justify-center mr-3">
                                @if ($trx->category->cat_name == 'Income')
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path d="M12 4v16m8-8H4"></path>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path d="M20 12H4"></path>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">{{ $trx->desc }}</p>
                                <p class="text-[10px] text-gray-400 font-medium">
                                    {{ \Carbon\Carbon::parse($trx->trans_date)->format('d M Y') }}</p>
                            </div>
                        </div>
                        <p
                            class="text-sm font-black {{ $trx->category->cat_name == 'Income' ? 'text-gray-900' : 'text-gray-400' }}">
                            {{ $trx->category->cat_name == 'Income' ? '+' : '-' }}Rp
                            {{ number_format($trx->amount, 0, ',', '.') }}
                        </p>
                    </div>
                @empty
                    <div class="text-center py-10">
                        <p class="text-xs font-bold text-gray-400">Belum ada histori transaksi</p>
                    </div>
                @endforelse
            </div>
            <a href="{{ route('transactions') }}"
                class="block text-center mt-8 text-[10px] font-bold text-gray-400 hover:text-gray-900 transition-colors uppercase tracking-widest">Lihat
                Semua</a>
        </div>
    </div>
@endsection


{{-- @extends('layouts.app')
@section('title', 'Dashboard')
@section('header', 'Overview')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gray-900 p-6 rounded-2xl shadow-xl text-white relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Total Balance</p>
                <h3 class="text-3xl font-black">Rp {{ number_format($total_saldo, 0, ',', '.') }}</h3>
                <div class="mt-6 flex items-center text-[10px] text-gray-400">
                    <span class="bg-white/10 px-2 py-1 rounded-md mr-2 text-white">ACTIVE</span> Updated today
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-10">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Incomes</p>
                <div class="p-2 bg-gray-50 rounded-lg text-gray-900 border border-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                </div>
            </div>
            <h3 class="text-2xl font-black text-gray-900 uppercase italic">Rp {{ number_format($pemasukkan, 0, ',', '.') }}</h3>
            <p class="text-[10px] text-gray-400 mt-2 font-bold uppercase tracking-tighter italic tracking-widest">Total monthly income</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Expenses</p>
                <div class="p-2 bg-gray-50 rounded-lg text-gray-900 border border-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                </div>
            </div>
            <h3 class="text-2xl font-black text-gray-900 uppercase italic">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</h3>
            <p class="text-[10px] text-gray-400 mt-2 font-bold uppercase tracking-widest italic">Total monthly expenses</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
            <h3 class="text-xs font-bold text-gray-900 uppercase tracking-[0.2em] mb-8">Cash Flow Analytics</h3>
            <div class="h-[300px]">
                <canvas id="mainChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
            <h3 class="text-xs font-bold text-gray-900 uppercase tracking-[0.2em] mb-8">Recent Activity</h3>
            <div class="space-y-6">
                @forelse ($recent_transaction as $trx)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-2 h-2 rounded-full mr-4 {{ $trx->category->cat_name == 'Income' ? 'bg-gray-900' : 'bg-gray-300' }}"></div>
                        <div>
                            <p class="text-sm font-bold text-gray-800 leading-tight">{{ $trx->desc }}</p>
                            <p class="text-[10px] text-gray-400 uppercase font-medium">{{ \Carbon\Carbon::parse($trx->trans_date)->format('d M') }}</p>
                        </div>
                    </div>
                    <p class="text-sm font-black tracking-tighter">
                        {{ $trx->category->cat_name == 'Income' ? '+' : '-' }}Rp {{ number_format($trx->amount, 0, ',', '.') }}
                    </p>
                </div>
                @empty
                <div class="text-center py-10">
                    <p class="text-xs font-bold text-gray-400 uppercase">No Data Found</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('mainChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [{
                    label: 'Income',
                    data: [1200000, 1900000, 3000000, 2500000],
                    borderColor: '#111827',
                    backgroundColor: 'rgba(17, 24, 39, 0.05)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0
                }, {
                    label: 'Expense',
                    data: [800000, 1200000, 1500000, 1100000],
                    borderColor: '#D1D5DB',
                    borderDash: [5, 5],
                    borderWidth: 2,
                    tension: 0.4,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, border: { display: false } },
                    y: { display: false }
                }
            }
        });
    </script>
@endsection --}}