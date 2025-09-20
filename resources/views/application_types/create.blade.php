@extends('layout.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6 lg:p-10">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
        <h1 class="text-2xl font-bold text-green-800 mb-6">Tambah Jenis Surat Baru</h1>
        
        <form method="POST" action="{{ route('application-types.store') }}" class="space-y-6" enctype="multipart/form-data">
            @csrf

            {{-- Bagian Detail Surat --}}
            <div class="space-y-4 p-6 border rounded-lg">
                <h3 class="font-semibold text-lg text-gray-800">Detail Utama</h3>
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Jenis Surat</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="input-style" placeholder="Contoh: Surat Keterangan Domisili" required>
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="template_file" class="block text-sm font-medium text-gray-700 mb-1">Upload Template Surat (.docx)</label>
                    <input type="file" name="template_file" id="template_file" class="input-file-style" required>
                    @error('template_file') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Bagian Form Builder untuk Requirements --}}
            <div class="space-y-4 p-6 border rounded-lg">
                <div class="flex justify-between items-center">
                    <h3 class="font-semibold text-lg text-gray-800">Isian Formulir untuk Warga</h3>
                    <button type="button" id="add-requirement" class="btn-sm bg-blue-500 hover:bg-blue-600">+ Tambah Field</button>
                </div>
                <p class="text-xs text-gray-500">Atur kolom formulir yang harus diisi oleh warga saat mengajukan surat ini.</p>
                
                <div id="requirements-container" class="space-y-4">
                    {{-- Kontainer untuk field dinamis yang ditambahkan oleh JavaScript --}}
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <a href="{{ route('application-types.index') }}" class="btn-secondary mr-4">Batal</a>
                <button type="submit" class="btn-primary">Simpan Jenis Surat</button>
            </div>
        </form>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('requirements-container');
    const addButton = document.getElementById('add-requirement');
    let requirementIndex = 0;

    addButton.addEventListener('click', function () {
        const newRow = document.createElement('div');
        newRow.className = 'requirement-row grid grid-cols-12 gap-3 items-center border p-3 rounded-md animate-fade-in';
        newRow.innerHTML = `
            <div class="col-span-12 sm:col-span-4">
                <label class="text-xs text-gray-500">Label Field</label>
                <input type="text" name="requirements[${requirementIndex}][label]" class="input-style-sm" placeholder="Contoh: Keperluan Surat" required>
            </div>
            <div class="col-span-12 sm:col-span-3">
                <label class="text-xs text-gray-500">Nama Variabel</label>
                <input type="text" name="requirements[${requirementIndex}][name]" class="input-style-sm font-mono" placeholder="keperluan_surat" required>
            </div>
            <div class="col-span-12 sm:col-span-2">
                <label class="text-xs text-gray-500">Tipe</label>
                <select name="requirements[${requirementIndex}][type]" class="input-style-sm">
                    <option value="text">Teks</option>
                    <option value="date">Tanggal</option>
                    <option value="file">File</option>
                    <option value="textarea">Textarea</option>
                </select>
            </div>
            <div class="col-span-8 sm:col-span-2 flex items-center pt-4">
                <input type="checkbox" name="requirements[${requirementIndex}][required]" value="true" class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                <label class="ml-2 text-sm text-gray-600">Wajib Diisi</label>
            </div>
            <div class="col-span-4 sm:col-span-1 flex justify-end pt-4">
                <button type="button" class="text-red-500 hover:text-red-700 remove-requirement">Hapus</button>
            </div>
        `;
        container.appendChild(newRow);
        requirementIndex++;
    });

    container.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-requirement')) {
            e.target.closest('.requirement-row').remove();
        }
    });
});
</script>

<style>
    .input-style {
        display: block; width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #D1D5DB; border-radius: 0.375rem; box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    }
    .input-style-sm {
        display: block; width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #D1D5DB; border-radius: 0.375rem; box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05); font-size: 0.875rem;
    }
    .input-file-style {
        display: block; width: 100%; font-size: 0.875rem; color: #4B5563;
        file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100;
    }
    .btn-primary {
        display: inline-block; background-color: #16a34a; color: white; font-weight: 500; padding: 0.5rem 1rem; border-radius: 0.375rem; transition: background-color 0.2s;
    }
    .btn-primary:hover {
        background-color: #15803d;
    }
    .btn-secondary {
        display: inline-block; background-color: #E5E7EB; color: #374151; font-weight: 500; padding: 0.5rem 1rem; border-radius: 0.375rem; transition: background-color 0.2s;
    }
    .btn-secondary:hover {
        background-color: #D1D5DB;
    }
    .btn-sm {
        display: inline-block; padding: 0.375rem 0.75rem; font-weight: 500; color: white; border-radius: 0.375rem; transition: background-color 0.2s; white-space: nowrap;
    }
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.3s ease-out forwards;
    }
</style>
@endsection