@extends('layout.main')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <div class="text-sm text-gray-500 mb-6">
        <span>Beranda</span>
        <span class="mx-2">></span>
        <span class="font-semibold text-green-700">Pengajuan Surat</span>
    </div>

    <h2 class="text-4xl font-bold text-center text-green-700 mb-10">Pengajuan Surat</h2>

    <form action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-6">
            {{-- Mengubah style label dan select --}}
            <label for="application_type_id" class="block font-semibold text-green-700 mb-1">Jenis Surat :</label>
            <select name="application_type_id" id="application_type_id" class="w-full bg-transparent border-b-2 border-gray-300 py-2 focus:outline-none focus:ring-0 focus:border-green-700">
                <option value="">-- Pilih Jenis Surat --</option>
                @foreach($applicationTypes as $type)
                    <option 
                        value="{{ $type->id }}" 
                        data-requirements='@json($type->requirements)'>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Container untuk form dinamis --}}
        <div id="dynamic-form" class="space-y-6"></div>

        <button type="submit" class="mt-8 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold">Ajukan</button>
    </form>
</div>

<script>
    document.getElementById('application_type_id').addEventListener('change', function() {
        let selected = this.options[this.selectedIndex];
        let requirementsAttr = selected.getAttribute('data-requirements');
        let container = document.getElementById('dynamic-form');
        container.innerHTML = '';

        if (requirementsAttr && requirementsAttr.length > 2) {
            try {
                // Sesuaikan jumlah JSON.parse() dengan kondisi server Anda.
                // Jika server sudah diperbaiki (dengan $casts), gunakan satu kali parse.
                // let requirements = JSON.parse(JSON.parse(requirementsAttr));
                let requirements = JSON.parse(requirementsAttr);


                if (Array.isArray(requirements)) {
                    requirements.forEach(field => {
                        let html = '';
                        
                        // Templat dasar untuk setiap field
                        const fieldWrapper = `
                            <div>
                                <label class="block font-semibold text-green-700 mb-1">${field.label} :</label>
                                %%FIELD_HTML%%
                            </div>
                        `;

                        let fieldHtml = '';

                        // Membuat HTML spesifik untuk setiap tipe input
                        if (field.type === 'text' || field.type === 'date') {
                            fieldHtml = `
                                <input 
                                    type="${field.type}" 
                                    name="fields[${field.name}]" 
                                    class="w-full bg-transparent border-b-2 border-gray-300 py-2 focus:outline-none focus:ring-0 focus:border-green-700" 
                                    ${field.required ? 'required' : ''}>
                            `;
                        } 
                        else if (field.type === 'textarea') {
                            fieldHtml = `
                                <textarea 
                                    name="fields[${field.name}]" 
                                    class="w-full bg-transparent border-b-2 border-gray-300 py-2 focus:outline-none focus:ring-0 focus:border-green-700" 
                                    ${field.required ? 'required' : ''}></textarea>
                            `;
                        }
                        else if (field.type === 'file') {
                            // File input distyle secara khusus agar lebih modern
                            fieldHtml = `
                                <input 
                                    type="file" 
                                    name="fields[${field.name}]" 
                                    class="w-full block text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100" 
                                    ${field.required ? 'required' : ''}>
                            `;
                        }
                        
                        // Menggabungkan wrapper dengan field HTML
                        html = fieldWrapper.replace('%%FIELD_HTML%%', fieldHtml);
                        container.innerHTML += html;
                    });
                }
            } catch (e) {
                console.error("Gagal mem-parsing JSON:", e);
            }
        }
    });
</script>
@endsection