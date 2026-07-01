@extends('layouts.app')
@section('title', 'Assets')
@section('header', 'Assets')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-gray-900 tracking-tight uppercase">Asset Vault</h2>
                <p class="text-xs text-gray-400">Track and manage asset inventory</p>
            </div>
            <button onclick="openModalCreate()"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 hover:bg-black text-white text-xs font-bold rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Register Asset</span>
            </button>
        </div>

        <!-- Stats Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Active Assets Value -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm flex flex-col justify-between min-h-[120px]">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Nilai Aset Aktif</span>
                    <h3 class="text-2xl font-bold text-gray-900 mt-2">
                        Rp{{ number_format($nilai_aset_aktif, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="flex items-center gap-1.5 mt-4 text-[10px] font-semibold text-emerald-600 uppercase tracking-wider">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                    Aset Dimiliki
                </div>
            </div>

            <!-- Total Sales -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm flex flex-col justify-between min-h-[120px]">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Total Penjualan Aset</span>
                    <h3 class="text-2xl font-bold text-gray-900 mt-2">
                        Rp{{ number_format($total_penjualan, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="flex items-center gap-1.5 mt-4 text-[10px] font-semibold text-blue-600 uppercase tracking-wider">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Nilai Jual
                </div>
            </div>

            <!-- Net Capital Gain -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm flex flex-col justify-between min-h-[120px]">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Total Profit / Loss</span>
                    <h3 class="text-2xl font-bold {{ $total_keuntungan >= 0 ? 'text-emerald-600' : 'text-rose-600' }} mt-2">
                        {{ $total_keuntungan >= 0 ? '+' : '' }}Rp{{ number_format($total_keuntungan, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="flex items-center gap-1.5 mt-4 text-[10px] font-semibold {{ $total_keuntungan >= 0 ? 'text-emerald-600' : 'text-rose-600' }} uppercase tracking-wider">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    Capital Gain
                </div>
            </div>
        </div>

        <!-- Inventory Table Section -->
        <div class="bg-white rounded-xl overflow-hidden border border-gray-200 shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-400">Asset Name</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-400">Purchase Date</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-400 text-right">Buy Price</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-400 text-center">Status</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-400">Sale Date</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-400 text-right">Sale Price</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-400 text-right">Profit / Loss</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-400 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($assets as $asset)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 uppercase">
                                    {{ $asset->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-gray-500">
                                    {{ \Carbon\Carbon::parse($asset->purchase_date)->format('d M, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-gray-900">
                                    Rp{{ number_format($asset->purchase_price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @if ($asset->status === 'owned')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-600 border border-emerald-100">
                                            Owned
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-500 border border-gray-200">
                                            Sold
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-gray-500">
                                    {{ $asset->sale_date ? \Carbon\Carbon::parse($asset->sale_date)->format('d M, Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-gray-900">
                                    {{ $asset->sale_price ? 'Rp' . number_format($asset->sale_price, 0, ',', '.') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold">
                                    @if ($asset->status === 'sold')
                                        @php
                                            $profit = $asset->sale_price - $asset->purchase_price;
                                        @endphp
                                        <span class="{{ $profit >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                                            {{ $profit >= 0 ? '+' : '' }}Rp{{ number_format($profit, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-gray-300">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                     <div class="flex justify-center items-center gap-2">
                                    
                                        @if ($asset->status === 'owned')
                                            <button onclick="openSellModal({{ $asset->id }}, '{{ $asset->name }}', '{{ $asset->purchase_date }}')"
                                                class="px-3 py-1.5 rounded-lg bg-gray-900 hover:bg-black text-white text-[10px] font-bold uppercase tracking-wider transition-colors">
                                                Sell
                                            </button>
                                        @endif
                                        <button onclick="confirmDelete({{ $asset->id }}, '{{ $asset->name }}')"
                                            class="w-8 h-8 rounded-lg border border-gray-200 bg-white text-red-500 hover:bg-red-50 flex items-center justify-center transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 text-center text-gray-400 font-semibold uppercase tracking-wider">
                                    No assets in inventory
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Register Asset Modal -->
    <div id="assetModal" class="fixed inset-0 z-[99] hidden items-center justify-center p-4">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm opacity-0 transition-opacity duration-300" id="modalBackdrop" onclick="closeModal()"></div>
        <!-- Container -->
        <div class="relative bg-white w-full max-w-md rounded-xl p-6 shadow-xl border border-gray-200 transform transition-all duration-300 translate-y-8 opacity-0" id="modalContainer">
            <div class="flex justify-between items-center mb-5 pb-3 border-b border-gray-100">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Register Asset</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="assetForm" action="{{ route('assets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <!-- Name -->
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Asset Name</label>
                    <input type="text" name="name" id="modal_name" required placeholder="Laptop, Vehicle, etc." value="{{ old('name') }}"
                        class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-gray-900 focus:outline-none focus:ring-0 transition-colors text-sm font-semibold text-gray-900 placeholder:text-gray-300 @error('name', 'create') border-red-500 @enderror">
                    @error('name', 'create')
                        <p class="text-[10px] text-red-500 font-semibold asset-error-msg uppercase">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Purchase Date -->
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Purchase Date</label>
                    <input type="date" name="purchase_date" id="modal_purchase_date" required value="{{ old('purchase_date', date('Y-m-d')) }}"
                        class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-gray-900 focus:outline-none focus:ring-0 transition-colors text-sm font-semibold text-gray-900 @error('purchase_date', 'create') border-red-500 @enderror">
                    @error('purchase_date', 'create')
                        <p class="text-[10px] text-red-500 font-semibold asset-error-msg uppercase">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Purchase Price -->
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Purchase Price</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 font-bold text-gray-400 text-sm">Rp</span>
                        <input type="number" name="purchase_price" id="modal_purchase_price" required placeholder="0" value="{{ old('purchase_price') }}"
                            class="w-full pl-9 pr-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-gray-900 focus:outline-none focus:ring-0 transition-colors text-sm font-bold text-gray-900 @error('purchase_price', 'create') border-red-500 @enderror">
                    </div>
                    @error('purchase_price', 'create')
                        <p class="text-[10px] text-red-500 font-semibold asset-error-msg uppercase">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Receipt Upload -->
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Receipt / Photo</label>
                    <input type="file" name="receipt" id="modal_receipt" accept="image/*,application/pdf"
                        class="w-full px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-gray-900 transition-colors text-xs font-semibold text-gray-900 file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-[10px] file:font-bold file:uppercase file:bg-gray-900 file:text-white hover:file:bg-black file:cursor-pointer @error('receipt', 'create') border-red-500 @enderror">
                    @error('receipt', 'create')
                        <p class="text-[10px] text-red-500 font-semibold asset-error-msg uppercase">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full py-3 bg-gray-900 text-white rounded-lg font-bold text-xs uppercase tracking-wider hover:bg-black transition-colors mt-2">
                    Save Asset
                </button>
            </form>
        </div>
    </div>

    <!-- Sell Asset Modal -->
    <div id="sellModal" class="fixed inset-0 z-[99] hidden items-center justify-center p-4">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm opacity-0 transition-opacity duration-300" id="sellBackdrop" onclick="closeSellModal()"></div>
        <!-- Container -->
        <div class="relative bg-white w-full max-w-md rounded-xl p-6 shadow-xl border border-gray-200 transform transition-all duration-300 translate-y-8 opacity-0" id="sellContainer">
            <div class="flex justify-between items-center mb-5 pb-3 border-b border-gray-100">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Sell Asset: <span id="sell_asset_title" class="text-gray-500">Asset</span></h3>
                <button onclick="closeSellModal()" class="text-gray-400 hover:text-gray-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="sellForm" action="" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="hidden" name="sell_id" id="modal_sell_id" value="{{ old('sell_id') }}">

                <!-- Sale Date -->
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Sale Date</label>
                    <input type="date" name="sale_date" id="modal_sale_date" required value="{{ old('sale_date', date('Y-m-d')) }}"
                        class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-gray-900 focus:outline-none focus:ring-0 transition-colors text-sm font-semibold text-gray-900 @error('sale_date', 'sell') border-red-500 @enderror">
                    @error('sale_date', 'sell')
                        <p class="text-[10px] text-red-500 font-semibold asset-error-msg uppercase">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sale Price -->
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Sale Price</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 font-bold text-gray-400 text-sm">Rp</span>
                        <input type="number" name="sale_price" id="modal_sale_price" required placeholder="0" value="{{ old('sale_price') }}"
                            class="w-full pl-9 pr-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-gray-900 focus:outline-none focus:ring-0 transition-colors text-sm font-bold text-gray-900 @error('sale_price', 'sell') border-red-500 @enderror">
                    </div>
                    @error('sale_price', 'sell')
                        <p class="text-[10px] text-red-500 font-semibold asset-error-msg uppercase">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sale Receipt Upload -->
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Sale Receipt / Photo</label>
                    <input type="file" name="receipt" id="sell_receipt" accept="image/*,application/pdf"
                        class="w-full px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-gray-900 transition-colors text-xs font-semibold text-gray-900 file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-[10px] file:font-bold file:uppercase file:bg-gray-900 file:text-white hover:file:bg-black file:cursor-pointer @error('receipt', 'sell') border-red-500 @enderror">
                    @error('receipt', 'sell')
                        <p class="text-[10px] text-red-500 font-semibold asset-error-msg uppercase">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full py-3 bg-gray-900 text-white rounded-lg font-bold text-xs uppercase tracking-wider hover:bg-black transition-colors mt-2">
                    Complete Sale
                </button>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-[110] hidden items-center justify-center p-4">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm opacity-0 transition-opacity duration-300" id="deleteBackdrop" onclick="closeDeleteModal()"></div>
        <!-- Container -->
        <div class="relative bg-white w-full max-w-sm rounded-xl p-6 shadow-xl border border-gray-200 transform transition-all duration-300 translate-y-8 opacity-0" id="deleteContainer">
            <div class="text-center mb-6">
                <h3 class="text-sm font-bold text-gray-900 tracking-wider uppercase mb-2">Delete Asset?</h3>
                <p class="text-xs text-gray-400 leading-relaxed">
                    Apakah Anda yakin ingin menghapus aset <span id="delete_desc" class="text-gray-900 font-bold"></span> dari inventory? Semua transaksi pembelian dan penjualan terkait juga akan dihapus.
                </p>
            </div>
            <div class="flex flex-col gap-2">
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg font-bold text-xs uppercase tracking-wider transition-colors">
                        Confirm Delete
                    </button>
                </form>
                <button onclick="closeDeleteModal()" class="w-full py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-bold text-xs uppercase tracking-wider transition-colors">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <script>
        // Modal Register Asset
        const modal = document.getElementById('assetModal');
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

        function clearAssetValidationErrors(formSelector) {
            const form = document.querySelector(formSelector);
            if (!form) return;
            form.querySelectorAll('input, select').forEach(input => {
                input.classList.remove('border-red-500');
            });
            form.querySelectorAll('.asset-error-msg').forEach(msg => {
                msg.remove();
            });
        }

        function openModalCreate() {
            document.getElementById('modal_name').value = '';
            document.getElementById('modal_purchase_date').value = new Date().toISOString().split('T')[0];
            document.getElementById('modal_purchase_price').value = '';
            document.getElementById('modal_receipt').value = '';
            clearAssetValidationErrors('#assetForm');
            openModal();
        }

        // Modal Sell Asset
        const sellModal = document.getElementById('sellModal');
        const sellBackdrop = document.getElementById('sellBackdrop');
        const sellContainer = document.getElementById('sellContainer');
        const sellForm = document.getElementById('sellForm');

        function openSellModal(id, name, purchaseDate) {
            clearAssetValidationErrors('#sellForm');
            document.getElementById('sell_asset_title').innerText = name;
            sellForm.action = `/assets/${id}/sell`;
            document.getElementById('modal_sell_id').value = id;
            document.getElementById('modal_sale_date').min = purchaseDate;
            document.getElementById('modal_sale_date').value = new Date().toISOString().split('T')[0];
            document.getElementById('modal_sale_price').value = '';
            document.getElementById('sell_receipt').value = '';

            sellModal.classList.remove('hidden');
            sellModal.classList.add('flex');
            setTimeout(() => {
                sellBackdrop.classList.add('opacity-100');
                sellContainer.classList.remove('translate-y-8', 'opacity-0');
                sellContainer.classList.add('translate-y-0', 'opacity-100');
            }, 10);
        }

        function closeSellModal() {
            sellBackdrop.classList.remove('opacity-100');
            sellContainer.classList.remove('translate-y-0', 'opacity-100');
            sellContainer.classList.add('translate-y-8', 'opacity-0');
            setTimeout(() => {
                sellModal.classList.remove('flex');
                sellModal.classList.add('hidden');
            }, 300);
        }

        // Delete Logic
        const deleteModal = document.getElementById('deleteModal');
        const deleteBackdrop = document.getElementById('deleteBackdrop');
        const deleteContainer = document.getElementById('deleteContainer');

        function confirmDelete(id, name) {
            document.getElementById('delete_desc').innerText = `"${name}"`;
            document.getElementById('deleteForm').action = `/assets/${id}`;
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
            @if ($errors->create->any())
                openModalCreate();
            @endif

            @if ($errors->sell->any())
                openSellModal({{ old('sell_id') }}, 'Asset', '');
            @endif
        });
    </script>
@endsection
