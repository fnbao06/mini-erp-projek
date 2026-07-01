@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Stats Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Balance -->
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Saldo</p>
                    <div class="p-2 bg-gray-100 rounded-lg text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                            </path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-none">Rp {{ number_format($total_saldo, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-gray-400 mt-4 font-semibold uppercase tracking-wider">
                    Update: {{ now()->format('d M Y') }}
                </p>
            </div>

            <!-- Income -->
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pemasukkan</p>
                    <div class="p-2 bg-emerald-50 rounded-lg text-emerald-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-none">Rp {{ number_format($pemasukkan, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-emerald-600 mt-4 font-semibold uppercase tracking-wider">
                    Inflow Management
                </p>
            </div>

            <!-- Expense -->
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pengeluaran</p>
                    <div class="p-2 bg-rose-50 rounded-lg text-rose-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-none">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-rose-600 mt-4 font-semibold uppercase tracking-wider">
                    Cost Efficiency
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Charts Section -->
            <div class="lg:col-span-2 bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-6 flex flex-col justify-between">
                <div class="flex justify-between items-center mb-4 border-b border-gray-100 pb-4">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Financial Analytics</h3>
                    <span class="px-2.5 py-1 bg-gray-100 rounded text-[9px] font-bold text-gray-500 uppercase tracking-wider">
                        Chart.js Engine
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 flex-1">
                    <div class="flex flex-col items-center justify-between">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-3">Cashflow Trend (30 Days)</p>
                        <div class="w-full bg-gray-50 rounded-lg p-4 min-h-[220px] flex items-center justify-center flex-1">
                            <canvas id="cashflowChart" class="max-w-full hidden"></canvas>
                            <div id="cashflowEmpty" class="text-gray-400 italic text-xs">No transaction data within last 30 days</div>
                        </div>
                    </div>

                    <div class="flex flex-col items-center justify-between">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-3">Expense Distribution</p>
                        <div class="w-full bg-gray-50 rounded-lg p-4 min-h-[220px] flex items-center justify-center flex-1">
                            <canvas id="expenseChart" class="max-w-full hidden"></canvas>
                            <div id="expenseEmpty" class="text-gray-400 italic text-xs">No expense data available</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-6 pb-4 border-b border-gray-100">
                        Recent Activity
                    </h3>
                    <div class="space-y-4">
                        @forelse ($recent_transaction as $trx)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full {{ $trx->category->type == 'income' ? 'bg-emerald-50 text-emerald-600' : 'bg-gray-100 text-gray-700' }} flex items-center justify-center mr-3">
                                        @if ($trx->category->type == 'income')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-width="2.5" d="M20 12H4"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-800 uppercase tracking-tight">
                                            {{ Str::limit($trx->desc, 18) }}
                                        </p>
                                        <p class="text-[9px] text-gray-400 font-medium uppercase mt-0.5">
                                            {{ $trx->category->cat_name }} • {{ \Carbon\Carbon::parse($trx->trans_date)->format('d M y') }}
                                        </p>
                                    </div>
                                </div>
                                <p class="text-xs font-bold {{ $trx->category->type == 'income' ? 'text-emerald-600' : 'text-gray-950' }}">
                                    {{ $trx->category->type == 'income' ? '+' : '-' }}Rp{{ number_format($trx->amount, 0, ',', '.') }}
                                </p>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">No logs found</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <a href="/transactions"
                    class="block text-center mt-6 py-2.5 border border-gray-200 rounded-lg text-xs font-bold text-gray-500 hover:bg-gray-50 transition-colors uppercase tracking-wider">
                    View All History
                </a>
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
