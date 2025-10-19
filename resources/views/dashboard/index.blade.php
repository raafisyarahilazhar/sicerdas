@extends('layout.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6 lg:p-10 space-y-8">
    
    {{-- Judul Utama Dashboard --}}
    <div>
        <p class="text-gray-500 text-sm">Welcome, {{ Auth::user()->name }}!</p>
        <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">Dashboard {{ Auth::user()->role }}</h1>
    </div>

    {{-- 1. Kartu Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
            <p class="text-sm font-medium text-gray-500">Menunggu Persetujuan</p>
            <p class="mt-2 text-5xl font-extrabold text-green-700">{{ $applications->count() }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
            <p class="text-sm font-medium text-gray-500">Total Warga di Wilayah</p>
            <p class="mt-4 text-5xl font-extrabold text-green-700">{{ $residents->count() }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
            <p class="text-sm font-medium text-gray-500">Surat Disetujui</p>
            <p class="mt-4 text-5xl font-extrabold text-green-700">{{ $history->where('status', 'approved')->count() }}</p>
        </div>

        @isset($users)
            <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                <p class="text-sm font-medium text-gray-500">Total Pengguna Sistem</p>
                <p class="mt-4 text-5xl font-extrabold text-green-700">{{ $users->count() }}</p>
            </div>
        @endisset
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 ">
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
            <p class="text-gray-500">Total Penduduk</p>
            <p class="text-4xl font-bold text-green-700">{{ number_format($total) }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
            <p class="text-gray-500 mb-2">Gender</p>
            <ul class="space-y-1">
                <li>Laki-laki: <strong>{{ $gender['L'] ?? 0 }}</strong></li>
                <li>Perempuan: <strong>{{ $gender['P'] ?? 0 }}</strong></li>
            </ul>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
            <p class="text-gray-500 mb-2">Kelompok Umur</p>
            <ul class="space-y-1">
                <li>0–5: <strong>{{ $age->a_0_5 ?? 0 }}</strong></li>
                <li>6–12: <strong>{{ $age->a_6_12 ?? 0 }}</strong></li>
                <li>13–17: <strong>{{ $age->a_13_17 ?? 0 }}</strong></li>
                <li>18–59: <strong>{{ $age->a_18_59 ?? 0 }}</strong></li>
                <li>60+: <strong>{{ $age->a_60p ?? 0 }}</strong></li>
            </ul>
        </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
    <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
      <h3 class="font-bold text-green-700 mb-3">Pendidikan</h3>
      <canvas id="eduChart"></canvas>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
      <h3 class="font-bold text-green-700 mb-3">Agama</h3>
      <canvas id="religChart"></canvas>
    </div>
  </div>

  <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
    <h3 class="font-bold text-green-700 mb-3">10 Pekerjaan Terbanyak</h3>
    <canvas id="workChart"></canvas>
  </div>

</main>

@push('addon-script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const eduData = @json($edu);
    const religData = @json($relig);
    const workTop = @json($workTop);

    function toLabelsVals(obj) {
    const labels = Object.keys(obj || {}).map(k => k ? k.toUpperCase().replace('_',' ') : 'N/A');
    const values = Object.values(obj || {});
    return {labels, values};
    }

    const e = toLabelsVals(eduData);
    new Chart(document.getElementById('eduChart'), {
    type: 'bar',
    data: { labels: e.labels, datasets: [{ label: 'Jumlah', data: e.values }] }
    });

    const r = toLabelsVals(religData);
    new Chart(document.getElementById('religChart'), {
    type: 'doughnut',
    data: { labels: r.labels, datasets: [{ data: r.values }] }
    });

    new Chart(document.getElementById('workChart'), {
    type: 'bar',
    data: {
        labels: (workTop||[]).map(i => i.occupation || 'N/A'),
        datasets: [{ label: 'Jumlah', data: (workTop||[]).map(i => i.c) }]
    }
    });
    </script>
@endpush

@endsection