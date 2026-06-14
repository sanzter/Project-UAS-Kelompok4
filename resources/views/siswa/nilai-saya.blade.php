@extends('layouts.siswa')
@section('page-title', 'Nilai Saya')
@section('siswa-content')

<div class="space-y-8">

    {{-- Ringkasan --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="card-siswa p-6 text-center">
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-2">Rata-rata</p>
            <h4 class="text-4xl font-black {{ $rataRata >= 75 ? 'text-emerald-600' : 'text-rose-500' }}">
                {{ $rataRata ?? '-' }}
            </h4>
        </div>
        <div class="card-siswa p-6 text-center">
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-2">Tertinggi</p>
            <h4 class="text-4xl font-black text-emerald-600">{{ $nilaiTertinggi ?? '-' }}</h4>
        </div>
        <div class="card-siswa p-6 text-center">
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-2">Terendah</p>
            <h4 class="text-4xl font-black text-rose-500">{{ $nilaiTerendah ?? '-' }}</h4>
        </div>
    </div>

    {{-- Tabel Nilai --}}
    <div class="card-siswa overflow-hidden">
        <div class="p-8 border-b border-slate-100">
            <h3 class="text-xl font-bold text-slate-800">Rekap Nilai</h3>
            <p class="text-slate-400 text-sm mt-0.5">Seluruh nilai kamu tercatat di sini</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-8 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Mata Pelajaran</th>
                        <th class="px-8 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Nilai</th>
                        <th class="px-8 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($grades as $grade)
                    <tr class="hover:bg-cyan-50/50 transition">
                        <td class="px-8 py-4 font-medium text-slate-800">{{ $grade->mata_pelajaran }}</td>
                        <td class="px-8 py-4">
                            <span class="px-3 py-1 rounded-full text-sm font-bold
                                {{ $grade->nilai >= 75 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                {{ $grade->nilai }}
                            </span>
                        </td>
                        <td class="px-8 py-4">
                            @if($grade->nilai >= 75)
                                <span class="flex items-center text-emerald-600 text-sm font-medium">
                                    <i class="fas fa-check-circle mr-1.5"></i> Tuntas
                                </span>
                            @else
                                <span class="flex items-center text-rose-500 text-sm font-medium">
                                    <i class="fas fa-exclamation-circle mr-1.5"></i> Belum Tuntas
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-4 text-slate-400 text-sm">{{ $grade->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-12 text-center">
                            <i class="fas fa-inbox text-slate-300 text-3xl mb-3 block"></i>
                            <p class="text-slate-400">Belum ada data nilai.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection