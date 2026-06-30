@extends('layouts.app')
@section('title', 'Manage Transactions')

@section('content')
    <div class="max-w-7xl mx-auto py-12 px-4">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-end gap-4 mb-12 animate-fade-in-up">
            <div>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.4em] mb-2 block">Financial
                    Records</span>
                <h2 class="text-4xl font-black text-gray-900 tracking-tighter uppercase leading-none">
                    Transaction <span class="text-gray-300">History.</span>
                </h2>
            </div>
            <button onclick="openModalCreate()"
                class="group relative inline-flex items-center gap-3 px-8 py-4 bg-gray-900 text-white text-xs font-bold rounded-2xl transition-all duration-500 hover:bg-black hover:shadow-[0_20px_50px_rgba(0,0,0,0.2)] hover:-translate-y-1 overflow-hidden">
                <div
                    class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-shimmer">
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="currentColor" class="w-4 h-4 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span class="relative uppercase tracking-widest text-white">New Transaction</span>
            </button>
        </div>

        <!-- Table Section -->
        <div
            class="bg-white rounded-[2.5rem] overflow-hidden shadow-[0_40px_80px_-20px_rgba(0,0,0,0.05)] border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-gray-400">Date</th>
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-gray-400">Description
                            </th>
                            <th
                                class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-gray-400 text-center">
                                Category</th>
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-gray-400 text-right">
                                Amount</th>
                            <th
                                class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-gray-400 text-center">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($transactions as $transaction)
                            <tr class="group hover:bg-gray-50/80 transition-all duration-300">
                                <td class="px-8 py-6 whitespace-nowrap text-sm font-bold text-gray-400">
                                    {{ \Carbon\Carbon::parse($transaction->trans_date)->format('d M, Y') }}
                                </td>
                                <td class="px-8 py-6 text-sm font-black text-gray-900 uppercase tracking-tight">
                                    <div class="flex items-center gap-2">
                                        <span>{{ $transaction->desc }}</span>
                                        @if ($transaction->receipt_path)
                                            <a href="{{ route('transactions.receipt', $transaction->id) }}" target="_blank"
                                                class="text-gray-400 hover:text-gray-900 transition-colors"
                                                title="Lihat Foto">
                                                <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span
                                        class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-gray-100 text-gray-600 border border-transparent group-hover:border-gray-200 transition-all">
                                        {{ $transaction->category->cat_name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap text-sm text-right font-black tracking-tighter">
                                    <span
                                        class="{{ ($transaction->category->type ?? '') === 'income' ? 'text-emerald-500' : 'text-red-500' }}">
                                        {{ ($transaction->category->type ?? '') === 'income' ? '+' : '-' }}
                                        Rp{{ number_format($transaction->amount, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <div
                                        class="flex justify-center items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        @if ($transaction->receipt_path)
                                            <a href="{{ route('transactions.receipt', $transaction->id) }}" target="_blank"
                                                class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-gray-900 hover:text-white transition-all duration-300"
                                                title="Lihat Foto">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </a>
                                        @endif
                                        <button onclick="editTransaction({{ $transaction->id }})"
                                            class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-gray-900 hover:text-white transition-all duration-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10">
                                                </path>
                                            </svg>
                                        </button>
                                        <button onclick="confirmDelete({{ $transaction->id }}, '{{ $transaction->desc }}')"
                                            class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-red-500 hover:text-white transition-all duration-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    class="py-20 text-center border-4 border-dashed border-gray-50 rounded-[3rem]">
                                    <p class="text-gray-400 font-black uppercase tracking-widest">No records found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Transaction CRUD Modal -->
    <div id="transactionModal"
        class="fixed inset-0 z-[99] hidden items-center justify-center p-4 transition-all duration-500">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm opacity-0 transition-opacity duration-500"
            id="modalBackdrop" onclick="closeModal()"></div>
        <div class="relative bg-white w-full max-w-md rounded-[2rem] p-8 shadow-2xl border border-gray-50 transform transition-all duration-500 translate-y-8 scale-95 opacity-0"
            id="modalContainer">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-black text-gray-900 uppercase tracking-tighter">Add <span
                        class="text-gray-300">Transaction</span></h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form id="transactionForm" action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div id="methodField"></div>

                {{-- Input hidden untuk menyimpan ID saat mode edit agar tidak hilang saat validasi gagal --}}
                <input type="hidden" name="active_id" id="modal_active_id"
                    value="{{ old('active_id') }}">

                <div class="grid grid-cols-2 gap-4">
                    {{-- Input Date --}}
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Date</label>
                        <input type="date" name="trans_date" id="modal_trans_date" value="{{ old('trans_date') }}"
                            required
                            class="w-full px-4 py-3 bg-gray-50 border-transparent border-2 rounded-xl focus:bg-white focus:border-gray-900 focus:ring-0 transition-all font-semibold text-gray-900 text-sm @error('trans_date', 'transaction') border-red-500 @enderror">
                        @error('trans_date', 'transaction')
                            <p class="text-[10px] text-red-500 font-bold ml-1 uppercase trans-error-msg">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Input Category --}}
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Category</label>
                        <select name="category_id" id="modal_category_id" required
                            class="w-full px-4 py-3 bg-gray-50 border-transparent border-2 rounded-xl focus:bg-white focus:border-gray-900 focus:ring-0 transition-all font-semibold text-gray-900 text-sm appearance-none @error('category_id', 'transaction') border-red-500 @enderror">
                            <option value="" disabled selected>Select Category</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->cat_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id', 'transaction')
                            <p class="text-[10px] text-red-500 font-bold ml-1 uppercase trans-error-msg">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Input Description --}}
                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Description</label>
                    <input type="text" name="desc" id="modal_desc" required placeholder="What was this for?"
                        value="{{ old('desc') }}"
                        class="w-full px-4 py-3 bg-gray-50 border-transparent border-2 rounded-xl focus:bg-white focus:border-gray-900 focus:ring-0 transition-all font-semibold text-gray-900 placeholder:text-gray-300 text-sm @error('desc', 'transaction') border-red-500 @enderror">
                    @error('desc', 'transaction')
                        <p class="text-[10px] text-red-500 font-bold ml-1 uppercase trans-error-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Amount --}}
                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Amount</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-gray-300 text-sm">Rp</span>
                        <input type="number" name="amount" id="modal_amount" required placeholder="0"
                            value="{{ old('amount') }}"
                            class="w-full pl-12 pr-4 py-3 bg-gray-50 border-transparent border-2 rounded-xl focus:bg-white focus:border-gray-900 focus:ring-0 transition-all font-black text-gray-900 text-lg tracking-tighter @error('amount', 'transaction') border-red-500 @enderror">
                    </div>
                    @error('amount', 'transaction')
                        <p class="text-[10px] text-red-500 font-bold ml-1 uppercase trans-error-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Receipt / Photo --}}
                <div class="space-y-1.5" id="modal_receipt_container">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Receipt / Photo</label>
                    <input type="file" name="receipt" id="modal_receipt" accept="image/*,application/pdf"
                        class="w-full px-4 py-3 bg-gray-50 border-transparent border-2 rounded-xl focus:bg-white focus:border-gray-900 focus:ring-0 transition-all font-semibold text-gray-900 text-sm file:mr-4 file:py-1.5 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-wider file:bg-gray-900 file:text-white hover:file:bg-black file:cursor-pointer @error('receipt', 'transaction') border-red-500 @enderror">
                    @error('receipt', 'transaction')
                        <p class="text-[10px] text-red-500 font-bold ml-1 uppercase trans-error-msg">{{ $message }}</p>
                    @enderror
                    <div id="modal_receipt_preview" class="hidden flex items-center gap-2 mt-2 px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl">
                        <span class="text-xs font-bold text-gray-500">Current Photo:</span>
                        <a id="modal_current_receipt_link" href="#" target="_blank" class="text-xs font-black text-gray-900 uppercase tracking-wider hover:underline flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            View
                        </a>
                    </div>
                </div>

                <button type="submit" id="submitBtn"
                    class="w-full py-4 bg-gray-900 text-white rounded-xl font-bold text-[10px] uppercase tracking-[0.3em] transition-all duration-300 hover:bg-black hover:shadow-lg active:scale-[0.98] mt-2">
                    Save Transaction
                </button>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-[110] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm opacity-0 transition-opacity duration-500"
            id="deleteBackdrop" onclick="closeDeleteModal()"></div>
        <div class="relative bg-white w-full max-w-sm rounded-[2.5rem] p-10 shadow-2xl border border-gray-50 transform transition-all duration-500 translate-y-8 scale-95 opacity-0"
            id="deleteContainer">
            <div
                class="w-20 h-20 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center mx-auto mb-6 rotate-12">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                    </path>
                </svg>
            </div>
            <div class="text-center mb-10">
                <h3 class="text-2xl font-black text-gray-900 tracking-tighter uppercase mb-2">Delete <span
                        class="text-red-500">Record?</span></h3>
                <p class="text-sm text-gray-400 font-medium leading-relaxed">
                    Apakah Anda yakin ingin menghapus transaksi <span id="delete_desc"
                        class="text-gray-900 font-bold"></span>? Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="flex flex-col gap-3">
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full py-4 bg-red-500 text-white rounded-2xl font-bold text-[10px] uppercase tracking-[0.3em] transition-all duration-300 hover:bg-red-600 hover:shadow-lg">
                        Confirm Delete
                    </button>
                </form>
                <button onclick="closeDeleteModal()"
                    class="w-full py-4 bg-gray-50 text-gray-400 rounded-2xl font-bold text-[10px] uppercase tracking-[0.3em] hover:bg-gray-100">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('transactionModal');
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

        function clearValidationErrors() {
            // Remove red borders from inputs
            const inputs = document.querySelectorAll('#transactionForm input, #transactionForm select');
            inputs.forEach(input => {
                input.classList.remove('border-red-500');
            });

            // Remove/hide error messages
            const errorMessages = document.querySelectorAll('#transactionForm .trans-error-msg');
            errorMessages.forEach(msg => {
                msg.remove();
            });
        }

        function openModalCreate() {
            document.querySelector('#transactionModal h3').innerHTML = 'Add <span class="text-gray-300">Transaction</span>';
            document.getElementById('submitBtn').innerText = 'Save Transaction';
            document.getElementById('transactionForm').action = "{{ route('transactions.store') }}";
            document.getElementById('methodField').innerHTML = '';
            
            // Clear values explicitly
            document.getElementById('modal_trans_date').value = '';
            document.getElementById('modal_category_id').value = '';
            document.getElementById('modal_desc').value = '';
            document.getElementById('modal_amount').value = '';
            document.getElementById('modal_active_id').value = '';
            document.getElementById('modal_receipt').value = '';
            document.getElementById('modal_receipt_preview').classList.add('hidden');
            
            clearValidationErrors();
            openModal();
        }

        function editTransaction(id) {
            clearValidationErrors();
            fetch(`/transactions/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.querySelector('#transactionModal h3').innerHTML =
                        'Edit <span class="text-gray-300">Transaction</span>';
                    document.getElementById('submitBtn').innerText = 'Update Transaction';
                    const form = document.getElementById('transactionForm');
                    form.action = `/transactions/${id}`;
                    document.getElementById('methodField').innerHTML = '@method('PUT')';

                    // Fill fields
                    document.getElementById('modal_trans_date').value = data.trans_date;
                    document.getElementById('modal_category_id').value = data.category_id;
                    document.getElementById('modal_desc').value = data.desc;
                    document.getElementById('modal_amount').value = data.amount;
                    document.getElementById('modal_active_id').value = id;
                    document.getElementById('modal_receipt').value = '';

                    if (data.receipt_path) {
                        document.getElementById('modal_receipt_preview').classList.remove('hidden');
                        document.getElementById('modal_current_receipt_link').href = `/transactions/${data.id}/receipt`;
                    } else {
                        document.getElementById('modal_receipt_preview').classList.add('hidden');
                    }

                    openModal();
                });
        }

        // Delete Logic
        const deleteModal = document.getElementById('deleteModal');
        const deleteBackdrop = document.getElementById('deleteBackdrop');
        const deleteContainer = document.getElementById('deleteContainer');

        function confirmDelete(id, desc) {
            document.getElementById('delete_desc').innerText = `"${desc}"`;
            document.getElementById('deleteForm').action = `/transactions/${id}`;
            deleteModal.classList.remove('hidden');
            deleteModal.classList.add('flex');
            setTimeout(() => {
                deleteBackdrop.classList.add('opacity-100');
                deleteContainer.classList.remove('translate-y-8', 'scale-95', 'opacity-0');
                deleteContainer.classList.add('translate-y-0', 'scale-100', 'opacity-100');
            }, 10);
        }

        function closeDeleteModal() {
            deleteBackdrop.classList.remove('opacity-100');
            deleteContainer.classList.remove('translate-y-0', 'scale-100', 'opacity-100');
            deleteContainer.classList.add('translate-y-8', 'scale-95', 'opacity-0');
            setTimeout(() => {
                deleteModal.classList.remove('flex');
                deleteModal.classList.add('hidden');
            }, 500);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Jika ada error pada transaction bag
            @if ($errors->transaction->any())
                @if (old('active_id'))
                    editTransaction({{ old('active_id') }});
                @else
                    openModalCreate();
                @endif
            @endif
        });
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

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection
