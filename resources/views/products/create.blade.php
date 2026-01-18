@extends('layouts.app')

@section('title', 'Buat Produk Baru')

@section('content')
    <!-- Breadcrumbs -->
    <nav class="flex items-center text-sm font-medium mb-6">
        <span class="text-slate-400">Menu Utama</span>
        <span class="material-symbols-outlined text-slate-300 mx-2 text-base">chevron_right</span>
        <a href="{{ route('products.index') }}"
            class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white">Produk</a>
        <span class="material-symbols-outlined text-slate-300 mx-2 text-base">chevron_right</span>
        <span class="text-slate-900 dark:text-white">Buat Produk Baru</span>
    </nav>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100 dark:border-slate-800">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Buat Produk Baru</h2>
            <a href="{{ route('products.index') }}"
                class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-300 transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                <span>Kembali</span>
            </a>
        </div>
        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nama Produk</label>
                    <input type="text" name="name" id="name"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary mt-1"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="product_type_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Tipe Produk</label>
                    <select name="product_type_id" id="product_type_id"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary mt-1"
                        required>
                        <option value="">Pilih Tipe Produk</option>
                        @foreach ($productTypes as $productType)
                            <option value="{{ $productType->id }}" {{ old('product_type_id') == $productType->id ? 'selected' : '' }}>
                                {{ $productType->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_type_id')
                        <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Harga</label>
                    <input type="number" name="price" id="price"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary mt-1"
                        value="{{ old('price') }}" required min="0">
                    @error('price')
                        <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="unit" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Satuan</label>
                    <input type="text" name="unit" id="unit"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary mt-1"
                        value="{{ old('unit') }}" required>
                    @error('unit')
                        <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Deskripsi (Opsional)</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary mt-1">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Spesifikasi Produk</h2>
                <div id="specifications-container" class="space-y-4">
                    @if (old('specifications'))
                        @foreach (old('specifications') as $index => $spec)
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 specification-item">
                                <div>
                                    <label for="specifications-{{ $index }}-name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nama Spesifikasi</label>
                                    <input type="text" name="specifications[{{ $index }}][name]" id="specifications-{{ $index }}-name"
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary"
                                        value="{{ $spec['name'] }}" required>
                                    @error('specifications.' . $index . '.name')
                                        <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="specifications-{{ $index }}-value" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nilai</label>
                                    <input type="text" name="specifications[{{ $index }}][value]" id="specifications-{{ $index }}-value"
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary"
                                        value="{{ $spec['value'] }}" required>
                                    @error('specifications.' . $index . '.value')
                                        <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="specifications-{{ $index }}-additional_price" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Harga Tambahan</label>
                                    <input type="text" name="specifications[{{ $index }}][name]" id="specifications-{{ $index }}-name"
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary mt-1"
                                        value="{{ $spec['name'] }}" required>
                                    @error('specifications.' . $index . '.name')
                                        <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="specifications-{{ $index }}-value" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nilai</label>
                                    <input type="text" name="specifications[{{ $index }}][value]" id="specifications-{{ $index }}-value"
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary mt-1"
                                        value="{{ $spec['value'] }}" required>
                                    @error('specifications.' . $index . '.value')
                                        <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="specifications-{{ $index }}-additional_price" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Harga Tambahan</label>
                                    <input type="number" name="specifications[{{ $index }}][additional_price]" id="specifications-{{ $index }}-additional_price"
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary mt-1"
                                        value="{{ $spec['additional_price'] }}" required min="0">
                                    @error('specifications.' . $index . '.additional_price')
                                        <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex items-end">
                                    <button type="button" class="remove-specification-button px-4 py-2 bg-rose-500 text-white rounded-lg hover:bg-rose-600 transition-colors w-full">Hapus</button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <button type="button" id="add-specification-button"
                    class="mt-4 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">add</span>
                    <span>Tambah Spesifikasi</span>
                </button>
            </div>

            <div class="flex justify-end gap-4">
                <button type="submit"
                    class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors">Simpan Produk</button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let specificationIndex = {{ old('specifications') ? count(old('specifications')) : 0 }};

                document.getElementById('add-specification-button').addEventListener('click', function () {
                    addSpecificationRow();
                });

                document.getElementById('specifications-container').addEventListener('click', function (e) {
                    if (e.target.classList.contains('remove-specification-button')) {
                        e.target.closest('.specification-item').remove();
                    }
                });

                function addSpecificationRow() {
                    const container = document.getElementById('specifications-container');
                    const newRow = document.createElement('div');
                    newRow.classList.add('grid', 'grid-cols-1', 'md:grid-cols-4', 'gap-4', 'specification-item');
                    newRow.innerHTML = `
                        <div>
                            <label for="specifications-${specificationIndex}-name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nama Spesifikasi</label>
                            <input type="text" name="specifications[${specificationIndex}][name]" id="specifications-${specificationIndex}-name"
                                class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary mt-1"
                                required>
                        </div>
                        <div>
                            <label for="specifications-${specificationIndex}-value" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nilai</label>
                            <input type="text" name="specifications[${specificationIndex}][value]" id="specifications-${specificationIndex}-value"
                                class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary mt-1"
                                required>
                        </div>
                        <div>
                            <label for="specifications-${specificationIndex}-additional_price" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Harga Tambahan</label>
                            <input type="number" name="specifications[${specificationIndex}][additional_price]" id="specifications-${specificationIndex}-additional_price"
                                class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary mt-1"
                                required min="0">
                        </div>
                        <div class="flex items-end">
                            <button type="button" class="remove-specification-button px-4 py-2 bg-rose-500 text-white rounded-lg hover:bg-rose-600 transition-colors w-full">Hapus</button>
                        </div>
                    `;
                    container.appendChild(newRow);
                    specificationIndex++;
                }
            });
        </script>
    @endpush
@endsection
