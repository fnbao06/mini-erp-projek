@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto space-y-8 animate-fade-in">
        <!-- Welcome Banner & Quick Actions -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-gray-100 pb-6">
            <div>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Selamat Datang, {{ Auth::user()->name }}!</h1>
                <p class="text-xs text-gray-400 font-medium mt-0.5">Berikut adalah rangkuman performa keuangan dan inventaris bisnis Anda hari ini.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="/transactions"
                    class="px-4 py-2 bg-gray-900 text-white rounded-lg font-bold text-xs uppercase tracking-wider hover:bg-black transition-colors shadow-sm">
                    Tambah Transaksi
                </a>
                <a href="/assets"
                    class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg font-bold text-xs uppercase tracking-wider hover:bg-gray-50 transition-colors shadow-sm">
                    Daftar Aset
                </a>
            </div>
        </div>

        <!-- Main Dashboard Split Layout Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <!-- Left Columns (lg:col-span-2) - Stats and Charts -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Stats Cards Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Balance -->
                    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex flex-col justify-between">
                        <div class="flex justify-between items-start">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Saldo</p>
                            <span class="p-1.5 bg-gray-50 rounded text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mt-2">Rp {{ number_format($total_saldo, 0, ',', '.') }}</h3>
                        <p class="text-[9px] text-gray-400 mt-2 font-medium">Saldo kas bersih saat ini</p>
                    </div>

                    <!-- Income -->
                    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex flex-col justify-between">
                        <div class="flex justify-between items-start">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Pemasukkan</p>
                            <span class="p-1.5 bg-emerald-50 rounded text-emerald-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                </svg>
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mt-2">Rp {{ number_format($pemasukkan, 0, ',', '.') }}</h3>
                        <p class="text-[9px] text-emerald-500 mt-2 font-medium">Total dana kas masuk</p>
                    </div>

                    <!-- Expense -->
                    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex flex-col justify-between">
                        <div class="flex justify-between items-start">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Pengeluaran</p>
                            <span class="p-1.5 bg-rose-50 rounded text-rose-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                </svg>
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mt-2">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</h3>
                        <p class="text-[9px] text-rose-500 mt-2 font-medium">Total dana kas keluar</p>
                    </div>
                </div>

                <!-- Cashflow Trend Card -->
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-4">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                        <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider">Tren Arus Kas (30 Hari Terakhir)</h3>
                        <span class="px-2.5 py-1 bg-emerald-50 text-[9px] font-bold text-emerald-600 rounded uppercase tracking-wider">
                            Cashflow
                        </span>
                    </div>
                    <div class="w-full bg-gray-50 rounded-lg p-4 min-h-[250px] flex items-center justify-center">
                        <canvas id="cashflowChart" class="max-w-full hidden"></canvas>
                        <div id="cashflowEmpty" class="text-gray-400 italic text-xs">Belum ada data transaksi dalam 30 hari terakhir.</div>
                    </div>
                </div>

                <!-- Expense Distribution Card -->
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-4">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                        <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider">Proporsi Pengeluaran per Kategori</h3>
                        <span class="px-2.5 py-1 bg-rose-50 text-[9px] font-bold text-rose-600 rounded uppercase tracking-wider">
                            Distribution
                        </span>
                    </div>
                    <div class="w-full bg-gray-50 rounded-lg p-4 min-h-[220px] flex items-center justify-center">
                        <canvas id="expenseChart" class="max-w-full hidden"></canvas>
                        <div id="expenseEmpty" class="text-gray-400 italic text-xs">Belum ada pengeluaran yang tercatat.</div>
                    </div>
                </div>
            </div>

            <!-- Right Column (lg:col-span-1) - Full Height Recent Activity Feed -->
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex flex-col justify-between min-h-[690px]">
                    <div>
                        <div class="flex justify-between items-center mb-6 pb-3 border-b border-gray-100">
                            <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider">Aktivitas Terbaru</h3>
                            <a href="/transactions" class="text-[10px] font-bold text-gray-400 hover:text-gray-950 uppercase tracking-wider transition-colors">
                                Lihat Semua
                            </a>
                        </div>
                        
                        <!-- Timeline List -->
                        <div class="space-y-3">
                            @forelse ($recent_transaction as $trx)
                                @php $type = $trx->category->type ?? 'expense'; @endphp
                                <div class="bg-gray-50/50 p-3 rounded-lg border-l-4 {{ $type === 'income' ? 'border-emerald-500' : 'border-rose-500' }} border border-gray-100 flex items-start justify-between gap-2 shadow-xs transition-all hover:bg-gray-50">
                                    <div class="space-y-1">
                                        <p class="text-xs font-bold text-gray-900 leading-tight">
                                            {{ Str::limit($trx->desc, 22) }}
                                        </p>
                                        <div class="flex items-center gap-1.5">
                                            <span class="px-1.5 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider {{ $type === 'income' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                                                {{ $trx->category->cat_name ?? 'Umum' }}
                                            </span>
                                            <span class="text-[9px] text-gray-400 font-medium">
                                                {{ \Carbon\Carbon::parse($trx->trans_date)->format('d M y') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs font-extrabold {{ $type === 'income' ? 'text-emerald-600' : 'text-gray-900' }}">
                                            {{ $type === 'income' ? '+' : '-' }}Rp{{ number_format($trx->amount, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-20">
                                    <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Belum ada transaksi</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-100 text-center">
                        <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">
                            Total: {{ $recent_transaction->count() }} Histori Terakhir
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const transactions = {!! json_encode($allTransactions) !!};

            // 1. Process Cashflow Trend (30 hari terakhir)
            const cashflowMap = {};
            const thirtyDaysAgo = new Date();
            thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);

            transactions.forEach(trx => {
                const trxDate = new Date(trx.trans_date);
                if (trxDate >= thirtyDaysAgo) {
                    const formattedDate = trxDate.toLocaleDateString('id-ID', { day: '2-digit', month: 'short' });
                    if (!cashflowMap[formattedDate]) {
                        cashflowMap[formattedDate] = { income: 0, expense: 0 };
                    }
                    const type = trx.category ? trx.category.type : 'expense';
                    if (type === 'income') {
                        cashflowMap[formattedDate].income += parseFloat(trx.amount);
                    } else {
                        cashflowMap[formattedDate].expense += parseFloat(trx.amount);
                    }
                }
            });

            const cashflowLabels = Object.keys(cashflowMap);
            const incomeData = cashflowLabels.map(label => cashflowMap[label].income);
            const expenseData = cashflowLabels.map(label => cashflowMap[label].expense);

            if (cashflowLabels.length > 0) {
                const cashflowCanvas = document.getElementById('cashflowChart');
                cashflowCanvas.classList.remove('hidden');
                document.getElementById('cashflowEmpty').classList.add('hidden');

                new Chart(cashflowCanvas, {
                    type: 'line',
                    data: {
                        labels: cashflowLabels,
                        datasets: [
                            {
                                label: 'Income',
                                data: incomeData,
                                borderColor: '#10B981', // emerald-500
                                backgroundColor: 'rgba(16, 185, 129, 0.05)',
                                tension: 0.3,
                                fill: true
                            },
                            {
                                label: 'Expense',
                                data: expenseData,
                                borderColor: '#EF4444', // red-500
                                backgroundColor: 'rgba(239, 68, 68, 0.05)',
                                tension: 0.3,
                                fill: true
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom',
                                labels: {
                                    font: { size: 10, weight: 'bold' },
                                    boxWidth: 12
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { font: { size: 9 } }
                            },
                            y: {
                                grid: { color: '#E5E7EB', borderDash: [2, 2] },
                                ticks: { font: { size: 9 } }
                            }
                        }
                    }
                });
            }

            // 2. Process Expense Distribution (per Kategori)
            const expenseMap = {};
            transactions.forEach(trx => {
                const type = trx.category ? trx.category.type : 'expense';
                if (type === 'expense') {
                    const categoryName = trx.category ? trx.category.cat_name : 'Uncategorized';
                    if (!expenseMap[categoryName]) {
                        expenseMap[categoryName] = 0;
                    }
                    expenseMap[categoryName] += parseFloat(trx.amount);
                }
            });

            const expenseLabels = Object.keys(expenseMap);
            const expenseValues = Object.values(expenseMap);

            if (expenseLabels.length > 0) {
                const expenseCanvas = document.getElementById('expenseChart');
                expenseCanvas.classList.remove('hidden');
                document.getElementById('expenseEmpty').classList.add('hidden');

                new Chart(expenseCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: expenseLabels,
                        datasets: [{
                            data: expenseValues,
                            backgroundColor: [
                                '#111827', // gray-900
                                '#374151', // gray-700
                                '#6B7280', // gray-500
                                '#9CA3AF', // gray-400
                                '#D1D5DB', // gray-300
                                '#E5E7EB'  // gray-200
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom',
                                labels: {
                                    font: { size: 10, weight: 'bold' },
                                    boxWidth: 10
                                }
                            }
                        },
                        cutout: '65%'
                    }
                });
            }
        });
    </script>
@endsection
