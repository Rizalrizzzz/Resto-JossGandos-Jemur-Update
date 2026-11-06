<nav id="navbar"
    class="fixed top-0 left-0 w-full z-50 bg-gradient-to-r from-[#fffdf8] via-[#fff8ec] to-[#f8ead8] shadow-lg opacity-0 -translate-y-5 transition-all duration-700">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <!-- Logo + Nama -->
            <a href="/">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('img/logojossgandos.png') }}" alt="Resto Joss Gandos"
                        class="h-12 w-auto transform transition-transform duration-500" />
                    <span
                        class="text-xl font-bold bg-gradient-to-l from-red-900 to-orange-600 bg-clip-text text-transparent">
                        Resto Joss Gandos
                    </span>
                </div>
            </a>

            <!-- Menu Navigasi (Desktop) -->
            <div class="hidden md:flex items-center space-x-3">
                <x-nav-link href="/"
                    class="relative after:absolute after:left-0 after:bottom-0 after:w-0 after:h-[2px] after:bg-red-600 after:transition-all hover:after:w-full">Home</x-nav-link>
                <x-nav-link href="/about"
                    class="relative after:absolute after:left-0 after:bottom-0 after:w-0 after:h-[2px] after:bg-red-600 after:transition-all hover:after:w-full">About</x-nav-link>
                <x-nav-link href="/menu"
                    class="relative after:absolute after:left-0 after:bottom-0 after:w-0 after:h-[2px] after:bg-red-600 after:transition-all hover:after:w-full">Menu</x-nav-link>
                <x-nav-link href="/gallery"
                    class="relative after:absolute after:left-0 after:bottom-0 after:w-0 after:h-[2px] after:bg-red-600 after:transition-all hover:after:w-full">Gallery</x-nav-link>
                <x-nav-link href="/reservation"
                    class="relative after:absolute after:left-0 after:bottom-0 after:w-0 after:h-[2px] after:bg-red-600 after:transition-all hover:after:w-full">Reservation</x-nav-link>
            </div>

            <!-- Tombol Mobile -->
            <div class="md:hidden flex items-center space-x-3">
                <button id="mobile-menu-btn" class="text-black hover:text-red-400 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Menu Navigasi Mobile -->
        <div id="mobile-menu"
            class="md:hidden mt-0 rounded-lg shadow p-0 overflow-hidden max-h-0 opacity-0 scale-95 pointer-events-none transition-all duration-300 ease-in-out">
            <x-nav-link href="/" class="block">Home</x-nav-link>
            <x-nav-link href="/about" class="block">About</x-nav-link>
            <x-nav-link href="/menu" class="block">Menu</x-nav-link>
            <x-nav-link href="/gallery" class="block">Gallery</x-nav-link>
            <x-nav-link href="/reservation" class="block">Reservation</x-nav-link>
        </div>
    </div>

    <script>
        // Navbar animasi muncul saat load
        window.addEventListener("load", () => {
            document
                .getElementById("navbar")
                .classList.remove("opacity-0", "-translate-y-5");
        });

        const menu = document.getElementById("mobile-menu");

        const menuButton = document.getElementById("mobile-menu-btn");

        menuButton.addEventListener("click", function(e) {
            e.stopPropagation();

            const isOpen = menu.classList.contains("max-h-96");

            if (isOpen) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });

        function openMobileMenu() {
            menu.classList.remove(
                "max-h-0",
                "opacity-0",
                "scale-95",
                "pointer-events-none",
                "p-0",
            );

            menu.classList.add(
                "max-h-96",
                "opacity-100",
                "scale-100",
                "pointer-events-auto",
                "p-4",
                "mt-2",
            );
        }

        function closeMobileMenu() {
            menu.classList.remove(
                "max-h-96",
                "opacity-100",
                "scale-100",
                "pointer-events-auto",
                "p-4",
                "mt-2",
            );

            menu.classList.add(
                "max-h-0",
                "opacity-0",
                "scale-95",
                "pointer-events-none",
                "p-0",
                "mt-0",
            );
        }

        // Tutup menu jika klik di luar navbar
        document.addEventListener("click", function(e) {
            const navbar = document.getElementById("navbar");

            if (
                menu.classList.contains("max-h-96") &&
                !navbar.contains(e.target)
            ) {
                closeMobileMenu();
            }
        });

        // Tutup menu saat link menu diklik
        menu.querySelectorAll("a").forEach(function(link) {
            link.addEventListener("click", function() {
                closeMobileMenu();
            });
        });
    </script>
</nav>
