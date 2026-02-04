@forelse($purchases as $purchase)
    <!-- Desktop Table View -->
    <div class="overflow-x-auto hidden md:block">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-800/50">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Barang</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Toko Asal</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status Bayar</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Dicatat Oleh</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                <tr>
                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $purchase->purchase_date->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-slate-200">{{ $purchase->item_name }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $purchase->source_shop }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-slate-200">Rp {{ number_format($purchase->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-sm">
                        @if ($purchase->payment_status == 'lunas')
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Lunas</span>
                        @else
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">Belum Lunas</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $purchase->createdBy->name }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('external-purchases.edit', $purchase->id) }}" class="text-slate-400 hover:text-amber-600">
                                <span class="material-symbols-outlined text-xl">edit</span>
                            </a>
                            <form action="{{ route('external-purchases.destroy', $purchase->id) }}" method="POST" id="delete-form-{{ $purchase->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    @click.prevent="$dispatch('open-confirm-modal', {
                                        title: 'Hapus Catatan',
                                        message: 'Anda yakin ingin menghapus catatan pembelian ini?',
                                        formId: 'delete-form-{{ $purchase->id }}'
                                    })"
                                    class="text-slate-400 hover:text-rose-600">
                                    <span class="material-symbols-outlined text-xl">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Mobile Card View -->
    <div class="md:hidden">
        <div class="p-4 space-y-4">
            <div class="bg-slate-50 dark:bg-slate-800/50 rounded-lg p-4 border border-slate-200 dark:border-slate-800">
                <div class="flex justify-between items-start mb-2">
                    <span class="font-bold text-slate-900 dark:text-white">{{ $purchase->item_name }}</span>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('external-purchases.edit', $purchase->id) }}" class="text-slate-400 hover:text-amber-600">
                            <span class="material-symbols-outlined text-xl">edit</span>
                        </a>
                        <form action="{{ route('external-purchases.destroy', $purchase->id) }}" method="POST" id="delete-form-mobile-{{ $purchase->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                @click.prevent="$dispatch('open-confirm-modal', {
                                    title: 'Hapus Catatan',
                                    message: 'Anda yakin ingin menghapus catatan pembelian ini?',
                                    formId: 'delete-form-mobile-{{ $purchase->id }}'
                                })"
                                class="text-slate-400 hover:text-rose-600">
                                <span class="material-symbols-outlined text-xl">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="text-sm text-slate-600 dark:text-slate-400 space-y-1">
                    <p><span class="font-medium text-slate-500">Toko:</span> {{ $purchase->source_shop }}</p>
                    <p><span class="font-medium text-slate-500">Harga:</span> Rp {{ number_format($purchase->price, 0, ',', '.') }}</p>
                    <p><span class="font-medium text-slate-500">Tanggal:</span> {{ $purchase->purchase_date->format('d M Y') }}</p>
                    <p><span class="font-medium text-slate-500">Status:</span>
                        @if ($purchase->payment_status == 'lunas')
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Lunas</span>
                        @else
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">Belum Lunas</span>
                        @endif
                    </p>
                     <p><span class="font-medium text-slate-500">Dicatat oleh:</span> {{ $purchase->createdBy->name }}</p>
                    @if($purchase->notes)
                    <p class="text-xs pt-1"><span class="font-medium text-slate-500">Catatan:</span> {{ Str::limit($purchase->notes, 100) }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="p-6">
        <p class="text-center text-sm text-slate-500 dark:text-slate-400">Belum ada catatan pembelian eksternal.</p>
    </div>
@endforelse

<div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
     <div class="text-sm text-slate-500 dark:text-slate-400">
        Menampilkan {{ $purchases->firstItem() }} hingga {{ $purchases->lastItem() }} dari
        {{ $purchases->total() }} hasil
    </div>
    {{ $purchases->links() }}
</div>