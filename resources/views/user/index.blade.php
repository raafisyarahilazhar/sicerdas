@extends('layout.app')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Daftar User</h1>
    <a href="{{ route('users.create') }}" class="bg-green-600 text-white px-4 py-2 rounded">Tambah User</a>
    <table class="w-full mt-4 border">
        <tr class="bg-gray-100">
            <th class="p-2 border">Nama</th>
            <th class="p-2 border">Email</th>
            <th class="p-2 border">Role</th>
            <th class="p-2 border">Aksi</th>
        </tr>
        @foreach($users as $user)
        <tr>
            <td class="p-2 border">{{ $user->name }}</td>
            <td class="p-2 border">{{ $user->email }}</td>
            <td class="p-2 border">{{ $user->role }}</td>
            <td class="p-2 border">
                <a href="{{ route('users.edit', $user) }}" class="text-blue-600">Edit</a>
                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button class="text-red-600">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
