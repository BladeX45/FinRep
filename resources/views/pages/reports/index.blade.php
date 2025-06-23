<x-layouts.layout :titleApps="'Laporan Keuangan'">
<main class="container mx-auto px-4 py-8">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Laporan Transaksi</h1>
        <a href="{{ route('pages.reports.exportPdf', request()->query()) }}" target="_blank"
           class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition">Export PDF</a>
    </div>

    <!-- Filter -->
    <form method="GET" class="grid md:grid-cols-4 gap-4 mb-6">
        <input type="date" name="start_date" value="{{ $filters['start_date'] ?? '' }}" class="input" placeholder="Dari Tanggal">
        <input type="date" name="end_date" value="{{ $filters['end_date'] ?? '' }}" class="input" placeholder="Sampai Tanggal">
        <select name="account_id" class="input">
            <option value="">Semua Akun</option>
            @foreach($accounts as $acc)
                <option value="{{ $acc->id }}" @selected(($filters['account_id'] ?? '') == $acc->id)>{{ $acc->account_name }}</option>
            @endforeach
        </select>
        <select name="category_id" class="input">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected(($filters['category_id'] ?? '') == $cat->id)>{{ $cat->category_name }}</option>
            @endforeach
        </select>
        <select name="transaction_type" class="input">
            <option value="">Semua Tipe</option>
            <option value="Income" @selected(($filters['transaction_type'] ?? '') == 'Income')>Pemasukan</option>
            <option value="Expense" @selected(($filters['transaction_type'] ?? '') == 'Expense')>Pengeluaran</option>
        </select>
        <button class="col-span-full md:col-span-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Filter</button>
    </form>

    <!-- Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-green-50 p-4 rounded-lg">
            <p class="text-sm text-green-700">Total Pemasukan</p>
            <p class="text-xl font-bold text-green-800">Rp {{ number_format($summary['income'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-red-50 p-4 rounded-lg">
            <p class="text-sm text-red-700">Total Pengeluaran</p>
            <p class="text-xl font-bold text-red-800">Rp {{ number_format($summary['expense'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-indigo-50 p-4 rounded-lg">
            <p class="text-sm text-indigo-700">Saldo Bersih</p>
            <p class="text-xl font-bold text-indigo-800">Rp {{ number_format($summary['net'], 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Tabel -->
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">Akun</th>
                    <th class="px-4 py-2 text-left">Kategori</th>
                    <th class="px-4 py-2 text-left">Deskripsi</th>
                    <th class="px-4 py-2 text-right">Pemasukan</th>
                    <th class="px-4 py-2 text-right">Pengeluaran</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalIncome = 0;
                    $totalExpense = 0;
                @endphp
                @forelse($transactions as $trx)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($trx->transaction_date)->format('d M Y') }}</td>
                    <td class="px-4 py-2">{{ $trx->account->account_name }}</td>
                    <td class="px-4 py-2">{{ $trx->category->category_name }}</td>
                    <td class="px-4 py-2">{{ $trx->description }}</td>
                    <td class="px-4 py-2 text-right text-green-600">
                        @if($trx->transaction_type === 'Income')
                            @php $totalIncome += $trx->amount; @endphp
                            Rp {{ number_format($trx->amount, 0, ',', '.') }}
                        @endif
                    </td>
                    <td class="px-4 py-2 text-right text-red-600">
                        @if($trx->transaction_type === 'Expense')
                            @php $totalExpense += $trx->amount; @endphp
                            Rp {{ number_format($trx->amount, 0, ',', '.') }}
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-4 text-center text-gray-500">Tidak ada transaksi ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot class="bg-gray-100 font-semibold">
                <tr>
                    <td colspan="4" class="px-4 py-2 text-right">Total:</td>
                    <td class="px-4 py-2 text-right text-green-700">Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
                    <td class="px-4 py-2 text-right text-red-700">Rp {{ number_format($totalExpense, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

</main>
</x-layouts.layout>
