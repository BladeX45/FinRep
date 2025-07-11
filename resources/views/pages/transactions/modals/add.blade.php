<!-- Modal Tambah Transaksi -->
<div id="addTransactionModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white w-full max-w-md mx-auto rounded-xl shadow-lg p-6 relative">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Tambah Transaksi</h2>

        <form method="POST" action="{{ route('transaction.store') }}" class="space-y-4">
            @csrf

            <!-- Tanggal -->
            <div>
                <label for="transactionDate" class="block text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" name="date" id="transactionDate"
                       class="mt-1 w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:outline-none"
                       value="{{ old('date') }}">
            </div>

            <!-- Akun Asal -->
            <div>
                <label for="accountId" class="block text-sm font-medium text-gray-700">Akun</label>
                <select name="account_id" id="accountId"
                        class="mt-1 w-full border border-gray-300 rounded-md px-4 py-2 bg-white focus:ring-blue-500 focus:outline-none">
                    <option value="">Pilih Akun</option>
                    @foreach($accounts as $account)
                        <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>{{ $account->account_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Kategori -->
            <div>
                <label for="categoryId" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select name="category_id" id="categoryId"
                        class="mt-1 w-full border border-gray-300 rounded-md px-4 py-2 bg-white focus:ring-blue-500 focus:outline-none">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <input type="text" name="description" id="description"
                       class="mt-1 w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:outline-none"
                       value="{{ old('description') }}" placeholder="Contoh: Belanja bulanan">
            </div>

            <!-- Jumlah -->
            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah (Rp)</label>
                <input type="number" name="amount" id="amount"
                       class="mt-1 w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:outline-none"
                       value="{{ old('amount') }}">
            </div>

            <!-- Jenis Transaksi -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Jenis</label>
                <div class="flex items-center gap-6 mt-2">
                    <label class="flex items-center">
                        <input type="radio" name="type" value="Deb" class="text-blue-600 focus:ring-blue-500" {{ old('type', 'Deb') === 'Deb' ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-800 text-sm">Pemasukan</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="type" value="Cre" class="text-blue-600 focus:ring-blue-500" {{ old('type') === 'Cre' ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-800 text-sm">Pengeluaran</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="type" value="Tf" class="text-blue-600 focus:ring-blue-500" {{ old('type') === 'Tf' ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-800 text-sm">Transfer</span>
                    </label>
                </div>
            </div>

            <!-- Akun Tujuan (Transfer) -->
            <div id="destinationAccountDiv" class="hidden">
                <label for="destination_account_id" class="block text-sm font-medium text-gray-700">Akun Tujuan</label>
                <select name="destination_account_id" id="destination_account_id"
                        class="mt-1 w-full border border-gray-300 rounded-md px-4 py-2 bg-white focus:ring-blue-500 focus:outline-none">
                    <option value="">Pilih Akun Tujuan</option>
                    @foreach($accounts as $account)
                        <option value="{{ $account->id }}" {{ old('destination_account_id') == $account->id ? 'selected' : '' }}>{{ $account->account_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Alokasi ke Goal (jika Pengeluaran) -->
            <div id="goalDiv" class="hidden">
                <label for="goal_id" class="block text-sm font-medium text-gray-700">Alokasikan ke Tujuan</label>
                <select name="goal_id" id="goal_id"
                        class="mt-1 w-full border border-gray-300 rounded-md px-4 py-2 bg-white focus:ring-blue-500 focus:outline-none">
                    <option value="">Pilih Goal</option>
                    @foreach($goals as $goal)
                        <option value="{{ $goal->id }}" {{ old('goal_id') == $goal->id ? 'selected' : '' }}>
                            {{ $goal->goal_name }} (Target: Rp {{ number_format($goal->target_amount, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Transaksi Berulang -->
            <div>
                <label class="flex items-center text-sm text-gray-700">
                    <input type="checkbox" name="is_recurring" class="text-blue-600 focus:ring-blue-500" {{ old('is_recurring') ? 'checked' : '' }}>
                    <span class="ml-2">Transaksi Berulang</span>
                </label>
            </div>

            <!-- Tombol -->
            <div class="flex justify-end gap-4 mt-6">
                <button type="button" onclick="hideAddTransactionForm()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Simpan</button>
            </div>
        </form>

        <!-- Tombol Close -->
        <button onclick="hideAddTransactionForm()" class="absolute top-3 right-3 text-gray-400 hover:text-red-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>
<script>
    const typeRadios = document.querySelectorAll('input[name="type"]');
    const destAccountDiv = document.getElementById('destinationAccountDiv');
    const goalDiv = document.getElementById('goalDiv');

    function toggleFields() {
        const selected = document.querySelector('input[name="type"]:checked');
        if (!selected) return;

        destAccountDiv.classList.toggle('hidden', selected.value !== 'Tf');
        goalDiv.classList.toggle('hidden', selected.value !== 'Cre');
    }

    document.addEventListener('DOMContentLoaded', () => {
        toggleFields();
        typeRadios.forEach(radio => {
            radio.addEventListener('change', toggleFields);
        });
    });
</script>
