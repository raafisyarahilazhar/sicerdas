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
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($residents as $resident)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-green-900">{{ $resident->name }}</td>
                            <td class="px-6 py-4">{{ $resident->nik }}</td>
                            <td class="px-6 py-4">{{ $resident->address }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('dashboard-warga-detail', $resident->id) }}" 
                                   class="text-green-600 hover:underline">Lihat Detail</a>  
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center px-6 py-4 text-gray-500">Belum ada data warga yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 custom-pagination">
            {{ $residents->links() }}
        </div>
    </div>
</main>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fade-in 0.4s ease-out forwards; }

    /* Perbaikan warna pagination agar tidak hitam dan lebih modern */
    .custom-pagination nav div:last-child span a,
    .custom-pagination nav div:last-child span span,
    .custom-pagination nav div:last-child a {
        background-color: white !important;
        color: #374151 !important; /* Gray-700 */
        /* border: 1px solid #E5E7EB !important;  */
        border-radius: 0.5rem !important;
        margin: 0 2px;
        /* padding: 0.5rem 1rem !important; */
        text-decoration: none !important;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
    }

    /* Warna untuk halaman yang sedang aktif (Hijau) */
    .custom-pagination nav div:last-child span span[aria-current="page"] span {
        background-color: #16a34a !important; /* Green-600 */
        border-color: #16a34a !important;
        color: white !important;
    }
    
    /* Hover state untuk tombol pagination */
    .custom-pagination nav div:last-child a:hover {
        background-color: #f0fdf4 !important; /* Green-50 */
        color: #15803d !important; /* Green-700 */
        border-color: #16a34a !important;
    }

    /* Menghilangkan bayangan default nav dan warna latar hitam */
    .custom-pagination nav {
        box-shadow: none !important;
        background-color: transparent !important;
    }

    /* Memastikan ikon panah (SVG) tidak berwarna aneh */
    .custom-pagination svg {
        width: 1.25rem !important;
        height: 1.25rem !important;
        display: inline-block !important;
        vertical-align: middle !important;
    }
</style>
@endsection