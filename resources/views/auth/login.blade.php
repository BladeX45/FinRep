{{-- import layout from layouts/layout --}}
<x-layouts.layout :titleApps="'Akun Masuk'">
<div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-indigo-100 to-purple-100">
    <div class="bg-white p-8 md:p-10 rounded-xl shadow-2xl w-full max-w-md">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Masuk ke Akun Anda</h2>
        <form action="{{ route('login-post') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">Email</label>
                <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" placeholder="Masukkan alamat email Anda" required>
            </div>
            <div>
                <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">Kata Sandi</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" placeholder="Masukkan kata sandi Anda" required>
            </div>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">Masuk</button>
        </form>
        <p class="mt-4 text-center text-gray-600">Belum punya akun? <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Daftar sekarang</a></p>
    </div>
</div>
</x-layouts.layout>
