@extends('layouts.app')
@section('title', 'Reports')
@section('header', 'Reports')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header Section -->
    <div>
        <h2 class="text-xl font-bold text-gray-900 tracking-tight uppercase">Financial Reports</h2>
        <p class="text-xs text-gray-400">Filter and export financial statements</p>
    </div>

    <!-- Filter Form -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
        <form method="GET" action="{{ route('reports') }}" class="flex flex-wrap items-end gap-4">
            <div class="flex flex-col gap-1">
                <label for="date_from" class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Dari Tanggal</label>
                <input type="date" name="date_from" id="date_from" value="{{ $dateFrom ?? '' }}"
                    class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-gray-900 focus:outline-none transition-colors font-semibold text-gray-900 text-sm">
            </div>

            <div class="flex flex-col gap-1">
                <label for="date_to" class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Sampai Tanggal</label>
                <input type="date" name="date_to" id="date_to" value="{{ $dateTo ?? '' }}"
                    class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-gray-900 focus:outline-none transition-colors font-semibold text-gray-900 text-sm">
            </div>

            <button type="submit"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 text-white text-[10px] font-bold uppercase tracking-wider rounded-lg hover:bg-black transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4h18M7 10h10M11 16h2"/>
                </svg>
                Apply Filter
            </button>

            <a href="{{ route('reports.export-pdf', request()->query()) }}" target="_blank"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 text-white text-[10px] font-bold uppercase tracking-wider rounded-lg hover:bg-red-700 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export PDF
            </a>
                
            @if ($dateFrom || $dateTo)
                <a href="{{ route('reports') }}" class="text-xs text-gray-400 hover:text-gray-900 font-bold underline transition-colors self-end pb-2">Reset</a>
            @endif
        </form>
    </div>

    <!-- Summary Metrics -->
    <div class="flex items-center gap-6 px-2">
        <div>
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Income</span>
            <p class="text-lg font-bold text-emerald-600">Rp{{ number_format($totalIncome, 0, ',', '.') }}</p>
        </div>
        <div class="w-px h-8 bg-gray-200"></div>
        <div>
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Expense</span>
            <p class="text-lg font-bold text-rose-600">Rp{{ number_format($totalExpense, 0, ',', '.') }}</p>
        </div>
        <div class="w-px h-8 bg-gray-200"></div>
        <div>
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Net Profit</span>
            <p class="text-lg font-bold {{ $netProfit >= 0 ? 'text-gray-900' : 'text-rose-600' }}">
                {{ $netProfit >= 0 ? '+' : '' }}Rp{{ number_format($netProfit, 0, ',', '.') }}
            </p>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <p class="text-sm font-bold text-gray-900 uppercase tracking-wider">Transaction Details</p>
            <span class="text-xs text-gray-400 font-semibold">{{ $transactions->count() }} records</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-400">Date</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-400">Description</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-400">Category</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-400 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($transactions as $trx)
                        @php $type = $trx->category->type ?? 'expense'; @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 text-xs text-gray-500 font-semibold whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($trx->trans_date)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900 uppercase">
                                {{ $trx->desc }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 bg-gray-100 text-gray-600 text-[10px] font-bold uppercase tracking-wider rounded-md border border-gray-200">
                                    {{ $trx->category->cat_name ?? 'Uncategorized' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-right whitespace-nowrap
                                {{ $type === 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $type === 'income' ? '+' : '-' }}Rp{{ number_format($trx->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-gray-400 font-semibold uppercase tracking-wider">
                                Tidak ada transaksi pada periode ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
