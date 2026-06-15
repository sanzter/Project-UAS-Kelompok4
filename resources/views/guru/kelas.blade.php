@extends('layouts.app') @section('content')
<div class="px-6 py-8">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Kelas Saya</h2>
        <p class="text-gray-500 text-sm mt-1">Daftar kelas dan mata pelajaran yang Anda ampu.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-emerald-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-sm font-semibold text-emerald-800 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-sm font-semibold text-emerald-800 uppercase tracking-wider">Nama Kelas</th>
                        <th class="px-6 py-4 text-sm font-semibold text-emerald-800 uppercase tracking-wider">Mata Pelajaran</th>
                        <th class="px-6 py-4 text-sm font-semibold text-emerald-800 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    
                    @forelse ($kelasSaya as $index => $kelas)
                    <tr class="hover:bg-gray-50 transition duration-200">
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            {{ $kelas->nama_kelas }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $kelas->mata_pelajaran }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('guru.input-nilai') }}" class="inline-flex items-center justify-center px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold hover:bg-emerald-200 transition">
                                Input Nilai
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                </div>
                                <p class="text-gray-500 font-medium">Belum ada kelas yang ditugaskan kepada Anda.</p>
                                <p class="text-gray-400 text-sm mt-1">Silakan hubungi Administrator.</p>
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