@extends('layouts.app')

@section('title', 'Unggah File Desain')

@section('content')
    <!-- Breadcrumbs -->
    <nav class="flex items-center text-sm font-medium mb-6">
        <span class="text-slate-400">Menu Utama</span>
        <span class="material-symbols-outlined text-slate-300 mx-2 text-base">chevron_right</span>
        <a href="{{ route('orders.show', $orderItem->order->id) }}"
            class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white">Detail Pesanan</a>
        <span class="material-symbols-outlined text-slate-300 mx-2 text-base">chevron_right</span>
        <span class="text-slate-900 dark:text-white">Unggah File Desain</span>
    </nav>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6">
        <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-6">Unggah File Desain untuk Item Pesanan</h2>

        <div class="mb-6 p-4 bg-slate-50 dark:bg-slate-800 rounded-lg">
            <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-2">Detail Item Pesanan</h3>
            <p class="text-sm text-slate-600 dark:text-slate-400">Pesanan: <a href="{{ route('orders.show', $orderItem->order->id) }}" class="text-primary hover:underline">#{{ $orderItem->order->order_number }}</a></p>
            <p class="text-sm text-slate-600 dark:text-slate-400">Produk: {{ $orderItem->product->name }} (Jumlah: {{ $orderItem->quantity }} {{ $orderItem->product->unit }})</p>
        </div>

        <form action="{{ route('design-files.store', $orderItem->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="file" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Pilih File</label>
                <input type="file" id="file" name="file" required
                    class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-slate-700 dark:text-white">
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Format yang didukung: PDF, JPG, JPEG, PNG, CDR. Ukuran maksimal: 10MB.</p>
                @error('file')
                    <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Catatan (opsional)</label>
                <textarea id="notes" name="notes" rows="3"
                    class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-slate-700 dark:text-white">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('orders.show', $orderItem->order->id) }}"
                    class="px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700 hover:bg-slate-50 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Batal
                </a>
                <button type="submit"
                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Unggah File
                </button>
            </div>
        </form>
    </div>
@endsection
