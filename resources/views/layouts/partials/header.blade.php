<header class="bg-white border-b border-slate-200 p-6 flex justify-between items-center px-10">
    <div>
        <h3 class="text-2xl font-bold text-slate-800">@yield('page-title', 'Beranda')</h3>
        <p class="text-slate-400 text-sm font-medium">Memantau performa akademik</p>
    </div>
    <div class="flex items-center space-x-6">

        {{-- User Dropdown --}}
        <div class="relative" id="user-menu-wrapper">
            <button
                id="user-menu-btn"
                onclick="toggleUserMenu()"
                class="flex items-center space-x-3 pl-6 border-l border-slate-200 focus:outline-none group cursor-pointer"
            >
                <div class="text-right">
                    <p class="text-sm font-bold text-slate-800 group-hover:text-cyan-600 transition">
                        Halo, {{ Auth::user()->name }}
                    </p>
                    <p class="text-xs text-slate-400 mt-1">Administrator</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-2xl flex items-center justify-center font-bold text-white shadow-lg">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <i class="fas fa-chevron-down text-slate-400 text-xs transition-transform duration-200" id="chevron-icon"></i>
            </button>

            {{-- Dropdown Panel --}}
            <div
                id="user-dropdown"
                class="hidden absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-xl border border-slate-100 z-50 overflow-hidden"
            >
                {{-- Account Info --}}
                <div class="px-5 py-4 bg-slate-50 border-b border-slate-100">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-xl flex items-center justify-center font-bold text-white text-sm flex-shrink-0">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-400 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>

                {{-- Menu Items --}}
                <div class="p-2">
                    <div class="px-3 py-2 text-xs font-black text-slate-400 uppercase tracking-widest">Akun</div>

                    <a href="#" class="flex items-center px-3 py-2.5 rounded-xl text-slate-700 hover:bg-slate-50 transition text-sm font-medium">
                        <i class="fas fa-user mr-3 text-slate-400 w-4"></i>
                        Profil Saya
                    </a>
                    <a href="#" class="flex items-center px-3 py-2.5 rounded-xl text-slate-700 hover:bg-slate-50 transition text-sm font-medium">
                        <i class="fas fa-gear mr-3 text-slate-400 w-4"></i>
                        Pengaturan
                    </a>

                    <div class="my-2 border-t border-slate-100"></div>

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center px-3 py-2.5 rounded-xl text-rose-500 hover:bg-rose-50 transition text-sm font-bold">
                            <i class="fas fa-power-off mr-3 w-4"></i>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
        {{-- End User Dropdown --}}

    </div>
</header>

<script>
    function toggleUserMenu() {
        const dropdown = document.getElementById('user-dropdown');
        const chevron  = document.getElementById('chevron-icon');
        const isHidden = dropdown.classList.contains('hidden');

        dropdown.classList.toggle('hidden', !isHidden);
        chevron.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
    }

    // Tutup dropdown saat klik di luar area
    document.addEventListener('click', function(event) {
        const wrapper  = document.getElementById('user-menu-wrapper');
        const dropdown = document.getElementById('user-dropdown');
        const chevron  = document.getElementById('chevron-icon');

        if (wrapper && !wrapper.contains(event.target)) {
            dropdown.classList.add('hidden');
            chevron.style.transform = 'rotate(0deg)';
        }
    });
</script>