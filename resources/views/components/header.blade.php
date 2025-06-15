<div>
    @auth
    <header class="bg-white shadow-sm p-4 sticky top-0 z-10">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center space-x-2">
                <img src="{{asset("assets/img/logo-bg.PNG")}}" alt="Logo.PNG" class="w-10">
            </h1>
            <nav>
                <ul class="flex space-x-6 text-gray-600">
                    <li><a href="#" class="hover:text-indigo-600 font-medium">Dashboard</a></li>
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
                <div class="relative">
                    <button id="user-menu-button" class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600 focus:outline-none">
                        <img src="{{ asset('assets/img/user-avatar.png') }}" alt="User Avatar" class="w-8 h-8 rounded-full">
                        <span class="hidden md:inline">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <!-- Dropdown Menu -->
                    <div id="user-dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-20 hidden">
                        <ul class="py-1">
                            <li><a href="#" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Profil</a></li>
                            <li><a href="#" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Pengaturan</a></li>
                            <li>
                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Keluar
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    @endauth

    @guest
    <header class="bg-white shadow-sm p-4 sticky top-0 z-10">
        <div class="container mx-auto flex justify-between items-center px-4 md:px-8">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center space-x-2">
                <img src="{{asset("assets/img/logo-bg.PNG")}}" alt="Logo.PNG" class="w-10">
            </h1>
            <nav class="hidden md:block">
                <ul class="flex space-x-6 text-gray-600">
                    <li><a href="#features" class="hover:text-indigo-600 font-medium">Fitur</a></li>
                    <li><a href="#about" class="hover:text-indigo-600">Tentang Kami</a></li>
                    <li><a href="#contact" class="hover:text-indigo-600">Kontak</a></li>
                    <li><a href="{{route('login')}}" class="hover:text-indigo-600 font-medium bg-indigo-50 text-indigo-700 py-2 px-4 rounded-lg transition-colors">Login</a></li>
                </ul>
            </nav>
            <button class="md:hidden p-2 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </header>
    @endguest

    <!-- Script untuk klik dropdown -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const userMenuButton = document.getElementById("user-menu-button");
            const userDropdown = document.getElementById("user-dropdown");

            if (userMenuButton && userDropdown) {
                userMenuButton.addEventListener("click", function () {
                    userDropdown.classList.toggle("hidden");
                });

                // Tutup dropdown saat klik di luar
                document.addEventListener("click", function (e) {
                    if (!userMenuButton.contains(e.target) && !userDropdown.contains(e.target)) {
                        userDropdown.classList.add("hidden");
                    }
                });
            }
        });
    </script>
</div>
