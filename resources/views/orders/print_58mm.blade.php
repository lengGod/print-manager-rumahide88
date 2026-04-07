<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $order->order_number }}</title>

    <style>
        @page {
            size: 58mm auto;
            margin: 0;
        }

        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 58mm;
            background: #fff;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.3;
            color: #000;
        }

        .print-wrapper {
            width: 58mm;
            padding: 2mm 3mm;
            margin: 0 auto;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        .header h1 {
            font-size: 16px;
            margin: 0;
            text-transform: uppercase;
        }

        .header p {
            margin: 1px 0;
            font-size: 10px;
        }

        .info {
            margin: 6px 0;
            font-size: 10px;
        }

        .info table {
            width: 100%;
        }

        .info td {
            padding: 1px 0;
        }

        /* ====================== */
        /* TABLE ITEMS (FIX RAPI) */
        /* ====================== */

        .items-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin: 6px 0;
        }

        .items-table th,
        .items-table td {
            font-size: 10px;
            padding: 3px 0;
            vertical-align: top;
            word-wrap: break-word;
        }

        .items-table th {
            border-bottom: 1px solid #000;
        }

        .items-table tbody tr {
            border-bottom: 1px dotted #aaa;
        }

        .items-table tbody tr:last-child {
            border-bottom: none;
        }

        .col-item {
            width: 50%;
            text-align: left;
        }

        .col-qty {
            width: 15%;
            text-align: center;
        }

        .col-total {
            width: 35%;
            text-align: right;
        }

        /* ====================== */

        .totals {
            margin-top: 5px;
        }

        .totals-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
            font-size: 11px;
        }

        .footer {
            margin-top: 8px;
            font-size: 10px;
        }

        @media print {

            .no-print {
                display: none !important;
            }

            html,
            body {
                width: 58mm;
            }

            .print-wrapper {
                width: 58mm;
                padding: 1mm 2mm;
            }

        }

        .no-print {
            text-align: center;
            padding: 15px;
            background: #f4f4f4;
            border-bottom: 1px solid #ddd;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        .btn-secondary {
            background: #64748b;
        }
    </style>
</head>

<body onload="window.print()">

    <div class="no-print">
        <button onclick="window.print()" class="btn">Cetak Sekarang</button>
        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-secondary">Kembali</a>
    </div>


    <div class="print-wrapper">

        <div class="header text-center">
            <h1>RumahIde88</h1>
            <p>Jl. Kamboja No.4, Enggal, Bandar Lampung</p>
            <p>Email: rumahide88@gmail.com</p>
        </div>

        <div class="divider"></div>

        <div class="info">
            <table>
                <tr>
                    <td width="35%">No. Order</td>
                    <td>: #{{ $order->order_number }}</td>
                </tr>

                <tr>
                    <td>Tanggal</td>
                    <td>: {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                </tr>

                <tr>
                    <td>Deadline</td>
                    <td>: {{ \Carbon\Carbon::parse($order->deadline)->format('d/m/Y') }}</td>
                </tr>

                <tr>
                    <td>Pelanggan</td>
                    <td>: {{ $order->customer->name }}</td>
                </tr>

                @if ($order->customer->phone)
                    <tr>
                        <td>Telepon</td>
                        <td>: {{ $order->customer->phone }}</td>
                    </tr>
                @endif

            </table>
        </div>

        <div class="divider"></div>


        <table class="items-table">

            <thead>
                <tr>
                    <th class="col-item">Item</th>
                    <th class="col-qty">Qty</th>
                    <th class="col-total">Total</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($order->items as $item)
                    <tr>

                        <td class="col-item">

                            <div class="font-bold">
                                {{ $item->product->name }}
                            </div>

                            @if ($item->size)
                                <div style="font-size:9px;">
                                    Size: {{ $item->size }}cm
                                </div>
                            @endif

                            @php
                                $specifications = json_decode($item->specifications ?? '[]', true);
                            @endphp

                            @if (!empty($specifications))
                                @foreach ($specifications as $spec)
                                    <div style="font-size:9px;">
                                        - {{ $spec['name'] }}: {{ $spec['value'] }}
                                    </div>
                                @endforeach
                            @endif

                        </td>

                        <td class="col-qty">
                            {{ $item->quantity }}
                        </td>

                        <td class="col-total">
                            {{ number_format($item->subtotal, 0, ',', '.') }}
                        </td>

                    </tr>
                @endforeach

            </tbody>
        </table>


        <div class="divider"></div>

        <div class="totals">

            <div class="totals-row">
                <span>Total</span>
                <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>

            <div class="totals-row">
                <span>Diskon</span>
                <span>-Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
            </div>

            <div class="totals-row font-bold"
                style="font-size:12px;border-top:1px solid #000;padding-top:3px;margin-top:3px;">
                <span>Grand Total</span>
                <span>Rp {{ number_format($order->final_amount, 0, ',', '.') }}</span>
            </div>

            <div class="totals-row">
                <span>Dibayar</span>
                <span>Rp {{ number_format($order->paid_amount, 0, ',', '.') }}</span>
            </div>

            <div class="totals-row font-bold">
                <span>Sisa Tagihan</span>
                <span>Rp {{ number_format($order->final_amount - $order->paid_amount, 0, ',', '.') }}</span>
            </div>

        </div>


        <div class="divider"></div>

        <div class="info">

            <p class="font-bold">Info Pembayaran:</p>
            <p>BCA: 2920636392</p>
            <p>BRI: 581601016483531</p>
            <p>a.n. Ratih Sulastri Ningsih</p>

        </div>


        @if ($order->notes)
            <div class="divider"></div>

            <div class="info">
                <p class="font-bold">Catatan:</p>
                <p>{{ $order->notes }}</p>
            </div>
        @endif


        <div class="divider"></div>

        <div class="footer text-center">

            <p class="font-bold">TERIMA KASIH</p>
            <p>Pesanan Anda Sedang Diproses</p>

            <p style="font-size:8px;margin-top:5px;">
                {{ date('d/m/Y H:i:s') }}
            </p>

        </div>

    </div>

</body>

</html>
