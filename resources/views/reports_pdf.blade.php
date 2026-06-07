<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {{-- <title>Laporan Keuangan</title> --}}
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1f2937;
            background: #fff;
            padding: 40px;
        }

        /* Header */
        .header {
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 2px solid #111827;
        }
        .brand {
            font-size: 18px;
            font-weight: 900;
            letter-spacing: -1px;
            color: #111827;
        }
        .period {
            font-size: 10px;
            color: #6b7280;
            margin-top: 4px;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        thead th {
            text-align: left;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #6b7280;
            padding: 8px 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        thead th.right { text-align: right; }
        tbody td {
            padding: 8px 10px;
            font-size: 10px;
            color: #374151;
            border-bottom: 1px solid #f3f4f6;
        }
        tbody td.right { text-align: right; font-weight: 700; }
        tbody td.muted { color: #9ca3af; }
        tbody td.bold { font-weight: 700; color: #111827; text-transform: uppercase; }

        .badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 999px;
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            background: #f3f4f6;
            color: #6b7280;
        }

        .income { color: #059669; }
        .expense { color: #dc2626; }

        /* Footer */
        .footer {
            margin-top: 24px;
            padding-top: 12px;
            border-top: 1px solid #e5e7eb;
            font-size: 9px;
            color: #9ca3af;
            display: flex;
            justify-content: space-between;
        }

        .empty {
            text-align: center;
            padding: 30px 0;
            color: #d1d5db;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="brand">MONEYTRACK.</div>
        <div class="period">Laporan Keuangan &mdash; {{ $filterLabel }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Kategori</th>
                <th class="right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $trx)
                @php $type = $trx->category->type ?? 'expense'; @endphp
                <tr>
                    <td class="muted">{{ \Carbon\Carbon::parse($trx->trans_date)->format('d M Y') }}</td>
                    <td class="bold">{{ $trx->desc }}</td>
                    <td><span class="badge">{{ $trx->category->cat_name ?? '-' }}</span></td>
                    <td class="right {{ $type === 'income' ? 'income' : 'expense' }}">
                        {{ $type === 'income' ? '+' : '-' }}Rp{{ number_format($trx->amount, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="empty">Tidak ada transaksi pada periode ini</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <span>{{ $transactions->count() }} transaksi</span>
        <span>Dicetak {{ now()->format('d M Y, H:i') }} WIB</span>
    </div>

</body>
</html>
