@extends('layouts.app')

@section('title', 'Laporan Laba Rugi')

@section('content')
    <div class="container mx-auto p-4">
        <div class="flex items-center justify-between mb-4 no-print">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Laporan Laba Rugi</h1>
            <button onclick="window.print()"
                class="bg-primary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                <span class="material-symbols-outlined mr-2">print</span>
                Cetak Laporan
            </button>
        </div>

        <div class="no-print mb-4 p-4 bg-white dark:bg-slate-800 rounded-lg shadow-md">
            <form action="{{ route('reports.profit') }}" method="GET" class="flex items-end space-x-4">
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
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Laporan Laba Rugi</h1>
            <p class="text-gray-600 dark:text-gray-400">Periode:
                {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} -
                {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-md overflow-hidden p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-center">
                <div class="p-4 bg-blue-50 dark:bg-slate-700 rounded-lg">
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Total Pendapatan</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">Rp. {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="p-4 bg-rose-50 dark:bg-slate-700 rounded-lg">
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Total Biaya Material</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">Rp. {{ number_format($materialCosts, 0, ',', '.') }}</p>
                </div>
                <div class="p-4 @if($profit >= 0) bg-green-50 @else bg-rose-50 @endif dark:bg-slate-700 rounded-lg">
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Total Laba/Rugi</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">Rp. {{ number_format($profit, 0, ',', '.') }}</p>
                </div>
                <div class="p-4 bg-purple-50 dark:bg-slate-700 rounded-lg md:col-span-2 lg:col-span-3">
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Margin Laba</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ number_format($profitMargin, 2) }}%</p>
                </div>
            </div>
        </div>

        {{-- You might want to display a table of orders that contributed to this profit/loss --}}
        {{-- For simplicity, this example only shows summaries --}}
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

            .bg-white, .bg-slate-800, .bg-gray-50, .bg-blue-50, .bg-rose-50, .bg-green-50, .bg-purple-50 {
                background-color: #fff !important;
                color: #000 !important;
                border: 1px solid #eee !important;
            }

            .dark\:text-white, .dark\:text-slate-200, .dark\:text-slate-400, .dark\:text-gray-300 {
                color: #000 !important;
            }

            .p-4 {
                padding: 10px !important;
            }

            .text-xl.font-bold {
                font-size: 18px !important;
            }

            .text-sm {
                font-size: 12px !important;
            }

            .grid.grid-cols-1.md\:grid-cols-2.lg\:grid-cols-3.gap-4.text-center {
                display: block !important;
            }

            .grid.grid-cols-1.md\:grid-cols-2.lg\:grid-cols-3.gap-4.text-center > div {
                margin-bottom: 10px;
            }
        }
    </style>
@endpush
