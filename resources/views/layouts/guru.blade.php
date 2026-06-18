<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simpsonv Guru — @yield('page-title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .guru-sidebar {
            background: #fff;
            border-right: 1px solid #d1fae5;
        }

        .guru-sidebar-item {
            color: #374151;
            border-radius: 0.75rem;
            padding: 0.85rem 1rem;
            display: flex;
            align-items: center;
            transition: all .2s;
            font-weight: 500;
        }

        .guru-sidebar-item:hover {
            background: #ecfdf5;
            color: #059669;
        }

        .guru-sidebar-item.active {
            background: #d1fae5;
            color: #065f46;
            font-weight: 700;
        }

        .guru-sidebar-item.active i {
            color: #059669;
        }

        .guru-badge {
            background: #059669;
            color: #fff;
            font-size: 0.65rem;
            font-weight: 800;
            padding: 2px 8px;
            border-radius: 99px;
        }

        .card-guru {
            background: #fff;
            border-radius: 1.25rem;
            border: 1px solid #d1fae5;
            box-shadow: 0 1px 4px 0 rgba(5, 150, 105, 0.06);
        }
    </style>
</head>

<body class="bg-emerald-50">
    <div class="min-h-screen flex">

        {{-- SIDEBAR GURU --}}
        <div class="w-72 guru-sidebar shadow-sm flex flex-col z-20 flex-shrink-0">
            <div class="px-8 pt-8 pb-6">
                <div class="flex items-center space-x-3 mb-2">
                    <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center shadow">
                        <i class="fas fa-chalkboard-teacher text-white text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800 tracking-tight">Simpsonv</h2>
                        <span class="guru-badge">GURU</span>
                    </div>
                </div>
                <div class="h-px bg-emerald-100 mt-4"></div>
            </div>

            <nav class="flex-1 px-5 space-y-1">
                <p class="text-emerald-600 text-xs font-black uppercase tracking-widest px-3 mb-3">Menu</p>
                <a href="{{ route('guru.dashboard') }}"
                    class="guru-sidebar-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large mr-3 w-5 text-center text-emerald-400"></i> Beranda
                </a>
                <a href="{{ route('guru.input-nilai') }}"
                    class="guru-sidebar-item {{ request()->routeIs('guru.input-nilai') ? 'active' : '' }}">
                    <i class="fas fa-plus-circle mr-3 w-5 text-center text-emerald-400"></i> Input Nilai
                </a>
                <a href="{{ route('guru.daftar-nilai') }}"
                    class="guru-sidebar-item {{ request()->routeIs('guru.daftar-nilai') ? 'active' : '' }}">
                    <i class="fas fa-table-list mr-3 w-5 text-center text-emerald-400"></i> Daftar Nilai
                </a>
                <a href="{{ route('guru.kelas') }}"
                    class="guru-sidebar-item {{ request()->routeIs('guru.kelas') ? 'active' : '' }}">
                    <i class="fas fa-school mr-3 w-5 text-center text-emerald-400"></i></i> Kelas Saya
                </a>
                <a href="{{ route('guru.jadwal') }}"
                    class="flex flex-col items-center justify-center p-5 bg-cyan-50 hover:bg-cyan-100 rounded-2xl transition text-center group">
                    <div
                        class="w-12 h-12 bg-cyan-500 group-hover:bg-cyan-600 rounded-xl flex items-center justify-center mb-3 transition">
                        <i class="fas fa-calendar-alt text-white text-lg"></i>
                    </div>
                    <span class="text-sm font-bold text-slate-700">Jadwal Mengajar</span>
                </a>
            </nav>

            <div class="p-5">
                <div class="h-px bg-emerald-100 mb-4"></div>
                <div class="flex items-center space-x-3 mb-4 px-2">
                    <div
                        class="w-9 h-9 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-xl flex items-center justify-center font-bold text-white text-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-slate-800 text-sm font-bold truncate">{{ Auth::user()->name }}</p>
                        <p class="text-emerald-500 text-xs">Guru</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center p-3 bg-rose-50 text-rose-400 hover:bg-rose-500 hover:text-white rounded-xl transition font-bold text-sm">
                        <i class="fas fa-power-off mr-2"></i> Keluar
                    </button>
                </form>
            </div>
        </div>

        {{-- MAIN CONTENT --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- HEADER --}}
            <header class="bg-white border-b border-emerald-100 px-10 py-5 flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">@yield('page-title', 'Beranda')</h3>
                    <p class="text-slate-400 text-xs mt-0.5">Portal Pengajar</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 bg-emerald-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-bell text-emerald-600 text-sm"></i>
                    </div>
                    <div
                        class="w-9 h-9 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-xl flex items-center justify-center font-bold text-white text-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            <main class="p-10 flex-1 overflow-y-auto bg-emerald-50">
                @yield('guru-content')
            </main>
        </div>

    </div>
    @stack('scripts')
</body>

</html>
