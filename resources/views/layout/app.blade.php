{{-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Layanan Desa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-green-700 text-white p-4 flex justify-between">
        <h1 class="font-bold">Sistem Layanan Desa</h1>
        <div>
            <a href="{{ route('dashboard') }}" class="px-2">Dashboard</a>
            <a href="{{ route('users.index') }}" class="px-2">Users</a>
            <a href="{{ route('rts.index') }}" class="px-2">RT</a>
            <a href="{{ route('rws.index') }}" class="px-2">RW</a>
            <a href="{{ route('applications.index') }}" class="px-2">Surat</a>
            <a href="{{ route('application-types.index') }}" class="px-2">Jenis Surat</a>
            <a href="{{ route('antrean.index') }}" class="px-2">Antrean</a>
            <a href="{{ route('tracking.index') }}" class="px-2">Tracking</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button class="px-2">Logout</button>
            </form>
        </div>
    </nav>
    <div class="p-6">
        @yield('content')
    </div>
</body>
</html>
     --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sicerdas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Menggunakan font Inter sebagai default */
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #a0aec0; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen bg-gray-100">
        <aside class="w-64 flex-shrink-0 bg-green-700 text-white flex flex-col">
            <div class="h-20 flex items-center justify-center border-b border-green-800">
                <h1 class="text-3xl font-bold tracking-wider">Sicerdas</h1>
            </div>
            <nav class="flex-grow px-4 py-6">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-green-800' : 'text-gray-200 hover:bg-green-800 hover:text-white' }} rounded-lg transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            <span class="font-semibold">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard-permohonan') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard-permohonan') ? 'bg-green-800' : 'text-gray-200 hover:bg-green-800 hover:text-white' }} rounded-lg transition-colors duration-200">
                           <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="font-semibold">Manajemen Permohonan</span>
                        </a>
                    </li>
                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'operator')
                    <li>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-200 hover:bg-green-800 hover:text-white rounded-lg transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                            <span class="font-semibold">Manajemen Konten & Pengguna</span>
                        </a>
                    </li>
                    @endif
                    @if (auth::User()->role === 'admin')
                        <li>
                        <a href="{{ route('application-types.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('application-types.index') ? 'bg-green-800' : 'text-gray-200 hover:bg-green-800 hover:text-white' }} rounded-lg transition-colors duration-200">
                           <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75L2.25 12l4.179 2.25m0-4.5l5.571 3 5.571-3m-11.142 0L2.25 12l4.179 2.25m0 0l5.571 3 5.571-3m0 0l4.179-2.25L12 9.75l-5.571 2.25z" />
                            </svg>
                            <span class="font-semibold">Manajemen Surat</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'operator')
                    <li>
                        <a href="{{ route('dashboard-surat') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard-surat') ? 'bg-green-800' : 'text-gray-200 hover:bg-green-800 hover:text-white' }} rounded-lg transition-colors duration-200">
                           <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="font-semibold">Data Surat Jadi</span>
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="{{ route('dashboard-warga')  }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard-warga') ? 'bg-green-800' : 'text-gray-200 hover:bg-green-800 hover:text-white' }} rounded-lg transition-colors duration-200">
                           <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197M15 11a4 4 0 110-5.292M12 4.354a4 4 0 010 5.292" />
                            </svg>
                            <span class="font-semibold">Data Warga</span>
                        </a>
                    </li>
                    @if (Auth::user()->role === 'admin')
                    <li>
                        <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('users.index') ? 'bg-green-800' : 'text-gray-200 hover:bg-green-800 hover:text-white' }} rounded-lg transition-colors duration-200">
                           <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="font-semibold">Manajemen User</span>
                        </a>
                    @endif
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" 
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="flex items-center gap-3 px-4 py-3 text-gray-200 hover:bg-green-800 hover:text-white rounded-lg transition-colors duration-200">
                                
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                
                                <span class="font-semibold">Logout</span>
                            </a>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="h-20 flex items-center justify-between px-10 bg-white border-b">

                <a href="{{ route('welcome') }}" class="font-semibold text-green-600 hover:text-green-800 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Halaman Utama
                </a>

                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-green-700 flex items-center justify-center text-white font-bold text-xl uppercase">
                        @php
                            // Mengambil 1 atau 2 huruf inisial dari nama pengguna
                            $nameParts = explode(' ', Auth::user()->name);
                            $initials = substr($nameParts[0], 0, 1);
                            if (count($nameParts) > 1) {
                                $initials .= substr(end($nameParts), 0, 1);
                            }
                        @endphp
                        {{ $initials }}
                    </div>
                    <span class="font-semibold text-gray-700">{{ Auth::user()->name }}</span>
                </div>

            </header>

            @yield('content')

            <footer class="text-center p-4 text-sm text-gray-400">
                Sicerdas. Copyright 2025
            </footer>
        </div>
    </div>
</body>
</html>