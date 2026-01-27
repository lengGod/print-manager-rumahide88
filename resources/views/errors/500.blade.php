<!DOCTYPE html>
<html lang="id" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 - Kesalahan Server</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200"
    x-data="{
        isDark: localStorage.getItem('darkMode') === 'true',
        toggle() {
            this.isDark = !this.isDark;
            localStorage.setItem('darkMode', this.isDark);
            document.documentElement.classList.toggle('dark', this.isDark);
        }
    }"
    x-init="document.documentElement.classList.toggle('dark', isDark)">

    <div class="relative min-h-screen">
        <div class="absolute top-4 right-4">
            <button @click="toggle()" type="button" class="p-2 text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">
                <span class="material-symbols-outlined" x-show="!isDark">dark_mode</span>
                <span class="material-symbols-outlined" x-show="isDark">light_mode</span>
            </button>
        </div>
        <div class="flex flex-col items-center justify-center min-h-screen text-center px-6">
            <h1 class="text-8xl md:text-9xl font-bold text-rose-500">500</h1>
            <h2 class="mt-4 text-2xl md:text-3xl font-semibold text-gray-800 dark:text-white">Kesalahan Server Internal</h2>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Maaf, terjadi kesalahan di pihak kami. Kami sedang menanganinya.</p>
            <div class="mt-8">
                <a href="{{ url('/') }}"
                    class="px-6 py-3 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary/90 transition-colors">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</body>

</html>
