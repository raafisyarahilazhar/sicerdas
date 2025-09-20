@extends('layout.main') {{-- Menggunakan layout utama untuk warga --}}

@section('content')
<main class="container mx-auto px-4 sm:px-6 py-12">
    <div class="text-sm text-gray-500 mb-6">
        <span>Beranda</span>
        <span class="mx-2">></span>
        <span>Berita</span>
        <span class="mx-2">></span>
        <span class="font-semibold text-green-700">{{ $berita->title }}</span>
    </div>
    <article class="max-w-4xl mx-auto bg-white p-6 sm:p-8 rounded-2xl shadow-lg">

        {{-- Gambar Sampul Berita --}}
        @if($berita->image_path)
            <img src="{{ Storage::url($berita->image_path) }}" alt="{{ $berita->title }}" class="w-full h-auto max-h-96 object-cover rounded-lg mb-6">
        @endif

        {{-- Judul Berita --}}
        <h1 class="text-3xl sm:text-4xl font-bold text-green-800 leading-tight mb-4">
            {{ $berita->title }}
        </h1>

        {{-- Meta Info: Penulis dan Tanggal --}}
        <div class="flex items-center text-sm text-gray-500 mb-6">
            <span>Ditulis oleh: <strong>{{ $berita->author ?? 'Admin' }}</strong></span>
            <span class="mx-2">|</span>
            <span>Dipublikasikan pada: <strong>{{ $berita->published_at->isoFormat('dddd, D MMMM YYYY') }}</strong></span>
        </div>

        {{-- Konten Berita --}}
        <div class="prose max-w-none text-gray-700 leading-relaxed">
            {!! $berita->content !!}
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-10 pt-6 border-t border-gray-200">
            <a href="{{ route('welcome') }}" 
               class="inline-flex items-center gap-2 bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar Berita
            </a>
        </div>

    </article>
</main>

{{-- Style tambahan untuk konten dari database --}}
<style>
    .prose {
        font-size: 1.125rem; /* text-lg */
        line-height: 1.75rem;
    }
    .prose p {
        margin-bottom: 1.25em;
    }
    .prose h2 {
        font-size: 1.5rem; /* text-2xl */
        font-weight: 700;
        margin-top: 2em;
        margin-bottom: 1em;
    }
    .prose ul {
        list-style-type: disc;
        padding-left: 1.5em;
        margin-bottom: 1.25em;
    }
</style>
@endsection
