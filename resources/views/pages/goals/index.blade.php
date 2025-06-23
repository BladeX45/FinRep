<x-layouts.layout :titleApps="'Goals'">
    <main class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Tujuan Keuangan</h1>
            <button onclick="document.getElementById('goalModal').classList.remove('hidden')" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow">
                + Tambah Goal
            </button>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-4">
            @forelse($goals as $goal)
                <div class="bg-white p-4 rounded-xl shadow flex justify-between items-center">
                    <div>
                        <h2 class="font-semibold text-lg text-gray-800">{{ $goal->goal_name }}</h2>
                        <p class="text-sm text-gray-500">Target: Rp {{ number_format($goal->target_amount, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-500">Tercapai: Rp {{ number_format($goal->current_amount, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-500">Batas Waktu: {{ \Carbon\Carbon::parse($goal->target_date)->translatedFormat('d F Y') }}</p>
                        <p class="text-sm text-gray-500">Tipe: {{ $goal->goal_type }}</p>

                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="bg-green-500 h-2 rounded-full transition-all duration-500"
                                style="width: {{ min(100, ($goal->current_amount / $goal->target_amount) * 100) }}%">
                            </div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('pages.goals.destroy', $goal) }}" onsubmit="return confirm('Hapus goal ini?')">
                        @csrf @method('DELETE')
                        <button class="bg-red-500 text-white px-3 py-1 rounded-lg text-sm">Hapus</button>
                    </form>
                </div>
            @empty
                <p class="text-gray-500 text-center">Belum ada tujuan keuangan.</p>
            @endforelse
        </div>

        <!-- Modal Tambah Goal -->
        <div id="goalModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-xl w-full max-w-md shadow-lg">
                <h2 class="text-xl font-semibold mb-4">Tambah Goal</h2>
                <form method="POST" action="{{ route('pages.goals.store') }}" class="space-y-4">
                    @csrf
                    <input name="goal_name" type="text" placeholder="Nama Tujuan" required class="w-full border rounded-lg px-4 py-2">
                    <input name="target_amount" type="number" placeholder="Jumlah Target" required class="w-full border rounded-lg px-4 py-2">
                    <input name="target_date" type="date" required class="w-full border rounded-lg px-4 py-2">
                    <input type="text" name="goal_type" placeholder="Tipe Goal (e.g. Tabungan, Investasi)" required class="w-full border rounded-lg px-4 py-2">

                    <div class="flex justify-between mt-4">
                        <button type="button" onclick="document.getElementById('goalModal').classList.add('hidden')" class="text-gray-500 hover:underline">Batal</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</x-layouts.layout>
