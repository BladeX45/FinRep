<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keuangan Saya - Kelola Uang dengan Cerdas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa; /* Light gray background */
            color: #333;
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
<x-header />

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white py-16 md:py-24 text-center px-4 rounded-b-xl shadow-lg">
        <div class="container mx-auto max-w-4xl">
            <h2 class="text-4xl md:text-5xl font-extrabold leading-tight mb-6">
                Kendali Penuh Atas Keuangan Anda, <span class="block">Mulai Hari Ini!</span>
            </h2>
            <p class="text-lg md:text-xl mb-10 opacity-90">
                Aplikasi "Keuangan Saya" membantu Anda melacak pengeluaran, membuat anggaran cerdas, dan mencapai tujuan finansial dengan mudah.
            </p>
            <a href="{{route('register')}}" class="bg-white text-indigo-700 hover:bg-gray-100 font-bold py-3 px-8 rounded-full text-lg shadow-xl transition-all duration-300 transform hover:scale-105">
                Daftar Gratis Sekarang
            </a>
            <div class="mt-12">
                <!-- Placeholder for a compelling product screenshot/illustration -->
                <img src="https://placehold.co/800x450/e0e7ff/3f51b5?text=Tampilan+Dasbor+Aplikasi" alt="Tampilan Aplikasi Keuangan Saya" class="rounded-xl shadow-2xl mx-auto w-full max-w-xl md:max-w-3xl">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 md:py-24 px-4">
        <div class="container mx-auto">
            <h3 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-12">Fitur Unggulan Kami</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <x-card
                    title="Pelacakan Otomatis"
                    description="Sinkronkan rekening bank, e-wallet, dan kartu kredit Anda untuk pelacakan transaksi otomatis dan akurat."
                    icon="document.png"
                    color="bg-indigo-100"
                    route="features">
                </x-card>
                {{-- Feature 2 --}}
                <x-card
                    title="Anggaran Cerdas"
                    description="Buat anggaran yang fleksibel dengan berbagai metodologi (zero-based, amplop, persentase) dan notifikasi."
                    icon="analytics.png"
                    color="bg-green-100"
                    route="features" />

                {{-- Feature 3 --}}
                <x-card
                    title="Pelacakan Tujuan"
                    description="Tetapkan dan lacak tujuan finansial Anda, seperti dana darurat, uang muka rumah, atau liburan impian."
                    icon="goal.png"
                    color="bg-indigo-100"
                    route="features"
                />

                <div class="bg-white p-6 rounded-xl shadow-md flex flex-col items-center text-center hover:shadow-lg transition-shadow duration-300">
                    <div class="p-4 bg-indigo-100 rounded-full mb-4">
                        <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h4 class="text-xl font-semibold text-gray-800 mb-3">Pelacakan Otomatis</h4>
                    <p class="text-gray-600">Sinkronkan rekening bank, e-wallet, dan kartu kredit Anda untuk pelacakan transaksi otomatis dan akurat.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-6 rounded-xl shadow-md flex flex-col items-center text-center hover:shadow-lg transition-shadow duration-300">
                    <div class="p-4 bg-green-100 rounded-full mb-4">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    </div>
                    <h4 class="text-xl font-semibold text-gray-800 mb-3">Anggaran Cerdas</h4>
                    <p class="text-gray-600">Buat anggaran yang fleksibel dengan berbagai metodologi (zero-based, amplop, persentase) dan notifikasi.</p>
                </div>
                <!-- Feature 3 -->
                <div class="bg-white p-6 rounded-xl shadow-md flex flex-col items-center text-center hover:shadow-lg transition-shadow duration-300">
                    <div class="p-4 bg-yellow-100 rounded-full mb-4">
                        <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13m0 0a9 9 0 1018 0a9 9 0 00-18 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"></path></svg>
                    </div>
                    <h4 class="text-xl font-semibold text-gray-800 mb-3">Wawasan AI Proaktif</h4>
                    <p class="text-gray-600">Dapatkan rekomendasi pengeluaran, identifikasi potensi tabungan, dan prakiraan arus kas berbasis AI.</p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-white p-6 rounded-xl shadow-md flex flex-col items-center text-center hover:shadow-lg transition-shadow duration-300">
                    <div class="p-4 bg-purple-100 rounded-full mb-4">
                        <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V9a1 1 0 00-1-1H7a1 1 0 00-1 1v2.586l-1.586 1.586A2 2 0 013 14.586V17a2 2 0 002 2h14a2 2 0 002-2v-2.414a2 2 0 01.586-1.414L18 9.414V8a1 1 0 00-1-1h-4a1 1 0 00-1 1z"></path></svg>
                    </div>
                    <h4 class="text-xl font-semibold text-gray-800 mb-3">Pelacakan Tujuan</h4>
                    <p class="text-gray-600">Tetapkan dan lacak tujuan finansial Anda, seperti dana darurat, uang muka rumah, atau liburan impian.</p>
                </div>
                <!-- Feature 5 -->
                <div class="bg-white p-6 rounded-xl shadow-md flex flex-col items-center text-center hover:shadow-lg transition-shadow duration-300">
                    <div class="p-4 bg-red-100 rounded-full mb-4">
                        <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="text-xl font-semibold text-gray-800 mb-3">Pengingat Tagihan</h4>
                    <p class="text-gray-600">Dapatkan notifikasi tepat waktu untuk tagihan yang akan datang agar Anda tidak pernah melewatkan pembayaran.</p>
                </div>
                <!-- Feature 6 -->
                <div class="bg-white p-6 rounded-xl shadow-md flex flex-col items-center text-center hover:shadow-lg transition-shadow duration-300">
                    <div class="p-4 bg-blue-100 rounded-full mb-4">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17.25v-4.5c0-.728.684-1.353 1.348-1.127l.794.265c.571.19.992.684.992 1.282V17.25h-3zm-2.25-4.5V20.25a.75.75 0 00.75.75H17.5a.75.75 0 00.75-.75V12.75a.75.75 0 00-.75-.75H11.25a.75.75 0 00-.75.75zM12 9.75a.75.75 0 01.75-.75h.008v.008H12.75A.75.75 0 0112 9.75zm1.5 0a.75.75 0 01.75-.75h.008v.008H13.5A.75.75 0 0113.5 9.75z"></path></svg>
                    </div>
                    <h4 class="text-xl font-semibold text-gray-800 mb-3">Laporan Mendalam</h4>
                    <p class="text-gray-600">Dapatkan gambaran jelas tentang arus kas, nilai bersih, dan pengeluaran Anda dengan laporan visual yang komprehensif.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="bg-indigo-700 text-white py-16 md:py-20 text-center px-4 rounded-xl shadow-lg mt-16 mx-auto w-11/12 max-w-5xl">
        <div class="container mx-auto">
            <h3 class="text-3xl md:text-4xl font-bold mb-6">Siap Mengatur Keuangan Anda?</h3>
            <p class="text-lg md:text-xl mb-8 opacity-90">
                Bergabunglah dengan ribuan pengguna yang telah mengambil alih kendali keuangan mereka.
            </p>

            <x-button link="register" label="Mulai Gratis Sekarang!" color="bg-white">

            </x-button>
        </div>
    </section>

<x-footer/>
</body>
</html>
