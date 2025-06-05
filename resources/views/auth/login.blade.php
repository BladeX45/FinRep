<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor Keuangan Pribadi - Mockup</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa; /* Light gray background */
        }
        .scroll-container {
            -ms-overflow-style: none; /* IE and Edge */
            scrollbar-width: none; /* Firefox */
        }
        .scroll-container::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <!-- Header / Navbar -->
    <header class="bg-white shadow-sm p-4 sticky top-0 z-10">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-2xl font-bold text-gray-800">
                <a href="#" class="hover:text-indigo-600 transition-colors">💵 Keuangan Saya</a>
            </h1>
            <nav>
                <ul class="flex space-x-6 text-gray-600">
                    <li><a href="#" class="hover:text-indigo-600 font-medium">Dasbor</a></li>
                    <li><a href="#" class="hover:text-indigo-600">Transaksi</a></li>
                    <li><a href="#" class="hover:text-indigo-600">Anggaran</a></li>
                    <li><a href="#" class="hover:text-indigo-600">Tujuan</a></li>
                    <li><a href="#" class="hover:text-indigo-600">Laporan</a></li>
                </ul>
            </nav>
            <div class="flex items-center space-x-4">
                <button class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-2 px-4 rounded-lg shadow-md transition-colors">
                    + Transaksi Baru
                </button>
                <!-- Placeholder for User Avatar/Menu -->
                <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold">
                    AB
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow container mx-auto p-4 md:p-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Kolom Kiri: Ringkasan & Wawasan -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Ringkasan Saldo Akun -->
                <section class="bg-white p-6 rounded-xl shadow-md">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Ringkasan Saldo Akun</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-indigo-50 p-4 rounded-lg flex flex-col items-center justify-center">
                            <span class="text-gray-500 text-sm">Total Saldo</span>
                            <span class="text-2xl font-bold text-indigo-700">Rp 15.750.000</span>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg flex flex-col items-center justify-center">
                            <span class="text-gray-500 text-sm">Rekening Tabungan</span>
                            <span class="text-xl font-semibold text-blue-700">Rp 10.000.000</span>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg flex flex-col items-center justify-center">
                            <span class="text-gray-500 text-sm">Kartu Kredit</span>
                            <span class="text-xl font-semibold text-green-700">-Rp 2.500.000</span>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <button class="text-indigo-600 hover:underline text-sm">Lihat Semua Akun</button>
                    </div>
                </section>

                <!-- Wawasan Cepat Berbasis AI -->
                <section class="bg-white p-6 rounded-xl shadow-md">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Wawasan Cepat</h2>
                    <div class="space-y-3">
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 p-4 rounded-md flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Anda menghabiskan <span class="font-semibold">15% lebih banyak</span> untuk makanan di luar bulan ini. Coba batasi pengeluaran.</span>
                        </div>
                        <div class="bg-green-50 border-l-4 border-green-400 text-green-800 p-4 rounded-md flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Potensi tabungan Rp 50.000 dari langganan *streaming* yang tidak terpakai.</span>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <button class="text-indigo-600 hover:underline text-sm">Lihat Semua Wawasan</button>
                    </div>
                </section>

                <!-- Diagram Lingkaran Rincian Pengeluaran berdasarkan Kategori -->
                <section class="bg-white p-6 rounded-xl shadow-md">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Rincian Pengeluaran (Bulan Ini)</h2>
                    <div class="flex flex-col md:flex-row items-center justify-center space-y-4 md:space-y-0 md:space-x-8">
                        <!-- Placeholder for Pie Chart. In a real app, this would be a charting library (e.g., Chart.js, D3.js) -->
                        <div class="relative w-48 h-48 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 font-semibold text-sm border-2 border-dashed border-gray-300">
                            [Diagram Lingkaran Pengeluaran]
                            <!-- Example segments (purely visual, not functional) -->
                            <div class="absolute inset-0 rounded-full" style="background: conic-gradient(#818cf8 0% 30%, #a78bfa 30% 55%, #c084fc 55% 70%, #e879f9 70% 85%, #f472b6 85% 100%);"></div>
                        </div>
                        <ul class="space-y-2">
                            <li class="flex items-center text-gray-700"><span class="block w-3 h-3 rounded-full mr-2 bg-indigo-400"></span>Makanan: Rp 2.500.000 (30%)</li>
                            <li class="flex items-center text-gray-700"><span class="block w-3 h-3 rounded-full mr-2 bg-purple-400"></span>Transportasi: Rp 1.800.000 (25%)</li>
                            <li class="flex items-center text-gray-700"><span class="block w-3 h-3 rounded-full mr-2 bg-violet-400"></span>Hiburan: Rp 1.200.000 (15%)</li>
                            <li class="flex items-center text-gray-700"><span class="block w-3 h-3 rounded-full mr-2 bg-pink-400"></span>Belanja: Rp 1.000.000 (10%)</li>
                            <li class="flex items-center text-gray-700"><span class="block w-3 h-3 rounded-full mr-2 bg-rose-400"></span>Lain-lain: Rp 1.000.000 (20%)</li>
                        </ul>
                    </div>
                    <div class="mt-4 text-center">
                        <button class="text-indigo-600 hover:underline text-sm">Laporan Pengeluaran Lengkap</button>
                    </div>
                </section>
            </div>

            <!-- Kolom Kanan: Tujuan & Tagihan -->
            <div class="lg:col-span-1 space-y-6">

                <!-- Bilah Kemajuan Tujuan Tabungan -->
                <section class="bg-white p-6 rounded-xl shadow-md">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Kemajuan Tujuan Keuangan</h2>
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between items-center text-gray-700 text-sm mb-1">
                                <span>Dana Darurat (Rp 10.000.000)</span>
                                <span>Rp 7.000.000 / 70%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-green-500 h-2.5 rounded-full" style="width: 70%;"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between items-center text-gray-700 text-sm mb-1">
                                <span>Uang Muka Rumah (Rp 50.000.000)</span>
                                <span>Rp 15.000.000 / 30%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-green-500 h-2.5 rounded-full" style="width: 30%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <button class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-medium py-2 px-4 rounded-lg transition-colors text-sm">
                            Kelola Tujuan
                        </button>
                    </div>
                </section>

                <!-- Daftar Tagihan yang Akan Datang -->
                <section class="bg-white p-6 rounded-xl shadow-md">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Tagihan Akan Datang</h2>
                    <ul class="divide-y divide-gray-200">
                        <li class="py-3 flex justify-between items-center">
                            <div>
                                <p class="font-medium text-gray-800">Internet</p>
                                <p class="text-sm text-gray-500">Jatuh Tempo: 10 Juni 2025</p>
                            </div>
                            <span class="font-semibold text-gray-700">Rp 300.000</span>
                        </li>
                        <li class="py-3 flex justify-between items-center">
                            <div>
                                <p class="font-medium text-gray-800">Listrik</p>
                                <p class="text-sm text-gray-500">Jatuh Tempo: 15 Juni 2025</p>
                            </div>
                            <span class="font-semibold text-gray-700">Rp 500.000</span>
                        </li>
                        <li class="py-3 flex justify-between items-center">
                            <div>
                                <p class="font-medium text-gray-800">Pinjaman Kendaraan</p>
                                <p class="text-sm text-gray-500">Jatuh Tempo: 20 Juni 2025</p>
                            </div>
                            <span class="font-semibold text-gray-700">Rp 1.500.000</span>
                        </li>
                    </ul>
                    <div class="mt-4 text-center">
                        <button class="text-indigo-600 hover:underline text-sm">Lihat Semua Tagihan</button>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <!-- Footer (simple) -->
    <footer class="bg-gray-800 text-white p-4 text-center text-sm mt-8">
        <div class="container mx-auto">
            &copy; 2025 Keuangan Pribadi. Hak Cipta Dilindungi Undang-Undang.
        </div>
    </footer>

</body>
</html>
