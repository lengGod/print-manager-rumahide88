<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cetak Dokumen')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                background-color: #fff; /* Ensure white background for print */
            }
            .no-print {
                display: none;
            }
            .invoice-container {
                width: 100%;
                margin: 0;
                box-shadow: none;
                border-radius: 0;
                padding: 0; /* Remove padding from invoice-container itself for print */
            }
            .invoice-container > div {
                padding: 0 32px; /* Re-add horizontal padding to direct children */
            }
            .invoice-container .flex.justify-between.items-start.border-b {
                padding-top: 32px; /* Add top padding to the header for print */
            }
            .invoice-container .mb-10 {
                margin-bottom: 0 !important; /* Adjust margins for print */
            }
            .invoice-container .w-full.overflow-x-auto.mb-10 {
                margin-bottom: 0 !important;
            }
            .invoice-container .flex.justify-end.mb-10 {
                margin-bottom: 0 !important;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div>
        <div class="flex justify-end mb-4 no-print">
            <button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Cetak</button>
            <a href="{{ url()->previous() }}" class="px-4 py-2 ml-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Kembali</a>
        </div>
        @yield('content')
    </div>
</body>
</html>