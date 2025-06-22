<x-layouts.layout :titleApps="'Transactions'">
    <main class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Transaksi</h1>
            <a href="#" onclick="showAddTransactionForm()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                + Tambah
            </a>
        </div>

        <!-- Filter -->
        <form method="GET" action="{{ route('transactions') }}" class="flex flex-col md:flex-row gap-4 mb-6">
            <input type="text" name="search" placeholder="Cari deskripsi..." value="{{ request('search') }}"
                   class="w-full md:w-1/3 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200">
            <input type="date" name="date" value="{{ request('date') }}"
                   class="w-full md:w-1/4 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200">
            <select name="category" class="w-full md:w-1/4 px-4 py-2 border border-gray-300 rounded-lg shadow-sm">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->category_name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-lg shadow">
                Filter
            </button>
            @if(request()->hasAny(['search', 'date', 'category']))
                <a href="{{ route('transactions') }}" class="text-sm text-blue-600 underline mt-2">Reset</a>
            @endif
        </form>

        <!-- Daftar Transaksi -->
        <div class="space-y-4">
            @forelse($transactions as $transaction)
                @php
                    $type = $transaction->transaction_type;

                    $color = match($type) {
                        'Income' => 'text-green-600',
                        'Expense' => 'text-red-500',
                        'Transfer', 'Transfer-In', 'Transfer-Out' => 'text-yellow-500',
                        default => 'text-gray-500',
                    };

                    $icon = match($type) {
                        'Income' => '<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>',
                        'Expense' => '<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>',
                        'Transfer' => '<svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>',
                        'Transfer-In' => '<svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>',
                        'Transfer-Out' => '<svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" /></svg>',
                        default => '',
                    };
                @endphp

                <div class="bg-white p-4 rounded-xl shadow hover:shadow-md transition flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($transaction->transaction_date)->translatedFormat('d F Y') }}</p>
                        <p class="font-semibold text-gray-800">{{ $transaction->description }}</p>
                        <p class="text-sm text-gray-500">Kategori: {{ $transaction->category->category_name ?? '-' }}</p>
                        <span class="text-xs inline-block mt-1 px-2 py-1 rounded-full bg-gray-100 text-gray-600">{{ $transaction->transaction_type }}</span>
                    </div>

                    <div class="flex items-center gap-2 text-lg font-semibold {{ $color }}">
                        {!! $icon !!}
                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                    </div>
                </div>
            @empty
                <div class="text-gray-500 text-center">Belum ada transaksi.</div>
            @endforelse
        </div>


        <!-- Tambah, Detail, Delete -->
        @include('pages.transactions.modals.add')
        @include('pages.transactions.modals.detail')
    </main>

    <!-- JS Modal -->
    <script>
        function showAddTransactionForm() {
            document.getElementById('addTransactionModal').classList.remove('hidden');
        }
        function hideAddTransactionForm() {
            document.getElementById('addTransactionModal').classList.add('hidden');
        }

        function showTransactionDetail(id) {
            // logika detail
            document.getElementById('transactionDetailModal').classList.remove('hidden');
        }
        function hideTransactionDetail() {
            document.getElementById('transactionDetailModal').classList.add('hidden');
        }

        function confirmDeleteTransaction(id) {
            document.getElementById('deleteConfirmModal').classList.remove('hidden');
        }
        function cancelDelete() {
            document.getElementById('deleteConfirmModal').classList.add('hidden');
        }
    </script>
</x-layouts.layout>
