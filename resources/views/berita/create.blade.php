@extends('layout.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6 lg:p-10">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
        <h1 class="text-2xl font-bold text-green-800 mb-6">Tulis Berita Baru</h1>
        
        <form method="POST" action="{{ route('berita.store') }}" class="space-y-6" enctype="multipart/form-data">
            @csrf

            {{-- Judul Berita --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Berita</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" class="input-style" placeholder="Masukkan judul yang menarik" required>
                @error('title') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Penulis Berita</label>
                <input type="text" name="author" id="author" value="{{ old('author') }}" class="input-style" placeholder="Masukkan nama penulis" required>
                @error('author') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Isi Berita --}}
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Isi Berita</label>
                <textarea name="content" id="content" rows="10" class="input-style" placeholder="Tulis isi berita di sini...">{{ old('content') }}</textarea>
                @error('content') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            
            {{-- Gambar Sampul --}}
            <div>
                <label for="image_path" class="block text-sm font-medium text-gray-700 mb-1">Gambar Sampul (Cover)</label>
                <input type="file" name="image_path" id="image_path" class="input-file-style" required>
                <p class="text-xs text-gray-500 mt-1">Format yang didukung: JPG, PNG, WEBP. Maksimal 2MB.</p>
                @error('image_path') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Opsi Publikasi --}}
            <div class="flex items-center pt-2">
                <input type="checkbox" name="publish" id="publish" value="1" class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                <label for="publish" class="ml-2 block text-sm text-gray-900">Publikasikan langsung setelah disimpan</label>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end pt-4 border-t border-gray-200">
                <a href="{{ route('dashboard.manajemen-konten') }}" class="btn-secondary mr-4">Batal</a>
                <button type="submit" class="btn-primary">Simpan Berita</button>
            </div>
        </form>
    </div>
</main>

{{-- Style ini bisa dipindahkan ke layout utama jika digunakan di banyak tempat --}}
<style>
    .input-style {
        display: block; width: 100%; border-radius: 0.375rem; border: 1px solid #D1D5DB; padding: 0.5rem 0.75rem;
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    }
    .input-style:focus {
        outline: none; --tw-ring-color: #16a34a; box-shadow: 0 0 0 2px var(--tw-ring-color); border-color: #16a34a;
    }
    .input-file-style {
        display: block; width: 100%; font-size: 0.875rem; color: #6B7280;
        file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold
        file:bg-green-50 file:text-green-700 hover:file:bg-green-100;
    }
    .btn-primary {
        background-color: #16a34a; color: white; font-weight: 500; padding: 0.5rem 1rem; border-radius: 0.375rem; transition: background-color 0.2s;
    }
    .btn-primary:hover {
        background-color: #15803d;
    }
    .btn-secondary {
        background-color: #E5E7EB; color: #374151; font-weight: 500; padding: 0.5rem 1rem; border-radius: 0.375rem; transition: background-color 0.2s;
    }
    .btn-secondary:hover {
        background-color: #D1D5DB;
    }
</style>
@endsection

@push('addon-script')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
    CKEDITOR.replace("content");
    </script>
    <script>
    function thisFileUpload() {
        document.getElementById("file").click();
    }
    </script>
@endpush