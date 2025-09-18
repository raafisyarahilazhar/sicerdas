@extends('layout.app')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Dashboard Operator</h1>
    <p>Operator dapat mengelola semua data surat:</p>

    <table class="w-full mt-4 border">
        <thead>
            <tr>
                <th class="border p-2">No Ref</th>
                <th class="border p-2">Jenis Surat</th>
                <th class="border p-2">Pemohon</th>
                <th class="border p-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $application)
                <tr>
                    <td class="border p-2">{{ $application->ref_number }}</td>
                    <td class="border p-2">{{ $application->applicationType->name }}</td>
                    <td class="border p-2">{{ $application->resident->name ?? '-' }}</td>
                    <td class="border p-2">{{ $application->status }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center p-2">Belum ada data</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
