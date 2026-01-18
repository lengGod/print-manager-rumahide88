@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Edit Produk: {{ $product->name }}</h1>
        <a href="{{ route('products.index') }}"
            class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg flex items-center gap-2 hover:bg-slate-300 transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6">
        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nama Produk</label>
                    <input type="text" name="name" id="name"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary"
                        value="{{ old('name', $product->name) }}" required>
                    @error('name')
                        <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="product_type_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Tipe Produk</label>
                    <select name="product_type_id" id="product_type_id"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary"
                        required>
                        <option value="">Pilih Tipe Produk</option>
                        @foreach ($productTypes as $productType)
                            <option value="{{ $productType->id }}" {{ old('product_type_id', $product->product_type_id) == $productType->id ? 'selected' : '' }}>
                                {{ $productType->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_type_id')
                        <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="base_price" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Harga Dasar</label>
                    <input type="number" name="base_price" id="base_price"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary"
                        value="{{ old('base_price', $product->base_price) }}" required min="0">
                    @error('base_price')
                        <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="unit" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Satuan</label>
                    <input type="text" name="unit" id="unit"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary"
                        value="{{ old('unit', $product->unit) }}" required>
                    @error('unit')
                        <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Deskripsi (Opsional)</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Spesifikasi Produk</h2>
                <div id="specifications-container" class="space-y-4">
                    @foreach (old('specifications', $product->specifications ?? []) as $index => $spec)
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 specification-item">
                            <div>
                                <label for="specifications-{{ $index }}-name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nama Spesifikasi</label>
                                <input type="text" name="specifications[{{ $index }}][name]" id="specifications-{{ $index }}-name"
                                    class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary"
                                    value="{{ $spec['name'] ?? '' }}" required>
                                @error('specifications.' . $index . '.name')
                                    <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="specifications-{{ $index }}-value" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nilai</label>
                                <input type="text" name="specifications[{{ $index }}][value]" id="specifications-{{ $index }}-value"
                                    class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary"
                                    value="{{ $spec['value'] ?? '' }}" required>
                                @error('specifications.' . $index . '.value')
                                    <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="specifications-{{ $index }}-additional_price" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Harga Tambahan</label>
                                <input type="number" name="specifications[{{ $index }}][additional_price]" id="specifications-{{ $index }}-additional_price"
                                    class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary"
                                    value="{{ $spec['additional_price'] ?? 0 }}" required min="0">
                                @error('specifications.' . $index . '.additional_price')
                                    <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex items-end">
                                <button type="button" class="remove-specification-button px-4 py-2 bg-rose-500 text-white rounded-lg hover:bg-rose-600 transition-colors w-full">Hapus</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="add-specification-button"
                    class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined">add</span>
                    <span>Tambah Spesifikasi</span>
                </button>
            </div>

            <div class="flex justify-end gap-4">
                <button type="submit"
                    class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">Update Produk</button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let specificationIndex = {{ $product->specifications->count() > 0 ? $product->specifications->count() : 0 }};

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
                                class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary"
                                required>
                        </div>
                        <div>
                            <label for="specifications-${specificationIndex}-value" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nilai</label>
                            <input type="text" name="specifications[${specificationIndex}][value]" id="specifications-${specificationIndex}-value"
                                class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary"
                                required>
                        </div>
                        <div>
                            <label for="specifications-${specificationIndex}-additional_price" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Harga Tambahan</label>
                            <input type="number" name="specifications[${specificationIndex}][additional_price]" id="specifications-${specificationIndex}-additional_price"
                                class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-primary focus:border-primary"
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
