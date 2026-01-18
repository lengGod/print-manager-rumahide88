@if (session()->has('success'))
    <div
        class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 px-4 py-3 rounded-lg mb-4">
        <div class="flex items-center">
            <span class="material-symbols-outlined text-emerald-500 mr-2">check_circle</span>
            {{ session('success') }}
        </div>
    </div>
@endif

@if (session()->has('error'))
    <div
        class="bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-200 px-4 py-3 rounded-lg mb-4">
        <div class="flex items-center">
            <span class="material-symbols-outlined text-rose-500 mr-2">error</span>
            {{ session('error') }}
        </div>
    </div>
@endif

@if ($errors->any())
    <div
        class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 text-amber-800 dark:text-amber-200 px-4 py-3 rounded-lg mb-4">
        <div class="flex items-center mb-2">
            <span class="material-symbols-outlined text-amber-500 mr-2">warning</span>
            <strong>Oops! Terjadi kesalahan:</strong>
        </div>
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
