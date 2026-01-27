<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Invoice')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        @page {
            size: 148mm 210mm;
            /* A5 Portrait */
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            font-family: 'Inter', sans-serif;
            color: #333;
            background-color: #f5f5f5;
        }

        .invoice-content {
            width: 148mm;
            min-height: 210mm;
            margin: 20px auto;
            box-sizing: border-box;
            padding: 10px;
            position: relative;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .watermark {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('assets/logo88.jpeg') }}');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            opacity: 0.08;
            z-index: 0;
        }

        .content-wrapper {
            position: relative;
            z-index: 1;
        }

        th,
        td {
            padding: 3px 5px;
        }

        table {
            page-break-inside: avoid;
        }

        tr {
            page-break-inside: avoid;
        }

        .avoid-break {
            page-break-inside: avoid;
        }

        .no-print {
            display: block;
        }

        @media print {
            body {
                background-color: #fff;
            }

            .no-print {
                display: none !important;
            }

            .invoice-content {
                width: 148mm;
                min-height: 210mm;
                margin: 0;
                padding: 10mm;
                box-shadow: none;
            }
        }

        @media screen {
            .invoice-content {
                border-radius: 4px;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-content" id="invoiceContent">
        <div class="watermark"></div>
        <div class="content-wrapper">
            <!-- Buttons for screen view, hidden in print -->
            <div class="flex justify-end mb-4 no-print gap-2">
                <button onclick="takeScreenshot()"
                    class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors">
                    <span class="material-symbols-outlined mr-2">screenshot</span>
                    {{ app()->getLocale() === 'en' ? 'Screenshot' : 'Screenshot' }}
                </button>
                <button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    {{ app()->getLocale() === 'en' ? 'Print' : 'Cetak' }}
                </button>
                <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                    {{ app()->getLocale() === 'en' ? 'Back' : 'Kembali' }}
                </a>
            </div>

            <!-- Invoice Content -->
            <!-- Header Section -->
            <div class="flex justify-between items-start border-b border-gray-300 pb-1.5 mb-2">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-800 mb-1">
                        {{ app()->getLocale() === 'en' ? 'INVOICE' : 'FAKTUR' }}</h1>
                    <p class="text-gray-600 text-[10px]">RumahIde88</p>
                    <p class="text-gray-600 text-[10px]">Jl. Kota Raja, Gn. Sari, Kec. Tj. Karang Pusat, Kota Bandar
                        Lampung, Lampung 35127, Indonesia</p>
                    <p class="text-gray-600 text-[10px]">Email:
                        {{ app()->getLocale() === 'en' ? 'rumahide88@gmail.com' : 'rumahide88@gmail.com' }}</p>
                </div>
                <div class="text-right">
                    <p class="text-lg font-bold text-gray-700 mb-1">#{{ $order->order_number ?? '' }}</p>
                    <p class="text-xs text-gray-600">
                        {{ app()->getLocale() === 'en' ? 'Order Date: ' : 'Tanggal Order: ' }}<span
                            class="font-medium">{{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('d F Y') : '' }}</span>
                    </p>
                    <p class="text-xs text-gray-600">
                        {{ app()->getLocale() === 'en' ? 'Deadline: ' : 'Batas Waktu: ' }}<span
                            class="font-medium">{{ $order->deadline ? \Carbon\Carbon::parse($order->deadline)->format('d F Y') : '' }}</span>
                    </p>
                </div>
            </div>

            <!-- Customer Info Section -->
            <div class="mb-2 avoid-break">
                <h2 class="text-xs font-semibold text-gray-700 mb-1 border-b border-gray-200 pb-0.5">
                    {{ app()->getLocale() === 'en' ? 'Bill To:' : 'Ditagihkan Kepada:' }}</h2>
                <p class="font-bold text-gray-800 text-xs mb-0.5">{{ $order->customer->name ?? '' }}</p>
                <p class="text-gray-600 text-[10px]">{{ $order->customer->address ?? '' }}</p>
                <p class="text-gray-600 text-[10px]">{{ $order->customer->phone ?? '' }}</p>
            </div>

            <!-- Order Items Table Section -->
            <div class="w-full overflow-x-auto mb-2 border border-gray-200 rounded avoid-break">
                <table class="min-w-full text-left text-xs">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-3 py-2 text-xs font-bold text-gray-600 uppercase tracking-wider">
                                {{ app()->getLocale() === 'en' ? 'Product' : 'Produk' }}</th>
                            <th class="px-3 py-2 text-xs font-bold text-gray-600 uppercase tracking-wider text-center">
                                {{ app()->getLocale() === 'en' ? 'Qty' : 'Jml' }}</th>
                            <th class="px-3 py-2 text-xs font-bold text-gray-600 uppercase tracking-wider text-center">
                                {{ app()->getLocale() === 'en' ? 'Size' : 'Ukuran' }}</th>
                            <th class="px-3 py-2 text-xs font-bold text-gray-600 uppercase tracking-wider text-right">
                                {{ app()->getLocale() === 'en' ? 'Price' : 'Harga' }}</th>
                            <th class="px-3 py-2 text-xs font-bold text-gray-600 uppercase tracking-wider text-right">
                                {{ app()->getLocale() === 'en' ? 'Subtotal' : 'Subtotal' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($order->items ?? [] as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 align-top">
                                    <p class="font-medium text-gray-800 text-xs">{{ $item->product->name ?? '' }}</p>
                                    @php
                                        $specifications = json_decode($item->specifications ?? '[]', true);
                                    @endphp
                                    @if (!empty($specifications))
                                        <ul class="text-[10px] text-gray-600 list-disc list-inside ml-2 mt-1">
                                            @foreach ($specifications as $spec)
                                                <li>{{ $spec['name'] }}: {{ $spec['value'] }}
                                                    (+{{ number_format($spec['additional_price'] ?? 0, 0, ',', '.') }})
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </td>
                                <td class="px-3 py-2 text-center align-top text-xs">{{ $item->quantity ?? '' }}</td>
                                <td class="px-3 py-2 text-center align-top text-xs">
                                    @if (($item->product->unit ?? '') === 'meter' && ($item->size ?? ''))
                                        {{ $item->size }} cm
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-3 py-2 text-right align-top text-xs">Rp
                                    {{ number_format($item->price ?? 0, 0, ',', '.') }}</td>
                                <td class="px-3 py-2 text-right align-top text-xs">Rp
                                    {{ number_format($item->subtotal ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totals Section -->
            <div class="flex justify-end mb-2 avoid-break">
                <div class="w-full max-w-xs">
                    <div class="flex justify-between py-0.5 border-b border-gray-300 text-[10px]">
                        <span class="text-gray-700">{{ app()->getLocale() === 'en' ? 'Total' : 'Total' }}</span>
                        <span class="font-bold text-gray-800">Rp
                            {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between py-0.5 border-b border-gray-300 text-[10px]">
                        <span class="text-gray-700">{{ app()->getLocale() === 'en' ? 'Discount' : 'Diskon' }}</span>
                        <span class="font-bold text-gray-800">Rp
                            {{ number_format($order->discount ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b-2 border-gray-400 text-xs">
                        <span
                            class="text-gray-800 font-extrabold">{{ app()->getLocale() === 'en' ? 'Final Amount' : 'Total Akhir' }}</span>
                        <span class="font-extrabold text-primary-600">Rp
                            {{ number_format($order->final_amount ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between py-0.5 border-b border-gray-300 text-[10px]">
                        <span
                            class="text-gray-700">{{ app()->getLocale() === 'en' ? 'Paid Amount' : 'Sudah Dibayar' }}</span>
                        <span class="font-bold text-gray-800">Rp
                            {{ number_format($order->paid_amount ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between py-1 mt-1 bg-blue-50 border-blue-200 border rounded px-2 text-xs">
                        <span
                            class="text-blue-800 font-bold">{{ app()->getLocale() === 'en' ? 'Amount Due' : 'Sisa Tagihan' }}</span>
                        <span class="font-bold text-rose-700">Rp
                            {{ number_format(($order->final_amount ?? 0) - ($order->paid_amount ?? 0), 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Information Section -->
            <div class="mt-2 border-t border-gray-200 pt-1.5 avoid-break">
                <h3 class="text-xs font-semibold text-gray-700 mb-1">
                    {{ app()->getLocale() === 'en' ? 'Payment Info:' : 'Info Pembayaran:' }}</h3>
                <div class="bg-blue-50 border border-blue-200 rounded p-2">
                    <p class="text-[10px] text-gray-700 mb-1">
                        {{ app()->getLocale() === 'en' ? 'Transfer to:' : 'Transfer ke:' }}
                    </p>
                    <div class="text-[10px]">
                        <p class="mb-0.5"><span class="font-bold">BCA:</span> 2920636392</p>
                        <p class="mb-0.5"><span class="font-bold">BRI:</span> 581601016483531</p>
                        <p class="font-semibold mb-0.5">a.n. Ratih Sulastri Ningsih</p>
                        <p class="italic text-gray-600 text-[9px]">
                            {{ app()->getLocale() === 'en' ? '(Send payment proof)' : '(Kirim bukti pembayaran)' }}</p>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="mt-2 border-t border-gray-200 pt-1.5 avoid-break">
                <h3 class="text-[10px] font-semibold text-gray-700 mb-0.5">
                    {{ app()->getLocale() === 'en' ? 'Notes:' : 'Catatan Order:' }}</h3>
                <p class="text-gray-600 text-[9px] leading-relaxed">
                    {{ $order->notes ?? (app()->getLocale() === 'en' ? 'No notes available.' : 'Tidak ada catatan.') }}
                </p>
            </div>

            <!-- Footer Section -->
            <div class="mt-2 text-center text-[9px] text-gray-500 border-t border-gray-300 pt-1.5 avoid-break">
                <p>{{ app()->getLocale() === 'en' ? 'Thank you for your business.' : 'Terima kasih telah berbisnis dengan kami.' }}
                </p>
                <p class="font-semibold text-gray-700">RumahIde88</p>
                <p class="text-[10px] mt-1">
                    {{ app()->getLocale() === 'en' ? 'Generated on ' : 'Dibuat pada ' }}{{ \Carbon\Carbon::now()->format('d F Y H:i') }}
                </p>
            </div>
        </div>
    </div>
    <script>
        function takeScreenshot() {
            // Hide the no-print elements temporarily
            const noPrintElements = document.querySelectorAll('.no-print');
            noPrintElements.forEach(el => el.style.visibility = 'hidden');

            html2canvas(document.getElementById('invoiceContent'), {
                scale: 2, // Increase scale for better quality
                useCORS: true // Enable CORS for images if any
            }).then(function(canvas) {
                // Restore visibility of no-print elements
                noPrintElements.forEach(el => el.style.visibility = 'visible');

                // Create a temporary link to download the image
                const link = document.createElement('a');
                link.download = 'invoice-{{ $order->order_number ?? 'undefined' }}.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        }
    </script>
</body>

</html>
