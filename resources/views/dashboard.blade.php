@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard Overview')

@section('content')
    <div class="p-6 bg-slate-50 min-h-screen">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div
                class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm group hover:border-indigo-500 transition-all">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Saldo</p>
                    <div class="p-2 bg-gray-900 rounded-lg text-white group-hover:bg-indigo-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                            </path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-gray-900 leading-none">Rp {{ number_format($total_saldo, 0, ',', '.') }}
                </h3>
                <p class="text-[10px] text-gray-400 mt-4 font-medium uppercase tracking-widest">Update:
                    {{ now()->format('d M Y') }}</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pemasukkan</p>
                    <div class="p-2 bg-emerald-50 rounded-lg text-emerald-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-gray-900">Rp {{ number_format($pemasukkan, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-emerald-500 mt-4 font-black flex items-center uppercase tracking-widest">
                    <span class="mr-1">↑</span> Inflow Management
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pengeluaran</p>
                    <div class="p-2 bg-rose-50 rounded-lg text-rose-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-gray-900">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-rose-500 mt-4 font-black flex items-center uppercase tracking-widest">
                    <span class="mr-1">↓</span> Cost Efficiency
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-sm">
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="text-sm font-black text-gray-900 uppercase tracking-tighter">Python Analytics Overview
                        </h3>
                        <span
                            class="px-3 py-1 bg-slate-100 rounded-full text-[9px] font-black text-slate-500 uppercase tracking-widest">Pandas
                            Engine</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="flex flex-col items-center">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Cashflow Trend
                            </p>
                            <div class="w-full flex justify-center items-center bg-slate-50 rounded-xl p-4">
                                @if (isset($flowChart) && $flowChart)
                                    <img src="data:image/png;base64,{{ $flowChart }}" class="max-w-full h-auto">
                                @else
                                    <div class="h-48 flex items-center justify-center text-slate-300 italic text-xs">Chart
                                        Data Unavailable</div>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col items-center">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Expense
                                Distribution</p>
                            <div class="w-full flex justify-center items-center bg-slate-50 rounded-xl p-4">
                                @if (isset($categoryChart) && $categoryChart)
                                    <img src="data:image/png;base64,{{ $categoryChart }}" class="max-w-full h-auto">
                                @else
                                    <div class="h-48 flex items-center justify-center text-slate-300 italic text-xs">
                                        Chart Data Unavailable
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-sm">
                <h3 class="text-sm font-black text-gray-900 uppercase tracking-tighter mb-8">Recent Activity</h3>
                <div class="space-y-6">
                    @forelse ($recent_transaction as $trx)
                        <div class="flex items-center justify-between group cursor-default">
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 rounded-full {{ $trx->category->type == 'income' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-900 text-white' }} flex items-center justify-center mr-4 transition-transform group-hover:scale-110">
                                    @if ($trx->category->type == 'income')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-width="3" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-width="3" d="M20 12H4"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-xs font-black text-gray-800 uppercase tracking-tight">
                                        {{ Str::limit($trx->desc, 18) }}</p>
                                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">
                                        {{ $trx->category->cat_name }} •
                                        {{ \Carbon\Carbon::parse($trx->trans_date)->format('d M') }}
                                    </p>
                                </div>
                            </div>
                            <p
                                class="text-sm font-black tracking-tighter {{ $trx->category->type == 'income' ? 'text-emerald-500' : 'text-slate-900' }}">
                                {{ $trx->category->type == 'income' ? '+' : '-' }}Rp{{ number_format($trx->amount, 0, ',', '.') }}
                            </p>
                        </div>
                    @empty
                        <div class="text-center py-20">
                            <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.2em]">No logs found</p>
                        </div>
                    @endforelse
                </div>

                <a href="/transactions"
                    class="block text-center mt-10 p-4 border-2 border-dashed border-slate-100 rounded-xl text-[9px] font-black text-slate-400 hover:text-indigo-600 hover:border-indigo-200 transition-all uppercase tracking-[0.3em]">
                    Explore All History
                </a>
            </div>
        </div>
    </div>
@endsection
