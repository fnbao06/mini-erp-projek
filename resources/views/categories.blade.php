@extends('layouts.app')

@section('title', 'Categories')
@section('header', 'Categories')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-gray-900 tracking-tight uppercase">Category Vault</h2>
                <p class="text-xs text-gray-400">Manage transaction categories</p>
            </div>
            <button onclick="openModalCreate()"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 hover:bg-black text-white text-xs font-bold rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Create Category</span>
            </button>
        </div>

        <!-- Grid Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse ($category as $cat)
                <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm flex flex-col justify-between min-h-[180px]">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider
                                {{ strtolower($cat->type) === 'expense' ? 'bg-rose-50 text-rose-600' : 'bg-emerald-50 text-emerald-600' }}">
                                {{ $cat->type }}
                            </span>
                            <span class="text-xs text-gray-400 font-medium">{{ $cat->transaction_count ?? 0 }} Transactions</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 tracking-tight uppercase">{{ $cat->cat_name }}</h3>
                    </div>

                    <div class="flex justify-end gap-2 mt-4 pt-3 border-t border-gray-100">
                        <button onclick="editCategory({{ $cat->id }})"
                            class="w-8 h-8 rounded-lg border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10">
                                </path>
                            </svg>
                        </button>
                        <button type="button" onclick="confirmDelete({{ $cat->id }}, '{{ $cat->cat_name }}')"
                            class="w-8 h-8 rounded-lg border border-gray-200 bg-white text-red-500 hover:bg-red-50 flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 flex flex-col items-center border border-dashed border-gray-200 rounded-xl bg-white">
                    <p class="text-gray-400 font-semibold uppercase tracking-wider">The vault is empty</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Category CRUD Modal -->
    <div id="categoryModal" class="fixed inset-0 z-[99] hidden items-center justify-center p-4">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm opacity-0 transition-opacity duration-300"
            id="modalBackdrop" onclick="closeModal()"></div>
        <!-- Container -->
        <div class="relative bg-white w-full max-w-sm rounded-xl p-6 shadow-xl border border-gray-200 transform transition-all duration-300 translate-y-8 opacity-0"
            id="modalContainer">
            <div class="flex justify-between items-center mb-5 pb-3 border-b border-gray-100">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Add Category</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form id="categoryForm" action="{{ route('categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="active_id" value="{{ old('active_id', session('edit_id')) }}">
                <div id="methodField"></div>

                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Name</label>
                    <input type="text" name="cat_name" value="{{ old('cat_name') }}" id="modal_cat_name" required placeholder="Enter name..."
                        class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-gray-900 focus:outline-none focus:ring-0 transition-colors text-sm font-semibold text-gray-900 placeholder:text-gray-300 @error('cat_name') border-red-500 @enderror">
                    @error('cat_name')
                        <p class="text-[10px] text-red-500 font-semibold cat-error-msg uppercase">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Type</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="type" value="income" id="type_income" class="peer sr-only"
                                {{ old('type') == 'income' ? 'checked' : '' }} required>
                            <div class="py-2.5 flex flex-col items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-400 peer-checked:border-gray-900 peer-checked:text-gray-900 peer-checked:bg-gray-50 transition-colors">
                                <span class="font-bold text-xs uppercase tracking-wider">Income</span>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="type" value="expense" id="type_expense" class="peer sr-only"
                                {{ old('type') == 'expense' ? 'checked' : '' }}>
                            <div class="py-2.5 flex flex-col items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-400 peer-checked:border-gray-900 peer-checked:text-gray-900 peer-checked:bg-gray-50 transition-colors">
                                <span class="font-bold text-xs uppercase tracking-wider">Expense</span>
                            </div>
                        </label>
                    </div>
                    @error('type')
                        <p class="text-[10px] text-red-500 font-semibold cat-error-msg uppercase">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" id="submitBtn"
                    class="w-full py-3 bg-gray-900 text-white rounded-lg font-bold text-xs uppercase tracking-wider hover:bg-black transition-colors mt-2">
                    Save Category
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
                <h3 class="text-sm font-bold text-gray-900 tracking-wider uppercase mb-2">Delete Category?</h3>
                <p class="text-xs text-gray-400 leading-relaxed">
                    Apakah Anda yakin ingin menghapus kategori <span id="delete_cat_name" class="text-gray-900 font-bold"></span>? Data yang memiliki transaksi akan di-soft delete.
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
        const modal = document.getElementById('categoryModal');
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

        function clearCategoryValidationErrors() {
            document.getElementById('modal_cat_name').classList.remove('border-red-500');
            document.querySelectorAll('#categoryForm .border-red-500').forEach(el => {
                el.classList.remove('border-red-500');
            });
            const errorMessages = document.querySelectorAll('#categoryForm .cat-error-msg');
            errorMessages.forEach(msg => {
                msg.remove();
            });
        }

        function editCategory(id) {
            clearCategoryValidationErrors();
            fetch(`/categories/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.querySelector('input[name="active_id"]').value = id;
                    document.querySelector('#categoryModal h3').innerHTML = 'Edit Category';
                    document.getElementById('submitBtn').innerText = 'Update Category';

                    const form = document.getElementById('categoryForm');
                    form.action = `/categories/${id}`;
                    document.getElementById('methodField').innerHTML = '@method('PUT')';

                    document.getElementById('modal_cat_name').value = data.cat_name;
                    if (data.type === 'income') {
                        document.getElementById('type_income').checked = true;
                    } else {
                        document.getElementById('type_expense').checked = true;
                    }

                    openModal();
                });
        }

        function openModalCreate() {
            document.querySelector('input[name="active_id"]').value = '';
            document.querySelector('#categoryModal h3').innerHTML = 'Add Category';
            document.getElementById('submitBtn').innerText = 'Save Category';
            document.getElementById('categoryForm').action = "{{ route('categories.store') }}";
            document.getElementById('methodField').innerHTML = '';
            
            document.getElementById('modal_cat_name').value = '';
            document.getElementById('type_income').checked = false;
            document.getElementById('type_expense').checked = false;

            clearCategoryValidationErrors();
            openModal();
        }

        const deleteModal = document.getElementById('deleteModal');
        const deleteBackdrop = document.getElementById('deleteBackdrop');
        const deleteContainer = document.getElementById('deleteContainer');
        const deleteForm = document.getElementById('deleteForm');
        const deleteTextName = document.getElementById('delete_cat_name');

        function confirmDelete(id, name) {
            deleteTextName.innerText = `"${name}"`;
            deleteForm.action = `/categories/${id}`;
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
    </script>
@endsection
