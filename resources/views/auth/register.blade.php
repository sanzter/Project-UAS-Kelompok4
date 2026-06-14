@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-slate-900 relative py-10">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-cyan-500/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl"></div>
    </div>

    <div class="bg-white/90 backdrop-blur-xl p-10 rounded-3xl shadow-2xl w-full max-w-md relative z-10">
        <div class="text-center mb-10">
            <div class="w-20 h-20 bg-cyan-500 rounded-full mx-auto mb-4 flex items-center justify-center shadow-lg">
                <i class="fas fa-user-graduate text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-slate-800">Daftar Siswa</h1>
            <p class="text-slate-500 mt-2">Buat akun untuk mengakses portal siswa</p>
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

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            {{-- Role disembunyikan, fixed ke 'siswa' --}}
            <input type="hidden" name="role" value="siswa">

            {{-- Nama Lengkap --}}
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">Nama Lengkap</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                        <i class="fas fa-user"></i>
                    </span>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full pl-11 pr-6 py-4 bg-slate-100 rounded-2xl focus:ring-2 focus:ring-cyan-500 outline-none transition"
                        placeholder="contoh: Budi Santoso">
                </div>
            </div>

            {{-- Username --}}
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">Username</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                        <i class="fas fa-at"></i>
                    </span>
                    <input
                        type="text"
                        name="username"
                        value="{{ old('username') }}"
                        required
                        class="w-full pl-11 pr-6 py-4 bg-slate-100 rounded-2xl focus:ring-2 focus:ring-cyan-500 outline-none transition"
                        placeholder="contoh: budi_santoso"
                        oninput="previewUsername(this.value)">
                </div>
                <p class="text-xs text-slate-400 pl-1">
                    Huruf, angka, titik <code class="bg-slate-100 px-1 rounded">.</code> dan underscore <code class="bg-slate-100 px-1 rounded">_</code> saja.
                    Akan disimpan sebagai: <span id="username-preview" class="font-bold text-cyan-600">...</span>
                </p>
            </div>

            {{-- Password --}}
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">Kata Sandi</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" name="password" required id="reg-password"
                        class="w-full pl-11 pr-12 py-4 bg-slate-100 rounded-2xl focus:ring-2 focus:ring-cyan-500 outline-none transition"
                        placeholder="Minimal 8 karakter"
                        oninput="checkStrength(this.value)">
                    <button type="button" onclick="togglePassword()"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition">
                        <i class="fas fa-eye" id="eye-icon"></i>
                    </button>
                </div>
                <div class="flex gap-1 mt-1.5">
                    <div class="h-1 flex-1 rounded-full bg-slate-200 transition-all" id="bar1"></div>
                    <div class="h-1 flex-1 rounded-full bg-slate-200 transition-all" id="bar2"></div>
                    <div class="h-1 flex-1 rounded-full bg-slate-200 transition-all" id="bar3"></div>
                    <div class="h-1 flex-1 rounded-full bg-slate-200 transition-all" id="bar4"></div>
                </div>
                <p class="text-xs text-slate-400" id="strength-label"></p>
            </div>

            {{-- Konfirmasi Password --}}
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">Konfirmasi Kata Sandi</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" name="password_confirmation" required
                        class="w-full pl-11 pr-6 py-4 bg-slate-100 rounded-2xl focus:ring-2 focus:ring-cyan-500 outline-none transition"
                        placeholder="Ulangi kata sandi">
                </div>
            </div>

            <button type="submit"
                class="w-full bg-cyan-500 text-white py-4 rounded-2xl font-bold hover:bg-cyan-600 active:scale-95 transition shadow-lg">
                Daftar Sekarang
            </button>
        </form>

        <div class="flex items-center my-6">
            <div class="flex-1 h-px bg-slate-200"></div>
            <span class="px-4 text-xs text-slate-400 font-medium">atau</span>
            <div class="flex-1 h-px bg-slate-200"></div>
        </div>

        <p class="text-center text-sm text-slate-500">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-cyan-600 font-bold hover:text-cyan-700 transition">
                Masuk di sini
            </a>
        </p>

        {{-- Info untuk guru --}}
        <div class="mt-6 p-4 bg-slate-50 border border-slate-200 rounded-2xl">
            <p class="text-xs text-slate-500 text-center">
                <i class="fas fa-info-circle text-slate-400 mr-1"></i>
                Guru & Admin? Hubungi administrator sekolah untuk mendapatkan akun.
            </p>
        </div>
    </div>
</div>

<script>
    function previewUsername(val) {
        const clean = val.toLowerCase().replace(/[^a-z0-9._]/g, '');
        document.getElementById('username-preview').textContent = clean || '...';
    }

    function togglePassword() {
        const input = document.getElementById('reg-password');
        const icon  = document.getElementById('eye-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    function checkStrength(val) {
        let score = 0;
        if (val.length >= 8)           score++;
        if (/[A-Z]/.test(val))         score++;
        if (/[0-9]/.test(val))         score++;
        if (/[^a-zA-Z0-9]/.test(val))  score++;

        const colors   = ['bg-rose-400', 'bg-amber-400', 'bg-yellow-400', 'bg-emerald-400'];
        const labels   = ['', 'Lemah', 'Cukup', 'Kuat', 'Sangat Kuat'];
        const txtColor = ['', 'text-rose-500', 'text-amber-500', 'text-yellow-500', 'text-emerald-500'];

        for (let i = 1; i <= 4; i++) {
            const bar = document.getElementById('bar' + i);
            bar.className = 'h-1 flex-1 rounded-full transition-all ' +
                (i <= score ? colors[score - 1] : 'bg-slate-200');
        }

        const label = document.getElementById('strength-label');
        label.textContent = val.length > 0 ? 'Kekuatan: ' + labels[score] : '';
        label.className   = 'text-xs ' + (val.length > 0 ? txtColor[score] : 'text-slate-400');
    }
</script>
@endsection