@extends('layouts.app')

@section('title', 'Daftar Bahan')

@section('content')
    <!-- Breadcrumbs -->
    <nav class="flex items-center text-sm font-medium mb-6">
        <span class="text-slate-400">Menu Utama</span>
        <span class="material-symbols-outlined text-slate-300 mx-2 text-base">chevron_right</span>
        <span class="text-slate-900 dark:text-white">Bahan</span>
    </nav>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
    <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Semua Bahan</h2>
        <a href="{{ route('materials.create') }}"
            class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary/90 transition-colors flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">add</span>
            <span class="hidden sm:inline">Tambah Bahan</span>
        </a>
    </div>

    <!-- Mobile Card View -->
    <div class="md:hidden">
        <div class="p-4 space-y-4">
            @forelse($materials as $material)
                <div
                    class="bg-slate-50 dark:bg-slate-800/50 rounded-lg p-4 border border-slate-200 dark:border-slate-800">
                    <div class="flex justify-between items-start mb-2">
                        <span class="font-bold text-slate-900 dark:text-white">{{ $material->name }}</span>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('materials.show', $material->id) }}"
                                class="text-slate-400 hover:text-primary">
                                <span class="material-symbols-outlined text-xl">visibility</span>
                            </a>
                            <a href="{{ route('materials.edit', $material->id) }}"
                                class="text-slate-400 hover:text-amber-600">
                                <span class="material-symbols-outlined text-xl">edit</span>
                            </a>
                            <form action="{{ route('materials.destroy', $material->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus bahan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-400 hover:text-rose-600">
                                    <span class="material-symbols-outlined text-xl">delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="text-sm text-slate-600 dark:text-slate-400 space-y-1">
                        <p><span class="font-medium text-slate-500">Stok Saat Ini:</span>
                            {{ number_format($material->current_stock, 0, ',', '.') }} {{ $material->unit }}
                            @if ($material->isLowStock())
                                <span class="ml-2 px-2 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-700">Stok Rendah</span>
                            @endif
                        </p>
                        <p><span class="font-medium text-slate-500">Stok Minimum:</span>
                            {{ number_format($material->minimum_stock, 0, ',', '.') }} {{ $material->unit }}</p>
                        <p><span class="font-medium text-slate-500">Harga:</span> Rp
                            {{ number_format($material->price, 0, ',', '.') }}</p>
                        <p class="text-xs pt-1">{{ Str::limit($material->description, 100) }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Tidak ada bahan yang ditemukan</p>
                </div>
            @endforelse
        </div>
    </div>


    <!-- Desktop Table View -->
    <div class="overflow-x-auto hidden md:block">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-800/50">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Stok Saat Ini</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Stok Minimum</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Deskripsi</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($materials as $material)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-slate-200">
                            {{ $material->name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                            {{ number_format($material->current_stock, 0, ',', '.') }} {{ $material->unit }}
                            @if ($material->isLowStock())
                                <span
                                    class="ml-2 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-700">Stok
                                    Rendah</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                            {{ number_format($material->minimum_stock, 0, ',', '.') }} {{ $material->unit }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-slate-200">
                            Rp {{ number_format($material->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                            {{ Str::limit($material->description, 50) }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('materials.show', $material->id) }}"
                                    class="text-slate-400 hover:text-primary">
                                    <span class="material-symbols-outlined text-xl">visibility</span>
                                </a>
                                <a href="{{ route('materials.edit', $material->id) }}"
                                    class="text-slate-400 hover:text-amber-600">
                                    <span class="material-symbols-outlined text-xl">edit</span>
                                </a>
                                <form action="{{ route('materials.destroy', $material->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus bahan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-slate-400 hover:text-rose-600">
                                        <span class="material-symbols-outlined text-xl">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-slate-500 dark:text-slate-400">
                            Tidak ada bahan yang ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
        <div class="text-sm text-slate-500 dark:text-slate-400">
            Menampilkan {{ $materials->firstItem() }} hingga {{ $materials->lastItem() }} dari
            {{ $materials->total() }} hasil
        </div>
        {{ $materials->links() }}
    </div>
</div>
    @endsection
