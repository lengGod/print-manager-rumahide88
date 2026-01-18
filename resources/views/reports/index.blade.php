@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
    <div class="container mx-auto p-4">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Laporan</h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('reports.customers') }}"
                class="block p-6 bg-white dark:bg-slate-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Laporan Pelanggan</h2>
                <p class="text-gray-600 dark:text-gray-400">Lihat daftar pelanggan beserta transaksi mereka.</p>
            </a>

            <a href="{{ route('reports.orders') }}"
                class="block p-6 bg-white dark:bg-slate-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Laporan Pesanan</h2>
                <p class="text-gray-600 dark:text-gray-400">Lihat semua pesanan yang telah tercatat.</p>
            </a>

            <a href="{{ route('reports.production') }}"
                class="block p-6 bg-white dark:bg-slate-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Laporan Produksi</h2>
                <p class="text-gray-600 dark:text-gray-400">Lihat status dan log produksi.</p>
            </a>

            <a href="{{ route('reports.materials') }}"
                class="block p-6 bg-white dark:bg-slate-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Laporan Bahan Baku</h2>
                <p class="text-gray-600 dark:text-gray-400">Pantau penggunaan dan stok bahan baku.</p>
            </a>

            <a href="{{ route('reports.profit') }}"
                class="block p-6 bg-white dark:bg-slate-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Laporan Laba Rugi</h2>
                <p class="text-gray-600 dark:text-gray-400">Analisis pendapatan dan pengeluaran.</p>
            </a>
        </div>
    </div>
@endsection
