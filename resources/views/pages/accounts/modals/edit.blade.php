<!-- Modal Edit Akun -->
<div id="editAccountModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded-xl w-full max-w-lg shadow-lg relative">
        <h2 class="text-xl font-semibold mb-4">Edit Akun</h2>
        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <input type="text" name="account_name" id="edit_account_name"
                class="w-full border rounded-lg px-4 py-2" required>

            <select name="account_type" id="edit_account_type" class="w-full border rounded-lg px-4 py-2">
                @foreach(['Cash', 'Checking', 'Savings', 'Credit Card', 'Investment', 'E-Wallet'] as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>

            <div class="grid grid-cols-2 gap-4">
                <input type="number" step="0.01" name="current_balance" id="edit_current_balance"
                    class="border rounded-lg px-4 py-2" required>
                <input type="text" name="currency" maxlength="3" id="edit_currency"
                    class="border rounded-lg px-4 py-2" required>
            </div>

            <input type="text" name="bank_integration_id" id="edit_bank_integration_id"
                class="w-full border rounded-lg px-4 py-2" placeholder="Bank Integration ID (opsional)">

            <div class="flex justify-between mt-4">
                <button type="button" onclick="hideEditAccountForm()" class="text-gray-500 hover:underline">Batal</button>
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg shadow">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
