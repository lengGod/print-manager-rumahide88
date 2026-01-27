@extends('layouts.print')

@section('title', 'Faktur Order #' . $order->id)

@section('content')
    <style>
        .invoice-container {
            position: relative;
            /* Needed for absolute positioning of watermark */
            background-color: transparent;
            /* Ensure content background is transparent */
            /* Removed padding: 32px; */
            z-index: 0;
            /* Make sure content is above watermark */
            font-family: 'Inter', sans-serif;
            /* Modern font, assuming Inter is loaded */
            color: #333;
            /* Darker default text */
        }

        .watermark {
            position: absolute;
            /* Position relative to .invoice-container */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('assets/logo88.jpeg') }}');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            /* Fill container */
            opacity: 0.08;
            /* Slightly less opaque for subtlety */
            z-index: -1;
            /* Ensure it's behind the content */
        }

        /* Override print styles if necessary */
        @media print {
            .invoice-container {
                background-color: transparent !important;
            }

            .watermark {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Adjust table cell padding for print */
            th,
            td {
                padding: 8px 12px !important;
            }
        }
    </style>
    <div class="invoice-container bg-white">
        <div class="watermark"></div>

        <!-- Header Section -->
        <div class="flex justify-between items-start border-b border-gray-300 pb-6 mb-8 px-8">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-800 mb-2">FAKTUR</h1>
                <p class="text-gray-600 text-sm">RumahIde88</p>
                <p class="text-gray-600 text-sm">Jl. Kota Raja, Gn. Sari, Kec. Tj. Karang Pusat, Kota Bandar Lampung, Lampung
                    35127, Indonesia</p>
                <p class="text-gray-600 text-sm">Email: kontak@rumahide88.com</p>
            </div>
            <div class="text-right">
                <p class="text-xl font-bold text-gray-700 mb-1">#{{ $order->order_number }}</p>
                <p class="text-sm text-gray-600">Tanggal Order: <span
                        class="font-medium">{{ \Carbon\Carbon::parse($order->order_date)->format('d F Y') }}</span></p>
                <p class="text-sm text-gray-600">Deadline: <span
                        class="font-medium">{{ \Carbon\Carbon::parse($order->deadline)->format('d F Y') }}</span></p>
            </div>
        </div>

        <!-- Customer Info Section -->
        <div class="mb-10 px-8">
            <h2 class="text-lg font-semibold text-gray-700 mb-3 border-b border-gray-200 pb-2">Ditagihkan Kepada:</h2>
            <p class="font-bold text-gray-800 text-base mb-1">{{ $order->customer->name }}</p>
            <p class="text-gray-600 text-sm">{{ $order->customer->address }}</p>
            <p class="text-gray-600 text-sm">{{ $order->customer->phone }}</p>
        </div>

        <!-- Order Items Table Section -->
        <div class="w-full overflow-x-auto mb-10 border border-gray-200 rounded-lg px-8">
            <table class="min-w-full text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider">Produk</th>
                        <th class="px-4 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center">Kuantitas
                        </th>
                        <th class="px-4 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center">Ukuran
                        </th>
                        <th class="px-4 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-right">Harga
                            Satuan</th>
                        <th class="px-4 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-right">Subtotal
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($order->items as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 align-top">
                                <p class="font-medium text-gray-800">{{ $item->product->name }}</p>
                                @php
                                    $specifications = json_decode($item->specifications, true);
                                @endphp
                                @if (!empty($specifications))
                                    <ul class="text-xs text-gray-600 list-disc list-inside ml-4 mt-1">
                                        @foreach ($specifications as $spec)
                                            <li>{{ $spec['name'] }}: {{ $spec['value'] }}
                                                (+{{ number_format($spec['additional_price'], 0, ',', '.') }})</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center align-top">{{ $item->quantity }}</td>
                            <td class="px-4 py-3 text-center align-top">
                                @if ($item->product->unit === 'meter' && $item->size)
                                    {{ $item->size }} cm
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right align-top">Rp {{ number_format($item->price, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-right align-top">Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals Section -->
        <div class="flex justify-end mb-10 px-8">
            <div class="w-full max-w-sm">
                <div class="flex justify-between py-2 border-b border-gray-300">
                    <span class="text-gray-700">Total</span>
                    <span class="font-bold text-gray-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-300">
                    <span class="text-gray-700">Diskon</span>
                    <span class="font-bold text-gray-800">Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-3 border-b-2 border-gray-400 text-xl">
                    <span class="text-gray-800 font-extrabold">Total Akhir</span>
                    <span class="font-extrabold text-primary-600">Rp
                        {{ number_format($order->final_amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-300">
                    <span class="text-gray-700">Sudah Dibayar</span>
                    <span class="font-bold text-gray-800">Rp {{ number_format($order->paid_amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-3 mt-4 bg-blue-50 border-blue-200 border rounded-lg px-4">
                    <span class="text-blue-800 font-bold">Sisa Tagihan</span>
                    <span class="font-bold text-rose-700">Rp
                        {{ number_format($order->final_amount - $order->paid_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Notes Section -->
        @if ($order->notes)
            <div class="mt-8 border-t border-gray-200 pt-6 px-8">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Catatan:</h3>
                <p class="text-gray-600 text-sm leading-relaxed">{{ $order->notes }}</p>
            </div>
        @endif

        <!-- Footer Section -->
        <div class="mt-12 text-center text-sm text-gray-500 border-t border-gray-300 pt-6 px-8">
            <p>Terima kasih telah berbisnis dengan kami.</p>
            <p class="font-semibold text-gray-700">RumahIde88</p>
            <p class="text-xs mt-1">Generated on {{ \Carbon\Carbon::now()->format('d F Y H:i') }}</p>
        </div>
    </div>
@endsection