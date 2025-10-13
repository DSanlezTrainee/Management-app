<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Proposal {{ $proposal->number }}</title>
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
    <div class="header" style="display: flex; align-items: flex-start; justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 16px;">
            @if($company && $company->logo)
            <img src="{{ public_path('storage/' . $company->logo) }}" alt="Logo"
                style="height: 60px; max-width: 120px; object-fit: contain; border-radius: 6px; border: 1px solid #eee;" />
            @endif
            <div>
                <div style="font-size: 18px; font-weight: bold;">{{ $company->name ?? '' }}</div>
                <div style="font-size: 13px;">{{ $company->address ?? '' }}</div>
                <div style="font-size: 13px;">{{ $company->postal_code ?? '' }} {{ $company->city ?? '' }}</div>
                <div style="font-size: 13px;">NIF: {{ $company->nif ?? '' }}</div>
            </div>
        </div>
        <div class="title" style="margin-bottom:0;">Proposal {{ $proposal->number }}</div>
    </div>
    <table class="info-table">
        <tr>
            <td><strong>Date:</strong> {{ $proposal->date }}</td>
            <td><strong>Valid Until:</strong> {{ $proposal->valid_until }}</td>
        </tr>
        <tr>
            <td><strong>Client:</strong> {{ $proposal->client->name ?? '-' }}</td>
            <td><strong>Status:</strong> {{ ucfirst($proposal->status) }}</td>
        </tr>
    </table>
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
            @foreach($proposal->lines as $line)
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
        Total: {{ number_format($proposal->total, 2) }}
    </div>
</body>

</html>