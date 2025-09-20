@extends('layout.main')

@section('content')

<main class="container mx-auto px-6 py-12">
        <div class="text-sm text-gray-500 mb-6">
            <span>Beranda</span>
            <span class="mx-2">></span>
            <span class="font-semibold text-green-700">Tracking Status Permohonan</span>
        </div>

        <h2 class="text-4xl font-bold text-center text-green-700 mb-10">Status Permohonan</h2>

        <div class="border border-green-200 rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="border-b border-green-200">
                        <tr>
                            <th class="px-6 py-3 text-sm font-bold text-green-600 uppercase tracking-wider">No Ref</th>
                            <th class="px-6 py-3 text-sm font-bold text-green-600 uppercase tracking-wider">Nama Surat</th>
                            <th class="px-6 py-3 text-sm font-bold text-green-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-sm font-bold text-green-600 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-sm font-bold text-green-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($applications as $application)
                            <tr class="hover:bg-green-50">
                                <td class="px-6 py-4 text-green-600 whitespace-nowrap">{{ $application->ref_number }}</td>
                                <td class="px-6 py-4 text-green-600 whitespace-nowrap font-medium">{{ $application->applicationType->name }}</td>
                                <td class="px-6 py-4 text-green-600 whitespace-nowrap">
                                    <span class="flex items-center">
                                        @if($application->status === 'pending_rt')
                                            <span class="h-3 w-3 rounded-full bg-yellow-500 mr-2"></span>
                                            Menunggu RT
                                        @elseif($application->status === 'pending_rw')
                                            <span class="h-3 w-3 rounded-full bg-yellow-500 mr-2"></span>
                                            Menunggu RW
                                        @elseif($application->status === 'pending_kades')
                                            <span class="h-3 w-3 rounded-full bg-yellow-500 mr-2"></span>
                                            Menunggu Kepala Desa
                                        @elseif($application->status === 'approved')
                                            <span class="h-3 w-3 rounded-full bg-green-500 mr-2"></span>
                                            Disetujui
                                        @elseif($application->status === 'rejected')
                                            <span class="h-3 w-3 rounded-full bg-red-500 mr-2"></span>
                                            Ditolak
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-green-600 whitespace-nowrap font-medium">{{ $application->created_at->format('d-m-Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-4">
                                        @if ($application->status == 'approved')
                                            @if ($application->pdf_path)
                                                {{-- Jika file sudah ada, tampilkan tombol Unduh --}}
                                                <a href="{{ route('applications.downloadPdf', $application) }}" title="Unduh Surat" class="action-btn bg-blue-500 hover:bg-blue-600">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                </a>
                                            @else
                                                {{-- Jika file belum dibuat, tampilkan tombol Buat --}}
                                                <a href="{{ route('applications.generatePdf', $application) }}" title="Buat File Surat" class="action-btn bg-green-500 hover:bg-green-600">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                </a>
                                            @endif
                                        @endif

                                        {{-- <a href="#" title="Unduh" class="text-gray-600 hover:text-green-700">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        </a> --}}
                                        <form action="{{ route('applications.destroy', $application->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permohonan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus" class="action-btn bg-red-500 hover:bg-red-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center p-2">Belum ada pengajuan surat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <a href="#" class="font-semibold text-green-700 hover:underline">Kembali</a>
        </div>
    </main>

    
@endsection
