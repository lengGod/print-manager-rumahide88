@extends('layouts.app')

@section('title', 'Detail File Desain')

@section('content')
    <!-- Breadcrumbs -->
    <nav class="flex items-center text-sm font-medium mb-6">
        <span class="text-slate-400">Menu Utama</span>
        <span class="material-symbols-outlined text-slate-300 mx-2 text-base">chevron_right</span>
        <a href="{{ route('orders.show', $designFile->orderItem->order->id) }}"
            class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white">Detail Pesanan</a>
        <span class="material-symbols-outlined text-slate-300 mx-2 text-base">chevron_right</span>
        <span class="text-slate-900 dark:text-white">Detail File Desain</span>
    </nav>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-2">File Desain: {{ $designFile->file_name }} (Revisi {{ $designFile->revision }})</h2>
                <p class="text-sm text-slate-600 dark:text-slate-400">Pesanan: <a href="{{ route('orders.show', $designFile->orderItem->order->id) }}" class="text-primary hover:underline">#{{ $designFile->orderItem->order->order_number }}</a></p>
                <p class="text-sm text-slate-600 dark:text-slate-400">Item Pesanan: {{ $designFile->orderItem->product->name }} (Jumlah: {{ $designFile->orderItem->quantity }})</p>
                <p class="text-sm text-slate-600 dark:text-slate-400">Diunggah Oleh: {{ $designFile->uploadedBy->name }} pada {{ $designFile->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('design-files.download', $designFile->id) }}"
                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">download</span>
                    Unduh
                </a>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-2">Status File</h3>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    @switch($designFile->status)
                        @case('approved') bg-emerald-100 text-emerald-700 @break
                        @case('rejected') bg-rose-100 text-rose-700 @break
                        @default bg-slate-100 text-slate-700
                    @endswitch">
                    @switch($designFile->status)
                        @case('uploaded') Diunggah @break
                        @case('approved') Disetujui @break
                        @case('rejected') Ditolak @break
                        @default {{ ucfirst($designFile->status) }}
                    @endswitch
                </span>
                @if ($designFile->approvedBy)
                    <span class="text-sm text-slate-600 dark:text-slate-400">Oleh {{ $designFile->approvedBy->name }} pada {{ $designFile->approved_at->format('d M Y, H:i') }}</span>
                @endif
            </div>

            @if ($designFile->status == 'uploaded')
                <div class="mt-4 flex items-center gap-2">
                    <form action="{{ route('design-files.approve', $designFile->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                            Setujui
                        </button>
                    </form>
                    <button type="button" onclick="showRejectForm()"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                        Tolak
                    </button>
                </div>

                <div id="reject-form-container" class="mt-4 p-4 bg-slate-50 dark:bg-slate-800 rounded-lg hidden">
                    <h4 class="text-md font-semibold text-slate-900 dark:text-white mb-2">Alasan Penolakan</h4>
                    <form action="{{ route('design-files.reject', $designFile->id) }}" method="POST">
                        @csrf
                        <textarea name="notes" rows="3" required
                            class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-slate-700 dark:text-white"
                            placeholder="Jelaskan alasan penolakan..."></textarea>
                        <div class="flex justify-end gap-2 mt-3">
                            <button type="button" onclick="hideRejectForm()"
                                class="px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700 hover:bg-slate-50 dark:hover:bg-slate-600">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                                Kirim Penolakan
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>

        @if ($designFile->notes)
            <div class="mb-6">
                <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-2">Catatan</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">{{ $designFile->notes }}</p>
            </div>
        @endif

        <div class="mt-6 border-t border-slate-200 dark:border-slate-700 pt-6">
            <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-4">Revisi Sebelumnya</h3>
            <div class="overflow-x-auto border border-slate-200 dark:border-slate-800 rounded-lg">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50">
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Revisi</th>
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama File</th>
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Diunggah Oleh</th>
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse ($designFile->orderItem->designFiles->sortByDesc('revision') as $prevFile)
                            @if ($prevFile->id != $designFile->id)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-slate-200">{{ $prevFile->revision }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $prevFile->file_name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                            @switch($prevFile->status)
                                                @case('approved') bg-emerald-100 text-emerald-700 @break
                                                @case('rejected') bg-rose-100 text-rose-700 @break
                                                @default bg-slate-100 text-slate-700
                                            @endswitch">
                                            @switch($prevFile->status)
                                                @case('uploaded') Diunggah @break
                                                @case('approved') Disetujui @break
                                                @case('rejected') Ditolak @break
                                                @default {{ ucfirst($prevFile->status) }}
                                            @endswitch
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $prevFile->uploadedBy->name }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $prevFile->created_at->format('d M Y, H:i') }}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('design-files.show', $prevFile->id) }}"
                                            class="text-slate-400 hover:text-primary">
                                            <span class="material-symbols-outlined text-xl">visibility</span>
                                        </a>
                                        <a href="{{ route('design-files.download', $prevFile->id) }}"
                                            class="text-slate-400 hover:text-blue-600 ml-2">
                                            <span class="material-symbols-outlined text-xl">download</span>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-slate-500 dark:text-slate-400">
                                    Tidak ada revisi sebelumnya ditemukan
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
                    <dd class="mt-1 text-sm text-slate-900 dark:text-white">{{ $designFile->created_at->format('d M Y, H:i') }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-slate-500">Terakhir Diperbarui</dt>
                    <dd class="mt-1 text-sm text-slate-900 dark:text-white">{{ $designFile->updated_at->format('d M Y, H:i') }}</dd>
                </div>
            </dl>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function showRejectForm() {
            document.getElementById('reject-form-container').classList.remove('hidden');
        }

        function hideRejectForm() {
            document.getElementById('reject-form-container').classList.add('hidden');
        }
    </script>
@endpush
