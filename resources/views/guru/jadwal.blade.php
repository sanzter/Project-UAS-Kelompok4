@extends('layouts.guru')
@section('page-title', 'Jadwal Mengajar')
@section('guru-content')

<div class="px-6 py-8">
    {{-- Header Halaman --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800">Jadwal Mengajar Anda</h2>
        <p class="text-slate-500 text-sm mt-1">Daftar kelas dan waktu mengajar yang telah ditetapkan oleh Administrator.</p>
    </div>

    {{-- Tabel Jadwal --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-emerald-50 border-b border-emerald-100">
                        <th class="px-6 py-4 text-xs font-black text-emerald-700 uppercase tracking-widest">Hari</th>
                        <th class="px-6 py-4 text-xs font-black text-emerald-700 uppercase tracking-widest">Waktu</th>
                        <th class="px-6 py-4 text-xs font-black text-emerald-700 uppercase tracking-widest">Kelas</th>
                        <th class="px-6 py-4 text-xs font-black text-emerald-700 uppercase tracking-widest">Mata Pelajaran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    {{-- Melakukan perulangan data dari $jadwalGuru --}}
                    @forelse($jadwalGuru as $jadwal)
                    <tr class="hover:bg-slate-50 transition">
                        
                        {{-- Kolom Hari --}}
                        <td class="px-6 py-4 font-bold text-slate-800">
                            {{ $jadwal->hari }}
                        </td>
                        
                        {{-- Kolom Waktu --}}
                        <td class="px-6 py-4 text-sm text-slate-600">
                            <span class="inline-flex items-center bg-slate-100 text-slate-600 py-1 px-3 rounded-lg font-medium">
                                <i class="far fa-clock mr-2 text-slate-400"></i>
                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                            </span>
                        </td>
                        
                        {{-- Kolom Kelas --}}
                        <td class="px-6 py-4 font-bold text-emerald-600 text-lg">
                            {{ $jadwal->kelas->nama_kelas ?? 'Kelas Dihapus' }}
                        </td>
                        
                        {{-- Kolom Mata Pelajaran --}}
                        <td class="px-6 py-4 font-bold text-slate-600">
                            {{ $jadwal->mata_pelajaran }}
                        </td>
                        
                    </tr>
                    @empty
                    {{-- Tampilan jika jadwal kosong --}}
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 mb-4">
                                <i class="fas fa-calendar-times text-2xl text-slate-300"></i>
                            </div>
                            <h3 class="text-slate-500 font-bold">Belum ada jadwal</h3>
                            <p class="text-sm text-slate-400 mt-1">Anda belum ditugaskan untuk mengajar kelas manapun saat ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection