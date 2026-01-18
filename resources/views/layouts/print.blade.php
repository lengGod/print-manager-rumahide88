<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>@yield('title', 'Cetak Laporan')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* Hide elements not needed for print */
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background-color: #fff !important;
                color: #000 !important;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #000;
                padding: 8px;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="container mx-auto p-4">
        @yield('content')
    </div>
    @stack('scripts')
</body>

</html>
