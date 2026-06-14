<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simpebet — @yield('page-title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .siswa-sidebar { background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%); }
        .siswa-sidebar-item { color: #94a3b8; border-radius: 0.75rem; padding: 0.85rem 1rem; display: flex; align-items: center; transition: all .2s; font-weight: 500; }
        .siswa-sidebar-item:hover { background: rgba(6,182,212,0.1); color: #fff; }
        .siswa-sidebar-item.active { background: rgba(6,182,212,0.15); color: #fff; border-left: 3px solid #06b6d4; }
        .siswa-badge { background: #0891b2; color: #fff; font-size: 0.65rem; font-weight: 800; padding: 2px 8px; border-radius: 99px; }
        .card-siswa { background: #fff; border-radius: 1.25rem; border: 1px solid #cffafe; box-shadow: 0 1px 4px 0 rgba(6,182,212,0.06); }
    </style>
</head>
<body class="bg-slate-50">
<div class="min-h-screen flex">

    {{-- SIDEBAR SISWA --}}
    <div class="w-72 siswa-sidebar shadow-2xl flex flex-col z-20 flex-shrink-0">
        <div class="px-8 pt-8 pb-6">
            <div class="flex items-center space-x-3 mb-2">
                <div class="w-10 h-10 bg-cyan-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-graduation-cap text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white tracking-tight">Simpebet</h2>
                    <span class="siswa-badge">SISWA</span>
                </div>
            </div>
            <div class="h-px bg-slate-700 mt-4"></div>
        </div>

        <nav class="flex-1 px-5 space-y-1">
            <p class="text-slate-500 text-xs font-black uppercase tracking-widest px-3 mb-3">Menu</p>
            <a href="{{ route('siswa.dashboard') }}"
               class="siswa-sidebar-item {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home mr-3 w-5 text-center"></i> Beranda
            </a>
            <a href="{{ route('siswa.nilai-saya') }}"
               class="siswa-sidebar-item {{ request()->routeIs('siswa.nilai-saya') ? 'active' : '' }}">
                <i class="fas fa-star mr-3 w-5 text-center"></i> Nilai Saya
            </a>
            <a href="{{ route('siswa.jadwal') }}"
               class="siswa-sidebar-item {{ request()->routeIs('siswa.jadwal') ? 'active' : '' }}">
                <i class="fas fa-calendar-days mr-3 w-5 text-center"></i> Jadwal
            </a>
            <a href="{{ route('siswa.kelas') }}"
               class="siswa-sidebar-item {{ request()->routeIs('siswa.kelas') ? 'active' : '' }}">
                <i class="fas fa-door-open mr-3 w-5 text-center"></i> Kelas Saya
            </a>
        </nav>

        <div class="p-5">
            <div class="h-px bg-slate-700 mb-4"></div>
            <div class="flex items-center space-x-3 mb-4 px-2">
                <div class="w-9 h-9 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-xl flex items-center justify-center font-bold text-white text-sm">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-white text-sm font-bold truncate">{{ Auth::user()->name }}</p>
                    <p class="text-slate-400 text-xs">Siswa</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center p-3 bg-rose-500/10 text-rose-400 hover:bg-rose-500 hover:text-white rounded-xl transition font-bold text-sm">
                    <i class="fas fa-power-off mr-2"></i> Keluar
                </button>
            </form>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col overflow-hidden">
        {{-- HEADER --}}
        <header class="bg-white border-b border-slate-200 px-10 py-5 flex justify-between items-center">
            <div>
                <h3 class="text-xl font-bold text-slate-800">@yield('page-title', 'Beranda')</h3>
                <p class="text-slate-400 text-xs mt-0.5">Portal Siswa</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 bg-cyan-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-bell text-cyan-600 text-sm"></i>
                </div>
                <div class="w-9 h-9 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-xl flex items-center justify-center font-bold text-white text-sm">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <main class="p-10 flex-1 overflow-y-auto bg-slate-50">
            @yield('siswa-content')
        </main>
    </div>

</div>
@stack('scripts')
</body>
</html>