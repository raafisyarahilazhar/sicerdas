@extends('layout.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6 lg:p-10 space-y-8">
    
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-green-800">Manajemen Pengguna</h2>
        <a href="{{ route('users.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-200 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah User
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex justify-between items-center animate-fade-in" role="alert">
            <p>{{ session('success') }}</p>
            <button onclick="this.parentElement.remove()" class="text-green-700 font-bold">&times;</button>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-400 uppercase bg-gray-50 tracking-widest font-bold">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4">No. HP</th>
                        <th class="px-6 py-4">E-Mail</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-green-50 transition duration-150">
                            {{-- Perbaikan nomor agar berlanjut di tiap halaman pagination --}}
                            <td class="px-6 py-4 font-medium text-gray-500">
                                {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-800">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->phone ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->email ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase
                                    @if($user->role == 'admin') bg-red-100 text-red-700
                                    @elseif($user->role == 'warga') bg-blue-100 text-blue-700
                                    @else bg-green-100 text-green-700 @endif">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center items-center gap-3">
                                    <a href="{{ route('users.edit', $user) }}" class="text-yellow-600 hover:text-yellow-700 font-bold transition">Edit</a>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Hapus user ini?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:text-red-700 font-bold transition">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-gray-400 italic">Data user tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Link Pagination --}}
        <div class="px-6 py-4 border-t border-gray-100 custom-pagination">
            {{ $users->links() }}
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