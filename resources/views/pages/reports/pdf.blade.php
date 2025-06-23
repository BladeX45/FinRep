<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
    <style>
        * {
            font-family: DejaVu Sans, sans-serif;
            box-sizing: border-box;
        }
        body {
            margin: 30px;
            font-size: 13px;
            color: #2d3748;
        }
        h1 {
            text-align: center;
            font-size: 22px;
            margin-bottom: 25px;
            color: #1a202c;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .summary-box {
            width: 32%;
            padding: 12px 16px;
            border-radius: 8px;
            background-color: #f8fafc;
            box-shadow: 0 1px 2px rgba(0,0,0,0.06);
        }

        .summary-title {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 6px;
        }

        .summary-value {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
        }

        .income { background-color: #ecfdf5; color: #047857; }
        .expense { background-color: #fef2f2; color: #b91c1c; }
        .net { background-color: #eef2ff; color: #3730a3; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px 8px;
            border: 1px solid #e2e8f0;
        }

        thead {
            background-color: #f1f5f9;
        }

        tfoot {
            background-color: #f8fafc;
            font-weight: bold;
        }

        .text-right { text-align: right; }
        .text-green { color: #16a34a; }
        .text-red { color: #dc2626; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <h1>Laporan Transaksi Keuangan</h1>

    <div style="width: 100%; margin-bottom: 24px;">
        <!-- Total Pemasukan -->
        <div style="float: left; width: 31.5%; margin-right: 2%; padding: 12px 1px; background-color: #ecfdf5; border-radius: 8px;">
            <div style="font-size: 14px; color: #047857; font-weight: 600; margin-bottom: 4px;">Total Pemasukan</div>
            <div style="font-size: 20px; color: #047857; font-weight: bold;">Rp {{ number_format($summary['income'], 0, ',', '.') }}</div>
        </div>

        <!-- Total Pengeluaran -->
        <div style="float: left; width: 31.5%; margin-right: 2%; padding: 12px 1px; background-color: #fef2f2; border-radius: 8px;">
            <div style="font-size: 14px; color: #b91c1c; font-weight: 600; margin-bottom: 4px;">Total Pengeluaran</div>
            <div style="font-size: 20px; color: #b91c1c; font-weight: bold;">Rp {{ number_format($summary['expense'], 0, ',', '.') }}</div>
        </div>

        <!-- Saldo Bersih -->
        <div style="float: left; width: 31.5%; padding: 12px 1px; background-color: #eef2ff; border-radius: 8px;">
            <div style="font-size: 14px; color: #3730a3; font-weight: 600; margin-bottom: 4px;">Saldo Bersih</div>
            <div style="font-size: 20px; color: #3730a3; font-weight: bold;">Rp {{ number_format($summary['net'], 0, ',', '.') }}</div>
        </div>

        <div style="clear: both;"></div>
    </div>



    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Akun</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th class="text-right">Pemasukan</th>
                <th class="text-right">Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalIncome = 0;
                $totalExpense = 0;
            @endphp
            @forelse($transactions as $trx)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($trx->transaction_date)->format('d M Y') }}</td>
                    <td>{{ $trx->account->account_name }}</td>
                    <td>{{ $trx->category->category_name }}</td>
                    <td>{{ $trx->description }}</td>
                    <td class="text-right text-green">
                        @if($trx->transaction_type === 'Income')
                            @php $totalIncome += $trx->amount; @endphp
                            Rp {{ number_format($trx->amount, 0, ',', '.') }}
                        @endif
                    </td>
                    <td class="text-right text-red">
                        @if($trx->transaction_type === 'Expense')
                            @php $totalExpense += $trx->amount; @endphp
                            Rp {{ number_format($trx->amount, 0, ',', '.') }}
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada transaksi ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right">Total:</td>
                <td class="text-right text-green">Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
                <td class="text-right text-red">Rp {{ number_format($totalExpense, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

</body>
</html>
