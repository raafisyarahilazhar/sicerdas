@extends('layout.app')

@section('content')

<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6 lg:p-10 space-y-8">
    
    {{-- Judul Utama Halaman --}}
    <div>
        <h2 class="text-2xl font-bold text-green-800 mb-4">Daftar RW</h2>
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
             <h2 class="text-xl font-bold text-green-800">Daftar RW</h2>
             <a href="{{ route('rws.create') }}" class="btn-sm bg-green-600 hover:bg-green-700">+ Tambah Data RW</a>
        </div>
       
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-green-700 uppercase bg-green-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">No.</th>
                        <th scope="col" class="px-6 py-3">Nama RW</th>
                        <th scope="col" class="px-6 py-3">Nomor RW</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rws as $item)
                        <tr class="bg-white border-b hover:bg-green-50">
                            <td class="px-6 py-4">
                                {{ $loop->iteration}}
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900">
                                {{ $item->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->nomor_rw }}
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('rws.edit', $item->id ) }}" class="btn-sm bg-yellow-500 hover:bg-yellow-700">Edit</a>
                                <form action="{{ route('rws.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data rw?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-sm bg-red-600 hover:bg-red-700">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center px-6 py-4 text-gray-500">
                                Belum ada data RW
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
