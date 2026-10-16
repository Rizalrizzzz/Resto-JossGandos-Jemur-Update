<x-layout>
    <style>
        main::-webkit-scrollbar {
            display: none;
        }

        main {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .testimonialSwiper .swiper-wrapper {
            align-items: stretch;
        }

        .testimonialSwiper .swiper-slide {
            height: auto;
            display: flex;
        }

        .testimonialSwiper .swiper-slide>div {
            width: 100%;
        }
    </style>

    <main class="pt-20 min-h-screen bg-white relative w-full overflow-x-hidden">
        {{-- ================= WELCOME ================= --}}
        <section id="features"
            class="relative z-10 pt-12 pb-16 bg-white fade-section opacity-0 translate-y-10 transition-all duration-1000 overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    {{-- =====================================================
                 KIRI
            ====================================================== --}}
                    <div class="min-w-0 w-full max-w-full overflow-hidden">
                        {{-- BADGE --}}
                        <span class="uppercase tracking-[4px] text-red-600 font-bold text-sm">
                            {{ $settings?->welcome_badge ?? 'Selamat Datang Di' }}
                        </span>

                        {{-- JUDUL --}}
                        @php
                            $welcomeTitle = trim($settings?->welcome_title ?? 'Resto Joss Gandos');

                            $welcomeTitleParts = preg_split('/\s+/', $welcomeTitle, 2);

                            $welcomeFirstTitle = $welcomeTitleParts[0] ?? 'Resto';

                            $welcomeGradientTitle = $welcomeTitleParts[1] ?? '';
                        @endphp

                        <h2
                            class="mt-5 text-4xl sm:text-5xl font-serif font-bold leading-tight text-gray-900 break-words">
                            {{ $welcomeFirstTitle }}

                            @if ($welcomeGradientTitle)
                                <span
                                    class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 via-red-500 to-orange-400">
                                    {{ $welcomeGradientTitle }}
                                </span>
                            @endif
                        </h2>

                        {{-- GARIS GRADIENT --}}
                        <div class="flex items-center gap-2 mt-6 mb-8">
                            <span class="w-16 h-1 rounded-full bg-gradient-to-r from-red-600 to-orange-400"></span>

                            <span class="w-6 h-1 rounded-full bg-orange-300"></span>
                        </div>

                        {{-- DESKRIPSI --}}
                        <p
                            class="w-full max-w-full text-gray-600 leading-7 text-base sm:text-lg break-words whitespace-normal">
                            {{ $settings?->welcome_description ?? 'Terima kasih telah memilih Resto Joss Gandos sebagai tujuan kuliner Anda. Kami menghadirkan cita rasa khas Nusantara dengan bahan berkualitas, diolah oleh chef berpengalaman, dan disajikan dengan sepenuh hati.' }}
                        </p>

                        {{-- QUOTE --}}
                        <p class="italic text-red-600 mt-6 text-lg">
                            {{ $settings?->welcome_quote ?? 'Selamat menikmati pengalaman bersantap istimewa.' }}
                        </p>

                        {{-- =================================================
                     WELCOME FEATURE CAROUSEL
                     TANPA BUTTON / DOTS
                ================================================== --}}
                        @if ($welcomeFeatures->count() > 0)
                            <div id="welcomeFeatureCarousel" class="relative mt-12 overflow-hidden">
                                {{-- TRACK --}}
                                <div id="welcomeFeatureTrack"
                                    class="flex gap-6 transition-transform duration-700 ease-in-out will-change-transform">
                                    {{-- ITEM ASLI --}}
                                    @foreach ($welcomeFeatures as $welcomeFeature)
                                        @php
                                            $welcomeIcon = $welcomeFeature->icon;

                                            if (
                                                $welcomeIcon &&
                                                !\Illuminate\Support\Str::startsWith($welcomeIcon, [
                                                    'http://',
                                                    'https://',
                                                ])
                                            ) {
                                                $welcomeIcon = asset('storage/' . ltrim($welcomeIcon, '/'));
                                            }
                                        @endphp

                                        <div
                                            class="welcome-feature-slide flex-none w-[calc((100%-84px)/4)] md:w-[calc((100%-72px)/4)] text-center">
                                            {{-- ICON --}}
                                            <div
                                                class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-gradient-to-br from-red-50 to-orange-50 border border-red-100 flex items-center justify-center mx-auto mb-4 shadow-sm">
                                                @if ($welcomeIcon)
                                                    <img src="{{ $welcomeIcon }}" alt="{{ $welcomeFeature->title }}"
                                                        class="w-8 h-8 object-contain" />
                                                @else
                                                    <i data-lucide="star" class="w-8 h-8 text-red-600 stroke-[1.8]"></i>
                                                @endif
                                            </div>

                                            {{-- JUDUL --}}
                                            <h4 class="font-semibold text-gray-900 text-[14px] leading-tight">
                                                {{ $welcomeFeature->title }}
                                            </h4>

                                            {{-- DESKRIPSI --}}
                                            <p class="text-gray-500 text-sm mt-1">
                                                {{ $welcomeFeature->description }}
                                            </p>
                                        </div>
                                    @endforeach

                                    {{-- DUPLIKASI UNTUK LOOP --}}
                                    @foreach ($welcomeFeatures as $welcomeFeature)
                                        @php
                                            $welcomeIcon = $welcomeFeature->icon;

                                            if (
                                                $welcomeIcon &&
                                                !\Illuminate\Support\Str::startsWith($welcomeIcon, [
                                                    'http://',
                                                    'https://',
                                                ])
                                            ) {
                                                $welcomeIcon = asset('storage/' . ltrim($welcomeIcon, '/'));
                                            }
                                        @endphp

                                        <div
                                            class="welcome-feature-slide flex-none w-[calc((100%-84px)/4)] md:w-[calc((100%-72px)/4)] text-center">
                                            <div
                                                class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-gradient-to-br from-red-50 to-orange-50 border border-red-100 flex items-center justify-center mx-auto mb-4 shadow-sm">
                                                @if ($welcomeIcon)
                                                    <img src="{{ $welcomeIcon }}" alt=""
                                                        class="w-8 h-8 object-contain" />
                                                @else
                                                    <i data-lucide="star" class="w-8 h-8 text-red-600 stroke-[1.8]"></i>
                                                @endif
                                            </div>

                                            <h4 class="font-semibold text-gray-900 text-[14px] leading-tight">
                                                {{ $welcomeFeature->title }}
                                            </h4>

                                            <p class="text-gray-500 text-sm mt-1">
                                                {{ $welcomeFeature->description }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        @endif
                    </div>

                    {{-- =====================================================
                 KANAN - FOTO
            ====================================================== --}}
                    <div class="relative">
                        {{-- Background dekorasi --}}
                        <div
                            class="absolute -inset-6 rounded-[3rem] bg-gradient-to-br from-red-100 via-orange-50 to-yellow-100 blur-2xl opacity-80">
                        </div>

                        {{-- Lingkaran dekorasi --}}
                        <div
                            class="absolute -top-8 -right-8 w-28 h-28 rounded-full bg-gradient-to-br from-red-500/20 to-orange-400/10 blur-xl">
                        </div>

                        <div
                            class="absolute -bottom-8 -left-8 w-32 h-32 rounded-full bg-gradient-to-br from-yellow-400/20 to-red-400/10 blur-xl">
                        </div>

                        {{-- FOTO --}}
                        @php
                            $welcomeImage = $settings?->welcome_image;

                            if (
                                $welcomeImage &&
                                !\Illuminate\Support\Str::startsWith($welcomeImage, ['http://', 'https://'])
                            ) {
                                $welcomeImage = asset('storage/' . ltrim($welcomeImage, '/'));
                            }
                        @endphp

                        <div class="relative rounded-[30px] shadow-[0_25px_70px_rgba(220,38,38,0.16)]">
                            <div class="overflow-hidden rounded-[30px] bg-white">
                                @if ($welcomeImage)
                                    <img src="{{ $welcomeImage }}"
                                        alt="{{ $settings?->welcome_title ?? 'Resto Joss Gandos' }}"
                                        class="w-full h-auto max-h-[520px] object-contain transition-transform duration-700 hover:scale-105" />
                                @else
                                    <img src="{{ asset('img/home/selamatdatang.JPG') }}" alt="Resto Joss Gandos"
                                        class="w-full h-auto max-h-[520px] object-contain transition-transform duration-700 hover:scale-105" />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- =========================================================
     WELCOME FEATURE CAROUSEL SCRIPT
========================================================= --}}
        @if ($welcomeFeatures->count() > 4)
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const track = document.getElementById("welcomeFeatureTrack");

                    const carousel = document.getElementById("welcomeFeatureCarousel");

                    if (!track || !carousel) {
                        return;
                    }

                    const items = track.querySelectorAll(".welcome-feature-slide");

                    const total = {{ $welcomeFeatures->count() }};

                    let currentIndex = 0;

                    function getItemsPerView() {
                        if (window.innerWidth >= 768) {
                            return 4;
                        }

                        return 4;
                    }

                    function moveCarousel() {
                        const itemsPerView = getItemsPerView();

                        const gap = 24;

                        const containerWidth = carousel.offsetWidth;

                        const itemWidth =
                            (containerWidth - gap * (itemsPerView - 1)) / itemsPerView;

                        const moveDistance = itemWidth + gap;

                        currentIndex++;

                        track.style.transform = `translateX(-${currentIndex * moveDistance}px)`;

                        /*
                         * Saat sampai ke akhir item asli,
                         * kita langsung kembali ke awal
                         * tanpa bergerak mundur.
                         */
                        if (currentIndex >= total) {
                            setTimeout(function() {
                                track.style.transition = "none";

                                currentIndex = 0;

                                track.style.transform = "translateX(0)";

                                requestAnimationFrame(function() {
                                    requestAnimationFrame(function() {
                                        track.style.transition = "transform 700ms ease-in-out";
                                    });
                                });
                            }, 750);
                        }
                    }

                    let carouselTimer = setInterval(moveCarousel, 3000);

                    /*
                     * Pause ketika cursor masuk.
                     * Supaya user tetap nyaman.
                     */
                    carousel.addEventListener("mouseenter", function() {
                        clearInterval(carouselTimer);
                    });

                    carousel.addEventListener("mouseleave", function() {
                        carouselTimer = setInterval(moveCarousel, 3000);
                    });

                    /*
                     * Saat resize,
                     * kembali ke posisi awal.
                     */
                    window.addEventListener("resize", function() {
                        currentIndex = 0;

                        track.style.transition = "none";

                        track.style.transform = "translateX(0)";

                        requestAnimationFrame(function() {
                            track.style.transition = "transform 700ms ease-in-out";
                        });
                    });
                });
            </script>
        @endif

        {{-- =========================================================
     KEUNGGULAN / KENAPA MEMILIH KAMI
========================================================= --}}
        <section
            class="relative pt-16 pb-16 overflow-hidden bg-white fade-section opacity-0 translate-y-10 transition-all duration-1000">
            <div class="relative z-10">
                <div class="max-w-7xl mx-auto px-6">
                    {{-- =====================================================
                 HEADER
            ====================================================== --}}
                    <div class="text-center mb-14">
                        <p class="uppercase tracking-[4px] text-red-600 text-sm font-bold">
                            {{ $settings?->feature_badge ?? 'Kenapa Memilih Kami' }}
                        </p>

                        <h2 class="mt-3 text-4xl font-serif font-bold text-gray-900">
                            {{ $settings?->feature_title ?? 'Pengalaman Terbaik Untuk Anda' }}
                        </h2>
                    </div>

                    {{-- =====================================================
                 GRID KEUNGGULAN
                 4 kolom x 2 baris = 8 item pertama terlihat
            ====================================================== --}}
                    @if ($features->count() > 0)
                        <div id="homeFeatureGrid" class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                            @foreach ($features as $index => $feature)
                                @php
                                    $featureIcon = $feature->icon;

                                    if (
                                        $featureIcon &&
                                        !\Illuminate\Support\Str::startsWith($featureIcon, ['http://', 'https://'])
                                    ) {
                                        $featureIcon = asset('storage/' . ltrim($featureIcon, '/'));
                                    }
                                @endphp

                                <div class="home-feature-card
                                   bg-white
                                   rounded-3xl
                                   p-8
                                   shadow
                                   hover:-translate-y-2
                                   transition-all
                                   duration-300

                                   {{ $index >= 8 ? 'hidden' : '' }}"
                                    data-feature-index="{{ $index }}">
                                    {{-- ICON --}}
                                    <div class="w-16 h-16 rounded-2xl bg-red-50 flex items-center justify-center mb-6">
                                        @if ($featureIcon)
                                            <img src="{{ $featureIcon }}" alt="{{ $feature->title }}" loading="lazy"
                                                class="w-8 h-8 object-contain" />
                                        @else
                                            <i data-lucide="star" class="w-8 h-8 text-red-600 stroke-[1.8]"></i>
                                        @endif
                                    </div>

                                    {{-- JUDUL --}}
                                    <h3 class="font-bold text-xl mb-3">
                                        {{ $feature->title }}
                                    </h3>

                                    {{-- DESKRIPSI --}}
                                    <p class="text-gray-600">
                                        {{ $feature->description }}
                                    </p>
                                </div>
                            @endforeach
                        </div>

                        {{-- =================================================
                     TOMBOL BACA SELENGKAPNYA
                     HANYA MUNCUL JIKA > 8
                ================================================== --}}
                        @if ($features->count() > 8)
                            <div class="flex justify-center mt-12">
                                <button type="button" id="toggleHomeFeatures"
                                    class="inline-flex items-center gap-3 px-7 py-3.5 rounded-full bg-red-700 text-white font-semibold shadow-lg hover:bg-red-800 hover:-translate-y-1 transition-all duration-300">
                                    <span id="toggleHomeFeaturesText">
                                        Baca Selengkapnya
                                    </span>

                                    <svg id="toggleHomeFeaturesIcon" class="w-5 h-5 transition-transform duration-300"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </div>
                        @endif
                    @else
                        {{-- TIDAK ADA DATA --}}
                        <div class="text-center py-12">
                            <p class="text-gray-500">Belum ada keunggulan yang tersedia.</p>
                        </div>

                    @endif
                </div>
            </div>
        </section>

        {{-- =========================================================
     SCRIPT SHOW / HIDE KEUNGGULAN
========================================================= --}}
        @if ($features->count() > 8)
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const toggleButton =
                        document.getElementById("toggleHomeFeatures");

                    const toggleText = document.getElementById(
                        "toggleHomeFeaturesText",
                    );

                    const toggleIcon = document.getElementById(
                        "toggleHomeFeaturesIcon",
                    );

                    const cards =
                        document.querySelectorAll(".home-feature-card");

                    if (!toggleButton || !toggleText || !toggleIcon) {
                        return;
                    }

                    let expanded = false;

                    toggleButton.addEventListener("click", function() {
                        expanded = !expanded;

                        cards.forEach(function(card, index) {
                            if (index < 8) {
                                return;
                            }

                            if (expanded) {
                                card.classList.remove("hidden");

                                card.classList.add(
                                    "opacity-0",
                                    "translate-y-3",
                                );

                                requestAnimationFrame(function() {
                                    card.classList.remove(
                                        "opacity-0",
                                        "translate-y-3",
                                    );
                                });
                            } else {
                                card.classList.add(
                                    "opacity-0",
                                    "translate-y-3",
                                );

                                setTimeout(function() {
                                    if (!expanded) {
                                        card.classList.add("hidden");
                                    }
                                }, 200);
                            }
                        });

                        if (expanded) {
                            toggleText.textContent = "Sembunyikan";

                            toggleIcon.style.transform = "rotate(180deg)";
                        } else {
                            toggleText.textContent = "Baca Selengkapnya";

                            toggleIcon.style.transform = "rotate(0deg)";

                            // Scroll sedikit ke posisi section
                            document
                                .getElementById("homeFeatureGrid")
                                ?.scrollIntoView({
                                    behavior: "smooth",
                                    block: "start",
                                });
                        }
                    });
                });
            </script>
        @endif

        {{-- =========================================================
     CTA HIDANGAN FAVORIT
========================================================= --}}

        @php
            // =========================================================
            // DATA MENU
            // =========================================================
            $allMenus = collect($menus)->flatten()->values();

            $latestMenus = $allMenus
                ->sortByDesc(function ($menu) {
                    return $menu->created_at ?? $menu->id;
                })
                ->take(3)
                ->values();

            $totalMenus = $allMenus->count();

            // =========================================================
            // DATA HIDANGAN FAVORIT DARI ADMIN
            // =========================================================

            // Badge
            $dishBadge = $settings?->dish_badge ?? 'Signature';

            // Judul
            $dishTitle = $settings?->dish_title ?? 'Hidangan Favorit Pelanggan';

            // Deskripsi
            $dishDescription =
                $settings?->dish_description ??
                'Aneka hidangan khas Nusantara dengan rasa autentik yang selalu menjadi favorit pelanggan kami.';

            // Gambar
            $dishImage = $settings?->dish_image;

            // Jika path lokal, arahkan ke storage
            if ($dishImage && !\Illuminate\Support\Str::startsWith($dishImage, ['http://', 'https://'])) {
                $dishImage = asset('storage/' . ltrim($dishImage, '/'));
            }
        @endphp

        <section
            class="relative pb-24 bg-white overflow-hidden fade-section opacity-0 translate-y-10 transition-all duration-1000">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="relative overflow-hidden rounded-[2rem] sm:rounded-[2.5rem] bg-neutral-950 shadow-2xl grid lg:grid-cols-2">
                    {{-- =====================================================
                 KIRI
            ====================================================== --}}
                    <div
                        class="relative z-20 flex flex-col justify-center px-6 py-10 sm:px-10 sm:py-12 lg:px-14 lg:py-14">
                        {{-- SHADOW FOTO KHUSUS MOBILE --}}
                        <div class="absolute inset-0 lg:hidden bg-black/55 z-[-1]"></div>
                        {{-- =================================================
                     BADGE
                ================================================== --}}
                        <span class="text-[10px] sm:text-xs uppercase tracking-[0.3em] font-bold text-yellow-400">
                            {{ $dishBadge }}
                        </span>

                        {{-- =================================================
                     JUDUL
                ================================================== --}}
                        <h2
                            class="mt-4 font-serif font-bold text-3xl sm:text-4xl lg:text-5xl leading-[1.05] text-white">
                            {{ $dishTitle }}
                        </h2>

                        {{-- =================================================
                     GARIS
                ================================================== --}}
                        <div class="flex items-center gap-2 mt-5">
                            <span class="w-10 h-1 bg-yellow-400 rounded-full"></span>

                            <span class="w-4 h-1 bg-yellow-400/40 rounded-full"></span>
                        </div>

                        {{-- =================================================
                     DESKRIPSI
                ================================================== --}}
                        <p class="mt-5 max-w-lg text-sm sm:text-base leading-relaxed text-gray-300">
                            {{ $dishDescription }}
                        </p>

                        {{-- =================================================
                     TOMBOL + MENU TERBARU
                ================================================== --}}
                        <div
                            class="mt-7 flex items-center max-w-full overflow-hidden rounded-full border border-yellow-400/70 bg-black/50 backdrop-blur-md p-1.5 shadow-xl">
                            {{-- =========================
                         TOMBOL MENU
                    ========================== --}}
                            <a href="{{ url('/menu') }}"
                                class="inline-flex flex-1 min-w-0 items-center justify-center gap-2 px-4 sm:px-5 py-3 rounded-full bg-yellow-400 text-neutral-950 text-sm font-bold shadow-md hover:bg-yellow-300 hover:-translate-y-0.5 transition-all duration-300 whitespace-nowrap">
                                Lihat Menu Lengkap

                                <i class="uil uil-arrow-right"></i>
                            </a>

                            {{-- =========================
                         3 MENU TERBARU
                    ========================== --}}
                            @if ($latestMenus->count() > 0)
                                <div class="hidden sm:flex items-center gap-1.5 ml-2">
                                    @foreach ($latestMenus as $menu)
                                        @php
                                            $menuImage = trim($menu->image_path ?? '');

                                            if (filter_var($menuImage, FILTER_VALIDATE_URL)) {
                                                $menuImageUrl = $menuImage;
                                            } elseif (\Illuminate\Support\Str::startsWith($menuImage, 'public/')) {
                                                $menuImageUrl = asset(substr($menuImage, 7));
                                            } elseif (\Illuminate\Support\Str::startsWith($menuImage, 'storage/')) {
                                                $menuImageUrl = asset($menuImage);
                                            } elseif (\Illuminate\Support\Str::startsWith($menuImage, 'img/')) {
                                                $menuImageUrl = asset($menuImage);
                                            } else {
                                                $menuImageUrl = asset('storage/' . ltrim($menuImage, '/'));
                                            }
                                        @endphp

                                        <a href="{{ url('/menu') }}" title="{{ $menu->title }}"
                                            class="w-9 h-9 shrink-0 rounded-lg overflow-hidden border border-white/30 shadow-md hover:scale-110 transition-transform duration-300">
                                            <img src="{{ $menuImageUrl }}" alt="{{ $menu->title }}"
                                                class="w-full h-full object-cover" />
                                        </a>
                                    @endforeach

                                    {{-- =========================
                                 JUMLAH MENU
                            ========================== --}}
                                    @if ($totalMenus > 0)
                                        <a href="{{ url('/menu') }}"
                                            class="ml-1 min-w-[48px] shrink-0 text-center text-white text-[10px] sm:text-xs font-bold leading-tight hover:text-yellow-300 transition">
                                            +{{ $totalMenus }}

                                            <span class="block">
                                                Menu<br class="sm:hidden" />
                                                Lainnya
                                            </span>
                                        </a>
                                    @endif
                                </div>

                            @endif
                        </div>
                    </div>

                    {{-- =================================================
     KANAN : GAMBAR
================================================== --}}
                    <div class="absolute inset-0 lg:relative lg:h-[480px] overflow-hidden">
                        @if ($dishImage)
                            <img src="{{ $dishImage }}" alt="{{ $dishTitle }}"
                                class="w-full h-full object-cover transition-transform duration-700 hover:scale-105" />
                        @else
                            <img src="https://cdn.phototourl.com/free/2026-08-06-4bf6f5c6-c6b9-47b2-b215-7ad2c6c9713d.jpg"
                                alt="{{ $dishTitle }}"
                                class="w-full h-auto object-contain transition-transform duration-700 hover:scale-105" />
                        @endif

                        {{-- TRANSISI LEMBUT HITAM → FOTO --}}
                        <div
                            class="absolute inset-0 bg-black/30 lg:bg-gradient-to-r lg:from-neutral-950/25 lg:via-neutral-950/8 lg:to-transparent pointer-events-none z-10">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- =========================================================
     ULASAN PELANGGAN
