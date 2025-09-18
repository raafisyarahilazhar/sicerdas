@extends('layout.app')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Daftar Pengajuan Surat</h1>
    <a href="{{ route('applications.create') }}" class="bg-green-600 text-white px-4 py-2 rounded">Ajukan Surat</a>
    <table class="w-full mt-4 border">
        <tr class="bg-gray-100">
            <th class="p-2 border">Jenis Surat</th>
            <th class="p-2 border">Status</th>
            <th class="p-2 border">Aksi</th>
        </tr>
        @foreach($applications as $app)
        <tr>
            <td class="p-2 border">{{ $app->applicationType->name }}</td>
            <td class="p-2 border">{{ $app->status }}</td>
            <td class="p-2 border">
                <a href="{{ route('applications.show', $app) }}" class="text-blue-600">Detail</a>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
