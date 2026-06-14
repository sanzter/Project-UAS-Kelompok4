@extends('layouts.guru')
@section('page-title', 'Input Nilai')
@section('guru-content')

<div class="space-y-8">
    {{-- Notifikasi Sukses --}}
    @if(session('success'))
    <div class="bg-emerald-100 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl flex items-center">
        <i class="fas fa-check-circle mr-3 text-lg"></i>
        <span class="font-bold text-sm">{{ session('success') }}</span>
    </div>
    @endif

    <div class="card-guru p-8 max-w-2xl mx-auto">
        <div class="flex items-center space-x-4 mb-8">
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-file-pen text-emerald-600 text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-slate-800">Form Input Nilai</h3>
                <p class="text-slate-400 text-sm mt-0.5">Masukkan data nilai siswa dengan teliti</p>
            </div>
        </div>

        <form action="{{ route('guru.store-nilai') }}" method="POST">
            @csrf
            
            {{-- Pilih Siswa --}}
            <div class="mb-5">
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Siswa</label>
                <select name="nama_siswa" class="w-full p-3.5 bg-slate-50 border border-emerald-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition text-slate-700">
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($siswas as $siswa)
                        <option value="{{ $siswa->name }}" {{ old('nama_siswa') == $siswa->name ? 'selected' : '' }}>
                            {{ $siswa->name }}
                        </option>
                    @endforeach
                </select>
                @error('nama_siswa') <span class="text-rose-500 text-xs mt-1 block font-medium"><i class="fas fa-circle-exclamation mr-1"></i>{{ $message }}</span> @enderror
            </div>

            {{-- Mata Pelajaran --}}
            <div class="mb-5">
                <label class="block text-sm font-bold text-slate-700 mb-2">Mata Pelajaran</label>
                <input type="text" name="mata_pelajaran" value="{{ old('mata_pelajaran') }}" class="w-full p-3.5 bg-slate-50 border border-emerald-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition text-slate-700" placeholder="Contoh: Matematika">
                @error('mata_pelajaran') <span class="text-rose-500 text-xs mt-1 block font-medium"><i class="fas fa-circle-exclamation mr-1"></i>{{ $message }}</span> @enderror
            </div>

            {{-- Nilai --}}
            <div class="mb-8">
                <label class="block text-sm font-bold text-slate-700 mb-2">Nilai Akhir (0 - 100)</label>
                <input type="number" name="nilai" min="0" max="100" value="{{ old('nilai') }}" class="w-full p-3.5 bg-slate-50 border border-emerald-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition text-slate-700" placeholder="Contoh: 85">
                @error('nilai') <span class="text-rose-500 text-xs mt-1 block font-medium"><i class="fas fa-circle-exclamation mr-1"></i>{{ $message }}</span> @enderror
            </div>

            {{-- Tombol Submit --}}
            <button type="submit" class="w-full bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-bold py-3.5 px-4 rounded-xl transition shadow-lg shadow-emerald-500/30 flex justify-center items-center">
                <i class="fas fa-save mr-2"></i> Simpan Nilai
            </button>
        </form>
    </div>
</div>

@endsection