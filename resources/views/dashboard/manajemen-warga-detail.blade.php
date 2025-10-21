@extends('layout.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6 lg:p-10 space-y-8">

    {{-- Breadcrumb / Back --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('dashboard-warga') }}"
           class="inline-flex items-center text-green-700 hover:text-green-800">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Data Warga
        </a>

        @php
            $canEdit = in_array(optional(Auth::user())->role, ['admin','operator','rt','rw']);
        @endphp
        @if($canEdit)
        {{-- {{ route('residents.edit', $resident->id) }} --}}
            <a href=""
               class="inline-flex items-center px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 shadow">
                Edit Data
            </a>
        @endif
    </div>

    {{-- Header: Identitas Singkat --}}
    <section class="bg-white p-6 rounded-2xl shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-center gap-4">
                @php
                    $nameParts = explode(' ', $resident->name ?? '');
                    $initials = '';
                    if (!empty($nameParts[0])) $initials .= strtoupper(substr($nameParts[0],0,1));
                    if (count($nameParts) > 1) $initials .= strtoupper(substr(end($nameParts),0,1));
                @endphp
                <div class="w-16 h-16 rounded-full bg-green-700 text-white flex items-center justify-center text-2xl font-bold">
                    {{ $initials ?: 'W' }}
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-green-800">{{ $resident->name }}</h1>
                    <p class="text-gray-600">NIK: <span class="font-medium text-green-700">{{ $resident->nik ?? '-' }}</span></p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-green-50 border border-green-100 rounded-xl p-4">
                    <p class="text-xs text-green-700">Usia</p>
                    <p class="text-xl font-semibold text-green-800">
                        {{ optional($resident->birth_date)->age ?? '—' }}
                    </p>
                </div>
                <div class="bg-green-50 border border-green-100 rounded-xl p-4">
                    <p class="text-xs text-green-700">Jenis Kelamin</p>
                    <p class="text-xl font-semibold text-green-800">
                        {{ data_get(config('demography.gender_labels'), $resident->gender, '-') }}
                    </p>
                </div>
                <div class="bg-green-50 border border-green-100 rounded-xl p-4">
                    <p class="text-xs text-green-700">RT / RW</p>
                    <p class="text-xl font-semibold text-green-800">
                        {{ optional($resident->rt)->nomor_rt ?? ($resident->rt_id ?? '-') }}
                        /
                        {{ optional($resident->rw)->nomor_rw ?? ($resident->rw_id ?? '-') }}
                    </p>
                </div>
                <div class="bg-green-50 border border-green-100 rounded-xl p-4">
                    <p class="text-xs text-green-700">No. KK</p>
                    <p class="text-md font-semibold text-green-800">
                        {{ $resident->kk_number ?? '—' }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Detail Grid --}}
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Kolom Kiri: Identitas & Demografi --}}
        <div class="lg:col-span-2 space-y-8">

            {{-- Identitas & Kontak --}}
            <div class="bg-white p-6 rounded-2xl shadow-lg border">
                <h2 class="text-lg font-bold text-green-800 mb-4">Identitas & Kontak</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                    <div>
                        <p class="text-gray-500">Nama Lengkap</p>
                        <p class="font-semibold text-green-900">{{ $resident->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">NIK</p>
                        <p class="font-semibold text-green-900">{{ $resident->nik ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Tanggal Lahir</p>
                        <p class="font-semibold text-green-900">
                            {{ optional($resident->birth_date)->format('d M Y') ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500">No. Telepon / WhatsApp</p>
                        <p class="font-semibold text-green-900">
                            @php
                                $phone = $resident->phone;
                                $waLink = $phone ? 'https://wa.me/'.preg_replace('/[^0-9]/','',$phone) : null;
                            @endphp
                            @if($waLink)
                                <a class="text-green-700 hover:underline" href="{{ $waLink }}" target="_blank" rel="noopener">
                                    {{ $phone }}
                                </a>
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-gray-500">Alamat</p>
                        <p class="font-semibold text-green-900">{{ $resident->address ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Demografi --}}
            <div class="bg-white p-6 rounded-2xl shadow-lg border">
                <h2 class="text-lg font-bold text-green-800 mb-4">Data Demografi</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
                    <div>
                        <p class="text-gray-500">Pendidikan</p>
                        <p class="font-semibold text-green-900">
                            {{ Str::of($resident->education_level ?? '-')->replace('_',' ')->upper() }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500">Pekerjaan</p>
                        <p class="font-semibold text-green-900">{{ $resident->occupation ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Agama</p>
                        <p class="font-semibold text-green-900">{{ Str::of($resident->religion ?? '-')->title() }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Status Kawin</p>
                        <p class="font-semibold text-green-900">
                            {{ Str::of($resident->marital_status ?? '-')->replace('_',' ')->title() }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500">Penghasilan</p>
                        <p class="font-semibold text-green-900">{{ $resident->income_bracket ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Golongan Darah</p>
                        <p class="font-semibold text-green-900">{{ $resident->blood_type ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Kewarganegaraan</p>
                        <p class="font-semibold text-green-900">{{ $resident->citizenship ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Disabilitas</p>
                        <p class="font-semibold text-green-900">
                            {{ $resident->disability_status ? 'Ya' : 'Tidak' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Riwayat Permohonan --}}
            <div class="bg-white p-6 rounded-2xl shadow-lg border">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-green-800">Riwayat Permohonan</h2>
                    <a href="{{ route('applications.index') }}" class="text-green-700 hover:underline text-sm">
                        Lihat semua
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-green-700">
                        <thead class="text-xs uppercase bg-green-50">
                            <tr>
                                <th class="px-4 py-2">Nomor</th>
                                <th class="px-4 py-2">Jenis Surat</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Dibuat</th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($resident->applications()->with('applicationType')->latest()->take(5)->get() as $app)
                                <tr class="border-b">
                                    <td class="px-4 py-2 font-semibold text-green-900">{{ $app->ref_number }}</td>
                                    <td class="px-4 py-2">{{ optional($app->applicationType)->name ?? '-' }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 rounded text-xs
                                            @class([
                                                'bg-yellow-100 text-yellow-800' => Str::startsWith($app->status,'pending'),
                                                'bg-green-100 text-green-800'   => $app->status === 'approved',
                                                'bg-red-100 text-red-800'       => $app->status === 'rejected',
                                            ])
                                        ">
                                            {{ Str::of($app->status)->replace('_',' ')->upper() }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">{{ $app->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-2 text-right">
                                        <a href="{{ route('applications.show', $app->id) }}"
                                           class="text-green-700 hover:underline">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada permohonan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        {{-- Kolom Kanan: Peta / Lokasi --}}
        <div class="space-y-8 lg:sticky lg:top-24 lg:self-start">
            <div class="bg-white p-6 rounded-2xl shadow-lg border">
                <h2 class="text-lg font-bold text-green-800 mb-4">Lokasi Tempat Tinggal</h2>
                @if($resident->lat && $resident->lng)
                    <div id="map" class="w-full h-72 rounded-xl border overflow-hidden z-0"></div>
                    <p class="text-xs text-gray-500 mt-2">
                        Koordinat: {{ $resident->lat }}, {{ $resident->lng }}
                    </p>
                @else
                    <div class="p-6 bg-green-50 border border-dashed border-green-200 rounded-xl text-green-700">
                        Koordinat belum diisi. <br>
                        <span class="text-sm text-gray-600">Isi kolom <em>lat</em> & <em>lng</em> di profil untuk menampilkan peta.</span>
                    </div>
                @endif
            </div>

            {{-- Aksi Cepat --}}
            <div class="bg-white p-6 rounded-2xl shadow-lg border">
                <h2 class="text-lg font-bold text-green-800 mb-4">Aksi Cepat</h2>
                <div class="grid grid-cols-1 gap-3">
                    <a href="{{ route('applications.create') }}"
                       class="inline-flex items-center justify-center w-full px-4 py-3 bg-green-700 text-white rounded-lg hover:bg-green-800">
                        Buat Surat atas Nama Warga
                    </a>
                    <a href="{{ route('tracking.index') }}"
                       class="inline-flex items-center justify-center w-full px-4 py-3 border-2 border-green-700 text-green-700 rounded-lg hover:bg-green-50">
                        Lihat Tracking Permohonan Warga
                    </a>
                </div>
            </div>
        </div>
    </section>
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
