@extends('layouts.dashboard')
@section('page-title', 'Beranda')
@section('dashboard-content')
<div class="space-y-10">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="card-modern p-8">
            <div class="stat-icon-circle bg-cyan-100 text-cyan-600 mb-6">
                <i class="fas fa-user-graduate text-xl"></i>
            </div>
            <p class="text-slate-400 text-sm font-bold uppercase tracking-wider">Total Siswa</p>
            <h4 class="text-4xl font-black text-slate-800 mt-2">{{ $totalSiswa }}</h4>
        </div>
        <div class="card-modern p-8">
            <div class="stat-icon-circle bg-emerald-100 text-emerald-600 mb-6">
                <i class="fas fa-chart-line text-xl"></i>
            </div>
            <p class="text-slate-400 text-sm font-bold uppercase tracking-wider">Rata-rata Nilai</p>
            <h4 class="text-4xl font-black text-slate-800 mt-2">{{ $rataRata }}</h4>
        </div>
        <div class="card-modern p-8">
            <div class="stat-icon-circle bg-amber-100 text-amber-600 mb-6">
                <i class="fas fa-award text-xl"></i>
            </div>
            <p class="text-slate-400 text-sm font-bold uppercase tracking-wider">Nilai Tertinggi</p>
            <h4 class="text-4xl font-black text-slate-800 mt-2">{{ $nilaiTertinggi }}</h4>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <div class="card-modern p-10">
            <h3 class="text-xl font-bold text-slate-800 mb-6">Ikhtisar Akademi</h3>
            <p class="text-slate-500 text-lg mb-8">
                Saat ini mengelola <span class="text-cyan-600 font-bold">{{ $totalSiswa }} siswa</span> di berbagai mata pelajaran.
            </p>
            <div class="flex space-x-4">
                <a href="{{ route('nilai.create') }}"
                   class="flex-1 py-4 bg-slate-900 text-white rounded-2xl font-bold hover:bg-slate-800 transition text-center">
                   Tambah Nilai
                </a>
                <a href="{{ route('nilai.index') }}"
                   class="flex-1 py-4 bg-white border-2 border-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-50 transition text-center">
                   Lihat Data
                </a>
            </div>
        </div>
        <div class="card-modern p-10">
            <h3 class="text-xl font-bold text-slate-800 mb-6">Proyeksi Tahunan</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-5 bg-slate-50 rounded-2xl">
                    <span class="font-bold text-slate-700">Penerimaan Baru</span>
                    <span class="font-black text-emerald-600">+85</span>
                </div>
                <div class="flex items-center justify-between p-5 bg-slate-50 rounded-2xl">
                    <span class="font-bold text-slate-700">Lulus</span>
                    <span class="font-black text-rose-600">-72</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection