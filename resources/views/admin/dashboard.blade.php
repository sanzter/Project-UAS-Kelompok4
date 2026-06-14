@extends('layouts.admin')
@section('page-title', 'Dashboard Admin')
@section('admin-content')

<div class="space-y-8">

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="card-admin p-6">
            <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center mb-4">
                <i class="fas fa-users text-violet-600"></i>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total User</p>
            <h4 class="text-3xl font-black text-slate-800 mt-1">{{ $totalUser }}</h4>
        </div>
        <div class="card-admin p-6">
            <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center mb-4">
                <i class="fas fa-chalkboard-teacher text-emerald-600"></i>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Guru</p>
            <h4 class="text-3xl font-black text-slate-800 mt-1">{{ $totalGuru }}</h4>
        </div>
        <div class="card-admin p-6">
            <div class="w-10 h-10 bg-cyan-100 rounded-xl flex items-center justify-center mb-4">
                <i class="fas fa-user-graduate text-cyan-600"></i>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Siswa</p>
            <h4 class="text-3xl font-black text-slate-800 mt-1">{{ $totalSiswa }}</h4>
        </div>
        <div class="card-admin p-6">
            <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center mb-4">
                <i class="fas fa-chart-line text-amber-600"></i>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Rata-rata Nilai</p>
            <h4 class="text-3xl font-black text-slate-800 mt-1">{{ $rataRata }}</h4>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- User Terbaru --}}
        <div class="card-admin p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-slate-800">User Terbaru</h3>
                <a href="{{ route('admin.kelola-user') }}" class="text-violet-600 text-sm font-bold hover:underline">
                    Lihat Semua →
                </a>
            </div>
            <div class="space-y-3">
                @forelse($userTerbaru as $user)
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 bg-gradient-to-br from-violet-400 to-purple-500 rounded-xl flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">{{ $user->name }}</p>
                            <p class="text-xs text-slate-400">{{ $user->email }}</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold px-2.5 py-1 rounded-full
                        {{ $user->role === 'admin' ? 'bg-violet-100 text-violet-700' :
                          ($user->role === 'guru'  ? 'bg-emerald-100 text-emerald-700' :
                                                     'bg-cyan-100 text-cyan-700') }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
                @empty
                <p class="text-slate-400 text-sm text-center py-4">Belum ada data user.</p>
                @endforelse
            </div>
        </div>

        {{-- Ringkasan Sistem --}}
        <div class="card-admin p-8">
            <h3 class="text-lg font-bold text-slate-800 mb-6">Ringkasan Sistem</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-violet-50 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-database text-violet-500"></i>
                        <span class="text-sm font-medium text-slate-700">Total Data Nilai</span>
                    </div>
                    <span class="font-black text-violet-700">{{ $totalNilai }}</span>
                </div>
                <div class="flex items-center justify-between p-4 bg-emerald-50 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-door-open text-emerald-500"></i>
                        <span class="text-sm font-medium text-slate-700">Total Kelas Aktif</span>
                    </div>
                    <span class="font-black text-emerald-700">{{ $totalKelas }}</span>
                </div>
                <div class="flex items-center justify-between p-4 bg-amber-50 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-book text-amber-500"></i>
                        <span class="text-sm font-medium text-slate-700">Mata Pelajaran</span>
                    </div>
                    <span class="font-black text-amber-700">{{ $totalMapel }}</span>
                </div>
                <div class="flex items-center justify-between p-4 bg-rose-50 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-triangle-exclamation text-rose-500"></i>
                        <span class="text-sm font-medium text-slate-700">Siswa Nilai Di Bawah KKM</span>
                    </div>
                    <span class="font-black text-rose-700">{{ $siswaRendah }}</span>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection