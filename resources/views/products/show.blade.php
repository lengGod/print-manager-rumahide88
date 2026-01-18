@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
    <!-- Breadcrumbs -->
    <nav class="flex items-center text-sm font-medium mb-6">
        <span class="text-slate-400">Menu Utama</span>
        <span class="material-symbols-outlined text-slate-300 mx-2 text-base">chevron_right</span>
        <a href="{{ route('products.index') }}"
            class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white">Produk</a>
        <span class="material-symbols-outlined text-slate-300 mx-2 text-base">chevron_right</span>
        <span class="text-slate-900 dark:text-white">Detail Produk</span>
    </nav>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6">
        <div class="flex justify-between items-start mb-6 border-b border-slate-100 dark:border-slate-800 pb-6">
            <div>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-2">{{ $product->name }}</h2>
            </div>
            <a href="{{ route('products.edit', $product->id) }}"
                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                Edit
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Nama Produk</p>
                <p class="text-lg text-slate-900 dark:text-white">{{ $product->name }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Tipe Produk</p>
                <p class="text-lg text-slate-900 dark:text-white">{{ $product->productType->name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Kategori</p>
                <p class="text-lg text-slate-900 dark:text-white">{{ $product->productType->category->name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Harga</p>
                <p class="text-lg text-slate-900 dark:text-white">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Satuan</p>
                <p class="text-lg text-slate-900 dark:text-white">{{ $product->unit }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Deskripsi</p>
                <p class="text-lg text-slate-900 dark:text-white">{{ $product->description ?? '-' }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Spesifikasi Produk</h2>
        @if ($product->specifications->isEmpty())
            <p class="text-slate-500 dark:text-slate-400">Tidak ada spesifikasi untuk produk ini.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50">
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nilai</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Harga Tambahan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($product->specifications as $specification)
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-slate-200">{{ $specification->name }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $specification->value }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">Rp {{ number_format($specification->additional_price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
