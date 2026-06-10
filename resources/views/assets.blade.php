@extends('layouts.app')
@section('title', 'Manage Assets')
@section('header', 'Asset Vault')

@section('content')
    <div class="max-w-7xl mx-auto py-12 px-4">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-end gap-4 mb-12 animate-fade-in-up">
            <div>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.4em] mb-2 block">Inventory Vault</span>
                <h2 class="text-4xl font-black text-gray-900 tracking-tighter uppercase leading-none">
                    Asset <span class="text-gray-300">Management.</span>
                </h2>
            </div>
            <button onclick="openModalCreate()"
                class="group relative inline-flex items-center gap-3 px-8 py-4 bg-gray-900 text-white text-xs font-bold rounded-2xl transition-all duration-500 hover:bg-black hover:shadow-[0_20px_50px_rgba(0,0,0,0.2)] hover:-translate-y-1 overflow-hidden">
                <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-shimmer"></div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span class="relative uppercase tracking-widest text-white">Register New Asset</span>
            </button>
        </div>

        <!-- Stats Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12 animate-fade-in-up">
            <!-- Nilai Aset Aktif -->
            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-[0_20px_50px_rgba(0,0,0,0.02)] flex flex-col justify-between min-h-[160px] relative overflow-hidden group hover:shadow-[0_30px_60px_-15px_rgba(0,0,0,0.05)] transition-all duration-500">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-[2] group-hover:bg-emerald-50/50 transition-all duration-500 z-0"></div>
                <div class="relative z-10">
                    <span class="text-[9px] font-black uppercase tracking-widest text-gray-400">Nilai Aset Aktif</span>
                    <h3 class="text-3xl font-black text-gray-900 tracking-tighter mt-4">
                        Rp{{ number_format($nilai_aset_aktif, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="relative z-10 flex items-center gap-2 mt-4 text-[10px] font-bold text-emerald-500 uppercase tracking-wider">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                    Aset yang Masih Dimiliki
                </div>
            </div>

            <!-- Total Penjualan -->
            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-[0_20px_50px_rgba(0,0,0,0.02)] flex flex-col justify-between min-h-[160px] relative overflow-hidden group hover:shadow-[0_30px_60px_-15px_rgba(0,0,0,0.05)] transition-all duration-500">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-50 rounded-full group-hover:scale-[2] group-hover:bg-blue-50/50 transition-all duration-500 z-0"></div>
                <div class="relative z-10">
                    <span class="text-[9px] font-black uppercase tracking-widest text-gray-400">Total Penjualan Aset</span>
                    <h3 class="text-3xl font-black text-gray-900 tracking-tighter mt-4">
                        Rp{{ number_format($total_penjualan, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="relative z-10 flex items-center gap-2 mt-4 text-[10px] font-bold text-blue-500 uppercase tracking-wider">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Akumulasi Nilai Jual
                </div>
            </div>

            <!-- Keuntungan / Kerugian Bersih -->
            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-[0_20px_50px_rgba(0,0,0,0.02)] flex flex-col justify-between min-h-[160px] relative overflow-hidden group hover:shadow-[0_30px_60px_-15px_rgba(0,0,0,0.05)] transition-all duration-500">
                <div class="absolute -right-6 -top-6 w-24 h-24 {{ $total_keuntungan >= 0 ? 'bg-emerald-50' : 'bg-red-50' }} rounded-full group-hover:scale-[2] group-hover:bg-opacity-50 transition-all duration-500 z-0"></div>
                <div class="relative z-10">
                    <span class="text-[9px] font-black uppercase tracking-widest text-gray-400">Total Profit / Loss</span>
                    <h3 class="text-3xl font-black {{ $total_keuntungan >= 0 ? 'text-emerald-500' : 'text-red-500' }} tracking-tighter mt-4">
                        {{ $total_keuntungan >= 0 ? '+' : '' }}Rp{{ number_format($total_keuntungan, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="relative z-10 flex items-center gap-2 mt-4 text-[10px] font-bold {{ $total_keuntungan >= 0 ? 'text-emerald-500' : 'text-red-500' }} uppercase tracking-wider">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    Capital Gain Penjualan
                </div>
            </div>
        </div>

        <!-- Inventory Table Section -->
        <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-[0_40px_80px_-20px_rgba(0,0,0,0.05)] border border-gray-100 animate-fade-in-up">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-gray-400">Asset Name</th>
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-gray-400">Purchase Date</th>
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-gray-400 text-right">Buy Price</th>
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-gray-400 text-center">Status</th>
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-gray-400">Sale Date</th>
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-gray-400 text-right">Sale Price</th>
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-gray-400 text-right">Profit / Loss</th>
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-gray-400 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($assets as $asset)
                            <tr class="group hover:bg-gray-50/80 transition-all duration-300">
                                <!-- Asset Name -->
                                <td class="px-8 py-6 whitespace-nowrap text-sm font-black text-gray-900 uppercase tracking-tight">
                                    {{ $asset->name }}
                                </td>
                                <!-- Purchase Date -->
                                <td class="px-8 py-6 whitespace-nowrap text-sm font-bold text-gray-400">
                                    {{ \Carbon\Carbon::parse($asset->purchase_date)->format('d M, Y') }}
                                </td>
                                <!-- Buy Price -->
                                <td class="px-8 py-6 whitespace-nowrap text-sm text-right font-black text-gray-900">
                                    Rp{{ number_format($asset->purchase_price, 0, ',', '.') }}
                                </td>
                                <!-- Status Badge -->
                                <td class="px-8 py-6 text-center whitespace-nowrap">
                                    @if ($asset->status === 'owned')
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100 transition-all">
                                            Owned
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-red-50 text-red-500 border border-red-100 transition-all">
                                            Sold
                                        </span>
                                    @endif
                                </td>
                                <!-- Sale Date -->
                                <td class="px-8 py-6 whitespace-nowrap text-sm font-bold text-gray-400">
                                    {{ $asset->sale_date ? \Carbon\Carbon::parse($asset->sale_date)->format('d M, Y') : '-' }}
                                </td>
                                <!-- Sale Price -->
                                <td class="px-8 py-6 whitespace-nowrap text-sm text-right font-black text-gray-900">
                                    {{ $asset->sale_price ? 'Rp' . number_format($asset->sale_price, 0, ',', '.') : '-' }}
                                </td>
                                <!-- Profit / Loss -->
                                <td class="px-8 py-6 whitespace-nowrap text-sm text-right font-black">
                                    @if ($asset->status === 'sold')
                                        @php
                                            $profit = $asset->sale_price - $asset->purchase_price;
                                        @endphp
                                        <span class="{{ $profit >= 0 ? 'text-emerald-500' : 'text-red-500' }}">
                                            {{ $profit >= 0 ? '+' : '' }}Rp{{ number_format($profit, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-gray-300">-</span>
                                    @endif
                                </td>
                                <!-- Actions -->
                                <td class="px-8 py-6 text-center whitespace-nowrap">
                                    <div class="flex justify-center items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        @if ($asset->status === 'owned')
                                            <!-- Sell Asset Button -->
                                            <button onclick="openSellModal({{ $asset->id }}, '{{ $asset->name }}', '{{ $asset->purchase_date }}')"
                                                class="px-4 py-2 rounded-xl bg-gray-900 text-white text-[10px] font-black uppercase tracking-widest hover:bg-black transition-all duration-300">
                                                Sell Asset
                                            </button>
                                        @endif
                                        <!-- Delete Button -->
                                        <button onclick="confirmDelete({{ $asset->id }}, '{{ $asset->name }}')"
                                            class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-red-500 hover:text-white transition-all duration-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-20 text-center border-4 border-dashed border-gray-50 rounded-[3rem]">
                                    <p class="text-gray-400 font-black uppercase tracking-widest">No assets in inventory</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Register Asset Modal -->
    <div id="assetModal" class="fixed inset-0 z-[99] hidden items-center justify-center p-4 transition-all duration-500">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm opacity-0 transition-opacity duration-500" id="modalBackdrop" onclick="closeModal()"></div>
        <div class="relative bg-white w-full max-w-md rounded-[2rem] p-8 shadow-2xl border border-gray-50 transform transition-all duration-500 translate-y-8 scale-95 opacity-0" id="modalContainer">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-black text-gray-900 uppercase tracking-tighter">Register <span class="text-gray-300">Asset</span></h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="assetForm" action="{{ route('assets.store') }}" method="POST" class="space-y-5">
                @csrf
                <!-- Name -->
                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Asset Name</label>
                    <input type="text" name="name" id="modal_name" required placeholder="Laptop, Vehicle, etc." value="{{ old('name') }}"
                        class="w-full px-4 py-3 bg-gray-50 border-transparent border-2 rounded-xl focus:bg-white focus:border-gray-900 focus:ring-0 transition-all font-semibold text-gray-900 placeholder:text-gray-300 text-sm @error('name', 'create') border-red-500 @enderror">
                    @error('name', 'create')
                        <p class="text-[10px] text-red-500 font-bold ml-1 uppercase asset-error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Purchase Date -->
                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Purchase Date</label>
                    <input type="date" name="purchase_date" id="modal_purchase_date" required value="{{ old('purchase_date', date('Y-m-d')) }}"
                        class="w-full px-4 py-3 bg-gray-50 border-transparent border-2 rounded-xl focus:bg-white focus:border-gray-900 focus:ring-0 transition-all font-semibold text-gray-900 text-sm @error('purchase_date', 'create') border-red-500 @enderror">
                    @error('purchase_date', 'create')
                        <p class="text-[10px] text-red-500 font-bold ml-1 uppercase asset-error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Purchase Price -->
                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Purchase Price</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-gray-300 text-sm">Rp</span>
                        <input type="number" name="purchase_price" id="modal_purchase_price" required placeholder="0" value="{{ old('purchase_price') }}"
                            class="w-full pl-12 pr-4 py-3 bg-gray-50 border-transparent border-2 rounded-xl focus:bg-white focus:border-gray-900 focus:ring-0 transition-all font-black text-gray-900 text-lg tracking-tighter @error('purchase_price', 'create') border-red-500 @enderror">
                    </div>
                    @error('purchase_price', 'create')
                        <p class="text-[10px] text-red-500 font-bold ml-1 uppercase asset-error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full py-4 bg-gray-900 text-white rounded-xl font-bold text-[10px] uppercase tracking-[0.3em] transition-all duration-300 hover:bg-black hover:shadow-lg active:scale-[0.98] mt-2">
                    Save Asset & Log Outflow
                </button>
            </form>
        </div>
    </div>

    <!-- Sell Asset Modal -->
    <div id="sellModal" class="fixed inset-0 z-[99] hidden items-center justify-center p-4 transition-all duration-500">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm opacity-0 transition-opacity duration-500" id="sellBackdrop" onclick="closeSellModal()"></div>
        <div class="relative bg-white w-full max-w-md rounded-[2rem] p-8 shadow-2xl border border-gray-50 transform transition-all duration-500 translate-y-8 scale-95 opacity-0" id="sellContainer">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-black text-gray-900 uppercase tracking-tighter">Sell <span class="text-gray-300" id="sell_asset_title">Asset</span></h3>
                <button onclick="closeSellModal()" class="text-gray-400 hover:text-gray-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="sellForm" action="" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="sell_id" id="modal_sell_id" value="{{ old('sell_id') }}">

                <!-- Sale Date -->
                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Sale Date</label>
                    <input type="date" name="sale_date" id="modal_sale_date" required value="{{ old('sale_date', date('Y-m-d')) }}"
                        class="w-full px-4 py-3 bg-gray-50 border-transparent border-2 rounded-xl focus:bg-white focus:border-gray-900 focus:ring-0 transition-all font-semibold text-gray-900 text-sm @error('sale_date', 'sell') border-red-500 @enderror">
                    @error('sale_date', 'sell')
                        <p class="text-[10px] text-red-500 font-bold ml-1 uppercase asset-error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sale Price -->
                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Sale Price</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-gray-300 text-sm">Rp</span>
                        <input type="number" name="sale_price" id="modal_sale_price" required placeholder="0" value="{{ old('sale_price') }}"
                            class="w-full pl-12 pr-4 py-3 bg-gray-50 border-transparent border-2 rounded-xl focus:bg-white focus:border-gray-900 focus:ring-0 transition-all font-black text-gray-900 text-lg tracking-tighter @error('sale_price', 'sell') border-red-500 @enderror">
                    </div>
                    @error('sale_price', 'sell')
                        <p class="text-[10px] text-red-500 font-bold ml-1 uppercase asset-error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full py-4 bg-gray-900 text-white rounded-xl font-bold text-[10px] uppercase tracking-[0.3em] transition-all duration-300 hover:bg-black hover:shadow-lg active:scale-[0.98] mt-2">
                    Complete Sale & Log Inflow
                </button>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-[110] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm opacity-0 transition-opacity duration-500" id="deleteBackdrop" onclick="closeDeleteModal()"></div>
        <div class="relative bg-white w-full max-w-sm rounded-[2.5rem] p-10 shadow-2xl border border-gray-50 transform transition-all duration-500 translate-y-8 scale-95 opacity-0" id="deleteContainer">
            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center mx-auto mb-6 rotate-12">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>
            <div class="text-center mb-10">
                <h3 class="text-2xl font-black text-gray-900 tracking-tighter uppercase mb-2">Delete <span class="text-red-500">Asset?</span></h3>
                <p class="text-sm text-gray-400 font-medium leading-relaxed">
                    Apakah Anda yakin ingin menghapus aset <span id="delete_desc" class="text-gray-900 font-bold"></span> dari inventory? Semua transaksi pembelian dan penjualan terkait juga akan dihapus.
                </p>
            </div>
            <div class="flex flex-col gap-3">
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-4 bg-red-500 text-white rounded-2xl font-bold text-[10px] uppercase tracking-[0.3em] transition-all duration-300 hover:bg-red-600 hover:shadow-lg">
                        Confirm Delete
                    </button>
                </form>
                <button onclick="closeDeleteModal()" class="w-full py-4 bg-gray-50 text-gray-400 rounded-2xl font-bold text-[10px] uppercase tracking-[0.3em] hover:bg-gray-100">
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
            document.getElementById('sell_asset_title').innerHTML = `Asset <span class="text-gray-900">${name}</span>`;
            sellForm.action = `/assets/${id}/sell`;
            document.getElementById('modal_sell_id').value = id;
            document.getElementById('modal_sale_date').min = purchaseDate;
            document.getElementById('modal_sale_date').value = new Date().toISOString().split('T')[0];
            document.getElementById('modal_sale_price').value = '';

            sellModal.classList.remove('hidden');
            sellModal.classList.add('flex');
            setTimeout(() => {
                sellBackdrop.classList.add('opacity-100');
                sellContainer.classList.remove('translate-y-8', 'scale-95', 'opacity-0');
                sellContainer.classList.add('translate-y-0', 'scale-100', 'opacity-100');
            }, 10);
        }

        function closeSellModal() {
            sellBackdrop.classList.remove('opacity-100');
            sellContainer.classList.remove('translate-y-0', 'scale-100', 'opacity-100');
            sellContainer.classList.add('translate-y-8', 'scale-95', 'opacity-0');
            setTimeout(() => {
                sellModal.classList.remove('flex');
                sellModal.classList.add('hidden');
            }, 500);
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
            // Auto open register modal on validation error
            @if ($errors->create->any())
                openModalCreate();
            @endif

            // Auto open sell modal on validation error
            @if ($errors->sell->any())
                openSellModal({{ old('sell_id') }}, 'Aset', '');
            @endif
        });
    </script>

    <style>
        @keyframes shimmer {
            100% { transform: translateX(100%); }
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
