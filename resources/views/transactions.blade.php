@extends('layouts.app')
@section('title', 'Transactions')
@section('header', 'Transactions')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-gray-900 tracking-tight uppercase">Transaction History</h2>
                <p class="text-xs text-gray-400">View and manage your transaction records</p>
            </div>
            <button onclick="openModalCreate()"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 hover:bg-black text-white text-xs font-bold rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>New Transaction</span>
            </button>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-xl overflow-hidden border border-gray-200 shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-400">Date</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-400">Description</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-400 text-center">Category</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-400 text-right">Amount</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-400 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($transactions as $transaction)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-500">
                                    {{ \Carbon\Carbon::parse($transaction->trans_date)->format('d M, Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900 uppercase">
                                    <div class="flex items-center gap-2">
                                        <span>{{ $transaction->desc }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-600 border border-gray-200">
                                        {{ $transaction->category->cat_name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold">
                                    <span class="{{ ($transaction->category->type ?? '') === 'income' ? 'text-emerald-600' : 'text-red-600' }}">
                                        {{ ($transaction->category->type ?? '') === 'income' ? '+' : '-' }}
                                        Rp{{ number_format($transaction->amount, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center items-center gap-2">
                                        @if ($transaction->receipt_path)
                                            <a href="{{ route('transactions.receipt', $transaction->id) }}" target="_blank"
                                                class="w-8 h-8 rounded-lg border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 flex items-center justify-center transition-colors"
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
                                            class="w-8 h-8 rounded-lg border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 flex items-center justify-center transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10">
                                                </path>
                                            </svg>
                                        </button>
                                        <button onclick="confirmDelete({{ $transaction->id }}, '{{ $transaction->desc }}')"
                                            class="w-8 h-8 rounded-lg border border-gray-200 bg-white text-red-500 hover:bg-red-50 flex items-center justify-center transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-gray-400 font-semibold uppercase tracking-wider">
                                    No records found
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
        class="fixed inset-0 z-[99] hidden items-center justify-center p-4">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm opacity-0 transition-opacity duration-300"
            id="modalBackdrop" onclick="closeModal()"></div>
        <!-- Container -->
        <div class="relative bg-white w-full max-w-md rounded-xl p-6 shadow-xl border border-gray-200 transform transition-all duration-300 translate-y-8 opacity-0"
            id="modalContainer">
            <div class="flex justify-between items-center mb-5 pb-3 border-b border-gray-100">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Add Transaction</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form id="transactionForm" action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div id="methodField"></div>

                <input type="hidden" name="active_id" id="modal_active_id" value="{{ old('active_id') }}">

                <div class="grid grid-cols-2 gap-4">
                    {{-- Input Date --}}
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Date</label>
                        <input type="date" name="trans_date" id="modal_trans_date" value="{{ old('trans_date') }}" required
                            class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-gray-900 focus:ring-0 focus:outline-none transition-colors text-sm font-semibold text-gray-900 @error('trans_date', 'transaction') border-red-500 @enderror">
                        @error('trans_date', 'transaction')
                            <p class="text-[10px] text-red-500 font-semibold trans-error-msg uppercase">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Input Category --}}
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Category</label>
                        <select name="category_id" id="modal_category_id" required
                            class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-gray-900 focus:ring-0 focus:outline-none transition-colors text-sm font-semibold text-gray-900 @error('category_id', 'transaction') border-red-500 @enderror">
                            <option value="" disabled selected>Select Category</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->cat_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id', 'transaction')
                            <p class="text-[10px] text-red-500 font-semibold trans-error-msg uppercase">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Input Description --}}
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Description</label>
                    <input type="text" name="desc" id="modal_desc" required placeholder="What was this for?" value="{{ old('desc') }}"
                        class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-gray-900 focus:ring-0 focus:outline-none transition-colors text-sm font-semibold text-gray-900 placeholder:text-gray-300 @error('desc', 'transaction') border-red-500 @enderror">
                    @error('desc', 'transaction')
                        <p class="text-[10px] text-red-500 font-semibold trans-error-msg uppercase">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Amount --}}
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Amount</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 font-bold text-gray-400 text-sm">Rp</span>
                        <input type="number" name="amount" id="modal_amount" required placeholder="0" value="{{ old('amount') }}"
                            class="w-full pl-9 pr-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-gray-900 focus:ring-0 focus:outline-none transition-colors text-sm font-bold text-gray-900 @error('amount', 'transaction') border-red-500 @enderror">
                    </div>
                    @error('amount', 'transaction')
                        <p class="text-[10px] text-red-500 font-semibold trans-error-msg uppercase">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Receipt / Photo --}}
                <div class="space-y-1" id="modal_receipt_container">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Receipt / Photo</label>
                    <input type="file" name="receipt" id="modal_receipt" accept="image/*,application/pdf"
                        class="w-full px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-gray-900 transition-colors text-xs font-semibold text-gray-900 file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-[10px] file:font-bold file:uppercase file:bg-gray-900 file:text-white hover:file:bg-black file:cursor-pointer @error('receipt', 'transaction') border-red-500 @enderror">
                    @error('receipt', 'transaction')
                        <p class="text-[10px] text-red-500 font-semibold trans-error-msg uppercase">{{ $message }}</p>
                    @enderror
                    <div id="modal_receipt_preview" class="hidden flex items-center gap-2 mt-2 px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-lg">
                        <span class="text-xs font-semibold text-gray-400">Current Photo:</span>
                        <a id="modal_current_receipt_link" href="#" target="_blank" class="text-xs font-bold text-gray-900 hover:underline flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            View
                        </a>
                    </div>
                </div>

                <button type="submit" id="submitBtn"
                    class="w-full py-3 bg-gray-900 text-white rounded-lg font-bold text-xs uppercase tracking-wider hover:bg-black transition-colors mt-2">
                    Save Transaction
                </button>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-[110] hidden items-center justify-center p-4">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm opacity-0 transition-opacity duration-300"
            id="deleteBackdrop" onclick="closeDeleteModal()"></div>
        <!-- Container -->
        <div class="relative bg-white w-full max-w-sm rounded-xl p-6 shadow-xl border border-gray-200 transform transition-all duration-300 translate-y-8 opacity-0"
            id="deleteContainer">
            <div class="text-center mb-6">
                <h3 class="text-sm font-bold text-gray-900 tracking-wider uppercase mb-2">Delete Record?</h3>
                <p class="text-xs text-gray-400 leading-relaxed">
                    Apakah Anda yakin ingin menghapus transaksi <span id="delete_desc" class="text-gray-900 font-bold"></span>? Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="flex flex-col gap-2">
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg font-bold text-xs uppercase tracking-wider transition-colors">
                        Confirm Delete
                    </button>
                </form>
                <button onclick="closeDeleteModal()"
                    class="w-full py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-bold text-xs uppercase tracking-wider transition-colors">
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
                container.classList.remove('translate-y-8', 'opacity-0');
                container.classList.add('translate-y-0', 'opacity-100');
            }, 10);
        }

        function closeModal() {
            backdrop.classList.remove('opacity-100');
            container.classList.remove('translate-y-0', 'opacity-100');
            container.classList.add('translate-y-8', 'opacity-0');
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 300);
        }

        function clearValidationErrors() {
            const inputs = document.querySelectorAll('#transactionForm input, #transactionForm select');
            inputs.forEach(input => {
                input.classList.remove('border-red-500');
            });
            const errorMessages = document.querySelectorAll('#transactionForm .trans-error-msg');
            errorMessages.forEach(msg => {
                msg.remove();
            });
        }

        function openModalCreate() {
            document.querySelector('#transactionModal h3').innerHTML = 'Add Transaction';
            document.getElementById('submitBtn').innerText = 'Save Transaction';
            document.getElementById('transactionForm').action = "{{ route('transactions.store') }}";
            document.getElementById('methodField').innerHTML = '';
            
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
                    document.querySelector('#transactionModal h3').innerHTML = 'Edit Transaction';
                    document.getElementById('submitBtn').innerText = 'Update Transaction';
                    const form = document.getElementById('transactionForm');
                    form.action = `/transactions/${id}`;
                    document.getElementById('methodField').innerHTML = '@method('PUT')';

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
                deleteContainer.classList.remove('translate-y-8', 'opacity-0');
                deleteContainer.classList.add('translate-y-0', 'opacity-100');
            }, 10);
        }

        function closeDeleteModal() {
            deleteBackdrop.classList.remove('opacity-100');
            deleteContainer.classList.remove('translate-y-0', 'opacity-100');
            deleteContainer.classList.add('translate-y-8', 'opacity-0');
            setTimeout(() => {
                deleteModal.classList.remove('flex');
                deleteModal.classList.add('hidden');
            }, 300);
        }

        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->transaction->any())
                @if (old('active_id'))
                    editTransaction({{ old('active_id') }});
                @else
                    openModalCreate();
                @endif
            @endif
        });
    </script>
@endsection
