<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $order->order_number }}</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            line-height: 1.4;
            width: 58mm;
            margin: 0 auto;
            padding: 5mm 2mm;
            color: #000;
            background-color: #fff;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .divider { border-top: 1px dashed #000; margin: 5px 0; }
        
        .header h1 { font-size: 16px; margin: 0; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 10px; }
        
        .info { margin: 10px 0; font-size: 10px; }
        .info table { width: 100%; border: none; }
        .info td { padding: 1px 0; }

        .items-table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        .items-table th { border-bottom: 1px solid #000; text-align: left; padding-bottom: 5px; font-size: 10px; }
        .items-table td { padding: 5px 0; vertical-align: top; font-size: 10px; }
        
        .totals { margin-top: 5px; }
        .totals-row { display: flex; justify-content: space-between; margin-bottom: 3px; font-size: 11px; }
        
        .footer { margin-top: 15px; font-size: 10px; }
        
        @media print {
            .no-print { display: none; }
            body { width: 58mm; padding: 0; margin: 0; }
        }

        .no-print {
            text-align: center;
            padding: 20px;
            background: #f4f4f4;
            border-bottom: 1px solid #ddd;
        }
        .btn {
            display: inline-block;
            padding: 8px 16px;
            background: #2563eb;
            color: #white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            font-size: 14px;
            color: white;
        }
        .btn-secondary { background: #64748b; }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print">
        <button onclick="window.print()" class="btn">Cetak Sekarang</button>
        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-secondary">Kembali</a>
    </div>

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
                <td>: {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td>Pelanggan</td>
                <td>: {{ $order->customer->name }}</td>
            </tr>
        </table>
    </div>

    <div class="divider"></div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Item</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>
                    {{ $item->product->name }}
                    @if($item->size)
                        <br><small>Size: {{ $item->size }}cm</small>
                    @endif
                </td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
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
        @if($order->discount > 0)
        <div class="totals-row">
            <span>Diskon</span>
            <span>-Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
        </div>
        @endif
        <div class="totals-row font-bold" style="font-size: 13px; border-top: 1px solid #000; padding-top: 5px;">
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

    <div class="footer text-center">
        <p class="font-bold">TERIMA KASIH</p>
        <p>Pesanan Anda Sedang Diproses</p>
        <p style="font-size: 8px; margin-top: 10px;">{{ date('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>