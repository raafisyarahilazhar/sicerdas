@extends('layout.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6 lg:p-10 space-y-8">
    
    {{-- Judul Utama Halaman --}}
    <div>
        <h2 class="text-2xl font-bold text-green-800 mb-4">Manajemen Konten</h2>
    </div>

    @if(session('success'))
        <div class="alert success-alert">
            <span class="close-btn">&times;</span>
            <strong>{{ session('success') }}</strong> 
        </div>
    @endif

    {{-- Tabel Daftar Berita --}}
    <div class="bg-white p-6 rounded-2xl shadow-lg">
        <div class="flex justify-between items-center mb-4">
             <h2 class="text-xl font-bold text-green-800">Semua Berita Terpublikasi</h2>
             <a href="{{ route('berita.create') }}" class="btn-sm bg-green-600 hover:bg-green-700">+ Tulis Berita Baru</a>
        </div>
       
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-700 uppercase bg-green-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">Judul</th>
                        <th scope="col" class="px-6 py-3">Penulis</th>
                        <th scope="col" class="px-6 py-3">Tanggal Publikasi</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($berita as $item)
                        <tr class="bg-white border-b hover:bg-green-50">
                            {{-- Menggunakan variabel $item yang benar dari loop --}}
                            <td class="px-6 py-4 font-semibold text-gray-900">
                                {{ Str::limit($item->title, 60) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->author ?? '-' }}
                            </td>
                            {{-- <td class="px-6 py-4">
                                {{-- Logika status untuk berita (Published/Draft) --}}
                                {{-- @if($item->published_at)
                                    <span class="px-2.5 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">
                                        Published
                                    </span>
                                @else
                                     <span class="px-2.5 py-1 text-xs font-semibold text-gray-800 bg-gray-100 rounded-full">
                                        Draft
                                    </span>
                                @endif
                            </td> --}}
                            <td class="px-6 py-4">
                                {{ $item->published_at ? $item->published_at->isoFormat('D MMM YYYY') : '-' }}
                            </td>
                            <td class="px-6 py-4">
                                {{-- Tombol untuk melihat detail berita --}}
                                <a href="{{ route('berita.show', $item) }}" 
                                   target="_blank" 
                                   class="btn-sm bg-blue-600 hover:bg-blue-700">
                                   Lihat
                                </a>
                                <form action="{{ route('berita.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus berita?');">
                                    @csrf
                                    @method('DELETE')
                                    {{-- Style diterapkan pada <button>, bukan <form> --}}
                                    <button type="submit" class="btn-sm bg-red-600 hover:bg-red-700">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center px-6 py-4 text-gray-500">
                                Belum ada berita yang dipublikasikan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

<style>
    .btn-primary {
    display: inline-block;
    background-color: #16a34a; /* bg-green-600 */
    color: white;
    font-weight: 500; /* font-medium */
    padding: 0.5rem 1rem; /* py-2 px-4 */
    border-radius: 0.375rem; /* rounded-md */
    transition: background-color 0.2s;
    }
    .btn-primary:hover {
        background-color: #15803d; /* hover:bg-green-700 */
    }
    .btn-sm {
        display: inline-block;
        padding: 0.375rem 0.75rem; /* py-1.5 px-3 */
        font-weight: 500;
        color: white;
        border-radius: 0.375rem;
        transition: background-color 0.2s;
        white-space: nowrap;
    }
</style>
@endsection