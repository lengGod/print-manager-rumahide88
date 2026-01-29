@extends('layouts.app')

@section('title', 'Laporan Produksi')

@section('content')
    <div class="container mx-auto p-4">
        <div class="flex items-center justify-between mb-4 no-print">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Laporan Produksi</h1>
            <button onclick="window.print()"
                class="bg-primary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                <span class="material-symbols-outlined mr-2">print</span>
                Cetak Laporan
            </button>
        </div>

        <div class="no-print mb-4 p-4 bg-white dark:bg-slate-800 rounded-lg shadow-md">
            <form action="{{ route('reports.production') }}" method="GET" class="flex items-end space-x-4">
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
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">Filter</button>
            </form>
        </div>

        <div class="report-header text-center mb-6 print-only">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Laporan Produksi</h1>
            <p class="text-gray-600 dark:text-gray-400">Periode:
                {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} -
                {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-md overflow-hidden" id="printable-content">
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
                            Status Produksi</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Operator</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Waktu Mulai</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Waktu Selesai</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Durasi (Jam)</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Catatan</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse ($orders as $order)
                        @foreach ($order->productionLogs as $log)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $order->order_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $order->customer->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full @if ($log->status == 'Selesai') bg-green-100 text-green-800 @elseif($log->status == 'Proses Cetak') bg-blue-100 text-blue-800 @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ $log->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $log->operator->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $log->start_time ? $log->start_time->format('d M Y, H:i') : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $log->end_time ? $log->end_time->format('d M Y, H:i') : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    @if ($log->start_time && $log->end_time)
                                        {{ $log->start_time->diffInHours($log->end_time) }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $log->notes ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="8"
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 text-center">
                                Tidak ada data produksi ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6 p-4 bg-white dark:bg-slate-800 rounded-lg shadow-md no-print">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Ringkasan Produksi</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Rata-rata Durasi Produksi (Jam):</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ number_format($avgProductionTime, 2) }}</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Pesanan Berdasarkan Status:</p>
                    <ul class="list-disc list-inside">
                        @foreach ($ordersByStatus as $statusName => $count)
                            <li class="text-gray-900 dark:text-white">{{ $statusName }}: {{ $count }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #printable-content, #printable-content * {
                visibility: visible;
            }
            #printable-content {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                overflow: visible !important;
                overflow-x: visible !important;
            }

            table {
                width: 100%;
                border-collapse: collapse;
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
                border: 1px solid #000 !important;
                padding: 6px 8px;
                text-align: left;
                font-size: 11px;
                line-height: 1.3;
                color: #000 !important;
                background-color: #fff !important;
            }
            th {
                background-color: #f2f2f2 !important;
                font-weight: bold;
            }
            .px-2.inline-flex.text-xs.leading-5.font-semibold.rounded-full {
                border: 1px solid #ccc !important;
                padding: 2px 5px;
            }
            span {
                color: #000 !important;
                background-color: transparent !important;
            }
            .dark\:text-white, .dark\:text-gray-300, .text-gray-900, .text-gray-500 {
                color: #000 !important;
            }
        }
    </style>
@endpush