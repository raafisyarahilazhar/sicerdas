@extends('layout.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6 lg:p-10">
    <div class="bg-white p-8 rounded-2xl shadow-lg">
        
        {{-- Bagian Header Halaman --}}
        <div class="flex justify-between items-center pb-4 border-b border-gray-200">
            <div>
                <h1 class="text-2xl font-bold text-green-800">Detail Permohonan Surat</h1>
                <p class="text-sm text-gray-500">Lihat detail lengkap dari permohonan yang diajukan.</p>
            </div>
            <a href="{{ url()->previous() }}" class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300">
                Kembali
            </a>
        </div>

        {{-- Konten Detail dalam Grid --}}
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-8">
            
            {{-- Kolom 1: Informasi Pemohon --}}
            <div class="md:col-span-1 space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Pemohon</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                        <dd class="mt-1 text-md text-gray-900">{{ $application->resident->name ?? 'Tidak ada data' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">NIK</dt>
                        <dd class="mt-1 text-md text-gray-900">{{ $application->resident->nik ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">No. Telepon</dt>
                        <dd class="mt-1 text-md text-gray-900">{{ $application->resident->phone ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                        <dd class="mt-1 text-md text-gray-900">{{ $application->resident->address ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Kolom 2 & 3: Detail Permohonan dan Aksi --}}
            <div class="md:col-span-2 space-y-6">
                {{-- Detail Surat --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Detail Permohonan</h3>
                    <dl class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nomor Referensi</dt>
                            <dd class="mt-1 text-md font-mono text-gray-900">{{ $application->ref_number }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Jenis Surat</dt>
                            <dd class="mt-1 text-md text-gray-900">{{ $application->applicationType->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal Pengajuan</dt>
                            <dd class="mt-1 text-md text-gray-900">{{ $application->created_at->isoFormat('dddd, D MMMM YYYY, HH:mm') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status Saat Ini</dt>
                            <dd class="mt-1">
                                <span class="px-3 py-1 text-xs font-semibold text-white rounded-full
                                    @if($application->status == 'pending_rt') bg-yellow-500
                                    @elseif($application->status == 'pending_rw') bg-blue-500
                                    @elseif($application->status == 'pending_kades') bg-indigo-500
                                    @elseif($application->status == 'approved') bg-green-500
                                    @else bg-red-500 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>

                {{-- Data Isian Formulir --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Data Isian Formulir</h3>
                    <dl class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                        @forelse ($application->form_data as $key => $value)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ ucfirst(str_replace('_', ' ', $key)) }}</dt>
                                <dd class="mt-1 text-md text-gray-900">
                                    @if (Str::startsWith($value, 'application_documents/'))
                                        <a href="{{ Storage::url($value) }}" target="_blank" class="text-blue-600 hover:underline">
                                            Lihat Dokumen
                                        </a>
                                    @else
                                        {{ $value }}
                                    @endif
                                </dd>
                            </div>
                        @empty
                            <p class="text-gray-500">Tidak ada data formulir tambahan.</p>
                        @endforelse
                    </dl>
                </div>

                {{-- Tombol Aksi --}}
                @if (auth()->user()->role != 'warga')
                <div class="pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Aksi</h3>
                    <div class="mt-4 flex items-center gap-4">
                        <form method="POST" action="{{ route('applications.approve', $application) }}">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700">Setujui</button>
                        </form>
                        <form method="POST" action="{{ route('applications.reject', $application) }}">
                            @csrf
                            <button type="submit" class="bg-red-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-700">Tolak</button>
                        </form>
                        
                        {{-- Logika untuk tombol PDF --}}
                        @if ($application->status == 'approved')
                            @if ($application->pdf_path)
                                <a href="{{ route('applications.downloadPdf', $application) }}" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700">
                                   Unduh PDF
                                </a>
                            @else
                                <a href="{{ route('applications.generatePdf', $application) }}" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700">
                                   Buat PDF
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</main>
@endsection