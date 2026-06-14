@extends('layouts.admin')
@section('page-title', 'Analitik Data')
@section('admin-content')

<div class="space-y-8">
    <div class="card-admin p-8">
        <h3 class="text-xl font-bold text-slate-800 mb-6">Grafik Nilai Terbaru</h3>
        <div class="h-80">
            <canvas id="gradeChart"></canvas>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="card-admin p-8 lg:col-span-2">
            <h3 class="text-lg font-bold mb-6 text-slate-800">Distribusi Mata Pelajaran</h3>
            <div class="space-y-3">
                @forelse($distribusi as $subject => $count)
                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
                    <span class="text-sm font-bold text-slate-700">{{ $subject }}</span>
                    <span class="bg-violet-100 text-violet-700 text-xs font-bold px-3 py-1.5 rounded-full">{{ $count }} Entri</span>
                </div>
                @empty
                <p class="text-slate-400 text-sm">Belum ada data untuk dianalisis.</p>
                @endforelse
            </div>
        </div>
        
        <div class="space-y-6">
            <div class="p-6 bg-violet-50 rounded-2xl border border-violet-100">
                <p class="text-xs font-black text-violet-600 uppercase tracking-widest mb-1">Mapel Terbanyak</p>
                <p class="text-slate-800 font-black text-2xl mt-2">{{ $topSubject }}</p>
            </div>
            <div class="p-6 bg-emerald-50 rounded-2xl border border-emerald-100">
                <p class="text-xs font-black text-emerald-600 uppercase tracking-widest mb-1">Total Data Masuk</p>
                <p class="text-slate-800 font-black text-2xl mt-2">{{ $totalGrades }} Rekam Jejak</p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const grades = @json($gradesData);
    if(grades.length > 0) {
        const ctx = document.getElementById('gradeChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: grades.map(g => g.nama_siswa),
                datasets: [{
                    label: 'Nilai Siswa',
                    data: grades.map(g => g.nilai),
                    backgroundColor: '#8b5cf6', // Warna violet Tailwind
                    borderRadius: 6
                }]
            },
            options: { 
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });
    }
});
</script>

@endsection