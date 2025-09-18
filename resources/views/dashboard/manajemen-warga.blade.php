@extends('layout.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6 lg:p-10 space-y-8">
    
    {{-- Judul Utama Dashboard --}}
    <div>
        <h2 class="text-2xl font-bold text-green-800 mb-4">Data Warga RT {{ Auth::user()->rt_id }} / RW {{ Auth::user()->rw_id }}</h2>
    </div>
    {{-- Tabel Data Warga --}}
    <div class="bg-white p-6 rounded-2xl shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-green-600">
                <thead class="text-xs text-green-700 uppercase bg-green-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">NIK</th>
                        <th scope="col" class="px-6 py-3">Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($residents as $resident)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-green-900">{{ $resident->name }}</td>
                            <td class="px-6 py-4">{{ $resident->nik }}</td>
                            <td class="px-6 py-4">{{ $resident->address }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center px-6 py-4 text-gray-500">Belum ada data warga yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection