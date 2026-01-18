@extends('layouts.app')

@section('title', 'Dasbor')

@section('content')
    <!-- Breadcrumbs -->
    <nav class="flex items-center text-sm font-medium mb-6">
        <span class="text-slate-400">Menu Utama</span>
        <span class="material-symbols-outlined text-slate-300 mx-2 text-base">chevron_right</span>
        <span class="text-slate-900 dark:text-white">Ringkasan Dasbor</span>
    </nav>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div
            class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total Pesanan Hari Ini</p>
                <div class="bg-primary/10 p-2 rounded-lg text-primary">
                    <span class="material-symbols-outlined">list_alt</span>
                </div>
            </div>
            <div class="flex items-end gap-2">
                <h3 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $todayOrdersCount }}</h3>
                <span class="text-emerald-500 text-sm font-medium mb-1 flex items-center">
                    <span class="material-symbols-outlined text-sm">trending_up</span> Baru
                </span>
            </div>
        </div>

        <div
            class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Pesanan dalam Proses</p>
                <div class="bg-amber-100 p-2 rounded-lg text-amber-600">
                    <span class="material-symbols-outlined">sync</span>
                </div>
            </div>
            <div class="flex items-end gap-2">
                <h3 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $inProgressOrdersCount }}</h3>
                <span class="text-amber-500 text-sm font-medium mb-1 flex items-center">
                    <span class="material-symbols-outlined text-sm">pending</span> Aktif
                </span>
            </div>
        </div>

        <div
            class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Pesanan Selesai</p>
                <div class="bg-emerald-100 p-2 rounded-lg text-emerald-600">
                    <span class="material-symbols-outlined">task_alt</span>
                </div>
            </div>
            <div class="flex items-end gap-2">
                <h3 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $completedOrdersCount }}</h3>
                <span class="text-emerald-500 text-sm font-medium mb-1 flex items-center">
                    <span class="material-symbols-outlined text-sm">done_all</span> Selesai
                </span>
            </div>
        </div>

        <div
            class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Peringatan Stok Rendah</p>
                <div class="bg-rose-100 p-2 rounded-lg text-rose-600">
                    <span class="material-symbols-outlined">warning</span>
                </div>
            </div>
            <div class="flex items-end gap-2">
                <h3 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $lowStockMaterialsCount }}</h3>
                <span class="text-slate-400 text-sm font-medium mb-1">Item berisiko</span>
            </div>
        </div>
    </div>

    <!-- Content Split -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Orders -->
                <div
                    class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 flex flex-col">
                    <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Pesanan Terbaru</h2>
                        <a href="{{ route('orders.index') }}" class="text-primary text-sm font-semibold hover:underline">Lihat
                            Semua</a>
                    </div>
        
                    <!-- Mobile Card View -->
                    <div class="md:hidden">
                        <div class="p-4 space-y-4">
                            @forelse($recentOrders as $order)
                                <div
                                    class="bg-slate-50 dark:bg-slate-800/50 rounded-lg p-4 border border-slate-200 dark:border-slate-800">
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="font-bold text-slate-900 dark:text-white">{{ $order->order_number }}</span>
                                        <a href="{{ route('orders.show', $order->id) }}"
                                            class="text-slate-400 hover:text-primary">
                                            <span class="material-symbols-outlined text-xl">visibility</span>
                                        </a>
                                    </div>
                                    <div class="text-sm text-slate-600 dark:text-slate-400 space-y-1">
                                        <p><span class="font-medium text-slate-500">Pelanggan:</span> {{ $order->customer->name }}
                                        </p>
                                        <p><span class="font-medium text-slate-500">Layanan:</span>
                                            {{ $order->items->first()->product->name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="mt-4">
                                        @switch($order->status)
                                            @case('Menunggu Desain')
                                                <span
                                                    class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Menunggu
                                                    Desain</span>
                                            @break
        
                                            @case('Proses Desain')
                                                <span
                                                    class="px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">Proses
                                                    Desain</span>
                                            @break
        
                                            @case('Proses Cetak')
                                                <span
                                                    class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">Proses
                                                    Cetak</span>
                                            @break
        
                                            @case('Finishing')
                                                <span
                                                    class="px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">Finishing</span>
                                            @break
        
                                            @case('Siap Diambil')
                                                <span
                                                    class="px-2.5 py-1 rounded-full text-xs font-semibold bg-teal-100 text-teal-700">Siap
                                                    Diambil</span>
                                            @break
        
                                            @case('Selesai')
                                                <span
                                                    class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Selesai</span>
                                            @break
        
                                            @default
                                                <span
                                                    class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">{{ $order->status }}</span>
                                        @endswitch
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <p class="text-sm text-slate-500 dark:text-slate-400">Tidak ada pesanan ditemukan</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
        
                    <!-- Desktop Table View -->
                    <div class="overflow-x-auto hidden md:block">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 dark:bg-slate-800/50">
                                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">ID Pesanan
                                    </th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Pelanggan
                                    </th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Layanan</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @forelse($recentOrders as $order)
                                    <tr>
                                        <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-slate-200">
                                            {{ $order->order_number }}</td>
                                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                            {{ $order->customer->name }}</td>
                                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                            {{ $order->items->first()->product->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @switch($order->status)
                                                @case('Menunggu Desain')
                                                    <span
                                                        class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Menunggu
                                                        Desain</span>
                                                @break
        
                                                @case('Proses Desain')
                                                    <span
                                                        class="px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">Proses
                                                        Desain</span>
                                                @break
        
                                                @case('Proses Cetak')
                                                    <span
                                                        class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">Proses
                                                        Cetak</span>
                                                @break
        
                                                @case('Finishing')
                                                    <span
                                                        class="px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">Finishing</span>
                                                @break
        
                                                @case('Siap Diambil')
                                                    <span
                                                        class="px-2.5 py-1 rounded-full text-xs font-semibold bg-teal-100 text-teal-700">Siap
                                                        Diambil</span>
                                                @break
        
                                                @case('Selesai')
                                                    <span
                                                        class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Selesai</span>
                                                @break
        
                                                @default
                                                    <span
                                                        class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">{{ $order->status }}</span>
                                            @endswitch
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('orders.show', $order->id) }}"
                                                class="text-slate-400 hover:text-primary">
                                                <span class="material-symbols-outlined text-xl">visibility</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5"
                                            class="px-6 py-4 text-center text-sm text-slate-500 dark:text-slate-400">
                                            Tidak ada pesanan ditemukan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            <!-- Material Stock Sidebar -->
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 flex flex-col p-6">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-6">Status Stok Material</h2>
                <div class="space-y-6">
                    @forelse($materials->take(4) as $material)
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm font-medium">
                                <span class="text-slate-600 dark:text-slate-400">{{ $material->name }}</span>
                                <span
                                    class="{{ $material->isLowStock() ? 'text-rose-600' : 'text-slate-900 dark:text-white' }}">
                                    {{ round(($material->current_stock / ($material->minimum_stock * 2)) * 100) }}%
                                </span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-2">
                                <div class="{{ $material->isLowStock() ? 'bg-rose-500' : (round(($material->current_stock / ($material->minimum_stock * 2)) * 100) > 70 ? 'bg-emerald-500' : (round(($material->current_stock / ($material->minimum_stock * 2)) * 100) > 40 ? 'bg-amber-500' : 'bg-primary')) }} h-2 rounded-full"
                                    style="width: {{ min(100, round(($material->current_stock / ($material->minimum_stock * 2)) * 100)) }}%">
                                </div>
                            </div>
                            @if ($material->isLowStock())
                                <p class="text-[10px] text-rose-500 font-bold uppercase tracking-tight">Peringatan Stok Rendah</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-sm text-slate-500 dark:text-slate-400">Tidak ada material ditemukan</p>
                    @endforelse

                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                        <a href="{{ route('materials.index') }}"
                            class="w-full py-2.5 bg-primary/10 text-primary rounded-lg text-sm font-bold hover:bg-primary/20 transition-colors text-center block">
                            Kelola Inventaris
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endsection
