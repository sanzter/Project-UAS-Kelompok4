@extends('layouts.guru')
@section('page-title', 'Jadwal Pelajaran')
@section('guru-content')

<div class="px-6 py-8">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Jadwal Pelajaran</h2>
        <p class="text-gray-500 text-sm mt-1">Jadwal kelas Anda yang telah diatur oleh Administrator.</p>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-md shadow-sm">
        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-indigo-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-sm font-semibold text-indigo-800 uppercase tracking-wider">Hari</th>
                        <th class="px-6 py-4 text-sm font-semibold text-indigo-800 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-4 text-sm font-semibold text-indigo-800 uppercase tracking-wider">Mata Pelajaran</th>
                        <th class="px-6 py-4 text-sm font-semibold text-indigo-800 uppercase tracking-wider">Wali / Guru</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    
                    @forelse ($jadwalGuru as $jadwal)
                    <tr class="hover:bg-gray-50 transition duration-200">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            {{ $jadwal->hari }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold text-indigo-600">
                            {{ $jadwal->mata_pelajaran }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $jadwal->kelas->guru->name ?? 'Belum Ditentukan' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <p class="text-gray-500 font-medium">Jadwal pelajaran belum tersedia.</p>
                                <p class="text-gray-400 text-sm mt-1">Administrator belum mempublikasikan jadwal untuk kelas Anda.</p>
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