@forelse($productTypes as $productType)
    <!-- Mobile Card View -->
    <div class="md:hidden">
        <div class="p-4 space-y-4">
            <div
                class="bg-slate-50 dark:bg-slate-800/50 rounded-lg p-4 border border-slate-200 dark:border-slate-800">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <span class="font-bold text-slate-900 dark:text-white">{{ $productType->name }}</span>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $productType->category->name }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('product-types.show', $productType->id) }}"
                            class="text-slate-400 hover:text-primary">
                            <span class="material-symbols-outlined text-xl">visibility</span>
                        </a>
                        <a href="{{ route('product-types.edit', $productType->id) }}"
                            class="text-slate-400 hover:text-amber-600">
                            <span class="material-symbols-outlined text-xl">edit</span>
                        </a>
                        <form action="{{ route('product-types.destroy', $productType->id) }}" method="POST"
                            id="delete-form-{{ $productType->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                @click.prevent="$dispatch('open-confirm-modal', {
                                    title: 'Hapus Tipe Produk',
                                    message: 'Anda yakin ingin menghapus tipe produk ini?',
                                    formId: 'delete-form-{{ $productType->id }}'
                                })"
                                class="text-slate-400 hover:text-rose-600">
                                <span class="material-symbols-outlined text-xl">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-400">{{ $productType->description }}</p>
            </div>
        </div>
    </div>
@empty
    <div class="p-6 md:hidden">
        <p class="text-sm text-slate-500 dark:text-slate-400 text-center">Tidak ada tipe produk yang ditemukan</p>
    </div>
@endforelse

{{-- Desktop Table View --}}
<div class="overflow-x-auto hidden md:block">
    @if ($productTypes->count() > 0)
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-800/50">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Deskripsi</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @foreach($productTypes as $productType)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-slate-200">
                            {{ $productType->name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                            {{ $productType->category->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                            {{ $productType->description }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('product-types.show', $productType->id) }}"
                                    class="text-slate-400 hover:text-primary">
                                    <span class="material-symbols-outlined text-xl">visibility</span>
                                </a>
                                <a href="{{ route('product-types.edit', $productType->id) }}"
                                    class="text-slate-400 hover:text-amber-600">
                                    <span class="material-symbols-outlined text-xl">edit</span>
                                </a>
                                <form action="{{ route('product-types.destroy', $productType->id) }}" method="POST"
                                    id="delete-form-desktop-{{ $productType->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        @click.prevent="$dispatch('open-confirm-modal', {
                                            title: 'Hapus Tipe Produk',
                                            message: 'Anda yakin ingin menghapus tipe produk ini?',
                                            formId: 'delete-form-desktop-{{ $productType->id }}'
                                        })"
                                        class="text-slate-400 hover:text-rose-600">
                                        <span class="material-symbols-outlined text-xl">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="p-6">
            <p class="text-sm text-slate-500 dark:text-slate-400 text-center">Tidak ada tipe produk yang ditemukan</p>
        </div>
    @endif
</div>

@if ($productTypes->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
        <div class="text-sm text-slate-500 dark:text-slate-400">
            Menampilkan {{ $productTypes->firstItem() }} hingga {{ $productTypes->lastItem() }} dari
            {{ $productTypes->total() }} hasil
        </div>
        {{ $productTypes->links() }}
    </div>
@endif