@forelse($orders as $order)
    <!-- Mobile Card View -->
    <div class="md:hidden">
        <div class="p-4 space-y-4">
            <div
                class="bg-slate-50 dark:bg-slate-800/50 rounded-lg p-4 border border-slate-200 dark:border-slate-800">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <span class="font-bold text-slate-900 dark:text-white">{{ $order->order_number }}</span>
                        <p class="text-xs text-slate-500">{{ $order->order_date->format('d M Y') }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('orders.show', $order->id) }}" class="text-slate-400 hover:text-primary">
                            <span class="material-symbols-outlined text-xl">visibility</span>
                        </a>
                        <a href="{{ route('orders.edit', $order->id) }}"
                            class="text-slate-400 hover:text-amber-600">
                            <span class="material-symbols-outlined text-xl">edit</span>
                        </a>
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
                            id="delete-form-{{ $order->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                @click.prevent="$dispatch('open-confirm-modal', {
                                title: 'Hapus Pesanan',
                                message: 'Anda yakin ingin menghapus pesanan ini?',
                                formId: 'delete-form-{{ $order->id }}'
                            })"
                                class="text-slate-400 hover:text-rose-600">
                                <span class="material-symbols-outlined text-xl">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="text-sm text-slate-600 dark:text-slate-400 space-y-2">
                    <p><span class="font-medium text-slate-500">Pelanggan:</span> {{ $order->customer->name }}</p>
                    <p><span class="font-medium text-slate-500">Total:</span> Rp
                        {{ number_format($order->final_amount, 0, ',', '.') }}</p>
                    <div class="flex items-center gap-2">
                        <span class="font-medium text-slate-500">Status:</span>
                        @switch($order->status)
                            @case('Menunggu Desain')
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Menunggu
                                    Desain</span>
                            @break

                            @case('Proses Desain')
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">Mendesain</span>
                            @break

                            @case('Proses Cetak')
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">Mencetak</span>
                            @break

                            @case('Finishing')
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">Finishing</span>
                            @break

                            @case('Siap Diambil')
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-semibold bg-teal-100 text-teal-700">Siap</span>
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
                    <div class="flex items-center gap-2">
                        <span class="font-medium text-slate-500">Pembayaran:</span>
                        @switch($order->payment_status)
                            @case('paid')
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Lunas</span>
                            @break

                            @case('partial')
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">Sebagian</span>
                            @break

                            @case('unpaid')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-700">Belum
                                    Lunas</span>
                            @break
                        @endswitch
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Desktop Table View -->
    <div class="overflow-x-auto hidden md:block">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-800/50">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">ID Pesanan</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Pelanggan</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Item</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status Pembayaran
                    </th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                <tr>
                    <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-slate-200">
                        {{ $order->order_number }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                        {{ $order->order_date->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $order->customer->name }}
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                        {{ $order->items->count() }}
                        item</td>
                    <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-slate-200">Rp
                        {{ number_format($order->final_amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        @switch($order->payment_status)
                            @case('paid')
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Lunas</span>
                            @break

                            @case('partial')
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">Sebagian</span>
                            @break

                            @case('unpaid')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-700">Belum
                                    Lunas</span>
                            @break
                        @endswitch
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
                                    class="px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">Mendesain</span>
                            @break

                            @case('Proses Cetak')
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">Mencetak</span>
                            @break

                            @case('Finishing')
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">Finishing</span>
                            @break

                            @case('Siap Diambil')
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-semibold bg-teal-100 text-teal-700">Siap</span>
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
                        <div class="flex items-center gap-2">
                            <a href="{{ route('orders.show', $order->id) }}"
                                class="text-slate-400 hover:text-primary">
                                <span class="material-symbols-outlined text-xl">visibility</span>
                            </a>
                            <a href="{{ route('orders.edit', $order->id) }}"
                                class="text-slate-400 hover:text-amber-600">
                                <span class="material-symbols-outlined text-xl">edit</span>
                            </a>
                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
                                id="delete-form-desktop-{{ $order->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    @click.prevent="$dispatch('open-confirm-modal', {
                                    title: 'Hapus Pesanan',
                                    message: 'Anda yakin ingin menghapus pesanan ini?',
                                    formId: 'delete-form-desktop-{{ $order->id }}'
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
@empty
    <div class="p-6">
        <td colspan="8" class="px-6 py-4 text-center text-sm text-slate-500 dark:text-slate-400">
            Tidak ada pesanan ditemukan
        </td>
    </div>
@endforelse

<div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
    <div class="text-sm text-slate-500 dark:text-slate-400">
        Menampilkan {{ $orders->firstItem() }} hingga {{ $orders->lastItem() }} dari {{ $orders->total() }}
        hasil
    </div>
    {{ $orders->links() }}
</div>