@extends('layouts.app')

@section('title', 'Laporan Pelanggan')

@section('content')
    <div class="container mx-auto p-4">
        <div class="flex items-center justify-between mb-4 no-print">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Laporan Pelanggan</h1>
            <button onclick="window.print()"
                class="bg-primary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                <span class="material-symbols-outlined mr-2">print</span>
                Cetak Laporan
            </button>
        </div>

        <div class="no-print mb-4 p-4 bg-white dark:bg-slate-800 rounded-lg shadow-md">
            <form action="{{ route('reports.customers') }}" method="GET" class="flex items-end space-x-4">
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
                        class="mt-1 block w-full rounded-md border-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                </div>
                <div>
                    <label for="status_filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status Pelanggan</label>
                    <select name="status_filter" id="status_filter"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                        <option value="all" {{ request('status_filter') == 'all' ? 'selected' : '' }}>Semua</option>
                        <option value="outstanding_debt" {{ request('status_filter') == 'outstanding_debt' ? 'selected' : '' }}>Memiliki Piutang</option>
                    </select>
                </div>
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">Filter</button>
            </form>
        </div>

        <div class="report-header text-center mb-6 print-only">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Laporan Pelanggan</h1>
            <p class="text-gray-600 dark:text-gray-400">Periode:
                {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} -
                {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-md overflow-hidden overflow-x-auto" id="printable-content">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                <thead class="bg-gray-50 dark:bg-slate-700">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Nama Pelanggan</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Email</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Nomor Telepon</th>
                                                    <th
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                        Jumlah Transaksi</th>
                                                    <th
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                        Total Pesanan</th>
                                                    <th
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                        Total Dibayar</th>
                                                    <th
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                        Piutang</th>
                                                    <th
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                        Status</th>                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse ($customersWithOrders as $customer)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                <a href="{{ route('customers.show', $customer->id) }}" class="text-primary hover:underline">
                                    {{ $customer->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $customer->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $customer->phone_number }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $customer->orders->count() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                Rp. {{ number_format($customer->total_order_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                Rp. {{ number_format($customer->total_paid_amount, 0, ',', '.') }}
                                </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm @if($customer->outstanding_debt > 0) text-rose-600 font-semibold @else text-gray-500 @endif dark:text-gray-300">
                                Rp. {{ number_format($customer->outstanding_debt, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                <!-- Example Status Logic: Can be customized based on your business rules -->
                                @if ($customer->outstanding_debt > 0)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-rose-100 text-rose-800">
                                        Piutang
                                    </span>
                                @elseif ($customer->orders->count() > 5 && $customer->total_order_amount > 5000000)
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Pelanggan Prioritas
                                    </span>
                                @elseif($customer->orders->count() > 0)
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Aktif
                                    </span>
                                @else
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Baru
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9"
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 text-center">
                                Tidak ada data pelanggan ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6 p-4 bg-white dark:bg-slate-800 rounded-lg shadow-md no-print">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Ringkasan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Total Pelanggan Aktif:</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $totalCustomers }}</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Total Transaksi:</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $totalOrders }}</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Total Pesanan:</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">Rp.
                        {{ number_format($totalAmount, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Total Dibayar:</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">Rp.
                        {{ number_format($totalPaid, 0, ',', '.') }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-gray-600 dark:text-gray-400">Total Piutang:</p>
                    <p class="text-lg font-bold @if($totalOutstandingDebt > 0) text-rose-600 @else text-gray-900 @endif dark:text-white">Rp.
                        {{ number_format($totalOutstandingDebt, 0, ',', '.') }}</p>
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
