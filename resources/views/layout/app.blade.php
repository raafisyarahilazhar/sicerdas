<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Sicerdas</title>

  <link rel="shortcut icon" href="{{ asset('images/sicerdas_logo.png') }}" type="image/x-icon">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    body { font-family: 'Inter', sans-serif; }
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: #f1f1f1; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #a0aec0; }
    .alert {
      padding: 20px; background-color: #4CAF50; color: white;
      margin-bottom: 15px; border-radius: 5px; position: relative;
      opacity: 1; transition: opacity 0.6s;
    }
    .alert.hide { opacity: 0; }
    .alert.hide .close-btn { display: none; }
    .close-btn {
      position: absolute; top: 50%; right: 20px; transform: translateY(-50%);
      color: white; font-weight: bold; font-size: 24px; cursor: pointer; transition: 0.3s;
    }
    .close-btn:hover { color: black; }
    [x-cloak] { display: none !important; } /* untuk mencegah flicker Alpine */
  </style>
</head>

<body class="bg-gray-50">
  <div class="flex h-screen bg-gray-100">
    {{-- SIDEBAR --}}
    <aside class="w-64 flex-shrink-0 bg-green-700 text-white flex flex-col">
      {{-- <div class="h-20 flex items-center justify-center border-b border-green-800">
        <h1 class="text-3xl font-bold tracking-wider">Sicerdas</h1>
      </div> --}}

      <div class="flex items-center gap-x-3 px-4 h-20 ">
          <img src="{{ asset('images/sicerdas_logo.png') }}" alt="SICERDAS Logo" class="w-12 h-12"/>
          <h1 id="title" class="text-3xl font-bold tracking-wider">SICERDAS</h1>
      </div>

      <nav class="flex-grow px-4 py-3">
        <ul class="space-y-2">
          {{-- Dashboard --}}
          <li>
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors duration-200
               {{ request()->routeIs('dashboard') ? 'bg-green-800' : 'text-gray-200 hover:bg-green-800 hover:text-white' }}">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                   viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
              </svg>
              <span class="font-semibold">Dashboard</span>
            </a>
          </li>

          {{-- DATA MASTER (dropdown) --}}
          @php
            $isMasterActive = request()->routeIs([
              'dashboard-warga',
              'rws.*',
              'rts.*',
              'users.*',
              'application-types.*',
            ]);
          @endphp

          <li x-data="{ open: {{ $isMasterActive ? 'true' : 'false' }} }">
            {{-- Header Dropdown --}}
            <button @click="open = !open"
              class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition-colors duration-200
              {{ $isMasterActive ? 'bg-green-800 text-white' : 'text-gray-200 hover:bg-green-800 hover:text-white' }}">
              <span class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 7a2 2 0 012-2h3l2 2h7a2 2 0 012 2v1M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9M3 7h6"/>
                </svg>
                <span class="font-semibold">Data Master</span>
              </span>
              <svg class="h-5 w-5 transform transition-transform duration-200"
                   :class="open ? 'rotate-180' : ''"
                   xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                   stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
              </svg>
            </button>

            {{-- Isi Dropdown --}}
            <div x-cloak x-show="open" x-transition class="mt-2 pl-2 space-y-1">
              {{-- Data Warga: tampil untuk semua peran (atur sendiri bila perlu) --}}
              <a href="{{ route('dashboard-warga') }}"
                 class="flex items-center gap-3 px-4 py-2 rounded-lg transition-colors duration-200
                 {{ request()->routeIs('dashboard-warga') ? 'bg-green-800 text-white' : 'text-gray-200 hover:bg-green-800 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M9 7a4 4 0 108 0 4 4 0 00-8 0z"/>
                </svg>
                <span>Data Warga</span>
              </a>

              {{-- Hanya admin/operator --}}
              @if (Auth::user()->role === 'admin' || Auth::user()->role === 'operator')
                <a href="{{ route('rws.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg transition-colors duration-200
                   {{ request()->routeIs('rws.*') ? 'bg-green-800 text-white' : 'text-gray-200 hover:bg-green-800 hover:text-white' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                       viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9-4 9 4-9 4-9-4z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9 4 9-4M3 17l9 4 9-4"/>
                  </svg>
                  <span>Data RW</span>
                </a>

                <a href="{{ route('rts.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg transition-colors duration-200
                   {{ request()->routeIs('rts.*') ? 'bg-green-800 text-white' : 'text-gray-200 hover:bg-green-800 hover:text-white' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                       viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 6h4v4H4V6zm6 0h4v4h-4V6zm6 0h4v4h-4V6zM4 12h4v4H4v-4zm6 0h4v4h-4v-4zm6 0h4v4h-4v-4z"/>
                  </svg>
                  <span>Data RT</span>
                </a>

                <a href="{{ route('users.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg transition-colors duration-200
                   {{ request()->routeIs('users.*') ? 'bg-green-800 text-white' : 'text-gray-200 hover:bg-green-800 hover:text-white' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                       viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                  </svg>
                  <span>Manajemen User</span>
                </a>

                {{-- Manajemen Surat (application types) --}}
                <a href="{{ route('application-types.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg transition-colors duration-200
                   {{ request()->routeIs('application-types.*') ? 'bg-green-800 text-white' : 'text-gray-200 hover:bg-green-800 hover:text-white' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                       viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12h6m-6 4h6M8 3h6l4 4v12a2 2 0 01-2 2H8a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                  </svg>
                  <span>Manajemen Surat</span>
                </a>
              @endif
            </div>
          </li>


          {{-- Manajemen Permohonan --}}
          <li>
            <a href="{{ route('dashboard-permohonan') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors duration-200
               {{ request()->routeIs('dashboard-permohonan') ? 'bg-green-800' : 'text-gray-200 hover:bg-green-800 hover:text-white' }}">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                   viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
              </svg>
              <span class="font-semibold">Manajemen Permohonan</span>
            </a>
          </li>

          {{-- Manajemen Konten & Pengguna (khusus admin/operator) --}}
          @if (Auth::user()->role === 'admin' || Auth::user()->role === 'operator')
            <li>
              <a href="{{ route('dashboard.manajemen-konten') }}"
                 class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors duration-200
                 {{ request()->routeIs('dashboard.manajemen-konten') ? 'bg-green-800' : 'text-gray-200 hover:bg-green-800 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                </svg>
                <span class="font-semibold">Manajemen Konten & Pengguna</span>
              </a>
            </li>
          @endif

          {{-- Logout --}}
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <a href="{{ route('logout') }}"
                 onclick="event.preventDefault(); this.closest('form').submit();"
                 class="flex items-center gap-3 px-4 py-3 text-gray-200 hover:bg-green-800 hover:text-white rounded-lg transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span class="font-semibold">Logout</span>
              </a>
            </form>
          </li>
        </ul>
      </nav>
    </aside>

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col overflow-hidden">
      <header class="h-20 flex items-center justify-between px-10 bg-white border-b">
        <a href="{{ route('welcome') }}" class="font-semibold text-green-600 hover:text-green-800 flex items-center">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
               xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          Halaman Utama
        </a>

        <div class="flex items-center gap-4">
          <div class="w-12 h-12 rounded-full bg-green-700 flex items-center justify-center text-white font-bold text-xl uppercase">
            @php
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

  <script src="https://cdn.tailwindcss.com"></script>
  {{-- Alpine (untuk dropdown) --}}
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  {{-- Alert close --}}
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const closeButton = document.querySelector('.close-btn');
      if (!closeButton) return;
      closeButton.onclick = function () {
        const alertDiv = this.parentElement;
        alertDiv.style.opacity = '0';
        setTimeout(() => { alertDiv.style.display = 'none'; }, 600);
      };
    });
  </script>

  @stack('addon-script')
</body>
</html>
