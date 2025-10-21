@extends('layout.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6 lg:p-10">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
        <h1 class="text-2xl font-bold text-green-800 mb-6">Edit Data RW</h1>
        
        <form method="POST" action="{{ route('rws.update', $rw->id) }}" class="space-y-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name', $rw->name ) }}" class="input-style" placeholder="Masukkan nama RW" required>
                @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="nomor_rw" class="block text-sm font-medium text-gray-700 mb-1">Nomor RW</label>
                <input type="number" name="nomor_rw" id="nomor_rw" value="{{ old('nomor_rw', $rw->nomor_rw ) }}" class="input-style" placeholder="Masukkan nomor RW" required>
                @error('nomor_rw') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end pt-4 border-gray-200">
                <a href="{{ route('rws.index') }}" class="btn-secondary mr-4">Batal</a>
                <button type="submit" class="btn-primary">Simpan</button>
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