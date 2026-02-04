@forelse($categories as $category)
    <!-- Mobile Card View -->
    <div class="md:hidden">
        <div class="p-4 space-y-4">
            <div
                class="bg-slate-50 dark:bg-slate-800/50 rounded-lg p-4 border border-slate-200 dark:border-slate-800">
                <div class="flex justify-between items-start mb-2">
                    <span class="font-bold text-slate-900 dark:text-white">{{ $category->name }}</span>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('categories.show', $category->id) }}"
                            class="text-slate-400 hover:text-primary">
                            <span class="material-symbols-outlined text-xl">visibility</span>
                        </a>
                        <a href="{{ route('categories.edit', $category->id) }}"
                            class="text-slate-400 hover:text-amber-600">
                            <span class="material-symbols-outlined text-xl">edit</span>
                        </a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                                        id="delete-form-{{ $category->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            @click.prevent="$dispatch('open-confirm-modal', {
                                                                title: 'Hapus Kategori',
                                                                message: 'Anda yakin ingin menghapus kategori ini?',
                                                                formId: 'delete-form-{{ $category->id }}'
                                                            })"
                                                            class="text-slate-400 hover:text-rose-600">
                                                            <span class="material-symbols-outlined text-xl">delete</span>
                                                        </button>
                                                    </form>                        </div>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-400">{{ $category->description }}</p>
            </div>
        </div>
    </div>

    <!-- Desktop Table View -->
    <div class="overflow-x-auto hidden md:block">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-800/50">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Deskripsi</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                <tr>
                    <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-slate-200">
                        {{ $category->name }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                        {{ $category->description }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('categories.show', $category->id) }}"
                                class="text-slate-400 hover:text-primary">
                                <span class="material-symbols-outlined text-xl">visibility</span>
                            </a>
                            <a href="{{ route('categories.edit', $category->id) }}"
                                class="text-slate-400 hover:text-amber-600">
                                <span class="material-symbols-outlined text-xl">edit</span>
                            </a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                                            id="delete-form-{{ $category->id }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                @click.prevent="$dispatch('open-confirm-modal', {
                                                                    title: 'Hapus Kategori',
                                                                    message: 'Anda yakin ingin menghapus kategori ini?',
                                                                    formId: 'delete-form-{{ $category->id }}'
                                                                })"
                                                                class="text-slate-400 hover:text-rose-600">
                                                                <span class="material-symbols-outlined text-xl">delete</span>
                                                            </button>
                                                        </form>                            </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@empty
    <div class="p-6">
        <p class="text-sm text-slate-500 dark:text-slate-400 text-center">Tidak ada kategori yang ditemukan</p>
    </div>
@endforelse

@if ($categories->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
        <div class="text-sm text-slate-500 dark:text-slate-400">
            Menampilkan {{ $categories->firstItem() }} hingga {{ $categories->lastItem() }} dari
            {{ $categories->total() }} hasil
        </div>
        {{ $categories->links() }}
    </div>
@endif
