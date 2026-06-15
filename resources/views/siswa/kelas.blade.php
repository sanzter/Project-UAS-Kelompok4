@extends('layouts.siswa')
@section('page-title', 'Informasi Kelas')
@section('siswa-content')

<div class="px-6 py-8">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">{{ $kelas->nama_kelas }}</h2>
        <p class="text-gray-500 text-sm">Informasi detail mengenai kelas Anda.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-4">Wali Kelas</h3>
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center font-bold text-indigo-600">
                        {{ substr($kelas->guru->name ?? 'G', 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">{{ $kelas->guru->name ?? 'Belum ada guru' }}</p>
                        <p class="text-xs text-gray-500">Guru Pengampu</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-4">Daftar Teman Sekelas ({{ $kelas->siswa->count() }} Siswa)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($kelas->siswa as $teman)
                    <div class="p-3 bg-gray-50 rounded-lg text-sm text-gray-700 border border-gray-100">
                        {{ $teman->name }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection