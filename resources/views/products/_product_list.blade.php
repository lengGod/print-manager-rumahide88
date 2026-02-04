@if ($products->isEmpty())
    <div class="p-6">
        <p class="text-slate-500 dark:text-slate-400 text-center">Belum ada produk yang tersedia.</p>
    </div>
@else
    <!-- Mobile Card View -->
    <div class="md:hidden">
        <div class="p-4 space-y-4">
            @foreach ($products as $product)
                <div
                    class="bg-slate-50 dark:bg-slate-800/50 rounded-lg p-4 border border-slate-200 dark:border-slate-800">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <span class="font-bold text-slate-900 dark:text-white">{{ $product->name }}</span>
                            <p class="text-xs text-slate-500">ID: {{ $product->id }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('products.show', $product->id) }}"
                                class="text-slate-400 hover:text-primary">
                                <span class="material-symbols-outlined text-xl">visibility</span>
                            </a>
                            <a href="{{ route('products.edit', $product->id) }}"
                                class="text-slate-400 hover:text-amber-600">
                                <span class="material-symbols-outlined text-xl">edit</span>
                            </a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                id="delete-form-{{ $product->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    @click.prevent="$dispatch('open-confirm-modal', {
                                    title: 'Hapus Produk',
                                    message: 'Anda yakin ingin menghapus produk ini?',
                                    formId: 'delete-form-{{ $product->id }}'
                                })"
                                    class="text-slate-400 hover:text-rose-600">
                                    <span class="material-symbols-outlined text-xl">delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="text-sm text-slate-600 dark:text-slate-400 space-y-1">
                        <p><span class="font-medium text-slate-500">Tipe:</span>
                            {{ $product->productType->name ?? 'N/A' }}</p>
                        <p><span class="font-medium text-slate-500">Kategori:</span>
                            {{ $product->category->name ?? 'N/A' }}</p>
                        <p><span class="font-medium text-slate-500">Harga:</span> Rp
                            {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Desktop Table View -->
    <div class="overflow-x-auto hidden md:block">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-800/50">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Produk
                    </th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tipe Produk
                    </th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @foreach ($products as $product)
                    <tr>
                        <td class="px-6 py-4">
                            <input type="checkbox"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:border-gray-600">
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $product->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                            {{ $product->productType->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                            {{ $product->category->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">Rp
                            {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('products.show', $product->id) }}"
                                    class="text-slate-400 hover:text-primary">
                                    <span class="material-symbols-outlined text-xl">visibility</span>
                                </a>
                                <a href="{{ route('products.edit', $product->id) }}"
                                    class="text-slate-400 hover:text-amber-600">
                                    <span class="material-symbols-outlined text-xl">edit</span>
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                    id="delete-form-desktop-{{ $product->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        @click.prevent="$dispatch('open-confirm-modal', {
                                        title: 'Hapus Produk',
                                        message: 'Anda yakin ingin menghapus produk ini?',
                                        formId: 'delete-form-desktop-{{ $product->id }}'
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
    </div>

    <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
        <div class="text-sm text-slate-500 dark:text-slate-400">
            Menampilkan {{ $products->firstItem() }} hingga {{ $products->lastItem() }} dari
            {{ $products->total() }} hasil
        </div>
        {{ $products->links() }}
    </div>
@endif
