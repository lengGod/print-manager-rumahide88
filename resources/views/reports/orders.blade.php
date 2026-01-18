@extends('layouts.app')

@section('title', 'Laporan Pesanan')

@section('content')
    <div class="container mx-auto p-4">
        <div class="flex items-center justify-between mb-4 no-print">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Laporan Pesanan</h1>
            <button onclick="window.print()"
                class="bg-primary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                <span class="material-symbols-outlined mr-2">print</span>
                Cetak Laporan
            </button>
        </div>

        <div class="no-print mb-4 p-4 bg-white dark:bg-slate-800 rounded-lg shadow-md">
            <form action="{{ route('reports.orders') }}" method="GET" class="flex items-end space-x-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dari
                        Tanggal</label>
                    <input type="date" name="start_date" id="start_date"
                        value="{{ \Carbon\Carbon::parse($startDate)->format('Y-m-d') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sampai
                        Tanggal</label>
                    <input type="date" name="end_date" id="end_date"
                        value="{{ \Carbon\Carbon::parse($endDate)->format('Y-m-d') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select name="status" id="status"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                        <option value="all" @if ($status == 'all') selected @endif>Semua</option>
                        <option value="pending" @if ($status == 'pending') selected @endif>Pending</option>
                        <option value="processing" @if ($status == 'processing') selected @endif>Processing</option>
                        <option value="completed" @if ($status == 'completed') selected @endif>Completed</option>
                        <option value="cancelled" @if ($status == 'cancelled') selected @endif>Cancelled</option>
                    </select>
                </div>
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">Filter</button>
            </form>
        </div>

        <div class="report-header text-center mb-6 print-only">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Laporan Pesanan</h1>
            <p class="text-gray-600 dark:text-gray-400">Periode:
                {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} -
                {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                <thead class="bg-gray-50 dark:bg-slate-700">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            ID Pesanan</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Pelanggan</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Tanggal Pesanan</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Total Jumlah</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse ($orders as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                {{ $order->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $order->customer->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                Rp. {{ number_format($order->final_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full @if ($order->status == 'completed') bg-green-100 text-green-800 @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800 @elseif($order->status == 'processing') bg-blue-100 text-blue-800 @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5"
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 text-center">
                                Tidak ada data pesanan ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6 p-4 bg-white dark:bg-slate-800 rounded-lg shadow-md no-print">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Ringkasan Pesanan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Total Pesanan:</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $totalOrders }}</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Total Pendapatan:</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">Rp.
                        {{ number_format($totalAmount, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Total Diskon:</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">Rp.
                        {{ number_format($totalDiscount, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-gray-600 dark:text-gray-400">Pesanan Berdasarkan Status:</p>
                <ul class="list-disc list-inside">
                    @foreach ($ordersByStatus as $statusName => $count)
                        <li class="text-gray-900 dark:text-white">{{ ucfirst($statusName) }}: {{ $count }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        @media print {
            body {
                background-color: #fff !important;
                color: #000 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .no-print {
                display: none !important;
            }

            .report-header {
                display: block !important;
                text-align: center;
                margin-bottom: 20px;
            }

            .report-header h1 {
                font-size: 24px;
                color: #333;
                margin-bottom: 5px;
            }

            .report-header p {
                font-size: 14px;
                color: #555;
            }

            .bg-white, .bg-slate-800, .bg-gray-50, .bg-blue-100, .bg-green-100, .bg-yellow-100, .bg-red-100 {
                background-color: #fff !important;
                color: #000 !important;
            }

            .dark\:text-white, .dark\:text-slate-200, .dark\:text-slate-400, .dark\:text-gray-300 {
                color: #000 !important;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            thead {
                display: table-header-group;
            }

            th,
            td {
                border: 1px solid #000;
                padding: 6px 8px; /* Slightly reduced padding */
                text-align: left;
                font-size: 11px; /* Slightly increased font size */
                line-height: 1.3;
            }

            th {
                background-color: #f2f2f2 !important;
                font-weight: bold;
                color: #333 !important;
            }

            .px-2.inline-flex.text-xs.leading-5.font-semibold.rounded-full {
                border: 1px solid #ccc;
                padding: 2px 5px;
            }

            .mt-6.p-4.bg-white.dark\:bg-slate-800.rounded-lg.shadow-md.no-print {
                border: 1px solid #eee;
                padding: 15px;
                margin-top: 20px;
            }

            .mt-6.p-4.bg-white.dark\:bg-slate-800.rounded-lg.shadow-md {
                border: 1px solid #eee;
                padding: 15px;
                margin-top: 20px;
            }

            .grid.grid-cols-1.md\:grid-cols-3.gap-4 p, .list-disc.list-inside li {
                font-size: 12px;
                margin-bottom: 2px;
            }

            .grid.grid-cols-1.md\:grid-cols-3.gap-4 p.font-bold {
                font-size: 14px;
            }
        }
    </style>
@endpush
