@extends('layouts.admin')
@section('page-title', 'Semua Data Nilai')
@section('admin-content')

<div class="card-admin overflow-hidden">
    <div class="p-8 border-b border-slate-100">
        <h3 class="text-xl font-bold text-slate-800">Rekapitulasi Seluruh Nilai</h3>
        <p class="text-slate-400 text-sm mt-0.5">Tampilan *read-only* dari seluruh data nilai yang dimasukkan oleh guru</p>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50">
                    <th class="px-8 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Nama Siswa</th>
                    <th class="px-8 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Mata Pelajaran</th>
                    <th class="px-8 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Nilai Akhir</th>
                    <th class="px-8 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Tanggal Input</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($grades as $grade)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-4 font-bold text-slate-800">{{ $grade->nama_siswa }}</td>
                    <td class="px-8 py-4 text-slate-500 font-medium">{{ $grade->mata_pelajaran }}</td>
                    <td class="px-8 py-4">
                        <span class="px-3 py-1.5 rounded-full text-sm font-bold {{ $grade->nilai >= 75 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                            {{ $grade->nilai }}
                        </span>
                    </td>
                    <td class="px-8 py-4 text-slate-400 text-sm">{{ $grade->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-12 text-center text-slate-400">
                        <i class="fas fa-folder-open text-3xl mb-3 block text-slate-300"></i>
                        Belum ada data nilai yang masuk.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($grades->hasPages())
    <div class="p-6 border-t border-slate-100 bg-slate-50">
        {{ $grades->links() }}
    </div>
    @endif
</div>

@endsection