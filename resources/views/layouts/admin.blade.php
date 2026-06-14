<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simpebet Admin — @yield('page-title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .admin-sidebar { background: linear-gradient(180deg, #1e1b4b 0%, #312e81 100%); }
        .admin-sidebar-item { color: #a5b4fc; border-radius: 0.75rem; padding: 0.85rem 1rem; display: flex; align-items: center; transition: all .2s; font-weight: 500; }
        .admin-sidebar-item:hover { background: rgba(167,139,250,0.15); color: #fff; }
        .admin-sidebar-item.active { background: rgba(167,139,250,0.2); color: #fff; border-left: 3px solid #a78bfa; }
        .admin-badge { background: #7c3aed; color: #fff; font-size: 0.65rem; font-weight: 800; padding: 2px 8px; border-radius: 99px; }
        .card-admin { background: #fff; border-radius: 1.25rem; border: 1px solid #ede9fe; box-shadow: 0 1px 4px 0 rgba(109,40,217,0.06); }
    </style>
</head>
<body class="bg-slate-100">
<div class="min-h-screen flex">

    {{-- SIDEBAR ADMIN --}}
    <div class="w-72 admin-sidebar shadow-2xl flex flex-col z-20 flex-shrink-0">
        <div class="px-8 pt-8 pb-6">
            <div class="flex items-center space-x-3 mb-2">
                <div class="w-10 h-10 bg-violet-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-graduation-cap text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white tracking-tight">Simpebet</h2>
                    <span class="admin-badge">ADMIN</span>
                </div>
            </div>
            <div class="h-px bg-violet-800/50 mt-4"></div>
        </div>

        <nav class="flex-1 px-5 space-y-1">
            <p class="text-violet-400 text-xs font-black uppercase tracking-widest px-3 mb-3">Menu Utama</p>
            <a href="{{ route('admin.dashboard') }}"
               class="admin-sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large mr-3 w-5 text-center"></i> Dashboard
            </a>
            <a href="{{ route('admin.kelola-user') }}"
               class="admin-sidebar-item {{ request()->routeIs('admin.kelola-user') ? 'active' : '' }}">
                <i class="fas fa-users-gear mr-3 w-5 text-center"></i> Kelola User
            </a>
            <a href="{{ route('admin.analitik') }}"
               class="admin-sidebar-item {{ request()->routeIs('admin.analitik') ? 'active' : '' }}">
                <i class="fas fa-chart-pie mr-3 w-5 text-center"></i> Analitik
            </a>
            <a href="{{ route('admin.kelas') }}"
               class="admin-sidebar-item {{ request()->routeIs('admin.kelas') ? 'active' : '' }}">
                <i class="fas fa-school mr-3 w-5 text-center"></i> Data Kelas
            </a>
            <a href="{{ route('admin.nilai') }}"
               class="admin-sidebar-item {{ request()->routeIs('admin.nilai') ? 'active' : '' }}">
                <i class="fas fa-table-list mr-3 w-5 text-center"></i> Semua Nilai
            </a>
        </nav>

        <div class="p-5">
            <div class="h-px bg-violet-800/50 mb-4"></div>
            <div class="flex items-center space-x-3 mb-4 px-2">
                <div class="w-9 h-9 bg-gradient-to-br from-violet-400 to-purple-600 rounded-xl flex items-center justify-center font-bold text-white text-sm">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-white text-sm font-bold truncate">{{ Auth::user()->name }}</p>
                    <p class="text-violet-400 text-xs">Administrator</p>
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
                <h3 class="text-xl font-bold text-slate-800">@yield('page-title', 'Dashboard')</h3>
                <p class="text-slate-400 text-xs mt-0.5">Panel kontrol administrator</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 bg-violet-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-bell text-violet-600 text-sm"></i>
                </div>
                <div class="w-9 h-9 bg-gradient-to-br from-violet-400 to-purple-600 rounded-xl flex items-center justify-center font-bold text-white text-sm">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <main class="p-10 flex-1 overflow-y-auto bg-slate-100">
            @yield('admin-content')
        </main>
    </div>

</div>
@stack('scripts')
</body>
</html>