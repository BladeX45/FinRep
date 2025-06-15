<x-layouts.layout :titleApps="'Akun Daftar'">
    <!-- Main Content Area - Registration Form -->
    <main class="flex-grow flex items-center justify-center p-4 md:p-8 bg-gradient-to-br from-indigo-100 to-purple-100">
        <div class="bg-white p-8 md:p-10 rounded-xl shadow-2xl w-full max-w-md">
            <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Daftar Akun Baru</h2>
            <form action="{{ route('register-post') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="name" class="block text-gray-700 text-sm font-semibold mb-2">Nama Pengguna</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" placeholder="Masukkan nama pengguna Anda" required>
                    <x-alert field="name" />
                </div>
                <div>
                    <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" placeholder="Masukkan alamat email Anda" required>
                    <x-alert field="email" />
                </div>
                <div>
                    <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">Kata Sandi</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" placeholder="Buat kata sandi" required>
                    <x-alert field="password" />
                </div>
                <div>
                    <label for="password_confirmation" class="block text-gray-700 text-sm font-semibold mb-2">Konfirmasi Kata Sandi</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" placeholder="Konfirmasi kata sandi Anda" required>
                    <x-alert field="password_confirmation" />
                </div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg shadow-lg transition-all duration-300 transform hover:scale-105">
                    Daftar
                </button>
            </form>
            <p class="text-center text-gray-600 text-sm mt-6">
                Sudah punya akun? <a href="#" class="text-indigo-600 hover:underline font-semibold">Masuk di sini</a>
            </p>
        </div>
    </main>
</x-layouts.layout>
