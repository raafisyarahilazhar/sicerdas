@extends('layout.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6 lg:p-10 space-y-8">

    {{-- Breadcrumb & Aksi --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('dashboard') }}"
        class="inline-flex items-center text-green-700 hover:text-green-800 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Dashboard
        </a>

        {{-- Perbaikan: Nama rute diubah dari admin.users.edit menjadi users.edit --}}
        {{-- Perbaikan: Role check disesuaikan dengan middleware di web.php (hanya admin & operator) --}}
        @if(in_array(auth()->user()->role, ['admin','operator']))
            <a href="{{ route('users.edit', $resident->user_id ?? 0) }}"
            class="inline-flex items-center px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 shadow transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                </svg>
                Edit Data Pengguna
            </a>
        @endif
    </div>

    {{-- Header: Profil Singkat --}}
    <section class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-center gap-5">
                @php
                    $nameParts = explode(' ', $resident->name ?? 'Warga');
                    $initials = strtoupper(substr($nameParts[0], 0, 1));
                    if (count($nameParts) > 1) {
                        $initials .= strtoupper(substr(end($nameParts), 0, 1));
                    }
                @endphp
                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-green-600 to-green-800 text-white flex items-center justify-center text-3xl font-bold shadow-inner">
                    {{ $initials }}
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $resident->name }}</h1>
                    <p class="text-gray-500 font-mono tracking-wider">NIK: {{ $resident->nik ?? '-' }}</p>
                    <div class="mt-2 flex gap-2">
                        <span class="px-2.5 py-0.5 bg-green-100 text-green-700 rounded-md text-xs font-bold uppercase">RT {{ optional($resident->rt)->nomor ?? '-' }}</span>
                        <span class="px-2.5 py-0.5 bg-blue-100 text-blue-700 rounded-md text-xs font-bold uppercase">RW {{ optional($resident->rw)->nomor ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                    <p class="text-[10px] uppercase font-bold text-gray-400">Pekerjaan</p>
                    <p class="text-sm font-semibold text-gray-700 truncate">{{ $resident->occupation ?? 'Tidak Bekerja' }}</p>
                </div>
                <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                    <p class="text-[10px] uppercase font-bold text-gray-400">Pendidikan</p>
                    <p class="text-sm font-semibold text-gray-700">{{ str_replace('_', ' ', strtoupper($resident->education_level ?? '-')) }}</p>
                </div>
                <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                    <p class="text-[10px] uppercase font-bold text-gray-400">No. KK</p>
                    <p class="text-sm font-semibold text-gray-700">{{ $resident->kk_number ?? '-' }}</p>
                </div>
            </div>
        </div>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Kiri: Data Lengkap --}}
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Informasi Biodata Lengkap
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-6">
                    <div class="border-b pb-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Tempat, Tanggal Lahir</label>
                        <p class="text-gray-700">{{ $resident->place_of_birth ?? '-' }}, {{ $resident->birth_date ? \Carbon\Carbon::parse($resident->birth_date)->isoFormat('D MMMM YYYY') : '-' }}</p>
                    </div>
                    <div class="border-b pb-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Jenis Kelamin</label>
                        <p class="text-gray-700">{{ $resident->gender == 'L' ? 'Laki-laki' : ($resident->gender == 'P' ? 'Perempuan' : '-') }}</p>
                    </div>
                    <div class="border-b pb-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Agama</label>
                        <p class="text-gray-700">{{ ucfirst($resident->religion ?? '-') }}</p>
                    </div>
                    <div class="border-b pb-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Status Perkawinan</label>
                        <p class="text-gray-700">{{ str_replace('_', ' ', ucfirst($resident->marital_status ?? '-')) }}</p>
                    </div>
                    <div class="border-b pb-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Golongan Darah</label>
                        <p class="text-gray-700">{{ $resident->blood_type ?? '-' }}</p>
                    </div>
                    <div class="border-b pb-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Kewarganegaraan</label>
                        <p class="text-gray-700">{{ strtoupper($resident->citizenship ?? '-') }}</p>
                    </div>
                    <div class="md:col-span-2 border-b pb-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Alamat Domisili</label>
                        <p class="text-gray-700">{{ $resident->address ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Riwayat Permohonan --}}
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Riwayat Permohonan Surat
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50">
                            <tr class="text-gray-400 text-[10px] uppercase tracking-widest">
                                <th class="py-3 px-4">Referensi</th>
                                <th class="py-3 px-4">Jenis Surat</th>
                                <th class="py-3 px-4 text-center">Status</th>
                                <th class="py-3 px-4">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($resident->applications as $app)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-4 px-4 font-mono text-sm text-green-700">{{ $app->ref_number }}</td>
                                    <td class="py-4 px-4 font-medium text-gray-700">{{ optional($app->applicationType)->name ?? 'Surat' }}</td>
                                    <td class="py-4 px-4 text-center">
                                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase
                                            @if($app->status === 'approved') bg-green-100 text-green-700
                                            @elseif($app->status === 'rejected') bg-red-100 text-red-700
                                            @else bg-yellow-100 text-yellow-700 @endif">
                                            {{ str_replace('_', ' ', $app->status) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-sm text-gray-500">{{ $app->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-10 text-center text-gray-400 italic">Belum ada riwayat permohonan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Kanan: Sidebar Info --}}
        <div class="lg:col-span-1 space-y-8">
            {{-- Kontak --}}
            <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
                <h4 class="font-bold text-gray-800 mb-4 uppercase text-xs tracking-widest">Kontak Warga</h4>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center text-green-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Telepon</p>
                            <p class="text-sm font-medium text-gray-700">{{ $resident->phone ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Peta Lokasi --}}
            <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
                <h4 class="font-bold text-gray-800 mb-4 uppercase text-xs tracking-widest">Lokasi Domisili</h4>
                @if($resident->lat && $resident->lng)
                    <div id="map" class="w-full h-48 rounded-xl border z-0"></div>
                    <p class="text-[10px] text-gray-400 mt-2 italic text-center">Koordinat: {{ (string)$resident->lat }}, {{ (string)$resident->lng }}</p>
                @else
                    <div class="bg-gray-50 border border-dashed rounded-xl p-6 text-center">
                        <p class="text-xs text-gray-400">Data koordinat lokasi tidak tersedia.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

</main>
@endsection

@push('addon-script')
    @if($resident->lat && $resident->lng)
        {{-- Leaflet Map --}}
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIu1sET/ig88VQ7G4S0hCw3rGphqMT+4H6A=" crossorigin=""/>
        
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        <script>
            const lat = {{ $resident->lat }};
            const lng = {{ $resident->lng }};
            const map = L.map('map').setView([lat, lng], 16);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);
            L.marker([lat, lng]).addTo(map).bindPopup(`{{ addslashes($resident->address ?? 'Lokasi Warga') }}`).openPopup();
        </script>
    @endif
@endpush
