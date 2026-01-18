@extends('layouts.app')

@section('title', 'Detail Bahan')

@section('content')
    <!-- Breadcrumbs -->
    <nav class="flex items-center text-sm font-medium mb-6">
        <span class="text-slate-400">Menu Utama</span>
        <span class="material-symbols-outlined text-slate-300 mx-2 text-base">chevron_right</span>
        <a href="{{ route('materials.index') }}"
            class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white">Bahan</a>
        <span class="material-symbols-outlined text-slate-300 mx-2 text-base">chevron_right</span>
        <span class="text-slate-900 dark:text-white">Detail Bahan</span>
    </nav>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-2">{{ $material->name }}</h2>
                <p class="text-sm text-slate-600 dark:text-slate-400">Stok Saat Ini: {{ number_format($material->current_stock, 0, ',', '.') }} {{ $material->unit }}</p>
                <p class="text-sm text-slate-600 dark:text-slate-400">Stok Minimum: {{ number_format($material->minimum_stock, 0, ',', '.') }} {{ $material->unit }}</p>
                <p class="text-sm text-slate-600 dark:text-slate-400">Harga per Satuan: Rp {{ number_format($material->price, 0, ',', '.') }}</p>
            </div>
            <a href="{{ route('materials.edit', $material->id) }}"
                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                Edit
            </a>
        </div>

        @if ($material->description)
            <div class="mb-6">
                <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-2">Deskripsi</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">{{ $material->description }}</p>
            </div>
        @endif

        <div class="mb-6">
            <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-4">Manajemen Stok</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Add Stock Form -->
                <div class="bg-slate-50 dark:bg-slate-800 p-4 rounded-lg">
                    <h4 class="text-md font-semibold text-slate-900 dark:text-white mb-3">Tambah Stok</h4>
                    <form action="{{ route('materials.add-stock', $material->id) }}" method="POST" class="flex flex-col gap-3">
                        @csrf
                        <div>
                            <label for="add_quantity" class="sr-only">Jumlah</label>
                            <input type="number" id="add_quantity" name="quantity" min="0.01" step="0.01" required
                                class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-slate-700 dark:text-white"
                                placeholder="Jumlah">
                        </div>
                        <div>
                            <label for="add_description" class="sr-only">Deskripsi</label>
                            <textarea id="add_description" name="description" rows="2"
                                class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-slate-700 dark:text-white"
                                placeholder="Deskripsi (opsional)"></textarea>
                        </div>
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Tambah Stok
                        </button>
                    </form>
                </div>

                <!-- Use Stock Form -->
                <div class="bg-slate-50 dark:bg-slate-800 p-4 rounded-lg">
                    <h4 class="text-md font-semibold text-slate-900 dark:text-white mb-3">Gunakan Stok</h4>
                    <form action="{{ route('materials.use-stock', $material->id) }}" method="POST" class="flex flex-col gap-3">
                        @csrf
                        <div>
                            <label for="use_quantity" class="sr-only">Jumlah</label>
                            <input type="number" id="use_quantity" name="quantity" min="0.01" step="0.01" required
                                class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-slate-700 dark:text-white"
                                placeholder="Jumlah">
                        </div>
                        <div>
                            <label for="use_description" class="sr-only">Deskripsi</label>
                            <textarea id="use_description" name="description" rows="2"
                                class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-slate-700 dark:text-white"
                                placeholder="Deskripsi (opsional)"></textarea>
                        </div>
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                            Gunakan Stok
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-6 border-t border-slate-200 dark:border-slate-700 pt-6">
            <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-4">Log Stok</h3>
            <div class="overflow-x-auto border border-slate-200 dark:border-slate-800 rounded-lg">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50">
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Stok Sebelumnya</th>
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Stok Baru</th>
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Oleh</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse ($material->stockLogs as $log)
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-slate-200">{{ $log->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                    @if ($log->type == 'in')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Masuk</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-700">Keluar</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ number_format($log->quantity, 0, ',', '.') }} {{ $material->unit }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ number_format($log->previous_stock, 0, ',', '.') }} {{ $material->unit }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ number_format($log->new_stock, 0, ',', '.') }} {{ $material->unit }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $log->description }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $log->createdBy->name ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-slate-500 dark:text-slate-400">
                                    Tidak ada log stok ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6 border-t border-slate-200 dark:border-slate-700 pt-6">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-slate-500">Dibuat Pada</dt>
                    <dd class="mt-1 text-sm text-slate-900 dark:text-white">{{ $material->created_at->format('d M Y, H:i') }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-slate-500">Terakhir Diperbarui</dt>
                    <dd class="mt-1 text-sm text-slate-900 dark:text-white">{{ $material->updated_at->format('d M Y, H:i') }}</dd>
                </div>
            </dl>
        </div>
    </div>
@endsection
