@extends('layout.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6 lg:p-10 space-y-8">
    
    {{-- Judul Utama Dashboard --}}
    <div>
        <h2 class="text-2xl font-bold text-green-800 mb-4">Daftar User</h2>
    </div>

    {{-- 3. Riwayat Permohonan Terbaru --}}
    <div class="bg-white p-6 rounded-2xl shadow-lg">
        <a href="{{ route('users.create') }}" class="font-medium text-white bg-green-600 hover:bg-green-700 px-3 py-1.5 rounded-md transition-colors">Tambah User</a>
        <div class="overflow-x-auto mt-4">
            <table class="w-full text-sm text-left text-green-600">
                <thead class="text-xs text-gray-700 uppercase bg-green-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">nama</th>
                        <th scope="col" class="px-6 py-3">No. Hp</th>
                        <th scope="col" class="px-6 py-3">E - Mail</th>
                        <th scope="col" class="px-6 py-3">Role</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="bg-white border-b hover:bg-green-50">
                            <td class="px-6 py-4 font-medium text-green-900">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">{{ $user->name }} </td>
                            <td class="px-6 py-4">{{ $user->phone }} </td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">{{ $user->role }}</td>
                            <td class="px-6 py-4 space-x-2">
                                <a href="{{ route('users.edit', $user) }}" class="font-medium text-white bg-yellow-400 hover:bg-yellow-500 px-3 py-1.5 rounded-md transition-colors">Edit</a>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="font-medium text-white bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded-md transition-colors">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center px-6 py-4 text-green-500">Belum ada user.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

@endsection
