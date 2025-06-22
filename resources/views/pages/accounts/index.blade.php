<x-layouts.layout :titleApps="'Accounts'">
    <style>[x-cloak] { display: none !important; }</style>

    <main class="container mx-auto px-4 py-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Accounts</h1>
            <button onclick="showAddAccountModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                + Tambah
            </button>
        </div>

        <!-- Filter -->
        <form method="GET" action="{{ route('pages.accounts.index') }}" class="flex flex-col md:flex-row gap-4 mb-6">
            <input type="text" name="search" placeholder="Cari deskripsi..." value="{{ request('search') }}"
                   class="w-full md:w-1/3 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200">

            <select name="type" class="w-full md:w-1/4 px-4 py-2 border border-gray-300 rounded-lg shadow-sm">
                <option value="">Semua Jenis</option>
                @foreach ($accounts->pluck('account_type')->unique() as $type)
                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>

            <select name="currency" class="w-full md:w-1/4 px-4 py-2 border border-gray-300 rounded-lg shadow-sm">
                <option value="">Semua Mata Uang</option>
                @foreach ($accounts->pluck('currency')->unique() as $currency)
                    <option value="{{ $currency }}" {{ request('currency') == $currency ? 'selected' : '' }}>
                        {{ $currency }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-lg shadow">
                Filter
            </button>

            @if(request()->hasAny(['search', 'type', 'currency']))
                <a href="{{ route('pages.accounts.index') }}" class="text-sm text-blue-600 underline mt-2">Reset</a>
            @endif
        </form>

        <!-- List Akun -->
        <div class="space-y-4">
            @forelse($accounts as $account)
                <div class="bg-white p-4 rounded-xl shadow hover:shadow-md transition flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $account->account_name }}</p>
                        <p class="text-sm text-gray-500">{{ $account->account_type }} • {{ $account->currency }}</p>
                    </div>
                    <div class="flex gap-3">
                        <button onclick="openEditAccountModal(
                            {{ $account->id }},
                            '{{ $account->account_name }}',
                            '{{ $account->account_type }}',
                            {{ $account->current_balance }},
                            '{{ $account->currency }}',
                            '{{ $account->bank_integration_id }}'
                        )"
                        class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-1 rounded-lg text-sm shadow">
                            Edit
                        </button>

                        <form action="{{ route('pages.accounts.destroy', $account) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded-lg text-sm shadow">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-gray-500 text-center">Belum ada akun.</div>
            @endforelse
        </div>

        <!-- Modal Add Account -->
        <div id="addAccountModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl w-full max-w-lg shadow-lg">
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
                        <button type="button" onclick="hideAddAccountModal()" class="text-gray-500 hover:underline">Batal</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit Account -->
        <div id="editAccountModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl w-full max-w-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-4">Edit Akun</h2>
                <form method="POST" id="editForm" class="space-y-4">
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
                        <button type="button" onclick="hideEditAccountModal()" class="text-gray-500 hover:underline">Batal</button>
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg shadow">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

    </main>

    <!-- JS Modal Control -->
    <script>
        function showAddAccountModal() {
            document.getElementById('addAccountModal').classList.remove('hidden');
            document.getElementById('addAccountModal').classList.add('flex');
        }

        function hideAddAccountModal() {
            document.getElementById('addAccountModal').classList.add('hidden');
            document.getElementById('addAccountModal').classList.remove('flex');
        }

        function openEditAccountModal(id, name, type, balance, currency, bankId) {
            const modal = document.getElementById('editAccountModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.getElementById('editForm').action = `/accounts/${id}`;
            document.getElementById('edit_account_name').value = name;
            document.getElementById('edit_account_type').value = type;
            document.getElementById('edit_current_balance').value = balance;
            document.getElementById('edit_currency').value = currency;
            document.getElementById('edit_bank_integration_id').value = bankId ?? '';
        }

        function hideEditAccountModal() {
            const modal = document.getElementById('editAccountModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-layouts.layout>
