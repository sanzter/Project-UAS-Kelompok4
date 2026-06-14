@extends('layouts.dashboard')
@section('page-title', 'Daftar Nilai')
@section('dashboard-content')
<div class="card-modern overflow-hidden">
    <div class="p-8 border-b border-slate-100 flex justify-between items-center">
        <h3 class="text-xl font-bold text-slate-800">Rekam Nilai Siswa</h3>
        <a href="{{ route('nilai.create') }}"
           class="px-6 py-2 bg-cyan-500 text-white rounded-full font-bold hover:bg-cyan-600 transition text-sm">
           + Tambah
        </a>
    </div>

    @if(session('success'))
    <div class="mx-8 mt-4 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-600 text-sm font-medium">
        {{ session('success') }}
    </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50">
                    <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase tracking-widest">Siswa</th>
                    <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase tracking-widest">Mata Pelajaran</th>
                    <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase tracking-widest">Nilai</th>
                    <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($grades as $grade)
                <tr class="hover:bg-cyan-50 transition">
                    <td class="px-8 py-5 font-medium text-slate-800">{{ $grade->nama_siswa }}</td>
                    <td class="px-8 py-5 text-slate-500">{{ $grade->mata_pelajaran }}</td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $grade->nilai >= 75 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                            {{ $grade->nilai }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-right">
                        <form method="POST" action="{{ route('nilai.destroy', $grade->id) }}" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Yakin ingin menghapus data ini?')"
                                class="text-red-500 hover:text-red-700 font-medium">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-12 text-center text-slate-400">Belum ada data nilai.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection