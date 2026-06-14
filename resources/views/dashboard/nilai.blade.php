@extends('layouts.dashboard')
@section('page-title', 'Input Nilai')
@section('dashboard-content')
<div class="max-w-3xl mx-auto card-modern p-10">
    <div class="mb-10">
        <h3 class="text-2xl font-bold text-slate-800">Tambah Data Nilai</h3>
        <p class="text-slate-400 mt-1">Rekam nilai siswa baru ke dalam sistem</p>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-600 text-sm font-medium">
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('nilai.store') }}" class="space-y-8">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-2">
                <label class="block text-sm font-bold text-slate-700">Nama Siswa</label>
                <input type="text" name="nama_siswa" value="{{ old('nama_siswa') }}" required
                    class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-cyan-500 outline-none transition"
                    placeholder="contoh: Budi Santoso">
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-bold text-slate-700">Mata Pelajaran</label>
                <select name="mata_pelajaran" required
                    class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-cyan-500 outline-none transition">
                    <option value="" disabled selected>Pilih Mata Pelajaran</option>
                    <option value="Mathematics">Matematika</option>
                    <option value="Physic">Fisika</option>
                    <option value="Calculus">Kalkulus</option>
                    <option value="Science">Sains</option>
                    <option value="History">Sejarah</option>
                    <option value="English">Bahasa Inggris</option>
                    <option value="Biology">Biologi</option>
                </select>
            </div>
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-bold text-slate-700">Nilai (0-100)</label>
            <input type="number" name="nilai" min="0" max="100" value="{{ old('nilai') }}" required
                class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-cyan-500 outline-none transition"
                placeholder="0">
        </div>
        <button type="submit"
            class="px-10 py-4 bg-cyan-500 text-white rounded-2xl font-bold hover:bg-cyan-600 transition shadow-lg">
            <i class="fas fa-save mr-2"></i> Simpan Data
        </button>
    </form>
</div>
@endsection