@extends('layouts.admin')
@section('page-title', 'Manajemen Kelas')
@section('admin-content')

    <div class="space-y-8">
        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div class="bg-violet-100 border border-violet-200 text-violet-700 px-6 py-4 rounded-xl flex items-center">
                <i class="fas fa-check-circle mr-3 text-lg"></i>
                <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- FORM TAMBAH KELAS (Kolom Kiri) --}}
            <div class="lg:col-span-1">
                <div class="card-admin p-8 sticky top-8">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-plus text-violet-600"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800">Buat Kelas Baru</h3>
                    </div>

                    <form action="{{ route('admin.store-kelas') }}" method="POST" onsubmit="const btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.classList.add('opacity-50', 'cursor-not-allowed'); btn.innerText = 'Menyimpan...';">
                        @csrf
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Kelas</label>
                                <input type="text" name="nama_kelas" required
                                    class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-violet-500 outline-none transition text-sm"
                                    placeholder="Contoh: XII IPA 1">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Mata Pelajaran</label>
                                <input type="text" name="mata_pelajaran" required
                                    class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-violet-500 outline-none transition text-sm"
                                    placeholder="Contoh: Matematika">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Guru Pengajar</label>
                                <select name="guru_id" required
                                    class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-violet-500 outline-none transition text-sm">
                                    <option value="">-- Pilih Guru --</option>
                                    @foreach ($gurus as $guru)
                                        <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- INPUT JADWAL BARU --}}
                            <hr class="border-slate-200 my-4">

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Hari</label>
                                <select name="hari" required
                                    class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-violet-500 outline-none transition text-sm">
                                    <option value="">-- Pilih Hari --</option>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Jam Mulai</label>
                                    <input type="time" name="jam_mulai" required
                                        class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-violet-500 outline-none transition text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Jam Selesai</label>
                                    <input type="time" name="jam_selesai" required
                                        class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-violet-500 outline-none transition text-sm">
                                </div>
                            </div>
                            {{-- END INPUT JADWAL BARU --}}

                            <button type="submit"
                                class="w-full bg-violet-600 hover:bg-violet-700 text-white font-bold py-3 px-4 rounded-xl transition shadow-lg shadow-violet-500/30 mt-4">
                                Simpan Kelas
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- DAFTAR KELAS (Kolom Kanan) --}}
            <div class="lg:col-span-2">
                <div class="card-admin overflow-hidden">
                    <div class="p-6 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800">Daftar Kelas & Penugasan</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-slate-50">
                                    <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Kelas
                                    </th>
                                    <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Mata
                                        Pelajaran</th>
                                    <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Guru
                                        Pengajar</th>
                                    <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Jadwal
                                    </th>
                                    <th
                                        class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest text-center">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($kelasList as $kelas)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-4 font-bold text-slate-800">{{ $kelas->nama_kelas }}</td>
                                        <td class="px-6 py-4 font-medium text-slate-500">{{ $kelas->mata_pelajaran }}</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-violet-50 text-violet-700">
                                                <i class="fas fa-chalkboard-teacher mr-2"></i>
                                                {{ $kelas->guru ? $kelas->guru->name : 'Belum ditugaskan' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($kelas->jadwal)
                                                <span
                                                    class="block font-bold text-slate-700 text-sm">{{ $kelas->jadwal->hari }}</span>
                                                <span class="text-xs text-slate-500">
                                                    {{ \Carbon\Carbon::parse($kelas->jadwal->jam_mulai)->format('H:i') }} -
                                                    {{ \Carbon\Carbon::parse($kelas->jadwal->jam_selesai)->format('H:i') }}
                                                </span>
                                            @else
                                                <span class="text-xs italic text-slate-400">Belum diatur</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <form action="{{ route('admin.destroy-kelas', $kelas->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus kelas {{ $kelas->nama_kelas }} - {{ $kelas->mata_pelajaran }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-rose-500 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 w-8 h-8 rounded-lg transition flex items-center justify-center mx-auto"
                                                    title="Hapus Kelas">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                            <i class="fas fa-school text-3xl mb-3 block text-slate-300"></i>
                                            Belum ada data kelas yang ditambahkan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
