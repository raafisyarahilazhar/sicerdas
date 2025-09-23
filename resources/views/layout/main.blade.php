<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SICERDAS</title>
    <style>
        .alert {
            padding: 20px;
            background-color: #4CAF50; /* Green */
            color: white;
            margin-bottom: 15px;
            border-radius: 5px;
            position: relative;
            opacity: 1;
            transition: opacity 0.6s;
        }

        .alert.hide {
            opacity: 0;
        }

        .alert.hide .close-btn {
            display: none;
        }

        .close-btn {
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            color: white;
            font-weight: bold;
            font-size: 24px;
            cursor: pointer;
            transition: 0.3s;
        }

        .close-btn:hover {
            color: black;
        }
    </style>
   
</head>

<body class="bg-white">

    <header class="sticky top-0 z-50">
        <div class="space-y-6 bg-cover bg-center" style="background-image: url('/images/bg-head.jpg');">
            <div class="container mx-auto flex justify-between items-center text-xs font-bold text-green-200">
                <div class="px-8 py-2 text-white
                
                text-base">
                    ID
                </div>
                @guest
                {{-- Tampilan untuk pengguna yang belum login --}}
                <div class="flex items-center space-x-3 text-sm font-bold">
                    <a href="{{ route('register') }}" class="tracking-wider text-green-200 hover:text-white transition-colors">DAFTAR</a>
                    <span class="border-l border-green-400 h-3"></span>
                    <a href="{{ route('login') }}" class="tracking-wider text-green-200 hover:text-white transition-colors">MASUK</a>
                </div>
                @endguest

                @auth
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="inline-flex items-center text-white text-sm font-semibold px-4 py-2 rounded-md hover:text-green-100 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>

                        <span>{{ Auth::user()->name }}</span>

                        <svg class="w-4 h-4 ml-1 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="open"
                        @click.away="open = false"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 py-1 z-50"
                        style="display: none;">

                        <a href="{{ route('profile.edit') }}" class="flex items-center w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                            {{ __('Edit Profile') }}
                        </a>

                        @if (Auth::user()->role === 'rt' || Auth::user()->role === 'rw' || Auth::user()->role === 'kades' ||Auth::user()->role === 'admin' || Auth::user()->role === 'operator')
                        <a href="{{ route('dashboard') }}" class="flex items-center w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm0 10a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm8-10a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zm8 10a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2a2 2 0 012-2h2a2 2 0 012 2v2z"></path>
                            </svg>
                            {{ __('Dashboard') }}
                        </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
                @endauth

            </div>
        </div>

        <div class="bg-white border-b">
            <div class="container mx-auto px-6 py-3 flex justify-between items-center">
                <h1 id="title"class="text-4xl font-bold text-green-700 transform -translate-y-full opacity-0 transition-all duration-700 ease-out ">SICERDAS</h1>

                <nav id="navMenu"
                    class="navMenu hidden md:flex items-center space-x-6 transform -translate-y-full opacity-0 transition-all duration-700 ease-out ">
                    <a href="/" class="text-green-800/90 font-medium hover:text-green-600 transition-colors">Beranda</a>
                    <a href="/applications/create" class="text-green-800/90 font-medium hover:text-green-600 transition-colors">Buat Surat</a>
                    <a href="#" class="text-green-800/90 font-medium hover:text-green-600 transition-colors">Panduan</a>
                    <a href="#" class="text-green-800/90 font-medium hover:text-green-600 transition-colors">Kontak</a>
                </nav>
                
                <div class="md:hidden">
                    <button id="menu-btn" class="text-gray-700 focus:outline-none">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div id="mobile-menu" class="md:hidden hidden bg-white border-t">
                <a href="#" class="block py-3 px-6 text-gray-700 hover:bg-green-50">Beranda</a>
                <a href="#" class="block py-3 px-6 text-gray-700 hover:bg-green-50">Buat Surat</a>
                <a href="#" class="block py-3 px-6 text-gray-700 hover:bg-green-50">Panduan</a>
                <a href="#" class="block py-3 px-6 text-gray-700 hover:bg-green-50">Kontak</a>
                <a href="#" class="block py-3 px-6 text-gray-700 font-semibold border-t hover:bg-green-50">DAFTAR</a>
                <a href="#" class="block py-3 px-6 text-gray-700 font-semibold hover:bg-green-50">MASUK</a>
            </div>
        </div>
    </header>


    @yield('content')

    <footer class="bg-green-700 text-white py-12">
        <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-8 items-start">
            <div class="text-center md:text-left md:col-span-1">
                <h2 class="text-5xl font-extrabold">SICERDAS</h2>
            </div>

            <div class="text-center md:text-left space-y-6 md:col-span-1">
                <div>
                    <p class="font-semibold text-lg mb-2">Kontak Kami :</p>
                    <div class="space-y-2">
                        <div class="flex items-center justify-center md:justify-start space-x-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.894 11.892-1.99-.001-3.956-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01s-.521.074-.792.372c-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.626.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                            </svg>
                            <span>WhatsApp</span>
                        </div>
                        <div class="flex items-center justify-center md:justify-start space-x-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                            <span>Email</span>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="font-semibold text-lg mb-2">Social Media :</p>
                    <div class="flex justify-center md:justify-start space-x-4">
                        <a href="#" class="hover:opacity-75 transition-opacity">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="hover:opacity-75 transition-opacity">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.024.06 1.378.06 3.808s-.012 2.784-.06 3.808c-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.024.048-1.378.06-3.808.06s-2.784-.012-3.808-.06c-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.048-1.024-.06-1.378-.06-3.808s.012-2.784.06-3.808c.049-1.064.218-1.791.465 2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 016.345 2.525c.636-.247 1.363-.416 2.427-.465C9.793 2.013 10.147 2 12.315 2zm0 1.62c-2.403 0-2.73.01-3.682.055-1.111.05-1.63.21-2.09.405-.51.22-1.01.51-1.46.96-.45.45-.74.95-1.01 1.46-.195.46-.355.98-.405 2.09-.045.952-.055 1.28-.055 3.682s.01 2.73.055 3.682c.05 1.111.21 1.63.405 2.09.27.61.56 1.11.96 1.46.45.45.95.74 1.46 1.01.46.195.98.355 2.09.405.952.045 1.28.055 3.682.055s2.73-.01 3.682-.055c1.111-.05 1.63-.21 2.09-.405.61-.27 1.11-.56 1.46-.96.45-.45.74-.95 1.01-1.46.195-.46.355-.98.405-2.09.045-.952.055-1.28.055-3.682s-.01-2.73-.055-3.682c-.05-1.111-.21-1.63-.405-2.09-.27-.61-.56-1.11-.96-1.46-.45-.45-.95-.74-1.46-1.01-.46-.195-.98-.355-2.09-.405C15.045 3.63 14.715 3.62 12.315 3.62zM12 7.18c-2.648 0-4.82 2.172-4.82 4.82s2.172 4.82 4.82 4.82 4.82-2.172 4.82-4.82-2.172-4.82-4.82-4.82zm0 8.04c-1.785 0-3.22-1.435-3.22-3.22s1.435-3.22 3.22-3.22 3.22 1.435 3.22 3.22-1.435 3.22-3.22 3.22zm3.896-8.34c-.552 0-1 .448-1 1s.448 1 1 1 1-.448 1-1-.448-1-1-1z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="text-center md:text-left md:col-span-1">
                <p class="font-semibold text-lg mb-2">Alamat :</p>
                <p>Desa Mekarjaya, Cihampelas, Bandung Barat, Jawabarat, Indonesia, 40563.</p>
            </div>

            <div class="text-center md:text-right space-y-2 md:col-span-1">
                <a href="#" class="block hover:underline font-medium">Kebijakan dan Privasi</a>
                <a href="#" class="block hover:underline mt-2 font-medium">Butuh Bantuan ?</a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var closeButton = document.querySelector('.close-btn');

            if (closeButton) {
                closeButton.onclick = function() {
                    var alertDiv = this.parentElement;
                    alertDiv.style.opacity = '0';
                    setTimeout(function() {
                        alertDiv.style.display = 'none';
                    }, 600);
                }
            }
        });
    </script>

    <script>
        // JavaScript for mobile menu toggle
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>

<script>
  window.addEventListener("DOMContentLoaded", () => {
    const nav = document.getElementById("navMenu");
    setTimeout(() => {
      nav.classList.remove("-translate-y-full", "opacity-0");
    }, 50); // kasih jeda 50ms biar transisi kebaca
  });
</script>

<script>
  window.addEventListener("DOMContentLoaded", () => {
    const nav = document.getElementById("title");
    setTimeout(() => {
      nav.classList.remove("-translate-y-full", "opacity-0");
    }, 50); // kasih jeda 50ms biar transisi kebaca
  });
</script>
</body>

</html>