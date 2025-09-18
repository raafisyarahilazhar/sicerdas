@extends('layout.app')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Kirim Notifikasi</h1>
    <form method="POST" action="{{ route('notification.kirim', $application) }}">
        @csrf
        <textarea name="pesan" class="w-full border p-2 mb-3" placeholder="Isi notifikasi"></textarea>
        <button class="bg-green-600 text-white px-4 py-2 rounded">Kirim</button>
    </form>
</div>
@endsection
