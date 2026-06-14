@extends('layouts.admin')
@section('page-title', 'Tambah Akun Guru')
@section('admin-content')

<div class="max-w-2xl mx-auto">

    {{-- Breadcrumb --}}
    <div class="flex items-center space-x-2 text-sm text-slate-400 mb-6">
        <a href="{{ route('admin.kelola-user') }}" class="hover:text-violet-600 transition font-medium">Kelola User</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-slate-600 font-semibold">Tambah Akun Guru</span>
    </div>

    <div class="card-admin p-10">

        <div class="flex items-center space-x-4 mb-8">
            <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center">
                <i class="fas fa-chalkboard-teacher text-emerald-600 text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-slate-800">Buat Akun Guru</h3>
                <p class="text-slate-400 text-sm mt-0.5">Akun ini hanya bisa dibuat oleh Administrator</p>
            </div>
        </div>

        @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl text-red-600 text-sm font-medium">
            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-600 text-sm font-medium">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('admin.store-guru') }}" class="space-y-6">
            @csrf

            {{-- Role dikunci ke guru --}}
            <input type="hidden" name="role" value="guru">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama Lengkap --}}
                <div class="space-y-2 md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700">Nama Lengkap</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full pl-11 pr-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-violet-500 outline-none transition"
                            placeholder="contoh: Budi Santoso">
                    </div>
                </div>

                {{-- Username --}}
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700">Username</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <i class="fas fa-at"></i>
                        </span>
                        <input type="text" name="username" value="{{ old('username') }}" required
                            class="w-full pl-11 pr-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-violet-500 outline-none transition"
                            placeholder="contoh: budi.santoso"
                            oninput="this.value = this.value.toLowerCase().replace(/[^a-z0-9._]/g, '')">
                    </div>
                    <p class="text-xs text-slate-400">Huruf kecil, angka, titik, underscore.</p>
                </div>

                {{-- Password --}}
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700">Password</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="text" name="password" value="{{ old('password') }}" required
                            class="w-full pl-11 pr-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-violet-500 outline-none transition"
                            placeholder="Minimal 8 karakter">
                    </div>
                    <p class="text-xs text-slate-400">Password akan langsung terlihat agar mudah dicatat.</p>
                </div>
            </div>

            {{-- Info Box --}}
            <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl flex items-start space-x-3">
                <i class="fas fa-triangle-exclamation text-amber-500 mt-0.5 flex-shrink-0"></i>
                <div>
                    <p class="text-sm font-bold text-amber-700">Informasi Penting</p>
                    <p class="text-xs text-amber-600 mt-0.5">
                        Catat username dan password ini sebelum disimpan, lalu berikan langsung ke guru yang bersangkutan.
                        Guru tidak bisa mendaftar sendiri.
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-4 pt-2">
                <button type="submit"
                    class="px-8 py-4 bg-violet-600 text-white rounded-2xl font-bold hover:bg-violet-700 active:scale-95 transition shadow-lg">
                    <i class="fas fa-user-plus mr-2"></i> Buat Akun Guru
                </button>
                <a href="{{ route('admin.kelola-user') }}"
                    class="px-8 py-4 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection