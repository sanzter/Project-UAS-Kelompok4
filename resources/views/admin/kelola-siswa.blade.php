@extends('layouts.app') @section('content')
    <div class="px-6 py-8">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Kelola Data Siswa</h2>
            <p class="text-gray-500 text-sm mt-1">Manajemen akun siswa dan pengaturan penempatan kelas.</p>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-md shadow-sm">
                <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
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
                            <th class="px-6 py-4 text-sm font-semibold text-slate-800 uppercase tracking-wider">Nama Lengkap
                            </th>
                            <th class="px-6 py-4 text-sm font-semibold text-slate-800 uppercase tracking-wider">Username
                            </th>
                            <th class="px-6 py-4 text-sm font-semibold text-slate-800 uppercase tracking-wider">Status Kelas
                            </th>
                            <th class="px-6 py-4 text-sm font-semibold text-slate-800 uppercase tracking-wider text-center">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">

                        @if ($siswa->status_keluar)
                            <form action="{{ route('admin.siswa.reset-kelas', $siswa->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="px-3 py-1.5 bg-green-500 text-white rounded-lg text-xs font-bold hover:bg-green-600">
                                    Setujui & Reset Kelas
                                </button>
                            </form>
                        @else
                            <span class="text-xs text-gray-400">-</span>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
