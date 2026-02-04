@extends('layouts.app')

@section('title', 'Produk')

@section('content')
    <!-- Breadcrumbs -->
    <nav class="flex items-center text-sm font-medium mb-6">
        <span class="text-slate-400">Menu Utama</span>
        <span class="material-symbols-outlined text-slate-300 mx-2 text-base">chevron_right</span>
        <span class="text-slate-900 dark:text-white">Produk</span>
    </nav>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800"
        x-data="{
            searchTerm: '{{ request('search') }}',
            productsHtml: '',
            loading: false,
            fetchProducts() {
                this.loading = true;
                fetch(`{{ route('products.index') }}?search=${this.searchTerm}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    this.productsHtml = html;
                    this.loading = false;
                })
                .catch(error => {
                    console.error('Error fetching products:', error);
                    this.loading = false;
                });
            },
            init() {
                this.fetchProducts();
                // Listen for pagination clicks within the loaded content
                this.$watch('productsHtml', () => {
                    this.$nextTick(() => {
                        this.$el.querySelectorAll('.pagination a').forEach(link => {
                            link.removeEventListener('click', this.handlePaginationClick);
                            link.addEventListener('click', this.handlePaginationClick.bind(this));
                        });
                    });
                });
            },
            handlePaginationClick(event) {
                event.preventDefault();
                const url = event.target.href;
                this.loading = true;
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    this.productsHtml = html;
                    this.loading = false;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                })
                .catch(error => {
                    console.error('Error fetching paginated products:', error);
                    this.loading = false;
                });
            }
        }"
    >
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row items-start sm:items-center justify-between">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-4 sm:mb-0">Daftar Produk</h2>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <div class="relative flex-grow sm:flex-grow-0">
                    <input type="text" x-model.debounce.300ms="searchTerm" @input="fetchProducts" placeholder="Cari produk..." class="pl-10 pr-4 py-2 w-full border border-slate-300 dark:border-slate-700 rounded-lg focus:ring-primary focus:border-primary dark:bg-slate-800 dark:text-white">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                </div>
                <a href="{{ route('products.create') }}"
                    class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary/90 transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">add</span>
                    <span class="hidden sm:inline">Tambah Produk</span>
                </a>
            </div>
        </div>

        <!-- Loading Indicator -->
        <div x-show="loading" class="p-6 text-center text-slate-500 dark:text-slate-400">
            Memuat...
        </div>

        <!-- Product List -->
        <div x-html="productsHtml">
            {{-- Initial load will be here, subsequent loads via AJAX --}}
            @include('products._product_list', ['products' => $products])
        </div>
    </div>
@endsection
