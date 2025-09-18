@extends('layout.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Tambah User</h1>
    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <input type="text" name="nama_rt" placeholder="Nama RT" class="w-full border p-2 mb-3">
        <input type="email" name="email" placeholder="Email" class="w-full border p-2 mb-3">
        <input type="password" name="password" placeholder="Password" class="w-full border p-2 mb-3">
        <select name="role" class="w-full border p-2 mb-3">
            <option value="warga">Warga</option>
            <option value="rt">RT</option>
            <option value="rw">RW</option>
            <option value="admin">Admin</option>
        </select>
        <button class="w-full bg-green-600 text-white py-2 rounded">Simpan</button>
    </form>
</div>
@endsection
