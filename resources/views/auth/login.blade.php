@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-slate-900 relative">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-cyan-500/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl"></div>
    </div>

    <div class="bg-white/90 backdrop-blur-xl p-10 rounded-3xl shadow-2xl w-full max-w-md relative z-10">
        <div class="text-center mb-10">
            <div class="w-20 h-20 bg-cyan-500 rounded-full mx-auto mb-4 flex items-center justify-center shadow-lg">
                <i class="fas fa-graduation-cap text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-slate-800">Simpebet</h1>
            <p class="text-slate-500 mt-2">Silakan login untuk melanjutkan</p>
        </div>

        @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl text-red-600 text-sm font-medium">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

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
                        autocomplete="username"
                        class="w-full pl-11 pr-6 py-4 bg-slate-100 rounded-2xl focus:ring-2 focus:ring-cyan-500 outline-none transition"
                        placeholder="contoh: budi_santoso">
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">Kata Sandi</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="w-full pl-11 pr-12 py-4 bg-slate-100 rounded-2xl focus:ring-2 focus:ring-cyan-500 outline-none transition"
                        placeholder="Masukkan password"
                        id="password-input">
                    {{-- Toggle show/hide password --}}
                    <button type="button" onclick="togglePassword()"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition">
                        <i class="fas fa-eye" id="eye-icon"></i>
                    </button>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-cyan-500 text-white py-4 rounded-2xl font-bold hover:bg-cyan-600 active:scale-95 transition shadow-lg">
                Masuk
            </button>
        </form>

        <div class="flex items-center my-6">
            <div class="flex-1 h-px bg-slate-200"></div>
            <span class="px-4 text-xs text-slate-400 font-medium">atau</span>
            <div class="flex-1 h-px bg-slate-200"></div>
        </div>

        <p class="text-center text-sm text-slate-500">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-cyan-600 font-bold hover:text-cyan-700 transition">
                Daftar sekarang
            </a>
        </p>
    </div>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password-input');
        const icon  = document.getElementById('eye-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
@endsection