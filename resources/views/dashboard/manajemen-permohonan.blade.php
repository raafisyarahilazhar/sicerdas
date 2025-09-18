@extends('layout.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6 lg:p-10 space-y-8">
    
    {{-- Judul Utama Dashboard --}}
    <div>
        <h2 class="text-2xl font-bold text-green-800 mb-4">Data Permohonan RT {{ Auth::user()->rt_id }} / RW {{ Auth::user()->rw_id }}</h2>
    </div>
    {{-- 2. Daftar Pengajuan Menunggu Persetujuan --}}
    <div class="bg-white p-6 rounded-2xl shadow-lg">
        <h2 class="text-xl font-bold text-green-800 mb-4">Pengajuan Menunggu Persetujuan</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-green-600">
                <thead class="text-xs text-gray-700 uppercase bg-green-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">No Ref</th>
                        <th scope="col" class="px-6 py-3">Jenis Surat</th>
                        <th scope="col" class="px-6 py-3">Pemohon</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $application)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-green-900">{{ $application->ref_number }}</td>
                            <td class="px-6 py-4">{{ $application->applicationType->name }}</td>
                            <td class="px-6 py-4">{{ $application->resident->name ?? '-' }}</td>
                            @if (Auth::user()->role === 'admin' || Auth::user()->role === 'rt' || Auth::user()->role === 'rw' || Auth::user()->role === 'kades')
                                <td class="px-6 py-4 text-center space-x-2">
                                    <form action="{{ route('applications.approve', $application) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="font-medium text-white bg-green-600 hover:bg-green-700 px-3 py-1.5 rounded-md transition-colors">Approve</button>
                                    </form>
                                    <form action="{{ route('applications.reject', $application) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="font-medium text-white bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded-md transition-colors">Reject</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center px-6 py-4 text-green-500">Tidak ada pengajuan yang menunggu persetujuan.</td>
                        </tr>
                    @endforelse
                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'operator')
                        <tr>
                            <td>
                                <p class="text-sm text-gray-500 italic mt-4">
                                    * Hanya RT, RW, Dan Kepala Desa yang boleh menyetujui permohonan.
                                </p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- 3. Riwayat Permohonan Terbaru --}}
    <div class="bg-white p-6 rounded-2xl shadow-lg">
        <h2 class="text-xl font-bold text-green-800 mb-4">Riwayat Permohonan Terbaru</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-green-600">
                <thead class="text-xs text-gray-700 uppercase bg-green-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">No Ref</th>
                        <th scope="col" class="px-6 py-3">Jenis Surat</th>
                        <th scope="col" class="px-6 py-3">Pemohon</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history as $h)
                        <tr class="bg-white border-b hover:bg-green-50">
                            <td class="px-6 py-4 font-medium text-green-900">{{ $h->ref_number }}</td>
                            <td class="px-6 py-4">{{ $h->applicationType->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $h->resident->name ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-semibold text-white rounded-full
                                    @if($h->status == 'pending_rt') bg-yellow-500
                                    @elseif($h->status == 'pending_rw') bg-blue-500
                                    @elseif($h->status == 'pending_kades') bg-indigo-500
                                    @elseif($h->status == 'approved') bg-green-500
                                    @else bg-red-500 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $h->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $h->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center px-6 py-4 text-green-500">Belum ada riwayat permohonan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection