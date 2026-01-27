@extends('layouts.app')

@section('title', 'Tambah Catatan Pembelian Eksternal')

@section('content')
    <!-- Breadcrumbs -->
    <nav class="flex items-center text-sm font-medium mb-6">
        <a href="{{ route('external-purchases.index') }}" class="text-slate-400 hover:text-primary">Pembelian Eksternal</a>
        <span class="material-symbols-outlined text-slate-300 mx-2 text-base">chevron_right</span>
        <span class="text-slate-900 dark:text-white">Tambah Catatan</span>
    </nav>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Formulir Pembelian Eksternal</h2>
        </div>

        <form action="{{ route('external-purchases.store') }}" method="POST" class="p-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Purchase Date -->
                <div class="flex flex-col">
                    <label for="purchase_date" class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Tanggal Pembelian <span class="text-rose-500">*</span></label>
                    <input type="date" id="purchase_date" name="purchase_date"
                        class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-primary/50 dark:focus:ring-primary/50 text-slate-900 dark:text-white"
                        value="{{ old('purchase_date', date('Y-m-d')) }}" required>
                    @error('purchase_date')
                        <p class="text-sm text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Item Name -->
                <div class="flex flex-col">
                    <label for="item_name" class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nama Barang <span class="text-rose-500">*</span></label>
                    <input type="text" id="item_name" name="item_name"
                        class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-primary/50 dark:focus:ring-primary/50 text-slate-900 dark:text-white"
                        value="{{ old('item_name') }}" placeholder="Contoh: Tinta Printer Epson" required>
                    @error('item_name')
                        <p class="text-sm text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Source Shop -->
                <div class="flex flex-col">
                    <label for="source_shop" class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Toko Asal <span class="text-rose-500">*</span></label>
                    <input type="text" id="source_shop" name="source_shop"
                        class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-primary/50 dark:focus:ring-primary/50 text-slate-900 dark:text-white"
                        value="{{ old('source_shop') }}" placeholder="Contoh: Toko ATK Jaya" required>
                    @error('source_shop')
                        <p class="text-sm text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div class="flex flex-col">
                    <label for="price" class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Total Harga <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-500">Rp</span>
                        <input type="number" id="price" name="price"
                            class="pl-10 pr-4 py-2 w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-primary/50 dark:focus:ring-primary/50 text-slate-900 dark:text-white"
                            value="{{ old('price') }}" placeholder="150000" min="0" required>
                    </div>
                     @error('price')
                        <p class="text-sm text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Payment Status -->
                <div class="flex flex-col">
                    <label for="payment_status" class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Status Pembayaran <span class="text-rose-500">*</span></label>
                    <select id="payment_status" name="payment_status"
                        class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-primary/50 dark:focus:ring-primary/50 text-slate-900 dark:text-white"
                        required>
                        <option value="belum lunas" {{ old('payment_status') == 'belum lunas' ? 'selected' : '' }}>Belum Lunas</option>
                        <option value="lunas" {{ old('payment_status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                    </select>
                    @error('payment_status')
                        <p class="text-sm text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div class="flex flex-col md:col-span-2">
                    <label for="notes" class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Catatan</label>
                    <textarea id="notes" name="notes" rows="3"
                        class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-primary/50 dark:focus:ring-primary/50 text-slate-900 dark:text-white"
                        placeholder="Informasi tambahan seperti detail barang, nomor referensi, dll.">{{ old('notes') }}</textarea>
                    @error('notes')
                         <p class="text-sm text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-6">
                <a href="{{ route('external-purchases.index') }}"
                    class="px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-lg text-sm font-medium hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                    Batal
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary/90 transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">save</span>
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
