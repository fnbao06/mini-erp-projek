@extends('layouts.app')
@section('title', 'Financial Reports')
@section('header', 'Reports')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-4">

    {{-- Page Title --}}
    <div class="mb-8">
        <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.4em] mb-2 block">Financial Analysis</span>
        <h2 class="text-4xl font-black text-gray-900 tracking-tighter uppercase leading-none">
            Financial <span class="text-gray-300">Reports.</span>
        </h2>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
        <form method="GET" action="{{ route('reports') }}" class="flex flex-wrap items-end gap-4">
            <div class="flex flex-col gap-1.5">
                <label for="date_from" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Dari Tanggal</label>
                <input type="date" name="date_from" id="date_from"
                    value="{{ $dateFrom ?? '' }}"
                    class="px-4 py-2.5 bg-gray-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-gray-900 focus:outline-none transition-all font-semibold text-gray-900 text-sm">
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="date_to" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Sampai Tanggal</label>
                <input type="date" name="date_to" id="date_to"
                    value="{{ $dateTo ?? '' }}"
                    class="px-4 py-2.5 bg-gray-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-gray-900 focus:outline-none transition-all font-semibold text-gray-900 text-sm">
            </div>

            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-black transition-all duration-200">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4h18M7 10h10M11 16h2"/>
                </svg>
                Apply
            </button>

            <a href="{{ route('reports.export-pdf', request()->query()) }}" target="_blank"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-rose-600 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-rose-700 transition-all duration-200">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Ekspor PDF
            </a>
                
            @if ($dateFrom || $dateTo)
                <a href="{{ route('reports') }}" class="text-[10px] text-gray-400 hover:text-gray-700 font-bold underline underline-offset-2 transition-colors self-end pb-[11px]">Reset</a>
            @endif
        </form>
    </div>


    {{-- Summary --}}
    <div class="flex items-center gap-6 px-2 mb-4">
        <div>
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Income</span>
            <p class="text-base font-black text-emerald-600 tracking-tighter">Rp{{ number_format($totalIncome, 0, ',', '.') }}</p>
        </div>
        <div class="w-px h-8 bg-gray-200"></div>
        <div>
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Expense</span>
            <p class="text-base font-black text-rose-600 tracking-tighter">Rp{{ number_format($totalExpense, 0, ',', '.') }}</p>
        </div>
        <div class="w-px h-8 bg-gray-200"></div>
        <div>
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Profit</span>
            <p class="text-base font-black tracking-tighter {{ $netProfit >= 0 ? 'text-gray-900' : 'text-rose-600' }}">
                {{ $netProfit >= 0 ? '+' : '' }}Rp{{ number_format($netProfit, 0, ',', '.') }}
            </p>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
            <p class="text-sm font-black text-gray-900 uppercase tracking-tight">Detail Transaksi</p>
            <span class="text-[10px] text-gray-400 font-bold">{{ $transactions->count() }} record</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Tanggal</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Deskripsi</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Kategori</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($transactions as $trx)
                        @php $type = $trx->category->type ?? 'expense'; @endphp
                        <tr class="hover:bg-gray-50/60 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-400 font-semibold whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($trx->trans_date)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-900 uppercase tracking-tight">
                                {{ $trx->desc }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-gray-100 text-gray-600 text-[10px] font-black uppercase tracking-widest rounded-full">
                                    {{ $trx->category->cat_name ?? 'Uncategorized' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-black text-right tracking-tighter whitespace-nowrap
                                {{ $type === 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $type === 'income' ? '+' : '-' }}Rp{{ number_format($trx->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-16 text-center text-gray-400 text-sm font-bold uppercase tracking-widest">
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
