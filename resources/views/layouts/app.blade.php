<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>@yield('title', 'RumahIde88 - Sistem Manajemen Percetakan')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#137fec",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101922",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen"
    x-data="themeSwitcher()" x-init="init()" :class="{ 'dark': isDark }">
    <div x-data="{ sidebarOpen: window.innerWidth >= 768 }" x-init="() => {
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                sidebarOpen = true; // Always show sidebar on desktop
            } else {
                sidebarOpen = false; // Hide sidebar on mobile when resizing from desktop
            }
        });
    }" class="flex">
        <!-- Sidebar Backdrop -->
        <div x-show="sidebarOpen && window.innerWidth < 768" x-on:click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-slate-900/50 z-20" aria-hidden="true"></div>

        <!-- Sidebar Navigation -->
        <aside
            class="fixed inset-y-0 left-0 z-30 w-64 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex-col h-screen
                   transform -translate-x-full transition-transform duration-300 ease-in-out
                   md:sticky md:top-0 md:translate-x-0 md:flex"
            :class="{ 'translate-x-0': sidebarOpen }">
            <div class="p-6 flex items-center gap-3">
                <img src="{{ asset('assets/logo88.jpeg') }}" alt="Logo" class="size-10 rounded-lg object-contain">
                <div class="flex flex-col">
                    <h1 class="text-slate-900 dark:text-white text-base font-bold leading-none">Rumah Ide 88</h1>
                    <p class="text-slate-500 dark:text-slate-400 text-xs font-medium">Konsol Admin</p>
                </div>
            </div>
            <nav class="flex-1 px-4 py-4 space-y-1">
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-primary/10 text-primary font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors' }}"
                    href="{{ route('dashboard') }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span class="text-sm">Dashboard</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('orders*') ? 'bg-primary/10 text-primary font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors' }}"
                    href="{{ route('orders.index') }}">
                    <span class="material-symbols-outlined">shopping_bag</span>
                    <span class="text-sm font-medium">Pesanan</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('customers*') ? 'bg-primary/10 text-primary font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors' }}"
                    href="{{ route('customers.index') }}">
                    <span class="material-symbols-outlined">group</span>
                    <span class="text-sm font-medium">Pelanggan</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('products*') ? 'bg-primary/10 text-primary font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors' }}"
                    href="{{ route('products.index') }}">
                    <span class="material-symbols-outlined">inventory_2</span>
                    <span class="text-sm font-medium">Produk</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('categories*') ? 'bg-primary/10 text-primary font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors' }}"
                    href="{{ route('categories.index') }}">
                    <span class="material-symbols-outlined">category</span>
                    <span class="text-sm font-medium">Kategori</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('product-types*') ? 'bg-primary/10 text-primary font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors' }}"
                    href="{{ route('product-types.index') }}">
                    <span class="material-symbols-outlined">layers</span>
                    <span class="text-sm font-medium">Tipe Produk</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('design-files*') ? 'bg-primary/10 text-primary font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors' }}"
                    href="{{ route('design-files.index') }}">
                    <span class="material-symbols-outlined">attachment</span>
                    <span class="text-sm font-medium">File Desain</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('materials*') ? 'bg-primary/10 text-primary font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors' }}"
                    href="{{ route('materials.index') }}">
                    <span class="material-symbols-outlined">format_paint</span>
                    <span class="text-sm font-medium">Bahan</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('external-purchases*') ? 'bg-primary/10 text-primary font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors' }}"
                    href="{{ route('external-purchases.index') }}">
                    <span class="material-symbols-outlined">receipt_long</span>
                    <span class="text-sm font-medium">Pembelian Eksternal</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('reports*') ? 'bg-primary/10 text-primary font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors' }}"
                    href="{{ route('reports.index') }}">
                    <span class="material-symbols-outlined">bar_chart</span>
                    <span class="text-sm font-medium">Laporan</span>
                </a>
            </nav>
            <div class="px-4 py-4 border-t border-slate-100 dark:border-slate-800 space-y-1">
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('settings*') ? 'bg-primary/10 text-primary font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors' }}"
                    href="{{ route('settings.index') }}">
                    <span class="material-symbols-outlined">settings</span>
                    <span class="text-sm font-medium">Pengaturan</span>
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-colors">
                        <span class="material-symbols-outlined">logout</span>
                        <span class="text-sm font-medium">Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-screen overflow-y-auto">
            <!-- Header -->
            <header
                class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 sm:px-8 py-4 sticky top-0 z-10">
                <div class="flex items-center gap-4">
                    <button x-on:click="sidebarOpen = !sidebarOpen" class="md:hidden p-2 rounded-lg">
                        <span class="material-symbols-outlined">menu</span>
                    </button>

                </div>
                <div class="flex items-center gap-4">
                    <button x-on:click="toggle()" type="button"
                        class="p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg">
                        <span class="material-symbols-outlined" x-show="!isDark">dark_mode</span>
                        <span class="material-symbols-outlined" x-show="isDark">light_mode</span>
                    </button>
                    <button class="p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg relative">
                        <span class="material-symbols-outlined">notifications</span>
                        <span
                            class="absolute top-2 right-2 size-2 bg-rose-500 rounded-full border-2 border-white dark:border-slate-900"></span>
                    </button>
                    <div x-data="{ open: false }" class="relative">
                        <button x-on:click="open = !open"
                            class="flex items-center gap-3 pl-4 border-l border-slate-200 dark:border-slate-800 focus:outline-none">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-bold leading-none">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-500 mt-1">
                                    {{ Auth::user()->roles->first()->display_name ?? 'Pengguna' }}</p>
                            </div>
                            <div class="size-10 rounded-full bg-slate-200 dark:bg-slate-700 bg-cover bg-center"
                                style='background-image: url("https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF");'>
                            </div>
                        </button>

                        <div x-show="open" x-on:click.away="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md shadow-lg py-1 z-50">
                            <a href="{{ route('settings.index') }}"
                                class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700">
                                Profil
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-4 sm:p-8">
                @include('partials.messages')
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        function themeSwitcher() {
            return {
                isDark: false,
                init() {
                    this.isDark = localStorage.getItem('darkMode') === 'true';
                    this.updateHtmlClass();
                },
                toggle() {
                    this.isDark = !this.isDark;
                    localStorage.setItem('darkMode', this.isDark);
                    this.updateHtmlClass();
                },
                updateHtmlClass() {
                    if (this.isDark) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
            }
        }
    </script>
    @stack('scripts')
    @include('partials.confirm-modal')
</body>

</html>
