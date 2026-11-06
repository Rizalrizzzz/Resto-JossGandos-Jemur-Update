<x-layout>
    @php
        // Semua gambar konten harus berasal dari aset lokal/storage.
        // URL eksternal, data URI, dan blob URI tidak diteruskan sebagai sumber gambar.
        $resolveLocalImage = function ($value) {
            if (!is_string($value) || trim($value) === '') {
                return null;
            }

            $path = trim($value);

            if (preg_match('/^(?:https?:)?\/\//i', $path) || preg_match('/^(?:data|blob):/i', $path)) {
                return null;
            }

            $path = ltrim($path, '/');

            if (str_starts_with($path, 'public/storage/')) {
                $path = substr($path, 7);
            }

            if (str_starts_with($path, 'storage/')) {
                return asset($path);
            }

            if (str_starts_with($path, 'public/')) {
                return asset(substr($path, 7));
            }

            if (str_starts_with($path, 'img/')) {
                return asset($path);
            }

            return asset('storage/' . $path);
        };
    @endphp

    <style>
        @media (max-width: 639px) {
            #priceFilterMenu {
                left: 0 !important;
                right: auto !important;
                width: 220px !important;
                max-width: calc(100vw - 80px) !important;
            }
        }

        /* Hide Scrollbar */
        main::-webkit-scrollbar {
            display: none;
        }

        main {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Hide horizontal scrollbar Promo */
        .promotion-carousel {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .promotion-carousel::-webkit-scrollbar {
            display: none;
        }

        .text-shadow-strong {
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
    </style>

    {{-- ================= HEADER MENU ================= --}}
    <section class="relative z-10 pt-6 pb-8 fade-section opacity-0 translate-y-10 transition-all duration-1000">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="relative min-h-[420px] sm:min-h-[480px] lg:min-h-[520px] overflow-hidden rounded-[1.5rem] sm:rounded-[2rem] shadow-[0_12px_30px_rgba(0,0,0,0.16)]">
                {{-- BACKGROUND IMAGE --}}
                @php
                    $heroImageUrl = $resolveLocalImage($menuSetting?->hero_image);
                @endphp
                @if ($heroImageUrl)
                    <img src="{{ $heroImageUrl }}" alt="{{ $menuSetting->hero_title ?? 'Menu Resto Joss Gandos' }}"
                        class="absolute inset-0 w-full h-full object-cover" />
                @else
                    {{-- BACKGROUND DEFAULT TANPA URL GAMBAR EKSTERNAL --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-red-950 via-neutral-800 to-amber-900"></div>
                @endif

                {{-- OVERLAY --}}
                <div class="absolute inset-0 bg-black/50"></div>

                {{-- KONTEN HEADER --}}
                <div class="relative z-10 min-h-[420px] sm:min-h-[480px] lg:min-h-[520px] flex items-start">
                    <div class="max-w-3xl px-6 pt-16 pb-10 sm:px-10 sm:pt-20 lg:px-16 lg:pt-24 text-white">
                        {{-- BADGE --}}
                        @if (!empty($menuSetting?->hero_badge))
                            <span
                                class="inline-flex items-center px-4 py-2 rounded-full bg-black/30 border border-yellow-400/40 backdrop-blur-sm text-yellow-300 text-sm font-semibold tracking-widest uppercase mb-6">
                                {{ $menuSetting->hero_badge }}
                            </span>
                        @endif

                        {{-- TITLE --}}
                        <h1
                            class="text-4xl sm:text-5xl lg:text-6xl font-serif font-bold leading-[1.05] max-w-4xl text-white drop-shadow-lg">
                            @php
                                $title = $menuSetting->hero_title ?? 'Cita Rasa Autentik Resto Joss Gandos';

                                $words = preg_split('/\s+/', trim($title));

                                if (count($words) >= 3) {
                                    $mainTitle = implode(' ', array_slice($words, 0, -3));
                                    $accentTitle = implode(' ', array_slice($words, -3));
                                } else {
                                    $mainTitle = $title;
                                    $accentTitle = '';
                                }
                            @endphp

                            {{ $mainTitle }}

                            @if ($accentTitle)
                                <span
                                    class="bg-gradient-to-r from-red-500 via-red-400 to-yellow-400 bg-clip-text text-transparent">
                                    {{ $accentTitle }}
                                </span>
                            @endif
                        </h1>

                        {{-- DESKRIPSI --}}
                        @if (!empty($menuSetting?->hero_description))
                            <p
                                class="mt-6 max-w-2xl text-base sm:text-lg lg:text-xl text-white/90 leading-relaxed drop-shadow-md">
                                {{ $menuSetting->hero_description }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    @php
        $localPromotions = collect($promotions)
            ->map(function ($promotion) use ($resolveLocalImage) {
                return [
                    'promotion' => $promotion,
                    'image' => $resolveLocalImage($promotion->image_path ?? ''),
                ];
            })
            ->filter(fn($item) => !empty($item['image']))
            ->values();
    @endphp

    {{-- ================= PROMO BULAN INI ================= --}}
    @if ($localPromotions->count())
        <section
            class="relative z-10 pb-12 fade-section opacity-0 translate-y-10 transition-all duration-1000 delay-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- JUDUL PROMO --}}
                <div class="text-center mb-9 sm:mb-10">
                    {{-- DEKORASI ATAS --}}
                    <div class="flex items-center justify-center gap-3 sm:gap-5 mb-4">
                        {{-- GARIS KIRI --}}
                        <div class="flex items-center gap-2">
                            <span class="w-10 sm:w-16 h-px bg-gradient-to-r from-transparent to-yellow-500"></span>

                            <span class="text-yellow-500 text-xs"> ◆ </span>
                        </div>

                        {{-- ICON --}}
                        <div
                            class="relative w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-gradient-to-br from-red-600 to-red-500 border-4 border-yellow-400 shadow-[0_6px_18px_rgba(220,38,38,0.22)] flex items-center justify-center">
                            <i class="uil uil-megaphone text-2xl sm:text-3xl text-white"></i>
                        </div>

                        {{-- GARIS KANAN --}}
                        <div class="flex items-center gap-2">
                            <span class="text-yellow-500 text-xs"> ◆ </span>

                            <span class="w-10 sm:w-16 h-px bg-gradient-to-l from-transparent to-yellow-500"></span>
                        </div>
                    </div>

                    {{-- JUDUL --}}
                    @php
                        $promoTitle = $menuSetting->promo_title ?? 'Promo Bulan Ini';
                        $promoWords = preg_split('/\s+/', trim($promoTitle));

                        if (count($promoWords) > 1) {
                            $promoMainTitle = implode(' ', array_slice($promoWords, 0, -1));
                            $promoAccentTitle = end($promoWords);
                        } else {
                            $promoMainTitle = $promoTitle;
                            $promoAccentTitle = '';
                        }
                    @endphp

                    <h2 class="text-3xl sm:text-4xl font-serif font-bold leading-tight tracking-tight text-gray-900">
                        {{ $promoMainTitle }}

                        @if ($promoAccentTitle)
                            <span class="text-red-600">
                                {{ $promoAccentTitle }}
                            </span>
                        @endif
                    </h2>

                    {{-- AKSEN BAWAH --}}
                    <div class="flex items-center justify-center gap-2 mt-5">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>

                        <span class="w-14 sm:w-20 h-1 rounded-full bg-gradient-to-r from-red-500 to-yellow-400">
                        </span>

                        <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                    </div>
                </div>

                {{-- CAROUSEL PROMO --}}
                <div class="relative px-10 sm:px-12">
                    {{-- AREA YANG BENAR-BENAR MENAMPUNG POSTER --}}
                    <div id="promotionCarousel"
                        class="promotion-carousel flex gap-3 sm:gap-4 overflow-x-auto overflow-y-hidden scroll-smooth snap-x snap-mandatory touch-pan-x select-none">
                        @foreach ($localPromotions as $promotionItem)
                            @php
                                $promotion = $promotionItem['promotion'];
                                $promotionImage = $promotionItem['image'];
                            @endphp

                            <button type="button"
                                onclick="openPromotionModal(
        '{{ $promotionImage }}',
        {{ $loop->index }}
    )"
                                class="promotion-slide flex-shrink-0 w-[130px] sm:w-[170px] md:w-[190px] aspect-[3/4] rounded-2xl overflow-hidden bg-gray-100 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 focus:outline-none">
                                <img src="{{ $promotionImage }}" alt="Promo Resto Joss Gandos"
                                    class="w-full h-full object-cover" />
                            </button>
                        @endforeach
                    </div>

                    {{-- TOMBOL KIRI --}}
                    <button type="button" onclick="prevPromotion()"
                        class="absolute left-0 top-1/2 -translate-y-1/2 w-9 h-9 sm:w-10 sm:h-10 bg-white border border-gray-200 shadow-md rounded-full flex items-center justify-center text-gray-700 hover:bg-red-500 hover:text-white transition z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </button>

                    {{-- TOMBOL KANAN --}}
                    <button type="button" onclick="nextPromotion()"
                        class="absolute right-0 top-1/2 -translate-y-1/2 w-9 h-9 sm:w-10 sm:h-10 bg-white border border-gray-200 shadow-md rounded-full flex items-center justify-center text-gray-700 hover:bg-red-500 hover:text-white transition z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                </div>

                {{-- DOT --}}
                <div id="promotionDots" class="flex justify-center gap-1.5 mt-4">
                    @foreach ($localPromotions as $promotionItem)
                        <button type="button"
                            class="promotion-dot w-2 h-2 rounded-full bg-gray-300 transition-all duration-300"></button>
                    @endforeach
                </div>
            </div>
        </section>

    @endif

    {{-- ================= REKOMENDASI SPECIAL ================= --}}
    @if ($carouselMenus->count())
        <section
            class="relative z-10 pb-20 fade-section opacity-0 translate-y-10 transition-all duration-1000 delay-100">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- JUDUL REKOMENDASI --}}
                <div class="text-center mb-8">
                    @php
                        $recommendedTitle = $menuSetting->recommended_title ?? 'Rekomendasi Menu Spesial Kami';
                        $recommendedWords = preg_split('/\s+/', trim($recommendedTitle));

                        if (count($recommendedWords) > 2) {
                            $recommendedMainTitle = implode(' ', array_slice($recommendedWords, 0, 2));
                            $recommendedAccentTitle = implode(' ', array_slice($recommendedWords, 2));
                        } else {
                            $recommendedMainTitle = $recommendedTitle;
                            $recommendedAccentTitle = '';
                        }
                    @endphp

                    <h2 class="text-3xl sm:text-4xl font-serif font-bold text-gray-800">
                        {{ $recommendedMainTitle }}

                        @if ($recommendedAccentTitle)
                            <span class="text-gray-800">
                                {{ $recommendedAccentTitle }}
                            </span>
                        @endif
                    </h2>

                    {{-- GARIS DEKORASI TETAP --}}
                    <div class="flex items-center justify-center gap-2 mt-3">
                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                        <span class="w-10 h-1 rounded-full bg-red-500"></span>
                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                    </div>
                </div>

                {{-- ================= CARD BESAR ================= --}}
                <div
                    class="relative w-full overflow-hidden rounded-[2.5rem] shadow-2xl bg-neutral-900 ring-1 ring-white/10">
                    {{-- ================= SLIDER ================= --}}
                    <div id="carousel" class="flex transition-transform duration-700 ease-in-out">
                        @forelse ($carouselMenus as $menu)
                            @php
                                $menuImage = $resolveLocalImage($menu->image_path ?? '');
                            @endphp

                            <div class="relative min-w-full flex flex-col md:flex-row h-auto md:h-[500px]">
                                {{-- ================= GAMBAR KIRI ================= --}}
                                <div
                                    class="w-full md:w-1/2 h-[300px] md:h-full relative overflow-hidden group z-10 shadow-2xl">
                                    @if ($menuImage)
                                        <img src="{{ $menuImage }}" alt="{{ $menu->title }}"
                                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                                    @else
                                        <div
                                            class="absolute inset-0 bg-gradient-to-br from-neutral-800 via-neutral-700 to-red-950">
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-black/10 z-10"></div>

                                    {{-- FAVORIT KHUSUS MOBILE --}}
                                    @if ($menu->is_recommended)
                                        <div
                                            class="md:hidden absolute top-4 right-4 flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-red-600 text-white text-xs font-bold shadow-lg z-20">
                                            <span class="text-yellow-300">★</span>
                                            <span>Favorit</span>
                                        </div>
                                    @endif
                                </div>

                                {{-- ================= INFORMASI KANAN ================= --}}
                                <div
                                    class="group w-full md:w-1/2 p-8 md:p-16 flex flex-col justify-center bg-neutral-900 relative overflow-hidden border-t-2 md:border-t-0 md:border-l-2 border-neutral-700">
                                    {{-- ================= FAVORIT ================= --}}
                                    <div
                                        class="hidden md:flex absolute top-6 right-6 items-center gap-1.5 px-4 py-2 rounded-full bg-red-600 text-white text-sm font-bold shadow-lg z-20">
                                        <span class="text-yellow-300 text-lg leading-none">
                                            ★
                                        </span>

                                        <span> Favorit </span>
                                    </div>

                                    {{-- ================= DEKORASI ================= --}}
                                    <div
                                        class="absolute top-0 right-0 w-64 h-64 bg-red-600/10 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2 pointer-events-none">
                                    </div>

                                    {{-- ================= KONTEN ================= --}}
                                    <div
                                        class="relative z-10 border-l-4 border-red-600 pl-6 transition-all duration-500">
                                        {{-- JUDUL --}}
                                        <h3
                                            class="text-white font-serif font-bold text-2xl md:text-5xl leading-tight mb-3 cursor-pointer">
                                            {{ $menu->title }}
                                        </h3>

                                        {{-- HARGA --}}
                                        @if ($menu->price !== null)
                                            <div class="text-red-500 font-bold text-xl md:text-2xl mb-4">
                                                Rp {{ number_format($menu->price, 0, ',', '.') }}
                                            </div>
                                        @endif

                                        {{-- DESKRIPSI HANYA MUNCUL SAAT HOVER --}}
                                        @if ($menu->description)
                                            <div
                                                class="hidden md:block max-h-0 overflow-hidden opacity-0 translate-y-2 transition-all duration-500 group-hover:max-h-32 group-hover:opacity-100 group-hover:translate-y-0">
                                                <p
                                                    class="text-gray-300 text-base md:text-lg font-light leading-relaxed">
                                                    {{ $menu->description }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        @empty
                            {{-- JIKA TIDAK ADA MENU --}}
                            <div class="relative min-w-full h-[450px] bg-neutral-800 flex items-center justify-center">
                                <p class="text-gray-500 italic">Menu rekomendasi belum tersedia.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- ================= TOMBOL NAVIGASI ================= --}}
                    @if ($carouselMenus->count() > 1)
                        <div class="absolute bottom-5 right-5 md:bottom-8 md:right-8 flex gap-3 md:gap-4 z-20">
                            {{-- TOMBOL KIRI --}}
                            <button type="button" onclick="prevSlide()"
                                class="bg-white/10 hover:bg-red-600 text-white p-3 rounded-full backdrop-blur-md transition-all border border-white/20 shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5
                                       L8.25 12
                                       l7.5-7.5" />
                                </svg>
                            </button>

                            {{-- TOMBOL KANAN --}}
                            <button type="button" onclick="nextSlide()"
                                class="bg-white/10 hover:bg-red-600 text-white p-3 rounded-full backdrop-blur-md transition-all border border-white/20 shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5
                                       l7.5 7.5
                                       -7.5 7.5" />
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </section>

    @endif

    {{-- ================= MENU LAINNYA ================= --}}
    @php
        $allMenus = collect($menus)->flatten()->values();
    @endphp

    <section class="relative z-10 pb-24 fade-section opacity-0 translate-y-10 transition-all duration-1000">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- JUDUL --}}
            <div class="text-center mb-8">
                <h2 class="text-3xl sm:text-4xl font-serif font-bold text-gray-800">
                    {{ $menuSetting->menu_title ?? 'Menu Lainnya' }}
                </h2>

                <div class="flex items-center justify-center gap-2 mt-2">
                    <span class="w-2 h-2 rounded-full bg-red-500"> </span>

                    <span class="w-10 h-1 rounded-full bg-red-500"> </span>

                    <span class="w-2 h-2 rounded-full bg-red-500"> </span>
                </div>
            </div>

            {{-- FILTER --}}
            <div id="menuFilters"
                class="grid grid-cols-2 gap-3 mb-8 justify-items-stretch sm:flex sm:flex-wrap sm:items-center sm:justify-center sm:gap-3">
                <button type="button" data-filter="all"
                    class="menu-filter active-filter flex items-center gap-2 px-5 py-2.5 rounded-full bg-red-600 text-white font-medium text-sm shadow-sm transition-all">
                    <i class="uil uil-apps"></i>
                    <span>Semua</span>
                </button>

                <button type="button" data-filter="makanan"
                    class="menu-filter flex items-center gap-2 px-5 py-2.5 rounded-full bg-white text-gray-700 font-medium text-sm border border-gray-200 shadow-sm transition-all">
                    <i class="uil uil-utensils"></i>
                    <span>Makanan</span>
                </button>

                <button type="button" data-filter="minuman"
                    class="menu-filter flex items-center gap-2 px-5 py-2.5 rounded-full bg-white text-gray-700 font-medium text-sm border border-gray-200 shadow-sm transition-all">
                    <i class="uil uil-glass"></i>
                    <span>Minuman</span>
                </button>

                <button type="button" data-filter="snack"
                    class="menu-filter flex items-center gap-2 px-5 py-2.5 rounded-full bg-white text-gray-700 font-medium text-sm border border-gray-200 shadow-sm transition-all">
                    <i class="uil uil-cookie"></i>
                    <span>Snack</span>
                </button>

                <div class="relative">
                    <button type="button" id="priceFilterButton"
                        class="w-full sm:w-auto flex items-center justify-center gap-2 px-5 py-2.5 rounded-full bg-white text-gray-700 font-medium text-sm border border-gray-200 shadow-sm transition-all">
                        <i class="uil uil-filter"></i>

                        <span>Harga</span>

                        <i class="uil uil-angle-down text-base"></i>
                    </button>

                    <div id="priceFilterMenu"
                        class="hidden absolute right-0 mt-3 w-56 bg-white rounded-2xl border border-gray-100 shadow-[0_12px_35px_rgba(0,0,0,0.12)] z-50 overflow-hidden p-2">
                        <button type="button" data-sort="desc"
                            class="price-sort w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-red-600 transition-all duration-200">
                            <span
                                class="w-9 h-9 rounded-lg bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                                <i class="uil uil-arrow-up"></i>
                            </span>

                            <span>Harga Tertinggi</span>
                        </button>

                        <button type="button" data-sort="asc"
                            class="price-sort w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-red-600 transition-all duration-200">
                            <span
                                class="w-9 h-9 rounded-lg bg-yellow-50 text-yellow-600 flex items-center justify-center shrink-0">
                                <i class="uil uil-arrow-down"></i>
                            </span>

                            <span>Harga Terendah</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- GRID MENU --}}
            <div id="menuGrid" class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5">
                @foreach ($allMenus as $menu)
                    @php
                        $menuImage = $resolveLocalImage($menu->image_path ?? '');
                    @endphp

                    <div data-category="{{ $menu->category }}" data-price="{{ $menu->price ?? 0 }}"
                        class="menu-card
    bg-white
    rounded-2xl
    overflow-hidden
    border border-gray-100
    shadow-sm
    hover:shadow-lg
    transition-all
    duration-300
    {{ $loop->index >= 8 ? 'extra-menu hidden' : '' }}">
                        {{-- GAMBAR --}}
                        <div
                            class="relative h-32 sm:h-40 overflow-hidden bg-gradient-to-br from-neutral-800 via-neutral-700 to-red-950">
                            @if ($menuImage)
                                <img src="{{ $menuImage }}" alt="{{ $menu->title }}"
                                    class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" />
                            @endif

                            {{-- FAVORIT --}}
                            @if ($menu->is_recommended)
                                <div
                                    class="absolute top-3 right-3 px-3 py-1 rounded-full bg-red-600 text-white text-xs font-bold flex items-center gap-1 shadow-md">
                                    <span class="text-yellow-300"> ★ </span>

                                    <span> Favorit </span>
                                </div>
                            @endif
                        </div>

                        {{-- INFORMASI --}}
                        <div class="p-3 sm:p-4">
                            {{-- NAMA --}}
                            <h3 class="font-bold text-gray-800 text-sm sm:text-base leading-tight">
                                {{ $menu->title }}
                            </h3>

                            {{-- HARGA --}}
                            @if ($menu->price !== null)
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-red-600 font-bold text-sm">
                                        Rp {{ number_format($menu->price, 0, ',', '.') }}
                                    </span>

                                    @if ($menu->description)
                                        <button type="button"
                                            class="description-toggle flex-shrink-0 w-8 h-8 rounded-full border border-red-300 text-red-600 flex items-center justify-center hover:bg-red-50 transition-colors">
                                            <i class="uil uil-angle-down text-lg"></i>
                                        </button>
                                    @endif
                                </div>
                            @endif

                            {{-- DESKRIPSI --}}
                            @if ($menu->description)
                                <div class="menu-description hidden mt-3 pt-3 border-t border-gray-100">
                                    <p class="text-gray-500 text-sm leading-relaxed">
                                        {{ $menu->description }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- TIDAK ADA HASIL FILTER --}}
            <div id="emptyMenuMessage" class="hidden py-12 text-center">
                <p class="text-gray-500">Belum ada menu pada kategori ini.</p>
            </div>

            {{-- ================= LIHAT SEMUA MENU ================= --}}
            <div id="showMoreMenusWrapper" class="hidden flex justify-center mt-8">
                <button type="button" id="showMoreMenus" data-expanded="false"
                    class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-full border border-red-400 bg-white text-red-600 font-semibold text-sm hover:bg-red-500 hover:text-white transition-all duration-300">
                    <i class="uil uil-sync text-base"></i>

                    <span>Muat Lebih Banyak</span>
                </button>
            </div>
        </div>
    </section>


    {{-- ================= MENU LENGKAP CTA ================= --}}
    @if (
        !empty($menuSetting?->cta_image) ||
            !empty($menuSetting?->cta_badge) ||
            !empty($menuSetting?->cta_title) ||
            !empty($menuSetting?->cta_description) ||
            !empty($menuSetting?->cta_link))
        <section class="relative z-10 pb-6 fade-section opacity-0 translate-y-10 transition-all duration-1000">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div
                    class="relative min-h-[300px] sm:min-h-[330px] lg:min-h-[360px]
                        overflow-hidden rounded-[2rem] 
                        shadow-[0_12px_35px_rgba(0,0,0,0.18)]">

                    {{-- ================= BACKGROUND IMAGE ================= --}}
                    @php
                        $ctaImageUrl = $resolveLocalImage($menuSetting?->cta_image);
                    @endphp
                    @if ($ctaImageUrl)
                        <img src="{{ $ctaImageUrl }}" alt="{{ $menuSetting->cta_title ?? 'Menu Lengkap' }}"
                            class="absolute inset-0 w-full h-full object-cover object-left md:object-center" />
                    @else
                        <div class="absolute inset-0 bg-gray-800"></div>
                    @endif

                    {{-- ================= OVERLAY ================= --}}
                    <div class="absolute inset-0 bg-black/20"></div>

                    {{-- SHADOW LEBIH KUAT DI BAGIAN KANAN --}}
                    <div
                        class="absolute inset-0
                           bg-gradient-to-r
                           from-black/0
                           via-black/10
                           to-black/75">
                    </div>

                    {{-- ================= KONTEN KANAN ================= --}}
                    <div
                        class="relative z-10 min-h-[300px] sm:min-h-[330px] lg:min-h-[360px] 
                            flex items-center justify-end">
                        <div
                            class="w-full lg:w-1/2
                               px-6 py-10
                               sm:px-10
                               lg:px-14 lg:py-14
                               text-white">

                            {{-- BADGE --}}
                            @if (!empty($menuSetting?->cta_badge))
                                <div class="flex items-center gap-3 mb-4">

                                    <span
                                        class="text-yellow-300
                                           text-xs sm:text-sm
                                           font-semibold
                                           tracking-[0.2em]
                                           uppercase
                                           drop-shadow-lg">
                                        {{ $menuSetting->cta_badge }}
                                    </span>

                                    <span class="w-10 h-px bg-yellow-400/70"></span>

                                </div>
                            @endif

                            {{-- JUDUL --}}
                            @if (!empty($menuSetting?->cta_title))
                                <h2
                                    class="font-serif 
                                    text-3xl sm:text-4xl lg:text-5xl 
                                    font-bold 
                                    leading-tight 
                                    bg-gradient-to-r from-red-500 via-orange-400 to-yellow-400 
                                    bg-clip-text text-transparent
                                    drop-shadow-[0_3px_8px_rgba(0,0,0,0.7)]">
                                    {{ $menuSetting->cta_title }}
                                </h2>
                            @endif

                            {{-- DESKRIPSI --}}
                            @if (!empty($menuSetting?->cta_description))
                                <p
                                    class="mt-5
                                       text-sm sm:text-base
                                       lg:text-lg
                                       leading-relaxed
                                       text-white/90
                                       max-w-xl
                                       drop-shadow-[0_2px_6px_rgba(0,0,0,0.7)]">
                                    {{ $menuSetting->cta_description }}
                                </p>
                            @endif

                            {{-- BUTTON --}}
                            @if (!empty($menuSetting?->cta_link) || $menuPreviews->count())
                                <div class="mt-7 flex flex-wrap items-center gap-3">

                                    {{-- GOOGLE DRIVE --}}
                                    @if (!empty($menuSetting?->cta_link))
                                        <a href="{{ $menuSetting->cta_link }}" target="_blank"
                                            rel="noopener noreferrer"
                                            class="w-full sm:w-auto inline-flex items-center justify-center gap-3
                                            px-6 py-3.5
                                            rounded-full
                                            bg-red-600
                                            hover:bg-red-700
                                            text-white
                                            text-sm sm:text-base
                                            font-semibold
                                            shadow-[0_5px_15px_rgba(0,0,0,0.3)]
                                            hover:shadow-[0_8px_20px_rgba(0,0,0,0.35)]
                                            transition-all duration-300">

                                            <i class="uil uil-google-drive text-xl"></i>

                                            <span>Lihat Menu Lengkap</span>

                                            <i class="uil uil-external-link-alt"></i>

                                        </a>
                                    @endif

                                    {{-- PREVIEW MENU --}}
                                    @if ($menuPreviews->count())
                                        <button type="button" onclick="openMenuPreviewModal(0)"
                                            class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-6 py-3.5 rounded-full bg-white text-red-600 text-sm sm:text-base font-semibold border border-red-200 shadow-[0_5px_15px_rgba(0,0,0,0.12)] hover:bg-red-50 transition-all duration-300">

                                            <i class="uil uil-images text-xl"></i>

                                            <span>Preview Menu</span>

                                        </button>
                                    @endif

                                </div>
                            @endif

                        </div>
                    </div>

                </div>

            </div>
        </section>
    @endif

    @php
        // Gunakan resolver aset lokal yang sama untuk ikon paket.
        $resolveMenuIconUrl = $resolveLocalImage;
    @endphp


    {{-- ================= PAKET & LAYANAN ================= --}}
    <section class="relative z-10 pt-6 pb-20 fade-section opacity-0 translate-y-10 transition-all duration-1000">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- JUDUL PAKET & LAYANAN --}}
            <div class="text-center mb-10">
                <h2 class="text-3xl sm:text-4xl font-serif font-bold text-gray-800">
                    {{ $menuSetting->package_title ?? 'Paket & Layanan' }}
                </h2>

                {{-- GARIS DEKORASI --}}
                <div class="flex items-center justify-center gap-2 mt-3">
                    <span class="w-2 h-2 rounded-full bg-red-500"></span>

                    <span class="w-10 h-1 rounded-full bg-red-500"></span>

                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                </div>

                {{-- DESKRIPSI TETAP DIPAKAI --}}
                @if (!empty($menuSetting?->package_description))
                    <p class="text-gray-500 mt-3 max-w-2xl mx-auto">
                        {{ $menuSetting->package_description }}
                    </p>
                @endif
            </div>

            {{-- ================= CARD PAKET & LAYANAN ================= --}}

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
                {{-- ================================================== --}}
                {{-- PACKAGE MENU --}}
                {{-- ================================================== --}}

                <div
                    class="relative overflow-hidden bg-white rounded-3xl border border-red-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 px-8 py-8 text-center">
                    {{-- HIASAN --}}
                    <div class="absolute -top-12 -left-12 w-32 h-32 rounded-full bg-red-50"></div>

                    <div class="absolute -bottom-14 -right-14 w-36 h-36 rounded-full bg-red-50/80"></div>

                    {{-- POLA TITIK --}}
                    <div class="absolute top-6 right-6 opacity-30">
                        <div class="grid grid-cols-3 gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>

                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>

                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                        </div>
                    </div>

                    {{-- ISI --}}
                    <div class="relative z-10">
                        {{-- ICON --}}
                        <div class="w-20 h-20 mx-auto rounded-full bg-red-50 flex items-center justify-center mb-5">
                            @if ($resolveMenuIconUrl($menuSetting?->package_menu_icon))
                                <img src="{{ $resolveMenuIconUrl($menuSetting->package_menu_icon) }}"
                                    alt="{{ $menuSetting->package_menu_title ?? 'Package Menu' }}"
                                    class="w-10 h-10 object-contain" />
                            @endif
                        </div>

                        {{-- JUDUL --}}
                        <h3 class="text-xl font-bold text-gray-800">
                            {{ $menuSetting->package_menu_title ?? 'Package Menu' }}
                        </h3>

                        {{-- DESKRIPSI --}}
                        <p class="text-gray-500 text-sm leading-relaxed mt-3 min-h-[48px]">
                            {{ $menuSetting->package_menu_description ?? '' }}
                        </p>

                        {{-- BUTTON --}}
                        <a href="{{ route('service-packages.front', ['category' => 'package_menu']) }}"
                            class="inline-flex items-center justify-center gap-2 mt-6 px-7 py-3 rounded-full bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition-all duration-300">
                            <span> Lihat Paket </span>

                            <i class="uil uil-arrow-right"></i>
                        </a>
                    </div>
                </div>

                {{-- ================================================== --}}
                {{-- BOX PACKAGE --}}
                {{-- ================================================== --}}

                <div
                    class="relative overflow-hidden bg-white rounded-3xl border border-red-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 px-8 py-8 text-center">
                    {{-- HIASAN --}}
                    <div class="absolute -top-12 -right-12 w-32 h-32 rounded-full bg-red-50"></div>

                    <div class="absolute -bottom-14 -left-14 w-36 h-36 rounded-full bg-red-50/80"></div>

                    {{-- POLA TITIK --}}
                    <div class="absolute top-6 left-6 opacity-30">
                        <div class="grid grid-cols-3 gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>

                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>

                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                        </div>
                    </div>

                    {{-- AKSEN BULAT --}}
                    <div class="absolute top-8 right-8 w-3 h-3 rounded-full bg-red-200"></div>

                    {{-- ISI --}}
                    <div class="relative z-10">
                        {{-- ICON --}}
                        <div class="w-20 h-20 mx-auto rounded-full bg-red-50 flex items-center justify-center mb-5">
                            @if ($resolveMenuIconUrl($menuSetting?->box_package_icon))
                                <img src="{{ $resolveMenuIconUrl($menuSetting->box_package_icon) }}"
                                    alt="{{ $menuSetting->box_package_title ?? 'Box Package' }}"
                                    class="w-10 h-10 object-contain" />
                            @endif
                        </div>

                        {{-- JUDUL --}}
                        <h3 class="text-xl font-bold text-gray-800">
                            {{ $menuSetting->box_package_title ?? 'Box Package' }}
                        </h3>

                        {{-- DESKRIPSI --}}
                        <p class="text-gray-500 text-sm leading-relaxed mt-3 min-h-[48px]">
                            {{ $menuSetting->box_package_description ?? '' }}
                        </p>

                        {{-- BUTTON --}}
                        <a href="{{ route('service-packages.front', ['category' => 'box_package']) }}"
                            class="inline-flex items-center justify-center gap-2 mt-6 px-7 py-3 rounded-full bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition-all duration-300">
                            <span> Lihat Box Package </span>

                            <i class="uil uil-arrow-right"></i>
                        </a>
                    </div>
                </div>

                {{-- ================================================== --}}
                {{-- WEDDING PACKAGE --}}
                {{-- ================================================== --}}

                <div
                    class="relative overflow-hidden bg-white rounded-3xl border border-red-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 px-8 py-8 text-center">
                    {{-- HIASAN --}}
                    <div class="absolute -top-12 -left-12 w-32 h-32 rounded-full bg-red-50"></div>

                    <div class="absolute -bottom-14 -right-14 w-36 h-36 rounded-full bg-red-50/80"></div>

                    {{-- POLA TITIK --}}
                    <div class="absolute top-6 right-6 opacity-30">
                        <div class="grid grid-cols-3 gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>

                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>

                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                        </div>
                    </div>

                    {{-- AKSEN BULAT --}}
                    <div class="absolute top-10 right-10 w-3 h-3 rounded-full bg-red-200"></div>

                    <div class="absolute top-16 right-16 w-2 h-2 rounded-full bg-red-300"></div>

                    {{-- ISI --}}
                    <div class="relative z-10">
                        {{-- ICON --}}
                        <div class="w-20 h-20 mx-auto rounded-full bg-red-50 flex items-center justify-center mb-5">
                            @if ($resolveMenuIconUrl($menuSetting?->wedding_package_icon))
                                <img src="{{ $resolveMenuIconUrl($menuSetting->wedding_package_icon) }}"
                                    alt="{{ $menuSetting->wedding_package_title ?? 'Wedding Package' }}"
                                    class="w-10 h-10 object-contain" />
                            @endif
                        </div>

                        {{-- JUDUL --}}
                        <h3 class="text-xl font-bold text-gray-800">
                            {{ $menuSetting->wedding_package_title ?? 'Wedding Package' }}
                        </h3>

                        {{-- DESKRIPSI --}}
                        <p class="text-gray-500 text-sm leading-relaxed mt-3 min-h-[48px]">
                            {{ $menuSetting->wedding_package_description ?? '' }}
                        </p>

                        {{-- BUTTON --}}
                        <a href="{{ route('service-packages.front', ['category' => 'wedding_package']) }}"
                            class="inline-flex items-center justify-center gap-2 mt-6 px-7 py-3 rounded-full bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition-all duration-300">
                            <span> Lihat Wedding Package </span>

                            <i class="uil uil-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </main>

    <script>
        // ==========================================
        // PROMOTION CAROUSEL
        // ==========================================

        const promotionCarousel = document.getElementById("promotionCarousel");

        let promoDragging = false;
        let promoStartX = 0;
        let promoStartScrollLeft = 0;

        promotionCarousel?.addEventListener("pointerdown", (event) => {
            if (window.innerWidth >= 768) {
                return;
            }

            promoDragging = true;
            promoStartX = event.clientX;
            promoStartScrollLeft = promotionCarousel.scrollLeft;

            promotionCarousel.setPointerCapture(event.pointerId);
        });

        promotionCarousel?.addEventListener("pointermove", (event) => {
            if (!promoDragging || window.innerWidth >= 768) {
                return;
            }

            const distance = event.clientX - promoStartX;

            promotionCarousel.scrollLeft = promoStartScrollLeft - distance;
        });

        promotionCarousel?.addEventListener("pointerup", () => {
            promoDragging = false;
        });

        promotionCarousel?.addEventListener("pointercancel", () => {
            promoDragging = false;
        });

        let promotionAutoPlay = null;

        const promotionDots = document.querySelectorAll(".promotion-dot");

        let promotionIndex = 0;

        function updatePromotionDots() {
            promotionDots.forEach((dot, index) => {
                if (index === promotionIndex) {
                    dot.classList.remove("bg-gray-300");
                    dot.classList.add("bg-red-500");
                } else {
                    dot.classList.remove("bg-red-500");
                    dot.classList.add("bg-gray-300");
                }
            });
        }

        function getPromotionStep() {
            const slide = promotionCarousel?.querySelector(".promotion-slide");

            if (!slide) {
                return 0;
            }

            const style = window.getComputedStyle(promotionCarousel);

            const gap = parseFloat(style.columnGap || style.gap || 0);

            return slide.offsetWidth + gap;
        }

        function nextPromotion() {
            if (!promotionCarousel) {
                return;
            }

            const step = getPromotionStep();

            if (!step) {
                return;
            }

            const maxScroll =
                promotionCarousel.scrollWidth - promotionCarousel.clientWidth;

            const currentScroll = promotionCarousel.scrollLeft;

            // Sudah sampai paling kanan
            if (currentScroll >= maxScroll - 5) {
                return;
            }

            const nextScroll = Math.min(currentScroll + step, maxScroll);

            promotionCarousel.scrollTo({
                left: nextScroll,
                behavior: "smooth",
            });

            // Hitung posisi dot berdasarkan posisi scroll
            promotionIndex = Math.round(nextScroll / step);

            promotionIndex = Math.min(promotionIndex, promotionDots.length - 1);

            updatePromotionDots();
        }

        function prevPromotion() {
            if (!promotionCarousel) {
                return;
            }

            const step = getPromotionStep();

            if (!step) {
                return;
            }

            const currentScroll = promotionCarousel.scrollLeft;

            // Sudah sampai paling kiri
            if (currentScroll <= 5) {
                return;
            }

            const previousScroll = Math.max(currentScroll - step, 0);

            promotionCarousel.scrollTo({
                left: previousScroll,
                behavior: "smooth",
            });

            promotionIndex = Math.round(previousScroll / step);

            promotionIndex = Math.max(
                0,
                Math.min(promotionIndex, promotionDots.length - 1),
            );

            updatePromotionDots();
        }

        promotionCarousel?.addEventListener("scroll", () => {
            if (!promotionCarousel) {
                return;
            }

            const step = getPromotionStep();

            if (!step) {
                return;
            }

            promotionIndex = Math.round(promotionCarousel.scrollLeft / step);

            promotionIndex = Math.max(
                0,
                Math.min(promotionIndex, promotionDots.length - 1),
            );

            updatePromotionDots();
        });

        function startPromotionAutoPlay() {
            if (!promotionCarousel) {
                return;
            }

            if (promotionAutoPlay) {
                clearInterval(promotionAutoPlay);
            }

            updatePromotionDots();

            promotionAutoPlay = setInterval(() => {
                nextPromotion();
            }, 5000);
        }

        // --- CAROUSEL LOGIC ---
        const carousel = document.getElementById("carousel");
        const totalSlides = carousel.children.length;
        let index = 0;

        function updateSlide() {
            const translateX = -(index * 100);
            carousel.style.transform = `translateX(${translateX}%)`;
        }

        function nextSlide() {
            index = (index + 1) % totalSlides;
            updateSlide();
            // Tidak ada resetTimer() karena tidak ada autoplay
        }

        function prevSlide() {
            index = (index - 1 + totalSlides) % totalSlides;
            updateSlide();
            // Tidak ada resetTimer() karena tidak ada autoplay
        }

        // --- FADE ANIMATION ---
        document.addEventListener("DOMContentLoaded", () => {
            // Hapus pemanggilan startTimer() di sini

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
                    threshold: 0.1,
                },
            );
            sections.forEach((section) => observer.observe(section));
            updatePromotionDots();
        });

        // ==========================================
        // PROMOTION LIGHTBOX
        // ==========================================

        let promotionModalIndex = 0;
        let promotionModalImages = [];

        function buildPromotionImages() {
            promotionModalImages = Array.from(
                    document.querySelectorAll(".promotion-slide"),
                )
                .map((button) => {
                    const img = button.querySelector("img");

                    return img ? img.src : "";
                })
                .filter(Boolean);
        }

        function openPromotionModal(imageUrl, index) {
            const modal = document.getElementById("promotionModal");

            const image = document.getElementById("promotionModalImage");

            const counter = document.getElementById("promotionModalCounter");

            if (!modal || !image || !counter) {
                return;
            }

            buildPromotionImages();

            promotionModalIndex = Number(index);

            image.src = imageUrl;

            counter.textContent = `${promotionModalIndex + 1} / ${promotionModalImages.length}`;

            modal.classList.remove("hidden");
            modal.classList.add("flex");

            document.body.classList.add("overflow-hidden");
        }

        function nextPromotionModal() {
            if (!promotionModalImages.length) {
                buildPromotionImages();
            }

            if (!promotionModalImages.length) {
                return;
            }

            promotionModalIndex++;

            if (promotionModalIndex >= promotionModalImages.length) {
                promotionModalIndex = 0;
            }

            const image = document.getElementById("promotionModalImage");

            const counter = document.getElementById("promotionModalCounter");

            image.src = promotionModalImages[promotionModalIndex];

            counter.textContent = `${promotionModalIndex + 1} / ${promotionModalImages.length}`;
        }

        function previousPromotionModal() {
            if (!promotionModalImages.length) {
                buildPromotionImages();
            }

            if (!promotionModalImages.length) {
                return;
            }

            promotionModalIndex--;

            if (promotionModalIndex < 0) {
                promotionModalIndex = promotionModalImages.length - 1;
            }

            const image = document.getElementById("promotionModalImage");

            const counter = document.getElementById("promotionModalCounter");

            image.src = promotionModalImages[promotionModalIndex];

            counter.textContent = `${promotionModalIndex + 1} / ${promotionModalImages.length}`;
        }

        function closePromotionModal() {
            const modal = document.getElementById("promotionModal");

            const image = document.getElementById("promotionModalImage");

            if (!modal) {
                return;
            }

            modal.classList.add("hidden");
            modal.classList.remove("flex");

            document.body.classList.remove("overflow-hidden");

            if (image) {
                image.src = "";
            }
        }

        document.addEventListener("click", function(event) {
            const modal = document.getElementById("promotionModal");

            if (modal && event.target === modal) {
                closePromotionModal();
            }
        });

        // ==========================================
        // DROPDOWN HARGA
        // ==========================================

        const priceFilterButton = document.getElementById("priceFilterButton");
        const priceFilterMenu = document.getElementById("priceFilterMenu");

        priceFilterButton?.addEventListener("click", (event) => {
            event.stopPropagation();

            priceFilterMenu?.classList.toggle("hidden");
        });

        document.addEventListener("click", (event) => {
            if (
                priceFilterMenu &&
                priceFilterButton &&
                !priceFilterMenu.contains(event.target) &&
                !priceFilterButton.contains(event.target)
            ) {
                priceFilterMenu.classList.add("hidden");
            }
        });

        document.querySelectorAll(".price-sort").forEach((button) => {
            button.addEventListener("click", () => {
                activePriceSort = button.dataset.sort;

                priceFilterMenu?.classList.add("hidden");

                updateMenuDisplay();
            });
        });

        // ==========================================
        // MENU LAINNYA
        // ==========================================

        const menuFilters = document.querySelectorAll(".menu-filter");

        const menuCards = Array.from(document.querySelectorAll(".menu-card"));

        const emptyMenuMessage = document.getElementById("emptyMenuMessage");

        const showMoreMenusWrapper = document.getElementById(
            "showMoreMenusWrapper",
        );

        const showMoreMenus = document.getElementById("showMoreMenus");

        let activeMenuCategory = "all";
        let menuExpanded = false;
        let activePriceSort = null;

        // ==========================================
        // UPDATE TAMPILAN MENU
        // ==========================================

        function updateMenuDisplay() {
            /*
            |------------------------------------------------------
            | Ambil card sesuai kategori
            |------------------------------------------------------
            */

            let filteredCards = menuCards.filter((card) => {
                const category = card.dataset.category;

                return (
                    activeMenuCategory === "all" ||
                    category === activeMenuCategory
                );
            });

            if (activePriceSort) {
                filteredCards.sort((a, b) => {
                    const priceA = parseFloat(a.dataset.price) || 0;
                    const priceB = parseFloat(b.dataset.price) || 0;

                    return activePriceSort === "desc" ?
                        priceB - priceA :
                        priceA - priceB;
                });
            }

            const menuGrid = document.getElementById("menuGrid");

            if (menuGrid && activePriceSort) {
                const orderedCards = [...menuCards].sort((a, b) => {
                    const priceA = parseFloat(a.dataset.price) || 0;
                    const priceB = parseFloat(b.dataset.price) || 0;

                    return activePriceSort === "desc" ?
                        priceB - priceA :
                        priceA - priceB;
                });

                orderedCards.forEach((card) => {
                    menuGrid.appendChild(card);
                });
            }

            /*
            |------------------------------------------------------
            | Reset semua card
            |------------------------------------------------------
            */

            menuCards.forEach((card) => {
                card.classList.add("hidden");
            });

            /*
            |------------------------------------------------------
            | Maksimal 8 card kalau belum expand
            |------------------------------------------------------
            */

            const visibleCards = menuExpanded ?
                filteredCards :
                filteredCards.slice(0, 8);

            visibleCards.forEach((card) => {
                card.classList.remove("hidden");
            });

            /*
            |------------------------------------------------------
            | Pesan kosong
            |------------------------------------------------------
            */

            if (emptyMenuMessage) {
                if (filteredCards.length === 0) {
                    emptyMenuMessage.classList.remove("hidden");
                } else {
                    emptyMenuMessage.classList.add("hidden");
                }
            }

            /*
            |------------------------------------------------------
            | Tombol Lihat Semua
            |
            | HANYA MUNCUL JIKA KATEGORI > 8
            |------------------------------------------------------
            */

            if (showMoreMenusWrapper) {
                if (filteredCards.length > 8) {
                    showMoreMenusWrapper.classList.remove("hidden");
                } else {
                    showMoreMenusWrapper.classList.add("hidden");
                }
            }

            /*
            |------------------------------------------------------
            | Teks tombol
            |------------------------------------------------------
            */

            if (showMoreMenus) {
                const text = showMoreMenus.querySelector("span");

                const icon = showMoreMenus.querySelector("i");

                if (menuExpanded) {
                    text.textContent = "Sembunyikan Menu";
                    icon.className = "uil uil-sync text-base";
                    showMoreMenus.dataset.expanded = "true";
                } else {
                    text.textContent = "Muat Lebih Banyak";
                    icon.className = "uil uil-sync text-base";
                    showMoreMenus.dataset.expanded = "false";
                }
            }
        }

        // ==========================================
        // FILTER
        // ==========================================

        menuFilters.forEach((filter) => {
            filter.addEventListener("click", () => {
                activeMenuCategory = filter.dataset.filter;

                /*
                        |--------------------------------------------------
                        | Setiap ganti kategori,
                        | kembali ke 8 card pertama
                        |--------------------------------------------------
                        */

                menuExpanded = false;

                /*
                        |--------------------------------------------------
                        | BUTTON AKTIF
                        |--------------------------------------------------
                        */

                menuFilters.forEach((button) => {
                    button.classList.remove("bg-red-600", "text-white");

                    button.classList.add("bg-white", "text-gray-700");
                });

                filter.classList.remove("bg-white", "text-gray-700");

                filter.classList.add("bg-red-600", "text-white");

                /*
                        |--------------------------------------------------
                        | UPDATE CARD
                        |--------------------------------------------------
                        */

                updateMenuDisplay();
            });
        });

        // ==========================================
        // LIHAT SEMUA / SEMBUNYIKAN
        // ==========================================

        if (showMoreMenus) {
            showMoreMenus.addEventListener("click", () => {
                menuExpanded = !menuExpanded;

                updateMenuDisplay();
            });
        }

        // ==========================================
        // INITIAL
        // ==========================================

        updateMenuDisplay();

        // ==========================================
        // DESKRIPSI MENU
        // ==========================================

        document.querySelectorAll(".description-toggle").forEach((button) => {
            button.addEventListener("click", () => {
                const card = button.closest(".menu-card");

                if (!card) {
                    return;
                }

                const description = card.querySelector(".menu-description");
                const icon = button.querySelector("i");

                if (!description || !icon) {
                    return;
                }

                const isHidden = description.classList.contains("hidden");

                if (isHidden) {
                    description.classList.remove("hidden");
                    icon.className = "uil uil-angle-up text-lg";
                } else {
                    description.classList.add("hidden");
                    icon.className = "uil uil-angle-down text-lg";
                }
            });
        });
    </script>

    </main>


    {{-- ================= DATA PREVIEW MENU ================= --}}
    @php
        $menuPreviewImages = $menuPreviews
            ->map(function ($preview) use ($resolveLocalImage) {
                return $resolveLocalImage($preview->image_path ?? '');
            })
            ->filter()
            ->values();
    @endphp

    {{-- ================= MENU PREVIEW MODAL ================= --}}
    <div id="menuPreviewModal"
        class="hidden fixed inset-0 z-[110] bg-black/70 backdrop-blur-sm items-center justify-center p-3 sm:p-5">

        <div
            class="relative w-full max-w-5xl h-[90vh] md:h-auto md:max-h-[92vh] bg-white rounded-2xl sm:rounded-3xl shadow-2xl overflow-hidden flex flex-col">

            {{-- HEADER --}}
            <div
                class="flex items-center justify-between gap-3 px-4 py-3 sm:px-6 sm:py-4 border-b border-gray-100 shrink-0">

                <div class="flex items-center gap-3 min-w-0">

                    <img src="{{ asset('img/logojossgandos.png') }}" alt="Logo Resto Joss Gandos"
                        class="w-9 h-9 sm:w-10 sm:h-10 object-contain shrink-0">

                    <div class="min-w-0">
                        <h2 class="text-sm sm:text-base font-bold text-gray-900 truncate">
                            Preview Menu Lengkap
                        </h2>

                        <p class="text-[10px] sm:text-xs text-gray-500 truncate">
                            Lihat berbagai pilihan menu makanan, minuman, dan lainnya.
                        </p>
                    </div>

                </div>

                {{-- CLOSE --}}
                <button type="button" onclick="closeMenuPreviewModal()"
                    class="w-9 h-9 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-gray-500 hover:bg-red-600 hover:text-white transition shrink-0">

                    <i class="uil uil-times text-xl"></i>

                </button>

            </div>


            {{-- CONTENT --}}
            <div class="flex-1 min-h-0 overflow-y-auto">

                <div class="grid grid-cols-1 md:grid-cols-[minmax(0,1fr)_250px] gap-0">

                    {{-- ================= GAMBAR UTAMA ================= --}}
                    <div id="menuPreviewImageArea"
                        class="relative bg-black h-[46vh] sm:h-[52vh] md:h-[580px] flex items-center justify-center p-3 sm:p-5 shrink-0">

                        {{-- GAMBAR --}}
                        <div class="relative w-full h-full flex items-center justify-center">

                            <img id="menuPreviewMainImage" src="" alt="Preview Menu"
                                class="max-w-full max-h-full w-auto h-auto object-contain rounded-lg sm:rounded-xl">

                        </div>


                        {{-- PREV --}}
                        <button type="button" onclick="previousMenuPreview()"
                            class="absolute left-3 sm:left-6 top-1/2 -translate-y-1/2
                               w-9 h-9 sm:w-11 sm:h-11
                               rounded-full bg-white text-red-600 shadow-lg
                               flex items-center justify-center
                               hover:bg-red-50 transition">

                            <i class="uil uil-angle-left text-2xl"></i>

                        </button>


                        {{-- NEXT --}}
                        <button type="button" onclick="nextMenuPreview()"
                            class="absolute right-3 sm:right-6 top-1/2 -translate-y-1/2
                               w-9 h-9 sm:w-11 sm:h-11
                               rounded-full bg-white text-red-600 shadow-lg
                               flex items-center justify-center
                               hover:bg-red-50 transition">

                            <i class="uil uil-angle-right text-2xl"></i>

                        </button>

                        {{-- LIHAT POSTER --}}
                        <button type="button" onclick="openMenuPosterModal()"
                            class="absolute bottom-4 left-1/2 -translate-x-1/2
                            px-4 py-2 rounded-full
                            bg-white/15 backdrop-blur-md
                            border border-white/40
                            text-white text-xs font-semibold
                            shadow-lg hover:bg-white/25 transition">
                            <i class="uil uil-image-search mr-1"></i>
                            Lihat Poster
                        </button>

                    </div>


                    {{-- ================= BAGIAN KANAN ================= --}}
                    <div class="bg-white p-4 sm:p-5 md:p-4 flex flex-col">

                        {{-- COUNTER --}}
                        <div class="text-center mb-3 shrink-0">
                            <span id="menuPreviewCounter" class="text-sm font-semibold text-gray-800">
                                1 / 1
                            </span>
                        </div>


                        {{-- THUMBNAIL --}}
                        <div id="menuPreviewThumbnails"
                            class="grid grid-cols-2 gap-2
                               max-h-[220px] sm:max-h-[250px] md:max-h-[280px]
                               overflow-y-auto pr-1">

                            @foreach ($menuPreviewImages as $image)
                                <button type="button"
                                    class="menu-preview-thumb aspect-[3/4] rounded-lg overflow-hidden border-2 border-transparent bg-gray-100 transition focus:outline-none"
                                    onclick="selectMenuPreview({{ $loop->index }})">

                                    <img src="{{ $image }}" alt="Thumbnail {{ $loop->iteration }}"
                                        class="w-full h-full object-cover">

                                </button>
                            @endforeach

                        </div>


                        {{-- GOOGLE DRIVE --}}
                        @if (!empty($menuSetting?->cta_link))
                            <a href="{{ $menuSetting->cta_link }}" target="_blank" rel="noopener noreferrer"
                                class="mt-4 inline-flex items-center justify-center gap-2
                                   w-full px-4 py-3
                                   rounded-full
                                   bg-red-600 hover:bg-red-700
                                   text-white text-sm font-semibold
                                   shadow-md transition">

                                <i class="uil uil-google-drive text-lg"></i>

                                <span>Buka Menu Lengkap di Google Drive</span>

                                <i class="uil uil-external-link-alt"></i>

                            </a>
                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- ================= POSTER DETAIL ================= --}}
    <div id="menuPosterModal" class="hidden fixed inset-0 z-[120] bg-black/90 items-center justify-center p-4">

        <div class="relative w-full max-w-[430px] max-h-[90vh] flex items-center justify-center">

            {{-- POSTER --}}
            <img id="menuPosterModalImage" src="" alt="Poster Menu"
                class="max-w-full max-h-[90vh] w-auto h-auto object-contain rounded-xl">

            {{-- CLOSE DI DALAM POSTER --}}
            <button type="button" onclick="closeMenuPosterModal()"
                class="absolute top-3 right-3
                w-10 h-10 rounded-full
                bg-white/10 backdrop-blur-sm
                border border-white/40
                text-red-600
                flex items-center justify-center
                hover:bg-white/20
                transition">
                <i class="uil uil-times text-xl"></i>
            </button>

        </div>
    </div>


    {{-- ================= PROMOTION MODAL ================= --}}
    <div id="promotionModal" class="hidden fixed inset-0 z-[100] bg-black/70 items-center justify-center p-4">
        {{-- TOMBOL KIRI --}}
        <button type="button" onclick="previousPromotionModal()"
            class="absolute left-4 sm:left-8 top-1/2 -translate-y-1/2 w-11 h-11 sm:w-12 sm:h-12 rounded-full border border-white/30 bg-black/30 text-white flex items-center justify-center hover:bg-white/20 transition z-20">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
        </button>

        {{-- TOMBOL KANAN --}}
        <button type="button" onclick="nextPromotionModal()"
            class="absolute right-4 sm:right-8 top-1/2 -translate-y-1/2 w-11 h-11 sm:w-12 sm:h-12 rounded-full border border-white/30 bg-black/30 text-white flex items-center justify-center hover:bg-white/20 transition z-20">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
        </button>

        {{-- CLOSE --}}
        <button type="button" onclick="closePromotionModal()"
            class="absolute top-4 right-4 sm:top-6 sm:right-6 w-10 h-10 rounded-full bg-white text-gray-800 shadow-lg flex items-center justify-center hover:bg-red-500 hover:text-white transition z-30">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- POSTER --}}
        <div
            class="relative w-[min(82vw,420px)] aspect-[3/4] flex items-center justify-center overflow-hidden rounded-2xl shadow-2xl bg-white">
            <img id="promotionModalImage" src="" alt="Poster Promosi" class="w-full h-full object-cover" />
        </div>

        {{-- COUNTER --}}
        <div
            class="absolute bottom-5 left-1/2 -translate-x-1/2 px-5 py-2 rounded-full bg-black/50 border border-white/20 text-white text-sm font-medium">
            <span id="promotionModalCounter">1 / 1</span>
        </div>
    </div>


    <script>
        // ==========================================
        // MENU PREVIEW MODAL
        // ==========================================

        const menuPreviewImages = @json($menuPreviewImages);

        let menuPreviewIndex = 0;


        function openMenuPreviewModal(index = 0) {
            const modal = document.getElementById("menuPreviewModal");
            const mainImage = document.getElementById("menuPreviewMainImage");
            const counter = document.getElementById("menuPreviewCounter");

            if (!modal || !mainImage || !counter || !menuPreviewImages.length) {
                return;
            }

            menuPreviewIndex = Math.max(
                0,
                Math.min(index, menuPreviewImages.length - 1)
            );

            updateMenuPreview();

            modal.classList.remove("hidden");
            modal.classList.add("flex");

            document.body.classList.add("overflow-hidden");
        }


        function updateMenuPreview() {
            const mainImage = document.getElementById("menuPreviewMainImage");
            const counter = document.getElementById("menuPreviewCounter");
            const thumbnails = document.querySelectorAll(".menu-preview-thumb");

            if (!mainImage || !counter) {
                return;
            }

            mainImage.src = menuPreviewImages[menuPreviewIndex];

            counter.textContent =
                `${menuPreviewIndex + 1} / ${menuPreviewImages.length}`;


            thumbnails.forEach((thumb, index) => {
                thumb.classList.remove("border-red-500");

                if (index === menuPreviewIndex) {
                    thumb.classList.add("border-red-500");
                }
            });
        }

        function openMenuPosterModal() {
            const posterModal = document.getElementById("menuPosterModal");
            const posterImage = document.getElementById("menuPosterModalImage");
            const mainImage = document.getElementById("menuPreviewMainImage");

            if (!posterModal || !posterImage || !mainImage) {
                return;
            }

            posterImage.src = mainImage.src;

            posterModal.classList.remove("hidden");
            posterModal.classList.add("flex");
        }

        function closeMenuPosterModal() {
            const posterModal = document.getElementById("menuPosterModal");
            const posterImage = document.getElementById("menuPosterModalImage");

            if (!posterModal) {
                return;
            }

            posterModal.classList.add("hidden");
            posterModal.classList.remove("flex");

            if (posterImage) {
                posterImage.src = "";
            }
        }

        let lastMenuPreviewTap = 0;

        const menuPreviewImageArea = document.getElementById("menuPreviewImageArea");

        menuPreviewImageArea?.addEventListener("pointerup", (event) => {
            if (event.target.closest("button")) {
                return;
            }

            const now = Date.now();

            if (now - lastMenuPreviewTap < 350) {
                openMenuPosterModal();
                lastMenuPreviewTap = 0;
                return;
            }

            lastMenuPreviewTap = now;
        });


        function selectMenuPreview(index) {
            menuPreviewIndex = index;

            updateMenuPreview();
        }


        function nextMenuPreview() {
            if (!menuPreviewImages.length) {
                return;
            }

            menuPreviewIndex++;

            if (menuPreviewIndex >= menuPreviewImages.length) {
                menuPreviewIndex = 0;
            }

            updateMenuPreview();
        }


        function previousMenuPreview() {
            if (!menuPreviewImages.length) {
                return;
            }

            menuPreviewIndex--;

            if (menuPreviewIndex < 0) {
                menuPreviewIndex = menuPreviewImages.length - 1;
            }

            updateMenuPreview();
        }


        function closeMenuPreviewModal() {
            const modal = document.getElementById("menuPreviewModal");
            const mainImage = document.getElementById("menuPreviewMainImage");

            if (!modal) {
                return;
            }

            modal.classList.add("hidden");
            modal.classList.remove("flex");

            document.body.classList.remove("overflow-hidden");

            if (mainImage) {
                mainImage.src = "";
            }
        }


        document.addEventListener("click", function(event) {
            const modal = document.getElementById("menuPreviewModal");

            if (modal && event.target === modal) {
                closeMenuPreviewModal();
            }
        });


        document.addEventListener("keydown", function(event) {

            const modal = document.getElementById("menuPreviewModal");

            if (!modal || modal.classList.contains("hidden")) {
                return;
            }

            if (event.key === "ArrowRight") {
                nextMenuPreview();
            }

            if (event.key === "ArrowLeft") {
                previousMenuPreview();
            }

            if (event.key === "Escape") {
                closeMenuPreviewModal();
            }

        });
    </script>

</x-layout>
