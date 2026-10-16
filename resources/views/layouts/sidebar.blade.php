<style>
    /* Scroll menu sidebar tanpa menampilkan scrollbar */
    .sidebar-scroll {
        overflow-y: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
        overscroll-behavior: contain;
        touch-action: pan-y;
    }

    .sidebar-scroll::-webkit-scrollbar {
        display: none;
    }
</style>

{{-- ================= SIDEBAR ================= --}}
<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-40 w-64 h-screen bg-slate-900 text-white transform -translate-x-full transition-transform duration-300 ease-in-out md:relative md:translate-x-0 flex flex-col shadow-2xl overflow-hidden">
    <div class="flex-1 min-h-0 flex flex-col">
        <div class="flex items-center gap-3 px-6 py-8 border-b border-slate-700/50">
            <div class="relative group">
                <div
                    class="absolute -inset-1 bg-gradient-to-r from-red-600 to-orange-600 rounded-full blur opacity-25 group-hover:opacity-75 transition duration-200">
                </div>
                <img src="{{ asset('img/logojossgandos.png') }}" alt="Logo"
                    class="relative w-10 h-10 object-contain" />
            </div>

            <div>
                <h1 class="font-bold text-lg tracking-wide leading-none">
                    Resto Joss Gandos
                </h1>
                <span class="text-xs text-slate-400 font-medium tracking-wider uppercase">Dashboard Admin</span>
            </div>
        </div>

        <nav id="sidebarNav" tabindex="0" class="sidebar-scroll flex-1 min-h-0 mt-8 px-4 pb-4 space-y-2 outline-none">
            {{-- OVERVIEW --}}
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-4 py-3.5 text-sm font-medium rounded-xl
        {{ request()->routeIs('dashboard')
            ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30'
            : 'text-slate-400 hover:text-white hover:bg-slate-800' }}
        transition-all group">
                <i
                    class="uil uil-apps text-xl
            {{ request()->routeIs('dashboard') ? '' : 'group-hover:text-indigo-400' }}
            transition-colors"></i>

                <span>Overview</span>
            </a>

            {{-- STATISTIK --}}
            <a href="{{ route('statistik') }}"
                class="flex items-center gap-3 px-4 py-3.5 text-sm font-medium rounded-xl
        {{ request()->routeIs('statistik')
            ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30'
            : 'text-slate-400 hover:text-white hover:bg-slate-800' }}
        transition-all group">
                <i
                    class="uil uil-chart-line text-xl
            {{ request()->routeIs('statistik') ? '' : 'group-hover:text-indigo-400' }}
            transition-colors"></i>

                <span>Statistik</span>
            </a>

            {{-- KELOLA HOME --}}
            <a href="{{ route('dashboard.home') }}"
                class="flex items-center gap-3 px-4 py-3.5 text-sm font-medium rounded-xl
    {{ request()->routeIs('dashboard.home')
        ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30'
        : 'text-slate-400 hover:text-white hover:bg-slate-800' }}
    transition-all group">
                <i
                    class="uil uil-estate text-xl
        {{ request()->routeIs('dashboard.home') ? '' : 'group-hover:text-indigo-400' }}
        transition-colors"></i>

                <span>Kelola Home</span>
            </a>

            {{-- ABOUT --}}
            <a href="{{ route('dashboard.about') }}"
                class="flex items-center gap-3 px-4 py-3.5 text-sm font-medium rounded-xl
        {{ request()->routeIs('dashboard.about')
            ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30'
            : 'text-slate-400 hover:text-white hover:bg-slate-800' }}
        transition-all group">
                <i
                    class="uil uil-info-circle text-xl
            {{ request()->routeIs('dashboard.about') ? '' : 'group-hover:text-indigo-400' }}
            transition-colors"></i>

                <span>Kelola About</span>
            </a>

            {{-- ================= KELOLA MENU ================= --}}
            @php
                $menuNavOpen =
                    request()->routeIs('menu.index') ||
                    request()->routeIs('menu-preview.index') ||
                    request()->routeIs('admin.promotions.*') ||
                    request()->routeIs('service-packages.*');
            @endphp

            <div>
                <button type="button" onclick="toggleMenuNav()"
                    class="flex items-center justify-between w-full px-4 py-3.5 text-sm font-medium rounded-xl
                    {{ $menuNavOpen
                        ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30'
                        : 'text-slate-400 hover:text-white hover:bg-slate-800' }}
                    transition-all group">
                    <div class="flex items-center gap-3">
                        <i
                            class="uil uil-utensils text-xl
                            {{ $menuNavOpen ? '' : 'group-hover:text-indigo-400' }}
                            transition-colors"></i>

                        <span>Kelola Menu</span>
                    </div>

                    <i id="menuNavArrow"
                        class="uil uil-angle-down text-lg transition-transform duration-300
                        {{ $menuNavOpen ? 'rotate-180' : '' }}"></i>
                </button>

                {{-- SUBMENU MENU --}}
                <div id="menuNavChildren" class="{{ $menuNavOpen ? '' : 'hidden' }} mt-1 ml-4 space-y-1">
                    {{-- KELOLA MENU --}}
                    <a href="{{ route('menu.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-lg
                        {{ request()->routeIs('menu.index')
                            ? 'bg-slate-800 text-white'
                            : 'text-slate-400 hover:text-white hover:bg-slate-800' }}
                        transition-all">
                        <i class="uil uil-utensils-alt text-base"></i>
                        <span>Kelola Menu</span>
                    </a>

                    {{-- KELOLA PREVIEW --}}
                    <a href="{{ route('menu-preview.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-lg
                        {{ request()->routeIs('menu-preview.index')
                            ? 'bg-slate-800 text-white'
                            : 'text-slate-400 hover:text-white hover:bg-slate-800' }}
                        transition-all">
                        <i class="uil uil-images text-base"></i>
                        <span>Kelola Preview</span>
                    </a>

                    {{-- KELOLA PROMOSI --}}
                    <a href="{{ route('admin.promotions.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-lg
                        {{ request()->routeIs('admin.promotions.*')
                            ? 'bg-slate-800 text-white'
                            : 'text-slate-400 hover:text-white hover:bg-slate-800' }}
                        transition-all">
                        <i class="uil uil-megaphone text-base"></i>
                        <span>Kelola Promosi</span>
                    </a>

                    {{-- KELOLA PACKAGE --}}
                    <a href="{{ route('service-packages.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-lg
                        {{ request()->routeIs('service-packages.*')
                            ? 'bg-slate-800 text-white'
                            : 'text-slate-400 hover:text-white hover:bg-slate-800' }}
                        transition-all">
                        <i class="uil uil-package text-base"></i>
                        <span>Kelola Package</span>
                    </a>
                </div>
            </div>

            {{-- GALLERY --}}
            <a href="{{ route('gallery.index') }}"
                class="flex items-center gap-3 px-4 py-3.5 text-sm font-medium rounded-xl
    {{ request()->routeIs('gallery.index')
        ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30'
        : 'text-slate-400 hover:text-white hover:bg-slate-800' }}
    transition-all group">
                <i
                    class="uil uil-image text-xl
        {{ request()->routeIs('gallery.index') ? '' : 'group-hover:text-indigo-400' }}
        transition-colors"></i>

                <span>Kelola Gallery</span>
            </a>

            {{-- RESERVATION --}}
            <a href="{{ route('reservation.index') }}"
                class="flex items-center gap-3 px-4 py-3.5 text-sm font-medium rounded-xl
    {{ request()->routeIs('reservation.index')
        ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30'
        : 'text-slate-400 hover:text-white hover:bg-slate-800' }}
    transition-all group">
                <i
                    class="uil uil-calendar-alt text-xl
        {{ request()->routeIs('reservation.index') ? '' : 'group-hover:text-indigo-400' }}
        transition-colors"></i>

                <span>Kelola Reservation</span>
            </a>
        </nav>
    </div>

    <div class="p-4 border-t border-slate-700/50">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="flex items-center justify-center gap-2 w-full px-4 py-3 text-sm font-medium text-red-400 bg-slate-800/50 hover:bg-red-500/10 hover:text-red-500 rounded-xl transition-all border border-transparent hover:border-red-500/20">
                <i class="uil uil-sign-out-alt text-lg"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>

