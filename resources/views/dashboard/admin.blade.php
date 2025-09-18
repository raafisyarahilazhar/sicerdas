@extends('layout.app')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Dashboard Admin</h1>
    <p>Admin dapat mengelola seluruh data sistem:</p>

    <ul class="list-disc pl-6 mt-4">
        <li><a href="{{ route('users.index') }}" class="text-blue-600">Kelola User</a></li>
        <li><a href="{{ route('rts.index') }}" class="text-blue-600">Kelola Data RT</a></li>
        <li><a href="{{ route('rws.index') }}" class="text-blue-600">Kelola Data RW</a></li>
        <li><a href="{{ route('application-types.index') }}" class="text-blue-600">Kelola Jenis Surat</a></li>
        <li><a href="{{ route('applications.index') }}" class="text-blue-600">Kelola Semua Surat</a></li>
    </ul>
</div>
@endsection
