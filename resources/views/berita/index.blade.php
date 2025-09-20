@extends('layout.main') {{-- Menggunakan layout utama untuk warga --}}

@section('content')
<main class="container mx-auto px-4 sm:px-6 py-12">
    <div class="text-sm text-gray-500 mb-6">
        <span>Beranda</span>
        <span class="mx-2">></span>
        <span class="font-semibold text-green-700">Berita</span>
    </div>
    {{-- Judul Halaman --}}
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-green-800">Berita & Informasi Desa</h1>
        <p class="mt-2 text-lg text-gray-600">Ikuti perkembangan dan pengumuman terbaru dari desa kita.</p>
    </div>

    {{-- Daftar Berita dalam Format Kartu --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($berita as $item)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                <a href="{{ route('berita.show', $item) }}">
                    {{-- Gambar Sampul --}}
                    @if($item->image_path)
                        <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                    @else
                        {{-- Gambar placeholder jika tidak ada gambar --}}
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-400">Tidak ada gambar</span>
                        </div>
                    @endif
                    
                    <div class="p-6">
                        {{-- Judul Berita --}}
                        <h2 class="text-xl font-bold text-gray-800 mb-2 leading-tight">
                            {{ Str::limit($item->title, 50) }}
                        </h2>
                        
                        {{-- Pratinjau Konten --}}
                        <p class="text-gray-600 text-sm mb-4">
                            {{ Str::limit(strip_tags($item->content), 100) }}
                        </p>
                        
                        {{-- Meta Info: Tanggal --}}
                        <div class="text-xs text-gray-500">
                            Dipublikasikan pada {{ $item->published_at->isoFormat('D MMMM YYYY') }}
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12">
                <p class="text-gray-500">Belum ada berita yang dipublikasikan.</p>
            </div>
        @endforelse
    </div>
    
    {{-- Tombol Paginasi --}}
    <div class="mt-12">
        {{ $berita->links() }}
    </div>

</main>
@endsection