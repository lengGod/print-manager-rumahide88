@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
    <!-- Breadcrumbs -->
    <nav class="flex items-center text-sm font-medium mb-6">
        <span class="text-slate-400">Menu Utama</span>
        <span class="material-symbols-outlined text-slate-300 mx-2 text-base">chevron_right</span>
        <a href="{{ route('orders.index') }}"
            class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white">Pesanan</a>
        <span class="material-symbols-outlined text-slate-300 mx-2 text-base">chevron_right</span>
        <span class="text-slate-900 dark:text-white">Detail Pesanan</span>
    </nav>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Pesanan #{{ $order->order_number }}</h2>
                <p class="text-sm text-slate-600 dark:text-slate-400">Pelanggan: <a
                        href="{{ route('customers.show', $order->customer->id) }}"
                        class="text-primary hover:underline">{{ $order->customer->name }}</a></p>
                <p class="text-sm text-slate-600 dark:text-slate-400">Tanggal Pesanan:
                    {{ $order->order_date->format('d M Y') }}</p>
                <p class="text-sm text-slate-600 dark:text-slate-400">Batas Waktu: {{ $order->deadline->format('d M Y') }}
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('orders.edit', $order->id) }}"
                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">edit</span>
                    Edit
                </a>
                <div class="relative inline-block text-left" x-data="{ open: false }">
                    <div>
                        <button @click="open = !open" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-blue-600 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500"
                            id="menu-button" aria-expanded="true" aria-haspopup="true">
                            <span class="material-symbols-outlined text-lg mr-2">receipt_long</span>
                            Faktur
                            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    <div x-show="open" @click.away="open = false"
                        class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                        role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                        <div class="py-1" role="none">
                            <a href="{{ route('orders.invoice', $order->id) }}" target="_blank"
                                class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                                id="menu-item-0">Faktur (ID)</a>
                            <a href="{{ route('orders.invoice', ['order' => $order->id, 'lang' => 'en']) }}" target="_blank"
                                class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                                id="menu-item-1">Invoice (EN)</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Status -->
        <div class="mb-6">
            <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-2">Status Pesanan</h3>
            <div class="flex items-center gap-2">
                @switch($order->status)
                    @case('Menunggu Desain')
                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-700">Menunggu Desain</span>
                    @break

                    @case('Proses Desain')
                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-indigo-100 text-indigo-700">Proses
                            Desain</span>
                    @break

                    @case('Proses Cetak')
                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-amber-100 text-amber-700">Proses Cetak</span>
                    @break

                    @case('Finishing')
                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-purple-100 text-purple-700">Finishing</span>
                    @break

                    @case('Siap Diambil')
                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-teal-100 text-teal-700">Siap Diambil</span>
                    @break

                    @case('Selesai')
                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-700">Selesai</span>
                    @break

                    @default
                        <span
                            class="px-3 py-1 rounded-full text-sm font-semibold bg-slate-100 text-slate-700">{{ $order->status }}</span>
                @endswitch
            </div>
            <form action="{{ route('orders.update-status', $order->id) }}" method="POST"
                class="mt-4 flex items-center gap-2">
                @csrf
                <select name="status"
                    class="w-48 px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-slate-700 dark:text-white">
                    <option value="Menunggu Desain" {{ $order->status == 'Menunggu Desain' ? 'selected' : '' }}>Menunggu
                        Desain</option>
                    <option value="Proses Desain" {{ $order->status == 'Proses Desain' ? 'selected' : '' }}>Proses Desain
                    </option>
                    <option value="Proses Cetak" {{ $order->status == 'Proses Cetak' ? 'selected' : '' }}>Proses Cetak
                    </option>
                    <option value="Finishing" {{ $order->status == 'Finishing' ? 'selected' : '' }}>Finishing</option>
                    <option value="Siap Diambil" {{ $order->status == 'Siap Diambil' ? 'selected' : '' }}>Siap Diambil
                    </option>
                    <option value="Selesai" {{ $order->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                <button type="submit"
                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Perbarui Status
                </button>
            </form>
        </div>

        <!-- Order Items -->
        <div class="mb-6">
            <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-4">Item Pesanan</h3>
            <div class="overflow-x-auto border border-slate-200 dark:border-slate-800 rounded-lg">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50">
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Produk</th>
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Kuantitas</th>
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Ukuran</th>
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Harga Satuan
                            </th>
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Spesifikasi</th>
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">File Desain</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-slate-200">
                                    {{ $item->product->name }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $item->quantity }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                    @if ($item->product->unit === 'meter' && $item->size)
                                        {{ $item->size }} cm
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">Rp
                                    {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                    @if ($item->specifications && count(json_decode($item->specifications)) > 0)
                                        <ul class="list-disc list-inside">
                                            @foreach (json_decode($item->specifications) as $spec)
                                                <li>{{ $spec->name }}: {{ $spec->value }} (+Rp
                                                    {{ number_format($spec->additional_price, 0, ',', '.') }})</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-slate-200">Rp
                                    {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm">
                                    @if ($item->designFiles->count() > 0)
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('design-files.download', $item->designFiles->first()->id) }}"
                                                class="text-blue-600 hover:underline">Unduh</a>
                                            <span
                                                class="text-xs px-2 py-1 rounded-full {{ $item->designFiles->first()->status == 'approved' ? 'bg-emerald-100 text-emerald-700' : ($item->designFiles->first()->status == 'rejected' ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-700') }}">
                                                {{ ucfirst($item->designFiles->first()->status) }}
                                            </span>
                                        </div>
                                    @else
                                        <a href="{{ route('design-files.create', $item->id) }}"
                                            class="text-primary hover:underline">Unggah Desain</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="mb-6 p-4 bg-slate-50 dark:bg-slate-800 rounded-lg">
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Subtotal:</span>
                <span class="text-sm font-medium text-slate-900 dark:text-white">Rp
                    {{ number_format($order->subtotal_amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Diskon:</span>
                <span class="text-sm font-medium text-slate-900 dark:text-white">Rp
                    {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center pt-2 border-t border-slate-200 dark:border-slate-700">
                <span class="text-base font-semibold text-slate-900 dark:text-white">Total:</span>
                <span class="text-base font-semibold text-slate-900 dark:text-white">Rp
                    {{ number_format($order->final_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Notes -->
        @if ($order->notes)
            <div class="mb-6">
                <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-2">Catatan</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">{{ $order->notes }}</p>
            </div>
        @endif

        <div class="mt-6 border-t border-slate-200 dark:border-slate-700 pt-6">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-slate-500">Dibuat Pada</dt>
                    <dd class="mt-1 text-sm text-slate-900 dark:text-white">{{ $order->created_at->format('d M Y, H:i') }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-slate-500">Terakhir Diperbarui</dt>
                    <dd class="mt-1 text-sm text-slate-900 dark:text-white">{{ $order->updated_at->format('d M Y, H:i') }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>
@endsection
