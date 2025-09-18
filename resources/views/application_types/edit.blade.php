@extends('layout.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Edit User</h1>
    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf @method('PUT')
        <input type="text" name="name" value="{{ $user->name }}" class="w-full border p-2 mb-3">
        <input type="email" name="email" value="{{ $user->email }}" class="w-full border p-2 mb-3">
        <select name="role" class="w-full border p-2 mb-3">
            <option value="warga" {{ $user->role=='warga'?'selected':'' }}>Warga</option>
            <option value="rt" {{ $user->role=='rt'?'selected':'' }}>RT</option>
            <option value="rw" {{ $user->role=='rw'?'selected':'' }}>RW</option>
            <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
        </select>
        <button class="w-full bg-green-600 text-white py-2 rounded">Update</button>
    </form>
</div>
@endsection
