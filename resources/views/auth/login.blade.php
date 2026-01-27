<!DOCTYPE html>
<html lang="id" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rumah Ide 88 - Masuk</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: "class"
        };
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900" x-data="{
    isDark: localStorage.getItem('darkMode') === 'true',
    toggle() {
        this.isDark = !this.isDark;
        localStorage.setItem('darkMode', this.isDark);
        document.documentElement.classList.toggle('dark', this.isDark);
    }
}" x-init="document.documentElement.classList.toggle('dark', isDark)">
    <div class="absolute top-4 right-4">
        <button @click="toggle()" type="button"
            class="p-2 text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">
            <span class="material-symbols-outlined" x-show="!isDark">dark_mode</span>
            <span class="material-symbols-outlined" x-show="isDark">light_mode</span>
        </button>
    </div>
    <div class="flex flex-col items-center justify-center min-h-screen px-4 py-12 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <div class="flex justify-center mb-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/logo88.jpeg') }}" alt="Logo"
                        class="size-12 rounded-lg object-contain">
                    <div class="flex flex-col">
                        <h1 class="text-gray-900 dark:text-white text-xl font-bold leading-none">Rumah Ide 88</h1>
                        <p class="text-gray-500 dark:text-gray-400 text-xs font-medium">Sistem Manajemen Percetakan</p>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 py-8 px-6 shadow-lg rounded-lg">
                <h2 class="text-center text-2xl font-bold text-gray-900 dark:text-white mb-6">Masuk ke akun Anda
                </h2>

                @include('partials.messages')

                <form class="space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat
                            email</label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" autocomplete="email" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                                value="{{ old('email') }}">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kata
                            Sandi</label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" autocomplete="current-password"
                                required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember" type="checkbox"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:border-gray-600">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                                Ingat saya
                            </label>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Masuk
                        </button>
                    </div>
                </form>
            </div>

            <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    Daftar di sini
                </a>
            </p>
        </div>
    </div>
</body>

</html>
