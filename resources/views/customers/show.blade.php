@extends('layouts.app')

@section('title', 'Detail Pelanggan')

@section('content')
    <!-- Breadcrumbs -->
    <nav class="flex items-center text-sm font-medium mb-6">
        <span class="text-slate-400">Menu Utama</span>
        <span class="material-symbols-outlined text-slate-300 mx-2 text-base">chevron_right</span>
        <a href="{{ route('customers.index') }}" class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white">Pelanggan</a>
        <span class="material-symbols-outlined text-slate-300 mx-2 text-base">chevron_right</span>
        <span class="text-slate-900 dark:text-white">Detail Pelanggan</span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Customer Details Card -->
        <div class="md:col-span-1">
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-2">{{ $customer->name }}</h2>
                    </div>
                    <a href="{{ route('customers.edit', $customer->id) }}"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                        Ubah
                    </a>
                </div>
                
                <div class="mt-4 space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Email</dt>
                        <dd class="mt-1 text-sm text-slate-900 dark:text-white">{{ $customer->email ?? '-' }}</dd>
                    </div>
                     <div>
                        <dt class="text-sm font-medium text-slate-500">Telepon</dt>
                        <dd class="mt-1 text-sm text-slate-900 dark:text-white">{{ $customer->phone }}</dd>
                    </div>
                     <div>
                        <dt class="text-sm font-medium text-slate-500">Alamat</dt>
                        <dd class="mt-1 text-sm text-slate-900 dark:text-white">{{ $customer->address ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Catatan</dt>
                        <dd class="mt-1 text-sm text-slate-900 dark:text-white">{{ $customer->notes ?? '-' }}</dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders History -->
        <div class="md:col-span-2">
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
                <div class="p-6 border-b border-slate-100 dark:border-slate-800">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Riwayat Pesanan</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-800/50">
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">ID Pesanan</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status Pembayaran</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse($orders as $order)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-slate-800 dark:text-slate-300">{{ $order->order_number }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $order->order_date->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">Rp {{ number_format($order->final_amount, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $order->status }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        @switch($order->payment_status)
                                            @case('paid')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-500/10 dark:text-emerald-400">
                                                    Lunas
                                                </span>
                                            @break
                                            @case('partial')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800 dark:bg-amber-500/10 dark:text-amber-400">
                                                    Sebagian
                                                </span>
                                            @break
                                            @case('unpaid')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-rose-100 text-rose-800 dark:bg-rose-500/10 dark:text-rose-400">
                                                    Belum Lunas
                                                </span>
                                            @break
                                            @default
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                    {{ $order->payment_status }}
                                                </span>
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <a href="{{ route('orders.show', $order->id) }}" class="text-primary hover:underline">Lihat</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-slate-500">Tidak ada pesanan yang ditemukan untuk pelanggan ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                 @if ($orders->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                         {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
