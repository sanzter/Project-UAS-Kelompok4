@extends('layouts.app') @section('content')
<div class="max-w-2xl mx-auto px-6 py-12">
    
    <div class="text-center mb-10">
        <h2 class="text-3xl font-extrabold text-gray-900">Pilih Kelas Anda</h2>
        <p class="mt-2 text-gray-600">Silakan pilih kelas yang sesuai untuk mendapatkan jadwal pelajaran Anda.</p>
    </div>

    @if(session('warning'))
    <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-md">
        <p class="text-sm text-yellow-700 font-medium">{{ session('warning') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden p-8">
        <form action="{{ route('siswa.simpan-kelas') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label for="kelas_id" class="block text-sm font-semibold text-gray-700 mb-2">Daftar Kelas Tersedia</label>
                <div class="relative">
                    <select name="kelas_id" id="kelas_id" class="block w-full pl-4 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-xl appearance-none bg-gray-50 border" required>
                        <option value="" disabled selected>-- Klik untuk memilih kelas --</option>
                        @foreach ($kelasList as $kelas)
                            <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }} (Wali/Guru: {{ $kelas->guru->name ?? 'Belum ada' }})</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                @error('kelas_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-8">
                <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                    Gabung ke Kelas
                </button>
                <p class="mt-3 text-xs text-center text-gray-500">Pilihan kelas bersifat permanen. Pastikan Anda memilih kelas yang benar.</p>
            </div>
        </form>
    </div>
</div>
@endsection