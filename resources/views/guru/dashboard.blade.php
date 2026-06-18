@extends('layouts.guru')
@section('page-title', 'Beranda')
@section('guru-content')

<div class="space-y-8">

    {{-- Greeting --}}
    <div class="card-guru p-8 flex items-center justify-between">
        <div>
            <p class="text-emerald-600 font-bold text-sm uppercase tracking-widest mb-1">Selamat Datang</p>
            <h2 class="text-2xl font-black text-slate-800">{{ Auth::user()->name }}</h2>
            <p class="text-slate-400 mt-1 text-sm">Hari ini ada <span class="text-emerald-600 font-bold">{{ $totalKelas }} kelas</span> yang kamu ampu.</p>
        </div>
        <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-2xl flex items-center justify-center text-white font-black text-2xl shadow-lg">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="card-guru p-6">
            <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center mb-4">
                <i class="fas fa-users text-emerald-600"></i>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Siswa</p>
            <h4 class="text-3xl font-black text-slate-800 mt-1">{{ $totalSiswa }}</h4>
        </div>
        <div class="card-guru p-6">
            <div class="w-10 h-10 bg-teal-100 rounded-xl flex items-center justify-center mb-4">
                <i class="fas fa-chart-bar text-teal-600"></i>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Rata-rata Nilai</p>
            <h4 class="text-3xl font-black text-slate-800 mt-1">{{ $rataRata }}</h4>
        </div>
        <div class="card-guru p-6">
            <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center mb-4">
                <i class="fas fa-triangle-exclamation text-amber-600"></i>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Di Bawah KKM</p>
            <h4 class="text-3xl font-black text-slate-800 mt-1">{{ $dibawahKkm }}</h4>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- Aksi Cepat --}}
        <div class="card-guru p-8">
            <h3 class="text-lg font-bold text-slate-800 mb-5">Aksi Cepat</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('guru.input-nilai') }}"
                    class="flex flex-col items-center justify-center p-5 bg-emerald-50 hover:bg-emerald-100 rounded-2xl transition text-center group">
                    <div class="w-12 h-12 bg-emerald-500 group-hover:bg-emerald-600 rounded-xl flex items-center justify-center mb-3 transition">
                        <i class="fas fa-plus text-white text-lg"></i>
                    </div>
                    <span class="text-sm font-bold text-slate-700">Input Nilai</span>
                </a>
                <a href="{{ route('guru.daftar-nilai') }}"
                    class="flex flex-col items-center justify-center p-5 bg-teal-50 hover:bg-teal-100 rounded-2xl transition text-center group">
                    <div class="w-12 h-12 bg-teal-500 group-hover:bg-teal-600 rounded-xl flex items-center justify-center mb-3 transition">
                        <i class="fas fa-table-list text-white text-lg"></i>
                    </div>
                    <span class="text-sm font-bold text-slate-700">Daftar Nilai</span>
                </a>
                <a href="{{ route('guru.kelas') }}"
                    class="flex flex-col items-center justify-center p-5 bg-cyan-50 hover:bg-cyan-100 rounded-2xl transition text-center group">
                    <div class="w-12 h-12 bg-cyan-500 group-hover:bg-cyan-600 rounded-xl flex items-center justify-center mb-3 transition">
                        <i class="fas fa-users-rectangle text-white text-lg"></i>
                    </div>
                    <span class="text-sm font-bold text-slate-700">Kelas Saya</span>
                </a>
                <div class="flex flex-col items-center justify-center p-5 bg-slate-50 rounded-2xl text-center opacity-50 cursor-not-allowed">
                    <div class="w-12 h-12 bg-slate-300 rounded-xl flex items-center justify-center mb-3">
                        <i class="fas fa-file-export text-white text-lg"></i>
                    </div>
                    <span class="text-sm font-bold text-slate-500">Export Nilai</span>
                    <span class="text-xs text-slate-400 mt-0.5">Segera hadir</span>
                </div>
            </div>
        </div>

        {{-- Nilai Terbaru --}}
        <div class="card-guru p-8">
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-lg font-bold text-slate-800">Nilai Terbaru</h3>
                <a href="{{ route('guru.daftar-nilai') }}" class="text-emerald-600 text-sm font-bold hover:underline">
                    Semua →
                </a>
            </div>
            <div class="space-y-3">
                @forelse($nilaiTerbaru as $nilai)
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                    <div>
                        <p class="text-sm font-bold text-slate-800">{{ $nilai->nama_siswa }}</p>
                        <p class="text-xs text-slate-400">{{ $nilai->mata_pelajaran }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-bold
                        {{ $nilai->nilai >= 75 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                        {{ $nilai->nilai }}
                    </span>
                </div>
                @empty
                <p class="text-slate-400 text-sm text-center py-4">Belum ada data nilai.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>

@endsection