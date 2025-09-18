@extends('layout.app')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Antrean Layanan</h1>
    <form method="POST" action="{{ route('antrean.ambil') }}">
        @csrf
        <button class="bg-green-600 text-white px-4 py-2 rounded">Ambil Nomor Antrean</button>
    </form>
    <ul class="mt-4">
        @foreach($antreans as $antrean)
            <li>{{ $antrean->user->name }} - Nomor: {{ $antrean->nomor }}</li>
        @endforeach
    </ul>
</div>
@endsection
