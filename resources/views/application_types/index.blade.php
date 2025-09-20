@extends('layout.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6 lg:p-10">
    <div class="bg-white p-6 rounded-2xl shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-green-800">Manajemen Jenis Surat</h1>
            <a href="{{ route('application-types.create') }}" class="btn-sm bg-green-600 hover:bg-green-700">
                + Tambah Jenis Surat
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-700 uppercase bg-green-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama Jenis Surat</th>
                        <th scope="col" class="px-6 py-3">File Template (.docx)</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applicationTypes as $type)
                        <tr class="bg-white border-b hover:bg-gray-50 align-middle">
                            <td class="px-6 py-4 font-semibold text-gray-900">
                                {{ $type->name }}
                            </td>
                            <td class="px-6 py-4">
                                @if($type->template_file)
                                    <a href="{{ Storage::url($type->template_file) }}" target="_blank" class="text-blue-600 hover:underline">
                                        {{ basename($type->template_file) }}
                                    </a>
                                @else
                                    <span class="text-red-500">Belum di-upload</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                {{-- PERBAIKAN DI SINI: Gunakan flexbox untuk menata tombol --}}
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('application-types.edit', $type->id) }}" class="btn-sm bg-yellow-400 hover:bg-yellow-500">Edit</a>
                                    
                                    <form action="{{ route('application-types.destroy', $type->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jenis surat ini beserta templatenya?');">
                                        @csrf
                                        @method('DELETE')
                                        {{-- Style diterapkan pada <button>, bukan <form> --}}
                                        <button type="submit" class="btn-sm bg-red-600 hover:bg-red-700">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center px-6 py-4 text-gray-500">
                                Belum ada data jenis surat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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