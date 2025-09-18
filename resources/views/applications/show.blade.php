@extends('layout.app')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Detail Surat</h1>
    <p><strong>Jenis Surat:</strong> {{ $application->applicationType->nama }}</p>
    <p><strong>Status:</strong> {{ $application->status }}</p>
    <p><strong>Pemohon:</strong> {{ $application->resident->name }}</p>
    <p><strong>Dokumen:</strong> 
        @if($application->dokumen_pendukung)
            <a href="{{ asset('storage/'.$application->dokumen_pendukung) }}" class="text-blue-600">Download</a>
        @endif
    </p>

    @if(auth()->user()->role != 'warga')
    <form method="POST" action="{{ route('applications.approve', $application) }}">
        @csrf
        <button class="bg-green-600 text-white px-4 py-2 mt-3 rounded">Setujui</button>
    </form>
    @endif
</div>
@endsection
