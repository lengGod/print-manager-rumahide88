@extends('layouts.app')

@section('title', 'File Desain')

@section('content')
    <!-- Breadcrumbs -->
    <nav class="flex items-center text-sm font-medium mb-6">
        <span class="text-slate-400">Menu Utama</span>
        <span class="material-symbols-outlined text-slate-300 mx-2 text-base">chevron_right</span>
        <span class="text-slate-900 dark:text-white">File Desain</span>
    </nav>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
    <div class="p-6 border-b border-slate-100 dark:border-slate-800">
        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Semua File Desain</h2>
    </div>

    <!-- Mobile Card View -->
    <div class="md:hidden">
        <div class="p-4 space-y-4">
            @forelse($designFiles as $file)
                <div
                    class="bg-slate-50 dark:bg-slate-800/50 rounded-lg p-4 border border-slate-200 dark:border-slate-800">
                    <div class="flex justify-between items-start mb-2">
                        <span
                            class="font-bold text-slate-900 dark:text-white truncate pr-4">{{ $file->file_name }}</span>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <a href="{{ route('design-files.download', $file->id) }}"
                                class="text-slate-400 hover:text-primary">
                                <span class="material-symbols-outlined text-xl">download</span>
                            </a>
                            <form action="{{ route('design-files.destroy', $file->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus file desain ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-400 hover:text-rose-600">
                                    <span class="material-symbols-outlined text-xl">delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="text-sm text-slate-600 dark:text-slate-400 space-y-1">
                        <p><span class="font-medium text-slate-500">Pesanan:</span>
                            {{ $file->orderItem->order->order_number }}</p>
                        <p><span class="font-medium text-slate-500">Pelanggan:</span>
                            {{ $file->orderItem->order->customer->name }}</p>
                        <p><span class="font-medium text-slate-500">Diunggah oleh:</span>
                            {{ $file->uploadedBy->name }}</p>
                        <p><span class="font-medium text-slate-500">Tanggal:</span>
                            {{ $file->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="mt-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                            @switch($file->status)
                                @case('approved') bg-emerald-100 text-emerald-700 @break
                                @case('rejected') bg-rose-100 text-rose-700 @break
                                @default bg-slate-100 text-slate-700
                            @endswitch">
                            @switch($file->status)
                                @case('uploaded') Diunggah @break
                                @case('approved') Disetujui @break
                                @case('rejected') Ditolak @break
                                @default {{ ucfirst($file->status) }}
                            @endswitch
                        </span>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Tidak ada file desain ditemukan</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Desktop Table View -->
    <div class="overflow-x-auto hidden md:block">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-800/50">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama File</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Pesanan</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Pelanggan</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Diunggah Oleh</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($designFiles as $file)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-slate-200">
                            {{ $file->file_name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                            {{ $file->orderItem->order->order_number }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                            {{ $file->orderItem->order->customer->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                            {{ $file->uploadedBy->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                            {{ $file->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                @switch($file->status)
                                    @case('approved') bg-emerald-100 text-emerald-700 @break
                                    @case('rejected') bg-rose-100 text-rose-700 @break
                                    @default bg-slate-100 text-slate-700
                                @endswitch">
                                @switch($file->status)
                                    @case('uploaded') Diunggah @break
                                    @case('approved') Disetujui @break
                                    @case('rejected') Ditolak @break
                                    @default {{ ucfirst($file->status) }}
                                @endswitch
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('design-files.download', $file->id) }}"
                                    class="text-slate-400 hover:text-primary">
                                    <span class="material-symbols-outlined text-xl">download</span>
                                </a>
                                <form action="{{ route('design-files.destroy', $file->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus file desain ini?')">
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
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-slate-500 dark:text-slate-400">
                            Tidak ada file desain ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($designFiles->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <div class="text-sm text-slate-500 dark:text-slate-400">
                Menampilkan {{ $designFiles->firstItem() }} hingga {{ $designFiles->lastItem() }} dari
                {{ $designFiles->total() }} hasil
            </div>
            {{ $designFiles->links() }}
        </div>
    @endif
</div>
@endsection