{{-- OVERLAY MOBILE --}}
<div id="sidebar-overlay" class="fixed inset-0 z-30 hidden bg-slate-900/50 md:hidden" onclick="closeSidebar()"></div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("sidebar-overlay");

        if (!sidebar) return;

        if (sidebar.classList.contains("-translate-x-full")) {
            // BUKA SIDEBAR
            sidebar.classList.remove("-translate-x-full");

            if (overlay) {
                overlay.classList.remove("hidden");
            }
        } else {
            // TUTUP SIDEBAR
            closeSidebar();
        }
    }

    function closeSidebar() {
        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("sidebar-overlay");

        if (!sidebar) return;

        sidebar.classList.add("-translate-x-full");

        if (overlay) {
            overlay.classList.add("hidden");
        }
    }

    function toggleMenuNav() {
        const children = document.getElementById("menuNavChildren");
        const arrow = document.getElementById("menuNavArrow");

        if (!children || !arrow) return;

        children.classList.toggle("hidden");
        arrow.classList.toggle("rotate-180");
    }

    const sidebarNav = document.getElementById("sidebarNav");

    if (sidebarNav) {
        sidebarNav.addEventListener("keydown", function(event) {
            if (event.key === "ArrowDown") {
                event.preventDefault();

                this.scrollBy({
                    top: 70,
                    behavior: "smooth",
                });
            }

            if (event.key === "ArrowUp") {
                event.preventDefault();

                this.scrollBy({
                    top: -70,
                    behavior: "smooth",
                });
            }
        });
    }
</script>
