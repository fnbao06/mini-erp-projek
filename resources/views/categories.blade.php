@extends('layouts.app')

@section('title', 'Manage Categories')
{{-- @section('header', 'Categories') --}}

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-end gap-4 mb-12 animate-fade-in-down">
            <div>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.4em] mb-2 block">Management</span>
                <h2 class="text-4xl font-black text-gray-900 tracking-tighter uppercase leading-none">
                    Category <span class="text-gray-300">Vault.</span>
                </h2>
            </div>
            <button onclick="openModal()"
                class="group relative inline-flex items-center gap-3 px-8 py-4 bg-gray-900 text-white text-xs font-bold rounded-2xl transition-all duration-500 hover:bg-black hover:shadow-[0_20px_50px_rgba(0,0,0,0.2)] hover:-translate-y-1 overflow-hidden">
                <div
                    class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-shimmer">
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span class="relative uppercase tracking-widest">Create New</span>
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse ($category as $cat)
                <div
                    class="group relative bg-white rounded-[2rem] p-8 border border-gray-100 hover:border-transparent transition-all duration-500 flex flex-col justify-between min-h-[250px] hover:shadow-[0_30px_60px_-15px_rgba(0,0,0,0.1)] overflow-hidden">

                    <div
                        class="absolute -right-8 -top-8 w-32 h-32 bg-gray-50 rounded-full transition-all duration-700 group-hover:scale-[3] group-hover:bg-gray-900/5 z-0">
                    </div>

                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-8">
                            <div
                                class="w-14 h-14 flex items-center justify-center rounded-2xl bg-gray-900 text-white shadow-xl shadow-gray-200 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                                </svg>
                            </div>

                            <div class="flex flex-col items-end">
                                <span
                                    class="text-[9px] font-black uppercase tracking-widest {{ strtolower($cat->type) === 'expense' ? 'text-red-400' : 'text-emerald-500' }}">
                                    ● {{ $cat->type }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <h3
                                class="text-2xl font-black text-gray-900 tracking-tight mb-2 group-hover:text-black transition-colors">
                                {{ $cat->cat_name }}
                            </h3>
                            <div class="flex items-center gap-4">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.1em]">
                                    {{ $cat->transaction_count ?? 0 }} Usage
                                </p>
                                <div class="h-px w-8 bg-gray-100 group-hover:w-16 transition-all duration-700"></div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="relative z-10 flex items-center justify-between mt-8 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
                        <div class="flex gap-2">
                            <button
                                class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-gray-900 hover:text-white transition-all duration-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10">
                                    </path>
                                </svg>
                            </button>
                            <button
                                class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-red-500 hover:text-white transition-all duration-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full py-20 flex flex-col items-center border-4 border-dashed border-gray-100 rounded-[3rem]">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-6 animate-bounce">
                        <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <p class="text-gray-400 font-black uppercase tracking-widest">The vault is empty</p>
                </div>
            @endforelse
        </div>
    </div>

    <div id="categoryModal" class="fixed inset-0 z-[99] hidden items-center justify-center p-4 transition-all duration-500">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm opacity-0 transition-opacity duration-500"
            id="modalBackdrop" onclick="closeModal()"></div>

        <div class="relative bg-white w-full max-w-sm rounded-[2rem] p-8 shadow-[0_40px_80px_-15px_rgba(0,0,0,0.1)] border border-gray-50 transform transition-all duration-500 translate-y-8 scale-95 opacity-0"
            id="modalContainer">

            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-black text-gray-900 uppercase tracking-tighter">
                    Add <span class="text-gray-300">Category</span>
                </h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form action="{{ route('categories.store') }}" method="POST" class="space-y-5">
                @csrf

                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Name</label>
                    <input type="text" name="cat_name" required placeholder="Enter name..."
                        class="w-full px-4 py-3 bg-gray-50 border-transparent border-2 rounded-xl focus:bg-white focus:border-gray-900 focus:ring-0 transition-all font-semibold text-gray-900 placeholder:text-gray-300 text-sm">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Type</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="type" value="income" class="peer sr-only" required>
                            <div
                                class="py-3 flex flex-col items-center justify-center rounded-xl border border-gray-100 bg-white text-gray-400 peer-checked:border-gray-900 peer-checked:text-gray-900 peer-checked:bg-gray-50 transition-all duration-300">
                                <span class="font-bold text-[10px] uppercase tracking-widest">Income</span>
                            </div>
                        </label>

                        <label class="relative cursor-pointer">
                            <input type="radio" name="type" value="expense" class="peer sr-only">
                            <div
                                class="py-3 flex flex-col items-center justify-center rounded-xl border border-gray-100 bg-white text-gray-400 peer-checked:border-gray-900 peer-checked:text-gray-900 peer-checked:bg-gray-50 transition-all duration-300">
                                <span class="font-bold text-[10px] uppercase tracking-widest">Expense</span>
                            </div>
                        </label>
                    </div>
                </div>

                <button type="submit"
                    class="w-full py-4 bg-gray-900 text-white rounded-xl font-bold text-[10px] uppercase tracking-[0.3em] transition-all duration-300 hover:bg-black hover:shadow-lg active:scale-[0.98] mt-2">
                    Save Category
                </button>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('categoryModal');
        const backdrop = document.getElementById('modalBackdrop');
        const container = document.getElementById('modalContainer');

        function openModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                backdrop.classList.add('opacity-100');
                container.classList.remove('translate-y-8', 'scale-95', 'opacity-0');
                container.classList.add('translate-y-0', 'scale-100', 'opacity-100');
            }, 10);
        }

        function closeModal() {
            backdrop.classList.remove('opacity-100');
            container.classList.remove('translate-y-0', 'scale-100', 'opacity-100');
            container.classList.add('translate-y-8', 'scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 500);
        }
    </script>

    <style>
        @keyframes shimmer {
            100% {
                transform: translateX(100%);
            }
        }

        .animate-shimmer {
            animation: shimmer 2s infinite;
        }

        .animate-fade-in-down {
            animation: fadeInDown 0.8s ease-out;
        }

        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection
