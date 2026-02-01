@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Pengaturan</h1>
        <p class="text-sm text-slate-500 dark:text-slate-400">Kelola profil akun dan cadangan basis data Anda.</p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Profile Settings --}}
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-slate-900 rounded-xl shadow">
                <div class="p-6 border-b border-slate-200 dark:border-slate-800">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Pengaturan Profil</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Perbarui informasi profil dan alamat email Anda.</p>
                </div>
                <form action="{{ route('settings.profile.update') }}" method="POST">
                    @csrf
                    <div class="p-6 space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Nama</label>
                            <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}"
                                class="mt-1 block w-full bg-slate-50 dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:border-primary focus:ring focus:ring-primary/50 text-sm">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Alamat Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                class="mt-1 block w-full bg-slate-50 dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:border-primary focus:ring focus:ring-primary/50 text-sm">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-slate-50 dark:bg-slate-900/50 text-right rounded-b-xl">
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary/50">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Database Backup --}}
        <div>
            <div class="bg-white dark:bg-slate-900 rounded-xl shadow">
                <div class="p-6 border-b border-slate-200 dark:border-slate-800">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Cadangkan Basis Data</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Unduh salinan cadangan dari basis data aplikasi.</p>
                </div>
                <div class="p-6">
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
                        Klik tombol di bawah ini untuk mengunduh file cadangan SQL dari basis data Anda saat ini. Simpan di tempat yang aman.
                    </p>
                    <form action="{{ route('settings.backup') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                            <span class="material-symbols-outlined mr-2 -ml-1">download</span>
                            Unduh Cadangan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection