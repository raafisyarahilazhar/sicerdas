@extends('layout.app')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Daftar User</h1>
    <a href="{{ route('users.create') }}" class="bg-green-600 text-white px-4 py-2 rounded">Tambah User</a>
    <table class="w-full mt-4 border">
        <tr class="bg-gray-100">
            <th class="p-2 border">Nama RT</th>
            <th class="p-2 border">Email</th>
            <th class="p-2 border">Role</th>
            <th class="p-2 border">Aksi</th>
        </tr>
        @foreach($rts as $rt)
        <tr>
            <td class="p-2 border">{{ $rt->name }}</td>
            <td class="p-2 border">{{ $rt->email }}</td>
            <td class="p-2 border">{{ $rt->role }}</td>
            <td class="p-2 border">
                <a href="{{ route('rts.edit', $rt) }}" class="text-blue-600">Edit</a>
                <form action="{{ route('rts.destroy', $rt) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button class="text-red-600">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
