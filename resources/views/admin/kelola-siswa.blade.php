@extends('layouts.app') @section('content')
<div class="px-6 py-8">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Kelola Data Siswa</h2>
        <p class="text-gray-500 text-sm mt-1">Manajemen akun siswa dan pengaturan penempatan kelas.</p>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-md shadow-sm">
        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-md shadow-sm">
        <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-sm font-semibold text-slate-800 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-sm font-semibold text-slate-800 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-6 py-4 text-sm font-semibold text-slate-800 uppercase tracking-wider">Username</th>
                        <th class="px-6 py-4 text-sm font-semibold text-slate-800 uppercase tracking-wider">Status Kelas</th>
                        <th class="px-6 py-4 text-sm font-semibold text-slate-800 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    
                    @forelse ($siswas as $index => $siswa)
                    <tr class="hover:bg-gray-50 transition duration-200">
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-slate-800">
                            {{ $siswa->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $siswa->username }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if($siswa->kelas_id)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-cyan-100 text-cyan-800">
                                    {{ $siswa->kelas->nama_kelas ?? 'Tergabung' }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800">
                                    Belum Memilih
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($siswa->kelas_id)
                                <form action="{{ route('admin.siswa.reset-kelas', $siswa->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mereset kelas {{ $siswa->name }}? Mereka harus memilih kelas ulang saat login berikutnya.');">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center justify-center px-3 py-1.5 bg-amber-100 text-amber-700 rounded-lg text-xs font-bold hover:bg-amber-200 transition shadow-sm">
                                        <i class="fas fa-history mr-1"></i> Reset Kelas
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-gray-400 italic">Menunggu siswa memilih</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-gray-500 font-medium">Belum ada akun siswa yang terdaftar.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection