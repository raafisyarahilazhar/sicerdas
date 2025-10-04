@extends('layout.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6 lg:p-10 space-y-8">
    
    {{-- Judul Utama Dashboard --}}
    <div>
        <p class="text-gray-500 text-sm">Welcome, {{ Auth::user()->name }}!</p>
        <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">Dashboard {{ Auth::user()->role }}</h1>
    </div>

    {{-- 1. Kartu Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
            <p class="text-sm font-medium text-gray-500">Menunggu Persetujuan</p>
            <p class="mt-2 text-5xl font-extrabold text-green-700">{{ $applications->count() }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
            <p class="text-sm font-medium text-gray-500">Total Warga di Wilayah</p>
            <p class="mt-4 text-5xl font-extrabold text-green-700">{{ $residents->count() }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
            <p class="text-sm font-medium text-gray-500">Surat Disetujui</p>
            <p class="mt-4 text-5xl font-extrabold text-green-700">{{ $history->where('status', 'approved')->count() }}</p>
        </div>

        @isset($users)
            <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                <p class="text-sm font-medium text-gray-500">Total Pengguna Sistem</p>
                <p class="mt-4 text-5xl font-extrabold text-green-700">{{ $users->count() }}</p>
            </div>
        @endisset
    </div>
</main>
@endsection