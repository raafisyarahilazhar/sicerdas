@extends('layout.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6 lg:p-10 space-y-8">
    
    {{-- Judul Utama Dashboard --}}
    <div>
        <h2 class="text-2xl font-bold text-green-800 mb-4">Data Surat</h2>
    </div>

    {{-- 3. Riwayat Permohonan Terbaru --}}
    <div class="bg-white p-6 rounded-2xl shadow-lg">
        <h2 class="text-xl font-bold text-green-800 mb-4">Surat Yang Sudah Disetujui</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-green-600">
                <thead class="text-xs text-gray-700 uppercase bg-green-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">No Ref</th>
                        <th scope="col" class="px-6 py-3">Jenis Surat</th>
                        <th scope="col" class="px-6 py-3">Pemohon</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Tanggal</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history as $h)
                        @if ($h->status == 'approved')
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
                                <td class="px-6 py-4">
                                    <a href="{{ route('applications.generatePdf', $h) }}" 
                                        target="_blank" 
                                        class="text-gray-600 hover:text-green-700">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    </a>
                                </td>
                            </tr>
                        @endif
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