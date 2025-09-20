@extends('layout.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6 lg:p-10">
    <div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
        <h1 class="text-2xl font-bold text-green-800 mb-6">Edit Jenis Surat</h1>
        
        {{-- Form ini sekarang menunjuk ke route 'update' dan menggunakan method 'PUT' --}}
        <form method="POST" 
              action="{{ route('application-types.update', $applicationType->id) }}" 
              class="space-y-6" 
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Field Nama Jenis Surat --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Jenis Surat</label>
                {{-- value diisi dengan data yang ada ($applicationType->name) --}}
                <input type="text" name="name" id="name" value="{{ old('name', $applicationType->name) }}" class="input-style" placeholder="Contoh: Surat Keterangan Domisili" required>
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            
            {{-- Field Upload Template Word --}}
            <div>
                <label for="template_file" class="block text-sm font-medium text-gray-700 mb-1">
                    Upload Template Baru (.docx)
                </label>
                {{-- 'required' dihapus agar menjadi opsional --}}
                <input type="file" name="template_file" id="template_file" class="input-file-style">
                <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah template yang sudah ada.</p>
                
                {{-- Menampilkan info template yang aktif saat ini --}}
                @if($applicationType->template_file)
                    <p class="text-xs text-gray-500 mt-2">
                        Template saat ini: 
                        <a href="{{ Storage::url($applicationType->template_file) }}" target="_blank" class="text-blue-600 hover:underline">
                            {{ basename($applicationType->template_file) }}
                        </a>
                    </p>
                @endif
                @error('template_file') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end pt-4">
                <a href="{{ route('application-types.index') }}" class="btn-secondary mr-4">Batal</a>
                <button type="submit" class="btn-primary">Update</button>
            </div>
        </form>
    </div>
</main>

<style>
    .btn-primary {
        display: inline-block;
        background-color: #16a34a; /* bg-green-600 */
        color: white;
        font-weight: 500; /* font-medium */
        padding: 0.5rem 1rem; /* py-2 px-4 */
        border-radius: 0.375rem; /* rounded-md */
        transition: background-color 0.2s;
    }
    .btn-primary:hover {
        background-color: #15803d; /* hover:bg-green-700 */
    }
    .btn-sm {
        display: inline-block;
        padding: 0.375rem 0.75rem; /* py-1.5 px-3 */
        font-weight: 500;
        color: white;
        border-radius: 0.375rem;
        transition: background-color 0.2s;
        white-space: nowrap;
    }
</style>
@endsection
