<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Keuangan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1f2937;
            background: #fff;
            padding: 40px;
        }

        /* Header Table Layout */
        .header-table {
            width: 100%;
            margin-bottom: 24px;
            border-bottom: 2px solid #111827;
            padding-bottom: 16px;
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

        /* Summary Cards Table Layout */
        .summary-table {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: separate;
            border-spacing: 12px 0;
            margin-left: -12px;
            margin-right: -12px;
        }
        .summary-card {
            width: 33.33%;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 16px;
            vertical-align: top;
        }
        .summary-title {
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #9ca3af;
            margin-bottom: 6px;
        }
        .summary-val {
            font-size: 15px;
            font-weight: 700;
            color: #111827;
        }

        /* Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        .data-table thead th {
            text-align: left;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #6b7280;
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        .data-table thead th.right { text-align: right; }
        .data-table tbody td {
            padding: 10px;
            font-size: 10px;
            color: #374151;
            border-bottom: 1px solid #f3f4f6;
        }
        .data-table tbody td.right { text-align: right; font-weight: 700; }
        .data-table tbody td.muted { color: #9ca3af; }
        .data-table tbody td.bold { font-weight: 700; color: #111827; text-transform: uppercase; }

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

        .income { color: #10B981; } /* emerald-500 */
        .expense { color: #EF4444; } /* red-500 */

        /* Footer */
        .footer {
            margin-top: 40px;
            padding-top: 16px;
            border-top: 1px solid #e5e7eb;
            font-size: 9px;
            color: #9ca3af;
            width: 100%;
        }
        .footer-left {
            float: left;
        }
        .footer-right {
            float: right;
        }

        .empty {
            text-align: center;
            padding: 40px 0;
            color: #d1d5db;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td>
                <div class="brand">MONEYTRACK.</div>
                <div class="period">Laporan Keuangan &mdash; {{ $filterLabel }}</div>
            </td>
            <td style="text-align: right; vertical-align: bottom; font-size: 9px; color: #9ca3af; text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">
                Financial Report
            </td>
        </tr>
    </table>

    <!-- Summary Statistics Grid -->
    <table class="summary-table">
        <tr>
            <td class="summary-card">
                <div class="summary-title">Total Pemasukan</div>
                <div class="summary-val income">Rp{{ number_format($totalIncome, 0, ',', '.') }}</div>
            </td>
            <td class="summary-card">
                <div class="summary-title">Total Pengeluaran</div>
                <div class="summary-val expense">Rp{{ number_format($totalExpense, 0, ',', '.') }}</div>
            </td>
            <td class="summary-card">
                <div class="summary-title">Laba/Rugi Bersih</div>
                <div class="summary-val {{ $netProfit >= 0 ? 'income' : 'expense' }}">
                    Rp{{ number_format($netProfit, 0, ',', '.') }}
                </div>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 50%;">Deskripsi</th>
                <th style="width: 15%;">Kategori</th>
                <th class="right" style="width: 20%;">Jumlah</th>
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
        <div class="footer-left">{{ $transactions->count() }} transaksi</div>
        <div class="footer-right">Dicetak {{ now()->format('d M Y, H:i') }} WIB</div>
        <div style="clear: both;"></div>
    </div>

</body>
</html>
