@extends('layouts.app')
@section('title', 'Daftar Transaksi - ')

@section('content')
    <div class="p-4 pt- sm:p-10 sm:pt-8 bg-slate-50 dark:bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 gap-6">
                <div>
                    <span class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.4em] inline-block">Financial
                        Records</span>
                    <h1 class="text-4xl font-black text-slate-900 dark:text-white tracking-tighter leading-tight">Transaction
                        <span class="text-slate-300">History.</span></h1>
                </div>
                <button onclick="openTransactionModal()"
                    class="group flex items-center px-6 py-4 bg-gray-900 dark:bg-indigo-600 text-white text-xs font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-black transition-all shadow-xl shadow-gray-200 dark:shadow-none active:scale-95">
                    <svg class="w-5 h-5 mr-3 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                    </svg>
                    New Transaction
                </button>
            </div>

            <div
                class="bg-white dark:bg-slate-900 rounded-[2.5rem] overflow-hidden shadow-[0_40px_80px_-20px_rgba(0,0,0,0.05)] border border-slate-100 dark:border-slate-800">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                                <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Date
                                </th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                    Description</th>
                                <th
                                    class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">
                                    Category</th>
                                <th
                                    class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">
                                    Amount</th>
                                <th
                                    class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                            @forelse ($transactions as $transaction)
                                <tr
                                    class="group hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-all duration-300">
                                    <td class="px-8 py-6 whitespace-nowrap text-sm font-bold text-slate-400">
                                        {{ \Carbon\Carbon::parse($transaction->trans_date)->format('d M, Y') }}
                                    </td>
                                    <td
                                        class="px-8 py-6 text-sm font-black text-slate-900 dark:text-white uppercase tracking-tight">
                                        {{ $transaction->desc }}
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        <span
                                            class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400 border border-transparent group-hover:border-slate-200 transition-all">
                                            {{ $transaction->category->cat_name ?? 'Uncategorized' }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap text-sm text-right font-black tracking-tighter">
                                        <span
                                            class="{{ $transaction->category->type === 'income' ? 'text-emerald-500' : 'text-rose-500' }}">
                                            {{ $transaction->category->type === 'income' ? '+' : '-' }}
                                            Rp{{ number_format($transaction->amount, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        <div
                                            class="flex justify-center items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <a href="#"
                                                class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.828 2.828 0 114 4L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="#" method="POST"
                                                onsubmit="return confirm('Hapus transaksi?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all">
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
                                    <td colspan="5" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <div
                                                class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                            </div>
                                            <p class="text-slate-400 font-black uppercase tracking-widest text-xs">No
                                                records found</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="transModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm opacity-0 transition-opacity duration-500"
            id="transBackdrop" onclick="closeTransactionModal()"></div>
        <div class="relative bg-white w-full max-w-lg rounded-[2.5rem] p-10 shadow-2xl transform transition-all duration-500 translate-y-8 opacity-0"
            id="transContainer">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-xl font-black text-slate-900 uppercase tracking-tighter">New <span
                        class="text-slate-300">Transaction.</span></h3>
                <button onclick="closeTransactionModal()" class="text-slate-400 hover:text-slate-900 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form action="{{ route('transactions.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Date</label>
                        <input type="date" name="trans_date" required
                            class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-gray-900 transition-all font-bold text-slate-900">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Category</label>
                        <select name="category_id" required
                            class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-gray-900 transition-all font-bold text-slate-900 appearance-none">
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->cat_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Description</label>
                    <input type="text" name="desc" placeholder="What was this for?" required
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-gray-900 transition-all font-bold text-slate-900">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Amount
                        (Nominal)</label>
                    <div class="relative">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 font-black text-slate-300">Rp</span>
                        <input type="number" name="amount" placeholder="0" required
                            class="w-full pl-12 pr-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-gray-900 transition-all font-bold text-slate-900 text-xl tracking-tighter">
                    </div>
                </div>
                <button type="submit"
                    class="w-full py-5 bg-gray-900 text-white rounded-[1.5rem] font-black text-[10px] uppercase tracking-[0.3em] hover:bg-black transition-all shadow-xl shadow-gray-200">
                    Finalize Transaction
                </button>
            </form>
        </div>
    </div>

    <script>
        function openTransactionModal() {
            const modal = document.getElementById('transModal');
            const backdrop = document.getElementById('transBackdrop');
            const container = document.getElementById('transContainer');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                backdrop.classList.add('opacity-100');
                container.classList.remove('translate-y-8', 'opacity-0');
                container.classList.add('translate-y-0', 'opacity-100');
            }, 10);
        }

        function closeTransactionModal() {
            const backdrop = document.getElementById('transBackdrop');
            const container = document.getElementById('transContainer');
            backdrop.classList.remove('opacity-100');
            container.classList.remove('translate-y-0', 'opacity-100');
            container.classList.add('translate-y-8', 'opacity-0');
            setTimeout(() => {
                document.getElementById('transModal').classList.add('hidden');
            }, 500);
        }
    </script>
@endsection
