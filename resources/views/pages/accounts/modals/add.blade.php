<!-- Modal Tambah Akun pakai Alpine.js -->
<div x-show="modalAddAccount" x-cloak x-transition
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div @click.away="modalAddAccount = false"
        class="bg-white p-6 rounded-xl w-full max-w-lg shadow-lg">
        <h2 class="text-xl font-semibold mb-4">Tambah Akun</h2>
        <form method="POST" action="{{ route('pages.accounts.store') }}" class="space-y-4">
            @csrf
            <input type="text" name="account_name" placeholder="Nama Akun"
                class="w-full border rounded-lg px-4 py-2" required>

            <select name="account_type" class="w-full border rounded-lg px-4 py-2">
                @foreach(['Cash', 'Checking', 'Savings', 'Credit Card', 'Investment', 'E-Wallet'] as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>

            <div class="grid grid-cols-2 gap-4">
                <input type="number" step="0.01" name="current_balance" placeholder="Saldo"
                    class="border rounded-lg px-4 py-2" required>
                <input type="text" name="currency" maxlength="3" placeholder="Mata Uang"
                    class="border rounded-lg px-4 py-2" required>
            </div>

            <input type="text" name="bank_integration_id" placeholder="Bank Integration ID (opsional)"
                class="w-full border rounded-lg px-4 py-2">

            <div class="flex justify-between mt-4">
                <button type="button" @click="modalAddAccount = false"
                    class="text-gray-500 hover:underline">Batal</button>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">Simpan</button>
            </div>
        </form>
    </div>
</div>
