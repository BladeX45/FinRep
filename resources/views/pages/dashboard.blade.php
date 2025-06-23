<x-layouts.layout :titleApps="'Dashboard'">
<main class="flex-grow container mx-auto p-4 md:p-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Kolom Kiri: Ringkasan & Wawasan -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Ringkasan Saldo Akun -->
            <section class="bg-white p-6 rounded-xl shadow-md">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2 md:col-span-1">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Ringkasan Saldo Akun</h2>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @php
                        $total = $balances->sum();
                    @endphp
                    <div class="bg-indigo-50 p-4 rounded-lg flex flex-col items-center justify-center">
                        <span class="text-gray-500 text-sm">Total Saldo</span>
                        <span class="text-2xl font-bold text-indigo-700">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    @foreach($balances as $currency => $amount)
                        <div class="bg-blue-50 p-4 rounded-lg flex flex-col items-center justify-center">
                            <span class="text-gray-500 text-sm">Saldo ({{ $currency }})</span>
                            <span class="text-xl font-semibold text-blue-700">Rp {{ number_format($amount, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 text-center">
                    <a href="-" class="text-indigo-600 hover:underline text-sm">Lihat Semua Akun</a>
                </div>
            </section>

            <!-- Wawasan Cepat Berbasis AI -->
            <section class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Wawasan Cepat</h2>
                <div class="space-y-3">
                    @foreach($insights as $insight)
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 p-4 rounded-md flex items-start">
                            <svg class="w-6 h-6 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                       d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{!! $insight !!}</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 text-center">
                    <a href="#" class="text-indigo-600 hover:underline text-sm">Lihat Semua Wawasan</a>
                </div>
            </section>

            <!-- Diagram Lingkaran Rincian Pengeluaran berdasarkan Kategori -->
        <!-- Rincian Pengeluaran (Bulan Ini) -->
       <!-- Rincian Pengeluaran (Bulan Ini) -->
            <section class="bg-white p-6 rounded-xl shadow-md mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Rincian Pengeluaran (Bulan Ini)</h2>
                <div class="flex flex-col md:flex-row items-center justify-center space-y-4 md:space-y-0 md:space-x-8">
                    <div class="w-48 h-48">
                        <canvas id="expensePieChart" width="300" height="300"></canvas>
                    </div>
                    <ul class="space-y-2">
                        @php $totalExpense = $expenseChart->sum('total'); @endphp
                        @foreach($expenseChart as $item)
                            @php $percent = $totalExpense ? round(($item->total / $totalExpense) * 100, 1) : 0; @endphp
                            <li class="flex items-center text-gray-700">
                                <span class="block w-3 h-3 rounded-full mr-2" style="background-color: #{{ substr(md5($item->category), 0, 6) }}"></span>
                                {{ $item->category }}: Rp {{ number_format($item->total, 0, ',', '.') }} ({{ $percent }}%)
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>

            <!-- Rincian Pemasukan (Bulan Ini) -->
            <section class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Rincian Pemasukan (Bulan Ini)</h2>
                <div class="flex flex-col md:flex-row items-center justify-center space-y-4 md:space-y-0 md:space-x-8">
                    <div class="w-48 h-48">
                        <canvas id="incomePieChart" width="300" height="300"></canvas>
                    </div>
                    <ul class="space-y-2">
                        @php $totalIncome = $incomeChart->sum('total'); @endphp
                        @foreach($incomeChart as $item)
                            @php $percent = $totalIncome ? round(($item->total / $totalIncome) * 100, 1) : 0; @endphp
                            <li class="flex items-center text-gray-700">
                                <span class="block w-3 h-3 rounded-full mr-2" style="background-color: #{{ substr(md5($item->category), 0, 6) }}"></span>
                                {{ $item->category }}: Rp {{ number_format($item->total, 0, ',', '.') }} ({{ $percent }}%)
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>

        </div>

        <!-- Kolom Kanan: Tujuan & Tagihan -->
        <div class="lg:col-span-1 space-y-6">

            <!-- Bilah Kemajuan Tujuan Tabungan -->
            <section class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Kemajuan Tujuan Keuangan</h2>
                <div class="space-y-4">
                    @foreach($goals as $goal)
                        <div>
                            <div class="flex justify-between items-center text-gray-700 text-sm mb-1">
                                <span>{{ $goal['name'] }} (Rp {{ number_format($goal['target'], 0, ',', '.') }})</span>
                                <span>Rp {{ number_format($goal['current'], 0, ',', '.') }} / {{ $goal['progress_percent'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ $goal['progress_percent'] }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 text-center">
                    <a href="#" class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-medium py-2 px-4 rounded-lg transition-colors text-sm">
                        Kelola Tujuan
                    </a>
                </div>
            </section>

            <!-- Daftar Tagihan yang Akan Datang -->
            <section class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Tagihan Akan Datang</h2>
                <ul class="divide-y divide-gray-200">
                    @forelse($nextBills as $bill)
                        <li class="py-3 flex justify-between items-center">
                            <div>
                                <p class="font-medium text-gray-800">{{ $bill->category->name ?? 'Tidak diketahui' }}</p>
                                <p class="text-sm text-gray-500">Jatuh Tempo: {{ \Carbon\Carbon::parse($bill->transaction_date)->format('d F Y') }}</p>
                            </div>
                            <span class="font-semibold text-gray-700">Rp {{ number_format($bill->amount, 0, ',', '.') }}</span>
                        </li>
                    @empty
                        <li class="py-3 text-center text-gray-500">Tidak ada tagihan dalam waktu dekat.</li>
                    @endforelse
                </ul>
                <div class="mt-4 text-center">
                    <a href="#" class="text-indigo-600 hover:underline text-sm">Lihat Semua Tagihan</a>
                </div>
            </section>
            <!-- Ringkasan Anggaran -->
            <section class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Ringkasan Anggaran</h2>
                @php
                    $totalBudget = $budgets->sum('budget_amount');
                    $totalSpent = $budgets->sum('current_spent');
                    $remaining = $totalBudget - $totalSpent;
                    $percentUsed = $totalBudget > 0 ? round(($totalSpent / $totalBudget) * 100) : 0;
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <p class="text-sm text-gray-500">Total Anggaran</p>
                        <p class="text-lg font-bold text-blue-700">Rp {{ number_format($totalBudget, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-4 bg-yellow-50 rounded-lg">
                        <p class="text-sm text-gray-500">Pengeluaran Saat Ini</p>
                        <p class="text-lg font-bold text-yellow-600">Rp {{ number_format($totalSpent, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-4 bg-green-50 rounded-lg">
                        <p class="text-sm text-gray-500">Sisa Anggaran</p>
                        <p class="text-lg font-bold text-green-700">Rp {{ number_format($remaining, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="h-3 rounded-full bg-indigo-600" style="width: {{ $percentUsed }}%"></div>
                    </div>
                    <p class="text-xs text-gray-600 mt-1 text-center">Terpakai: {{ $percentUsed }}%</p>
                </div>

                <div class="mt-4 text-center">
                    <a href="{{ route('pages.budgets.index') }}" class="text-indigo-600 hover:underline text-sm">Lihat Detail Anggaran</a>
                </div>
            </section>

        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const expenseCtx = document.getElementById('expensePieChart').getContext('2d');
    const incomeCtx = document.getElementById('incomePieChart').getContext('2d');

    const expenseData = {
        labels: {!! json_encode($expenseChart->pluck('category')) !!},
        datasets: [{
            data: {!! json_encode($expenseChart->pluck('total')) !!},
            backgroundColor: {!! json_encode($expenseChart->map(fn($item) => '#' . substr(md5($item->category), 0, 6))) !!}
        }]
    };

    const incomeData = {
        labels: {!! json_encode($incomeChart->pluck('category')) !!},
        datasets: [{
            data: {!! json_encode($incomeChart->pluck('total')) !!},
            backgroundColor: {!! json_encode($incomeChart->map(fn($item) => '#' . substr(md5($item->category), 0, 6))) !!}
        }]
    };

    new Chart(expenseCtx, {
        type: 'pie',
        data: expenseData,
        options: {
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let val = context.parsed;
                            return `${context.label}: Rp ${val.toLocaleString('id-ID')}`;
                        }
                    }
                }
            }
        }
    });

    new Chart(incomeCtx, {
        type: 'pie',
        data: incomeData,
        options: {
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let val = context.parsed;
                            return `${context.label}: Rp ${val.toLocaleString('id-ID')}`;
                        }
                    }
                }
            }
        }
    });
</script>


</x-layouts.layout>
