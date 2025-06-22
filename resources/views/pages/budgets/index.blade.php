<x-layouts.layout :titleApps="'Budgeting'">
    <style>[x-cloak] { display: none !important; }</style>


    <main class="container mx-auto px-4 py-8">
        @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
        @endif
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Budgeting</h1>
            <button onclick="showAddBudgetModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                + Tambah Anggaran
            </button>
        </div>

        <!-- Filter -->
        <form method="GET" action="{{ route('pages.budgets.index') }}" class="flex flex-col md:flex-row gap-4 mb-6">
            <select name="category_id" class="w-full md:w-1/3 px-4 py-2 border rounded-lg shadow-sm">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>

            <select name="budget_period" id="budget_period">
                <option value="">Semua Periode</option>
                @foreach ($budgetPeriods as $period)
                    <option value="{{ $period }}" {{ request('budget_period') == $period ? 'selected' : '' }}>
                        {{ ucfirst($period) }}
                    </option>
                @endforeach
            </select>


            <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-lg shadow">
                Filter
            </button>
            @if(request()->hasAny(['category_id', 'bulan']))
                <a href="{{ route('pages.budgets.index') }}" class="text-sm text-blue-600 underline mt-2">Reset</a>
            @endif
        </form>

        <!-- List Budget -->
        <div class="space-y-4">
        @forelse($budgets as $budget)
            <div class="bg-white p-4 rounded-xl shadow flex justify-between items-center">
                <div class="w-full">
                    <p class="font-semibold text-gray-800">{{ $budget->category->category_name }}</p>
                    <p class="text-sm text-gray-500">Bulan: {{ $budget->budget_period }}</p>
                    <p class="text-sm text-gray-500">Anggaran: Rp {{ number_format($budget->budget_amount, 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-500">Sisa: Rp {{ number_format($budget->remaining_amount, 0, ',', '.') }}</p>

                    @php
                        $used = $budget->budget_amount > 0
                            ? ($budget->current_spent / $budget->budget_amount) * 100
                            : 0;
                        $used = min(100, $used);
                    @endphp

                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-500" style="width: {{ $used }}%"></div>
                    </div>
                    <p class="text-xs text-gray-600 mt-1">
                        Terpakai: Rp {{ number_format($budget->current_spent, 0, ',', '.') }} dari Rp {{ number_format($budget->budget_amount, 0, ',', '.') }}
                    </p>
                </div>

                <form action="{{ route('pages.budgets.destroy', $budget) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus anggaran ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded-lg text-sm shadow">Hapus</button>
                </form>
            </div>
        @empty
            <p class="text-center text-gray-500">Belum ada anggaran.</p>
        @endforelse

        </div>

        <!-- Modal Tambah Anggaran -->
        <div id="addBudgetModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl w-full max-w-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-4">Tambah Anggaran</h2>
                <form method="POST" action="{{ route('pages.budgets.store') }}" class="space-y-4">
                    @csrf

                    <!-- Kategori -->
                    <select name="category_id" class="w-full border rounded-lg px-4 py-2" required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>

                    <!-- Periode Anggaran -->
                    <select name="budget_period" class="w-full border rounded-lg px-4 py-2" required>
                        <option value="">Pilih Periode</option>
                        <option value="Weekly">Mingguan</option>
                        <option value="Monthly">Bulanan</option>
                        <option value="Annually">Tahunan</option>
                    </select>

                    <div class="grid grid-cols-2 gap-4">
                        <label for="start_date" class="rounded-lg px-4 py-2">Tanggal Mulai :</label>
                        <label for="end_date" class="rounded-lg px-4 py-2">Tanggal Akhir :</label>
                    </div>

                    <!-- Tanggal Mulai & Akhir -->
                    <div class="grid grid-cols-2 gap-4">
                        <input type="date" name="start_date" class="border rounded-lg px-4 py-2" required>
                        <input type="date" name="end_date" class="border rounded-lg px-4 py-2" required>
                    </div>

                    <!-- Jumlah Anggaran -->
                    <input type="number" step="0.01" name="budget_amount" placeholder="Jumlah Anggaran (Rp)"
                        class="w-full border rounded-lg px-4 py-2" required>

                    <!-- Tombol -->
                    <div class="flex justify-between mt-4">
                        <button type="button" onclick="hideAddBudgetModal()" class="text-gray-500 hover:underline">Batal</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">Simpan</button>
                    </div>
                </form>
            </div>
        </div>


    </main>

    <script>
        function showAddBudgetModal() {
            const modal = document.getElementById('addBudgetModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function hideAddBudgetModal() {
            const modal = document.getElementById('addBudgetModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-layouts.layout>
