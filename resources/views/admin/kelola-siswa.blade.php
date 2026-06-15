@extends('layouts.admin') 
@section('page-title', 'Kelola Siswa')
@section('admin-content')
<div class="px-6 py-8">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Kelola Data Siswa</h2>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-sm font-semibold text-slate-800 uppercase">No</th>
                        <th class="px-6 py-4 text-sm font-semibold text-slate-800 uppercase">Nama Lengkap</th>
                        <th class="px-6 py-4 text-sm font-semibold text-slate-800 uppercase">Status Kelas</th>
                        <th class="px-6 py-4 text-sm font-semibold text-slate-800 uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    {{-- Kita looping variabel $siswas di sini --}}
                    @forelse ($siswas as $index => $siswa)
                    <tr class="{{ $siswa->status_keluar ? 'bg-red-50' : '' }}">
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-slate-800">{{ $siswa->name }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($siswa->status_keluar)
                                <span class="text-xs font-bold text-red-600">Mengajukan Keluar</span>
                            @elseif($siswa->kelas_id)
                                <span class="text-xs font-bold text-cyan-600">{{ $siswa->kelas->nama_kelas ?? 'Tergabung' }}</span>
                            @else
                                <span class="text-xs text-gray-400 italic">Belum Memilih</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{-- Tombol muncul hanya jika status_keluar true --}}
                            @if ($siswa->status_keluar)
                                <form action="{{ route('admin.siswa.reset-kelas', $siswa->id) }}" method="POST" onsubmit="return confirm('Setujui permintaan keluar dan reset kelas siswa ini?');">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 bg-green-500 text-white rounded-lg text-xs font-bold hover:bg-green-600">
                                        Setujui & Reset
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada data siswa.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection