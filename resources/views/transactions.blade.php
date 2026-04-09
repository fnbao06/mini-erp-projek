@extends('layouts.app')
@section('title', 'Daftar Transaksi - ')
@section('header', 'Riwayat Transaksi')

@section('content')
    <div class="p-4 sm:p-8 bg-slate-50 dark:bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto">

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Data Transaksi</h1>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Daftar seluruh riwayat pemasukan dan pengeluaran.
                    </p>
                </div>
                <a href="" {{-- <a href="{{ route('transactions.create') }}" --}}
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-all shadow-sm shadow-indigo-200 dark:shadow-none">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Transaksi
                </a>
            </div>

            <div
                class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                                <th
                                    class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Tanggal</th>
                                <th
                                    class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Keterangan</th>
                                <th
                                    class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 text-center">
                                    Kategori</th>
                                <th
                                    class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 text-right">
                                    Nominal</th>
                                <th
                                    class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 text-center">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                            @forelse ($transactions as $transaction)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-300">
                                        {{ \Carbon\Carbon::parse($transaction->trans_date)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">
                                        {{ $transaction->desc }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-800">
                                            {{ $transaction->category->cat_name ?? 'Tanpa Kategori' }}
                                        </span>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold 
                                        {{ $transaction->category->type === 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                        {{ $transaction->category->type === 'income' ? '+' : '-' }}
                                        Rp{{ number_format($transaction->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center items-center gap-3">
                                            <a href="" {{-- <a href="{{ route('transactions.edit', $transaction->id) }}" --}}
                                                class="text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.828 2.828 0 114 4L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="" {{-- <form action="{{ route('transactions.destroy', $transaction->id) }}" --}} method="POST"
                                                onsubmit="return confirm('Hapus transaksi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-slate-400 hover:text-rose-600 dark:hover:text-rose-400 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5"
                                        class="px-6 py-10 text-center text-slate-500 dark:text-slate-400 italic">
                                        Tidak ada data transaksi ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($transactions instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/30 border-t border-slate-200 dark:border-slate-800">
                        {{ $transactions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
