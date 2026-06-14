<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Akses Ditolak | Simpebet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center relative overflow-hidden">

    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-rose-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-violet-500/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 text-center px-6">

        {{-- Icon --}}
        <div class="w-24 h-24 bg-rose-500/10 border border-rose-500/20 rounded-3xl flex items-center justify-center mx-auto mb-8">
            <i class="fas fa-shield-halved text-rose-400 text-4xl"></i>
        </div>

        {{-- Kode Error --}}
        <p class="text-rose-400 text-sm font-black uppercase tracking-widest mb-3">Error 403</p>

        {{-- Judul --}}
        <h1 class="text-4xl font-black text-white mb-4">Akses Ditolak</h1>

        {{-- Pesan --}}
        <p class="text-slate-400 text-lg max-w-md mx-auto mb-10">
            Kamu tidak memiliki izin untuk mengakses halaman ini.
            Silakan login dengan akun yang sesuai.
        </p>

        {{-- Info Role --}}
        @auth
        <div class="inline-flex items-center space-x-2 bg-slate-800 border border-slate-700 rounded-2xl px-5 py-3 mb-8">
            <div class="w-7 h-7 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-lg flex items-center justify-center text-white font-bold text-xs">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <span class="text-slate-300 text-sm">Kamu login sebagai <span class="font-bold text-white">{{ Auth::user()->name }}</span></span>
            <span class="text-xs px-2 py-0.5 rounded-full font-bold
                {{ Auth::user()->role === 'admin' ? 'bg-violet-500/20 text-violet-300' :
                  (Auth::user()->role === 'guru'  ? 'bg-emerald-500/20 text-emerald-300' :
                                                    'bg-cyan-500/20 text-cyan-300') }}">
                {{ ucfirst(Auth::user()->role) }}
            </span>
        </div>
        @endauth

        {{-- Tombol Aksi --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @auth
            <a href="{{ Auth::user()->dashboardRoute() }}"
               class="px-8 py-3.5 bg-cyan-500 hover:bg-cyan-600 text-white rounded-2xl font-bold transition shadow-lg">
                <i class="fas fa-home mr-2"></i> Ke Dashboard Saya
            </a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit"
                    class="w-full px-8 py-3.5 bg-slate-700 hover:bg-slate-600 text-slate-300 rounded-2xl font-bold transition">
                    <i class="fas fa-power-off mr-2"></i> Ganti Akun
                </button>
            </form>
            @else
            <a href="{{ route('login') }}"
               class="px-8 py-3.5 bg-cyan-500 hover:bg-cyan-600 text-white rounded-2xl font-bold transition shadow-lg">
                <i class="fas fa-arrow-right mr-2"></i> Kembali ke Login
            </a>
            @endauth
        </div>

    </div>

</body>
</html>