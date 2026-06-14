@extends('layouts.guru')
@section('page-title', 'Daftar Nilai')
@section('guru-content')

<div class="space-y-8">
    {{-- Notifikasi --}}
    @if(session('success'))
    <div class="bg-emerald-100 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl flex items-center">
        <i class="fas fa-check-circle mr-3 text-lg"></i>
        <span class="font-bold text-sm">{{ session('success') }}</span>
    </div>
    @endif

    <div class="card-guru overflow-hidden">
        <div class="p-8 border-b border-emerald-50 flex justify-between items-center">
            <div>
                <h3 class="text-xl font-bold text-slate-800">Rekap Semua Nilai</h3>
                <p class="text-slate-400 text-sm mt-0.5">Daftar nilai seluruh siswa yang telah Anda masukkan</p>
            </div>
            <a href="{{ route('guru.input-nilai') }}" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-600 font-bold py-2.5 px-5 rounded-xl transition text-sm flex items-center">
                <i class="fas fa-plus mr-2"></i>Tambah Baru
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-8 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Nama Siswa</th>
                        <th class="px-8 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Mata Pelajaran</th>
                        <th class="px-8 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Nilai</th>
                        <th class="px-8 py-4 text-xs font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-emerald-50">
                    @forelse($grades as $grade)
                    <tr class="hover:bg-emerald-50/50 transition">
                        <td class="px-8 py-4 font-bold text-slate-800">{{ $grade->nama_siswa }}</td>
                        <td class="px-8 py-4 font-medium text-slate-500">{{ $grade->mata_pelajaran }}</td>
                        <td class="px-8 py-4">
                            <span class="px-3 py-1 rounded-full text-sm font-bold {{ $grade->nilai >= 75 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                {{ $grade->nilai }}
                            </span>
                        </td>
                        <td class="px-8 py-4 text-right">
                            <form action="{{ route('guru.destroy-nilai', $grade->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data nilai {{ $grade->nama_siswa }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition flex items-center justify-center">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-12 text-center">
                            <i class="fas fa-box-open text-slate-300 text-4xl mb-3 block"></i>
                            <p class="text-slate-500 font-medium">Belum ada data nilai.</p>
                            <a href="{{ route('guru.input-nilai') }}" class="text-emerald-500 text-sm font-bold mt-2 hover:underline inline-block">Mulai input nilai</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        @if($grades->hasPages())
        <div class="p-6 border-t border-emerald-50 bg-slate-50">
            {{ $grades->links() }}
        </div>
        @endif
    </div>
</div>

@endsection