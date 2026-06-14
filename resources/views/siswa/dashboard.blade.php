@extends('layouts.siswa')
@section('page-title', 'Beranda')
@section('siswa-content')

<div class="space-y-8">

    {{-- Hero Greeting --}}
    <div class="card-siswa p-8 relative overflow-hidden">
        <div class="absolute -top-8 -right-8 w-36 h-36 bg-cyan-100 rounded-full opacity-50"></div>
        <div class="absolute -bottom-8 -right-20 w-48 h-48 bg-blue-100 rounded-full opacity-30"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-cyan-600 font-bold text-sm uppercase tracking-widest mb-1">Halo 👋</p>
                <h2 class="text-2xl font-black text-slate-800">{{ Auth::user()->name }}</h2>
                <p class="text-slate-400 mt-1 text-sm">
                    Kamu terdaftar di <span class="text-cyan-600 font-bold">{{ $namaKelas }}</span>
                </p>
            </div>
            <div class="w-16 h-16 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-2xl flex items-center justify-center text-white font-black text-2xl shadow-lg">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="card-siswa p-6">
            <div class="w-10 h-10 bg-cyan-100 rounded-xl flex items-center justify-center mb-4">
                <i class="fas fa-star text-cyan-600"></i>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Rata-rata Nilai</p>
            <h4 class="text-3xl font-black text-slate-800 mt-1">{{ $rataRata ?? '-' }}</h4>
        </div>
        <div class="card-siswa p-6">
            <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center mb-4">
                <i class="fas fa-trophy text-emerald-600"></i>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Nilai Tertinggi</p>
            <h4 class="text-3xl font-black text-slate-800 mt-1">{{ $nilaiTertinggi ?? '-' }}</h4>
        </div>
        <div class="card-siswa p-6">
            <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center mb-4">
                <i class="fas fa-book-open text-violet-600"></i>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Mata Pelajaran</p>
            <h4 class="text-3xl font-black text-slate-800 mt-1">{{ $totalMapel ?? '-' }}</h4>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- Nilai Per Mata Pelajaran --}}
        <div class="card-siswa p-8">
            <h3 class="text-lg font-bold text-slate-800 mb-5">Nilai Per Mata Pelajaran</h3>
            <div class="space-y-3">
                @forelse($nilaiPerMapel as $item)
                <div class="flex items-center justify-between p-3.5 bg-slate-50 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-cyan-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-book text-cyan-600 text-xs"></i>
                        </div>
                        <span class="text-sm font-medium text-slate-700">{{ $item->mata_pelajaran }}</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-24 bg-slate-200 rounded-full h-1.5">
                            <div class="h-1.5 rounded-full {{ $item->nilai >= 75 ? 'bg-emerald-400' : 'bg-rose-400' }}"
                                 style="width: {{ $item->nilai }}%"></div>
                        </div>
                        <span class="text-sm font-bold w-8 text-right
                            {{ $item->nilai >= 75 ? 'text-emerald-600' : 'text-rose-500' }}">
                            {{ $item->nilai }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <i class="fas fa-inbox text-slate-300 text-3xl mb-3"></i>
                    <p class="text-slate-400 text-sm">Belum ada data nilai.</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Status Akademik --}}
        <div class="card-siswa p-8">
            <h3 class="text-lg font-bold text-slate-800 mb-5">Status Akademik</h3>
            <div class="space-y-4">
                <div class="p-5 rounded-2xl {{ $rataRata >= 75 ? 'bg-emerald-50' : 'bg-amber-50' }}">
                    <p class="text-xs font-black uppercase tracking-widest mb-1
                        {{ $rataRata >= 75 ? 'text-emerald-600' : 'text-amber-600' }}">Status Kelulusan</p>
                    <p class="text-slate-800 font-bold text-lg">
                        {{ $rataRata >= 75 ? '✅ Di Atas KKM' : '⚠️ Perlu Peningkatan' }}
                    </p>
                </div>
                <div class="p-5 bg-cyan-50 rounded-2xl">
                    <p class="text-xs font-black text-cyan-600 uppercase tracking-widest mb-1">Kelas</p>
                    <p class="text-slate-800 font-bold">{{ $namaKelas ?? '-' }}</p>
                </div>
                <div class="p-5 bg-slate-50 rounded-2xl">
                    <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-1">Nilai Minimum</p>
                    <p class="text-slate-800 font-bold">{{ $nilaiMinimum ?? '-' }}</p>
                </div>
            </div>

            <a href="{{ route('siswa.nilai-saya') }}"
               class="mt-6 w-full flex items-center justify-center py-3.5 bg-cyan-500 hover:bg-cyan-600 text-white rounded-xl font-bold transition text-sm">
                <i class="fas fa-chart-line mr-2"></i> Lihat Detail Nilai
            </a>
        </div>

    </div>
</div>

@endsection