<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Order {{ $order->number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
        }

        .header {
            margin-bottom: 30px;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 4px 8px;
        }

        .lines-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .lines-table th,
        .lines-table td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: left;
        }

        .lines-table th {
            background: #f5f5f5;
        }

        .total {
            font-size: 16px;
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="title">Order {{ $order->number }}</div>
        <table class="info-table">
            <tr>
                <td><strong>Date:</strong> {{ $order->date }}</td>
                <td><strong>Valid Until:</strong> {{ $order->valid_until }}</td>
            </tr>
            <tr>
                <td><strong>Client:</strong> {{ $order->client->name ?? '-' }}</td>
                <td><strong>Status:</strong> {{ ucfirst($order->status) }}</td>
            </tr>
        </table>
    </div>
    <table class="lines-table">
        <thead>
            <tr>
                <th>Article</th>
                <th>Reference</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Supplier</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->lines as $line)
            <tr>
                <td>{{ $line->article->name ?? '-' }}</td>
                <td>{{ $line->article->reference ?? '-' }}</td>
                <td>{{ $line->quantity }}</td>
                <td>{{ number_format($line->price, 2) }}</td>
                <td>{{ $line->supplier->name ?? '-' }}</td>
                <td>{{ number_format($line->price * $line->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="total">
        Total: {{ number_format($order->total, 2) }}
    </div>
</body>

</html>