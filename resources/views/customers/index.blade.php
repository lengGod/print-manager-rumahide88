@extends('layouts.app')

@section('title', 'Pelanggan')

@section('content')
    <!-- Breadcrumbs -->
    <nav class="flex items-center text-sm font-medium mb-6">
        <span class="text-slate-400">Menu Utama</span>
        <span class="material-symbols-outlined text-slate-300 mx-2 text-base">chevron_right</span>
        <span class="text-slate-900 dark:text-white">Pelanggan</span>
    </nav>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
    <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Semua Pelanggan</h2>
        <a href="{{ route('customers.create') }}"
            class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary/90 transition-colors flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">add</span>
            <span class="hidden sm:inline">Pelanggan Baru</span>
        </a>
    </div>

    <!-- Mobile Card View -->
    <div class="md:hidden">
        <div class="p-4 space-y-4">
            @forelse($customers as $customer)
                <div
                    class="bg-slate-50 dark:bg-slate-800/50 rounded-lg p-4 border border-slate-200 dark:border-slate-800">
                    <div class="flex justify-between items-start mb-2">
                        <span class="font-bold text-slate-900 dark:text-white">{{ $customer->name }}</span>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('customers.show', $customer->id) }}"
                                class="text-slate-400 hover:text-primary">
                                <span class="material-symbols-outlined text-xl">visibility</span>
                            </a>
                            <a href="{{ route('customers.edit', $customer->id) }}"
                                class="text-slate-400 hover:text-amber-600">
                                <span class="material-symbols-outlined text-xl">edit</span>
                            </a>
                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST"
                                id="delete-form-{{ $customer->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    @click.prevent="$dispatch('open-confirm-modal', {
                                        title: 'Hapus Pelanggan',
                                        message: 'Anda yakin ingin menghapus pelanggan ini?',
                                        formId: 'delete-form-{{ $customer->id }}'
                                    })"
                                    class="text-slate-400 hover:text-rose-600">
                                    <span class="material-symbols-outlined text-xl">delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="text-sm text-slate-600 dark:text-slate-400 space-y-1">
                        <p><span class="font-medium text-slate-500">Telepon:</span> {{ $customer->phone }}</p>
                        <p><span class="font-medium text-slate-500">Email:</span> {{ $customer->email }}</p>
                        <p><span class="font-medium text-slate-500">Alamat:</span> {{ $customer->address }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Tidak ada pelanggan yang ditemukan</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Desktop Table View -->
    <div class="overflow-x-auto hidden md:block">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-800/50">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kontak</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Alamat</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($customers as $customer)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-slate-200">
                            {{ $customer->name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                            <div class="flex flex-col">
                                <span>{{ $customer->phone }}</span>
                                <span class="text-xs text-slate-500">{{ $customer->email }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                            {{ $customer->address }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('customers.show', $customer->id) }}"
                                    class="text-slate-400 hover:text-primary">
                                    <span class="material-symbols-outlined text-xl">visibility</span>
                                </a>
                                <a href="{{ route('customers.edit', $customer->id) }}"
                                    class="text-slate-400 hover:text-amber-600">
                                    <span class="material-symbols-outlined text-xl">edit</span>
                                </a>
                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST"
                                    id="delete-form-desktop-{{ $customer->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        @click.prevent="$dispatch('open-confirm-modal', {
                                            title: 'Hapus Pelanggan',
                                            message: 'Anda yakin ingin menghapus pelanggan ini?',
                                            formId: 'delete-form-desktop-{{ $customer->id }}'
                                        })"
                                        class="text-slate-400 hover:text-rose-600">
                                        <span class="material-symbols-outlined text-xl">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-slate-500 dark:text-slate-400">
                            Tidak ada pelanggan yang ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($customers->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <div class="text-sm text-slate-500 dark:text-slate-400">
                Menampilkan {{ $customers->firstItem() }} hingga {{
                $customers->lastItem() }} dari
                {{ $customers->total() }} hasil
            </div>
            {{ $customers->links() }}
        </div>
    @endif
</div>
@endsection
