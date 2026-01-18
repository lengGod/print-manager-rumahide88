@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('content')
    <!-- Breadcrumbs -->
    <nav class="flex items-center text-sm font-medium mb-6">
        <span class="text-slate-400">Menu Utama</span>
        <span class="material-symbols-outlined text-slate-300 mx-2 text-base">chevron_right</span>
        <a href="{{ route('categories.index') }}" class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white">Kategori</a>
        <span class="material-symbols-outlined text-slate-300 mx-2 text-base">chevron_right</span>
        <span class="text-slate-900 dark:text-white">Detail Kategori</span>
    </nav>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-2">{{ $category->name }}</h2>
                <p class="text-sm text-slate-600 dark:text-slate-400">{{ $category->description }}</p>
            </div>
            <a href="{{ route('categories.edit', $category->id) }}"
                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                Ubah
            </a>
        </div>
        
        <div class="mt-6 border-t border-slate-200 dark:border-slate-700 pt-6">
             <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-slate-500">Dibuat pada</dt>
                    <dd class="mt-1 text-sm text-slate-900 dark:text-white">{{ $category->created_at->format('d M Y, H:i') }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-slate-500">Diperbarui pada</dt>
                    <dd class="mt-1 text-sm text-slate-900 dark:text-white">{{ $category->updated_at->format('d M Y, H:i') }}</dd>
                </div>
            </dl>
        </div>
    </div>
@endsection
