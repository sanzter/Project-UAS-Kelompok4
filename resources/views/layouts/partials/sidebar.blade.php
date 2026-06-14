<div class="w-72 dark-blue-bg shadow-2xl flex flex-col z-20">
    <div class="logo-container">
        <div class="logo-circle">
            <i class="fas fa-graduation-cap text-white text-2xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-white tracking-tight">Simpebet</h2>
        <div class="h-1 w-8 bg-cyan-400 mt-3 rounded-full opacity-50"></div>
    </div>

    <nav class="flex-1 mt-4 px-6 space-y-2">
        <a href="{{ route('dashboard') }}"
           class="sidebar-item w-full flex items-center p-4 transition {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-th-large mr-4 text-lg"></i>
            <span class="font-medium">Beranda</span>
        </a>
        <a href="{{ route('nilai.create') }}"
           class="sidebar-item w-full flex items-center p-4 transition {{ request()->routeIs('nilai.create') ? 'active' : '' }}">
            <i class="fas fa-plus-circle mr-4 text-lg"></i>
            <span class="font-medium">Input Nilai</span>
        </a>
        <a href="{{ route('nilai.index') }}"
           class="sidebar-item w-full flex items-center p-4 transition {{ request()->routeIs('nilai.index') ? 'active' : '' }}">
            <i class="fas fa-table-list mr-4 text-lg"></i>
            <span class="font-medium">Daftar Nilai</span>
        </a>
        <a href="{{ route('analitik') }}"
           class="sidebar-item w-full flex items-center p-4 transition {{ request()->routeIs('analitik') ? 'active' : '' }}">
            <i class="fas fa-chart-pie mr-4 text-lg"></i>
            <span class="font-medium">Analitik</span>
        </a>
        <a href="{{ route('kelas') }}"
           class="sidebar-item w-full flex items-center p-4 transition {{ request()->routeIs('kelas') ? 'active' : '' }}">
            <i class="fas fa-users-rectangle mr-4 text-lg"></i>
            <span class="font-medium">Kelas</span>
        </a>
    </nav>

    <div class="p-8">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center p-4 bg-rose-500/10 text-rose-400 hover:bg-rose-500 hover:text-white rounded-2xl transition-all font-bold group">
                <i class="fas fa-power-off mr-3"></i> Keluar
            </button>
        </form>
    </div>
</div>