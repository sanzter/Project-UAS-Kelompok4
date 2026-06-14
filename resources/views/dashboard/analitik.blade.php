@extends('layouts.dashboard')
@section('page-title', 'Analitik Performa')
@section('dashboard-content')
<div class="space-y-10">
    <div class="card-modern p-10">
        <h3 class="text-xl font-bold text-slate-800 mb-8">Grafik Nilai Siswa</h3>
        <div class="h-96">
            <canvas id="gradeChart"></canvas>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <div class="card-modern p-8 lg:col-span-2">
            <h3 class="text-lg font-bold mb-6 text-slate-800">Distribusi Mata Pelajaran</h3>
            <div class="space-y-3">
                @forelse($distribusi as $subject => $count)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <span class="text-sm font-medium text-gray-700">{{ $subject }}</span>
                    <span class="bg-cyan-100 text-cyan-700 text-xs font-bold px-2 py-1 rounded-full">{{ $count }} Entri</span>
                </div>
                @empty
                <p class="text-gray-400 text-sm">Belum ada data untuk dianalisis.</p>
                @endforelse
            </div>
        </div>
        <div class="card-modern p-8">
            <h3 class="text-lg font-bold mb-6 text-slate-800">Wawasan Kunci</h3>
            <div class="space-y-4">
                <div class="p-5 bg-emerald-50 rounded-2xl">
                    <p class="text-xs font-black text-emerald-600 uppercase tracking-widest mb-1">Mapel Terbanyak</p>
                    <p class="text-slate-800 font-bold">{{ $topSubject }}</p>
                </div>
                <div class="p-5 bg-blue-50 rounded-2xl">
                    <p class="text-xs font-black text-blue-600 uppercase tracking-widest mb-1">Total Data</p>
                    <p class="text-slate-800 font-bold">{{ $totalGrades }} rekam data</p>
                </div>
                <div class="p-5 bg-purple-50 rounded-2xl">
                    <p class="text-xs font-black text-purple-600 uppercase tracking-widest mb-1">Status</p>
                    <p class="text-slate-800 font-bold">{{ $statusAkademik }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const grades = @json($gradesData);
const ctx = document.getElementById('gradeChart').getContext('2d');
if (grades.length > 0) {
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: grades.map(g => g.nama_siswa),
            datasets: [{ label: 'Nilai', data: grades.map(g => g.nilai), backgroundColor: '#06b6d4', borderRadius: 8 }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, max: 100 } } }
    });
}
</script>
@endpush