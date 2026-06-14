@extends('layouts.guru')
@section('page-title', 'Kelas Saya')
@section('guru-content')

<div class="flex items-center justify-center min-h-[60vh]">
    <div class="card-guru p-10 max-w-lg w-full text-center">
        <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-users-rectangle text-emerald-600 text-4xl"></i>
        </div>
        <h2 class="text-2xl font-black text-slate-800 mb-3">Manajemen Kelas</h2>
        <p class="text-slate-500 leading-relaxed mb-8">
            Fitur untuk mengelola kelas dan jadwal mengajar saat ini sedang dalam tahap pengembangan. Silakan pantau terus pembaruan selanjutnya!
        </p>
        <a href="{{ route('guru.dashboard') }}" class="inline-flex items-center px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
    </div>
</div>

@endsection