========================================================= --}}
        <section id="testimonials"
            class="relative z-10 pt-8 pb-10 fade-section opacity-0 translate-y-10 transition-all duration-1000">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                {{-- =====================================================
             HEADER ULASAN
        ====================================================== --}}
                <h2 class="text-4xl md:text-5xl font-serif font-bold text-gray-800 mb-4">
                    @php
                        $testimonialBadge = $settings?->testimonial_badge ?? 'Ulasan Pelanggan';

                        $testimonialTitleParts = preg_split('/\s+/', trim($testimonialBadge), 2);

                        $testimonialFirst = $testimonialTitleParts[0] ?? 'Ulasan';

                        $testimonialSecond = $testimonialTitleParts[1] ?? 'Pelanggan';
                    @endphp

                    {{ $testimonialFirst }}

                    <span class="text-red-700"> {{ $testimonialSecond }} </span>
                </h2>

                {{-- DESKRIPSI --}}
                <p class="text-gray-600 mb-12 max-w-2xl mx-auto">
                    {{ $settings?->testimonial_description ??
                        'Apa kata mereka yang telah merasakan kehangatan dan cita rasa Joss Gandos?' }}
                </p>

                {{-- =====================================================
             SWIPER
        ====================================================== --}}
                @if ($testimonials->count() > 0)
                    <div class="swiper testimonialSwiper pb-12">
                        <div class="swiper-wrapper">
                            @foreach ($testimonials as $testimonial)
                                @php
                                    $testimonialName = trim($testimonial->name);

                                    /*
                                     * Avatar tidak dikelola dari Admin,
                                     * jadi gunakan avatar otomatis berdasarkan nama.
                                     */
                                    $avatarUrl =
                                        'https://api.dicebear.com/9.x/adventurer/svg?seed=' .
                                        urlencode($testimonialName);
                                @endphp

                                <div class="swiper-slide !h-auto flex items-stretch">
                                    <div
                                        class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-lg p-8 text-left hover:shadow-2xl transition-all duration-300 border border-stone-100 min-h-[350px] h-full flex flex-col">
                                        {{-- =================================================
                                     BINTANG
                                ================================================== --}}
                                        <div class="flex text-yellow-400 mb-4 text-lg" aria-label="5 dari 5 bintang">
                                            ★★★★★
                                        </div>

                                        {{-- =================================================
                                     REVIEW DARI ADMIN
                                ================================================== --}}
                                        <p class="text-gray-600 mb-6 italic flex-grow leading-relaxed">
                                            "{{ $testimonial->review }}"</p>

                                        {{-- =================================================
                                     IDENTITAS
                                ================================================== --}}
                                        <div class="flex items-center mt-auto pt-4 border-t border-gray-100">
                                            {{-- AVATAR --}}
                                            <img src="{{ $avatarUrl }}" alt="{{ $testimonialName }}"
                                                class="w-12 h-12 rounded-full mr-4 border-2 border-red-100" />

                                            {{-- NAMA --}}
                                            <div>
                                                <h4 class="font-bold text-gray-900 font-serif">
                                                    {{ $testimonialName }}
                                                </h4>

                                                <p class="text-xs text-red-600 font-semibold uppercase tracking-wider">
                                                    Resto Joss Gandos - Jemursari</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- =================================================
                     PAGINATION
                ================================================== --}}
                        @if ($testimonials->count() > 1)
                            <div class="swiper-pagination mt-8"></div>
                        @endif
                    </div>
                @else
                    {{-- =================================================
                 EMPTY STATE
            ================================================== --}}
                    <div class="py-16 text-center">
                        <div
                            class="mx-auto w-16 h-16 rounded-full bg-red-50 flex items-center justify-center text-red-500 mb-4">
                            <i class="uil uil-comments text-2xl"></i>
                        </div>

                        <p class="text-gray-500">Belum ada ulasan pelanggan.</p>
                    </div>

                @endif

                {{-- =====================================================
             TOMBOL LIHAT GOOGLE
        ====================================================== --}}
                <div class="mt-4">
                    <a href="https://www.google.com/maps/search/?api=1&query=Resto%20Joss%20Gandos%20Jl.%20Raya%20Jemursari%20No.15%20Surabaya"
                        target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center justify-center gap-2 px-8 py-3 text-base font-semibold text-white transition-all duration-300 bg-red-700 rounded-full hover:bg-red-800 hover:shadow-lg hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        {{-- GOOGLE --}}
                        <svg class="w-5 h-5 bg-white rounded-full p-0.5" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M23.52 12.3c0-.85-.08-1.68-.22-2.48H12v4.7h6.46c-.28 1.48-1.12 2.74-2.38 3.58v2.98h3.86c2.26-2.08 3.56-5.14 3.56-8.78z"
                                fill="#4285F4" />

                            <path
                                d="M12 24c3.24 0 5.96-1.07 7.94-2.9l-3.86-2.98c-1.07.72-2.44 1.14-4.08 1.14-3.13 0-5.78-2.12-6.73-4.96H1.27v3.12C3.23 21.32 7.33 24 12 24z"
                                fill="#34A853" />

                            <path
                                d="M5.27 14.3c-.24-.71-.38-1.47-.38-2.26s.14-1.55.38-2.26V6.66H1.27C.46 8.28 0 10.09 1.27 12c.46 1.91-.46 3.72 1.27 5.34l4-3.04z"
                                fill="#FBBC05" />

                            <path
                                d="M12 4.78c1.76 0 3.34.6 4.58 1.79l3.43-3.44C17.96 1.17 15.24 0 12 0 7.33 0 3.23 2.68 1.27 6.66l4 3.04c.95-2.84 3.6-4.96 6.73-4.96z"
                                fill="#EA4335" />
                        </svg>

                        <span> Lihat Ulasan Selengkapnya </span>
                    </a>
                </div>
            </div>
        </section>

        {{-- =========================================================
     CTA RESERVATION
========================================================= --}}

        @php
            // =========================================================
            // DATA CTA DARI ADMIN
            // =========================================================
            $ctaTitle = $settings?->cta_title ?? 'Siap Merasakan Pengalaman Kuliner Terbaik?';

            $ctaDescription =
                $settings?->cta_description ??
                'Reservasi lebih mudah untuk makan bersama, gathering, ulang tahun, meeting, dan acara spesial Anda.';

            $ctaButton1Link = $settings?->cta_button_1_link ?? 'https://lynk.id/jossgandosjemursari';
        @endphp

        <section
            class="relative z-10 px-4 sm:px-6 lg:px-8 pb-20 fade-section opacity-0 translate-y-10 transition-all duration-1000 delay-100">
            <div
                class="relative max-w-7xl mx-auto overflow-hidden rounded-[1.5rem] sm:rounded-[2rem] bg-gradient-to-r from-red-700 via-red-600 to-red-500 shadow-[0_15px_40px_rgba(185,28,28,0.25)]">
                {{-- =====================================================
             DEKORASI
        ====================================================== --}}
                <div class="absolute inset-0 opacity-20 pointer-events-none"
                    style="
                        background-image:
                            radial-gradient(
                                circle at 10% 20%,
                                white 1px,
                                transparent 1px
                            ),
                            radial-gradient(
                                circle at 80% 70%,
                                white 1px,
                                transparent 1px
                            );
                        background-size:
                            28px 28px,
                            36px 36px;
                    ">
                </div>

                <div class="absolute -left-16 -top-16 w-44 h-44 rounded-full border-[18px] border-white/10"></div>

                <div class="absolute -right-20 -bottom-24 w-56 h-56 rounded-full border-[20px] border-white/10"></div>

                {{-- =====================================================
             CONTENT
        ====================================================== --}}
                <div
                    class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8 lg:gap-10 px-6 py-7 sm:px-8 sm:py-8 lg:px-10 lg:py-9">
                    {{-- =================================================
                 KIRI
            ================================================== --}}
                    <div
                        class="flex flex-col items-center gap-3 sm:flex-row sm:items-center sm:gap-5 text-center sm:text-left">
                        {{-- ICON --}}
                        <div
                            class="flex-shrink-0 w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-white/15 border border-white/20 backdrop-blur-md flex items-center justify-center text-white">
                            <i class="uil uil-calendar-alt text-2xl sm:text-3xl"></i>
                        </div>

                        {{-- TEKS --}}
                        <div>
                            @php
                                $ctaWords = preg_split('/\s+/', trim($ctaTitle));

                                $ctaFirst = implode(' ', array_slice($ctaWords, 0, 3));

                                $ctaRest = implode(' ', array_slice($ctaWords, 3));

                                // Fallback kalau input Admin kosong/tidak lengkap
                                if ($ctaFirst === '') {
                                    $ctaFirst = 'Siap Merasakan Pengalaman';
                                }

                                if ($ctaRest === '') {
                                    $ctaRest = 'Kuliner Terbaik?';
                                }
                            @endphp

                            <h2 class="font-serif font-bold text-xl sm:text-2xl lg:text-3xl leading-tight">
                                <span class="text-white">
                                    {{ $ctaFirst }}
                                </span>

                                <span class="text-yellow-300">
                                    {{ $ctaRest }}
                                </span>
                            </h2>

                            <p class="mt-2 text-red-50 text-xs sm:text-sm max-w-xl leading-relaxed">
                                {{ $ctaDescription }}
                            </p>
                        </div>
                    </div>

                    {{-- =================================================
                 KANAN / TOMBOL
            ================================================== --}}
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-3 flex-shrink-0">
                        {{-- =================================================
                     TOMBOL 1 - DARI ADMIN
                ================================================== --}}
                        <a href="{{ $ctaButton1Link }}" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center justify-center min-w-[170px] px-5 py-3 rounded-full bg-white text-red-700 text-sm font-bold shadow-lg hover:bg-red-50 hover:-translate-y-1 transition-all duration-300">
                            <i class="uil uil-shopping-bag text-lg mr-2"></i>

                            Pesan Sekarang
                        </a>

                        {{-- =================================================
                     TOMBOL 2 - WHATSAPP
                     Tetap memakai yang sekarang
                ================================================== --}}
                        <a href="{{ url('/reservation') }}"
                            class="inline-flex items-center justify-center min-w-[180px] px-6 py-3 rounded-full bg-yellow-400 text-red-900 text-sm font-bold shadow-lg hover:bg-yellow-300 hover:-translate-y-1 transition-all duration-300">
                            <i class="uil uil-calendar-alt text-lg mr-2"></i>

                            Reservasi Sekarang

                            <i class="uil uil-arrow-right text-base ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        var swiper = new Swiper(".testimonialSwiper", {
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            slidesPerView: 1,
            spaceBetween: 30,
            breakpoints: {
                768: {
                    slidesPerView: 2,
                    spaceBetween: 40,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 40,
                },
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
                dynamicBullets: true,
            },
        });

        // Fade In Animation
        document.addEventListener("DOMContentLoaded", () => {
            const sections = document.querySelectorAll(".fade-section");

            const observer = new IntersectionObserver(
                (entries, obs) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            entry.target.classList.remove(
                                "opacity-0",
                                "translate-y-10",
                            );
                            entry.target.classList.add(
                                "opacity-100",
                                "translate-y-0",
                            );
                            obs.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.15,
                },
            );

            sections.forEach((section) => {
                observer.observe(section);
            });
        });
    </script>

    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        lucide.createIcons();
    </script>

    {{-- ================= PROMO HOME POPUP ================= --}}
    @if ($homePopup)
        @php
            $homePopupImage = $homePopup->image_path;

            if ($homePopupImage && !\Illuminate\Support\Str::startsWith($homePopupImage, ['http://', 'https://'])) {
                $homePopupImage = asset('storage/' . ltrim($homePopupImage, '/'));
            }
        @endphp

        <div id="homePromoPopup"
            style="
                display: none;
                position: fixed;
                inset: 0;
                z-index: 999999;
                align-items: center;
                justify-content: center;
                padding: 12px;
                background: rgba(0, 0, 0, 0.68);
                backdrop-filter: blur(3px);
            "
            onclick="closeHomePromo(event)">
            {{-- ================= POPUP PORTRAIT ================= --}}
            <div style="
                    position: relative;
                    width: min(430px, 88vw);
                    aspect-ratio: 430 / 620;
                    max-height: 82vh;
                    overflow: hidden;
                    border-radius: 24px;
                    background: transparent;
                    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.45);
                "
                onclick="event.stopPropagation()">
                {{-- ================= GAMBAR PROMO ================= --}}
                <a href="{{ route('menu.front') }}"
                    style="
        display: block;
        width: 100%;
        height: 100%;
        line-height: 0;
    ">
                    <img src="{{ $homePopupImage }}" alt="Promo Resto Joss Gandos"
                        style="
            display: block;
            width: 100%;
            height: 100%;
            object-fit: fill;
            object-position: center;
            border-radius: 24px;
        " />
                </a>

                {{-- ================= TOMBOL X ================= --}}
                <button type="button" onclick="closeHomePromo()" aria-label="Tutup promo"
                    style="
                        position: absolute;
                        top: 12px;
                        right: 12px;
                        z-index: 20;
                        width: 42px;
                        height: 42px;
                        border: none;
                        border-radius: 50%;
                        background: rgba(80, 80, 80, 0.88);
                        color: #ffffff;
                        font-size: 28px;
                        line-height: 42px;
                        padding: 0;
                        text-align: center;
                        cursor: pointer;
                        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.35);
                    ">
                    &times;
                </button>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const popup = document.getElementById("homePromoPopup");

                if (!popup) {
                    return;
                }

                // Pindahkan popup ke body agar tidak terpengaruh
                // oleh transform/animasi dari main Home.
                document.body.appendChild(popup);

                // Tampilkan popup.
                popup.style.display = "flex";

                // Kunci scroll ketika popup terbuka.
                document.documentElement.style.overflow = "hidden";
                document.body.style.overflow = "hidden";
            });

            function closeHomePromo(event) {
                // Klik area gelap di luar popup = tutup.
                if (event && event.target.id !== "homePromoPopup") {
                    return;
                }

                const popup = document.getElementById("homePromoPopup");

                if (popup) {
                    popup.style.display = "none";
                }

                // Kembalikan scroll halaman.
                document.documentElement.style.overflow = "";
                document.body.style.overflow = "";
            }
        </script>
    @endif
</x-layout>
