<x-layout>
    <style>
        /* CSS untuk Hide Scrollbar di Main Container */

        main::-webkit-scrollbar {

            display: none;

        }

        main {

            -ms-overflow-style: none;

            scrollbar-width: none;

        }

        /* Base Transition Style */

        .fade-section {

            transition-property: opacity, transform;

            transition-timing-function: ease-out;

        }

        @media (max-width: 639px) {

            /* Hero mobile saja */

            .reservation-mobile-hero {

                min-height: 500px;

            }

            .reservation-mobile-content {

                padding-top: 28px;

            }

        }


        .reservation-step-card {
            box-sizing: border-box;
        }

        @media (max-width: 767px) {
            .reservation-step-line {
                display: none !important;
            }

            .reservation-step-arrow {
                width: 36px;
                height: 36px;
            }
        }




        /* =========================================================
           HERO RESERVATION - STYLE MODERN
        ========================================================= */

        .reservation-hero-red-panel {
            position: absolute;
            inset: 0 auto 0 0;
            width: 58%;
            background:
                linear-gradient(90deg,
                    rgba(18, 8, 5, 0.97) 0%,
                    rgba(55, 12, 7, 0.92) 55%,
                    rgba(117, 20, 12, 0.58) 82%,
                    rgba(117, 20, 12, 0) 100%);
            border-top-right-radius: 42%;
            border-bottom-right-radius: 18%;
            pointer-events: none;
            z-index: 2;
        }

        .reservation-hero-content {
            position: relative;
            z-index: 4;
        }

        @media (max-width: 767px) {

            .reservation-hero-red-panel {
                width: 100%;
                border-radius: 0;
                background:
                    linear-gradient(180deg,
                        rgba(10, 5, 3, 0.94) 0%,
                        rgba(35, 10, 6, 0.88) 52%,
                        rgba(20, 5, 3, 0.68) 100%);
            }

        }

        /* =========================================================
           CARA RESERVASI - CARD MODERN
        ========================================================= */

        .reservation-step-card {
            box-sizing: border-box;
        }

        .reservation-step-inner {
            position: relative;
            height: 100%;
            min-height: 250px;
            background: #ffffff;
            border: 1px solid #f0f0f0;
            border-radius: 22px;
            padding: 24px 20px 28px;
            text-align: center;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .reservation-step-inner:hover {
            transform: translateY(-5px);
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.10);
        }


        /* Nomor */
        .reservation-step-number {
            position: absolute;
            top: 14px;
            left: 14px;
            width: 34px;
            height: 34px;
            border-radius: 11px;
            background: #dc2626;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            z-index: 5;
        }


        /* Lingkaran icon */
        .reservation-step-icon {
            width: 76px;
            height: 76px;
            margin: 4px auto 18px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fff1f2, #fff7ed);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            z-index: 3;
        }

        .reservation-step-icon img {
            width: 44px;
            height: 44px;
            object-fit: contain;
        }


        /* Aksen bawah */
        .reservation-step-wave {
            position: absolute;
            left: -10%;
            right: -10%;
            bottom: -28px;
            height: 65px;
            background: linear-gradient(90deg, #fff1f2, #fff7ed);
            border-radius: 50% 50% 0 0;
            opacity: 0.9;
        }


        /* Tombol slider */
        .reservation-step-arrow {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: white;
            border: 1px solid #e5e7eb;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.10);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #dc2626;
            transition: all 0.3s ease;
            z-index: 20;
        }

        .reservation-step-arrow.hidden {
            display: none !important;
        }

        .reservation-step-arrow:hover {
            background: #dc2626;
            color: white;
            border-color: #dc2626;
        }


        /* Mobile */
        @media (max-width: 767px) {

            .reservation-step-card {
                padding-left: 6px;
                padding-right: 6px;
            }

            .reservation-step-inner {
                min-height: 235px;
                padding: 20px 14px 24px;
                border-radius: 18px;
            }

            .reservation-step-icon {
                width: 66px;
                height: 66px;
            }

            .reservation-step-icon img {
                width: 38px;
                height: 38px;
            }

            .reservation-step-connector {
                display: none;
            }

            .reservation-step-arrow {
                width: 36px;
                height: 36px;
            }

        }

        /* =========================================================
           KENALI AREA RESTO - MODERN WRAPPER
        ========================================================= */

        .reservation-area-wrapper {
            position: relative;
            overflow: hidden;
            background: #fff;
            border: 1px solid #f3e8e8;
            border-radius: 32px;
            padding: 48px 34px 42px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.05);
        }

        /* garis dekorasi kecil */
        .reservation-area-wrapper .area-decoration-left {
            position: absolute;
            top: 28px;
            left: 28px;
            width: 55px;
            height: 55px;
            opacity: 0.75;
            background-image: radial-gradient(#f59e0b 2px, transparent 2px);
            background-size: 14px 14px;
        }

        .reservation-area-wrapper .area-decoration-right {
            position: absolute;
            bottom: 28px;
            right: 28px;
            width: 55px;
            height: 55px;
            opacity: 0.75;
            background-image: radial-gradient(#f59e0b 2px, transparent 2px);
            background-size: 14px 14px;
        }


        /* Card area */
        .reservation-area-card {
            position: relative;
            overflow: hidden;
            background: #fff;
            border-radius: 22px;
            border: 1px solid #f1f1f1;
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.06);
            transition: all 0.35s ease;
        }

        .reservation-area-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 30px rgba(0, 0, 0, 0.10);
        }


        /* Foto */
        .reservation-area-image {
            position: relative;
            height: 215px;
            overflow: hidden;
        }

        .reservation-area-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .reservation-area-card:hover .reservation-area-image img {
            transform: scale(1.05);
        }

        /* isi card */
        .reservation-area-content {
            padding: 34px 24px 24px;
        }


        /* garis kecil bawah judul */
        .reservation-area-title-line {
            width: 42px;
            height: 3px;
            background: #dc2626;
            border-radius: 999px;
            margin-top: 8px;
        }


        /* mobile */
        @media (max-width: 767px) {

            .reservation-area-wrapper {
                padding: 32px 16px 30px;
                border-radius: 24px;
            }

            .reservation-area-image {
                height: 180px;
            }

            .reservation-area-content {
                padding: 30px 18px 20px;
            }

            .reservation-area-icon {
                left: 18px;
                width: 52px;
                height: 52px;
            }

            .reservation-area-wrapper .area-decoration-left,
            .reservation-area-wrapper .area-decoration-right {
                display: none;
            }

        }
    </style>

    <main class="min-h-screen bg-white relative w-full overflow-x-hidden pt-[64px] md:pt-0">
        {{-- =========================================================
     HERO / HEADER RESERVASI
========================================================= --}}

        <section
            class="relative z-20 pt-8 sm:pt-10 pb-14 sm:pb-20 fade-section opacity-0 translate-y-10 transition-all duration-1000">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="reservation-mobile-hero relative w-full h-[520px] sm:h-[420px] lg:h-[460px] overflow-hidden rounded-[1.5rem] sm:rounded-[2rem] shadow-[0_12px_30px_rgba(0,0,0,0.20)]">
                    {{-- =====================================================
                 BACKGROUND FOTO
            ====================================================== --}}

                    <img src="{{ $setting->hero_image ?? '' }}" alt="Resto Joss Gandos"
                        class="absolute inset-0 w-full h-full object-cover" />

                    {{-- =====================================================
                 OVERLAY DASAR
            ====================================================== --}}

                    <div class="absolute inset-0 bg-black/25 z-[1]"></div>

                    {{-- =====================================================
                 PANEL MERAH GELAP
            ====================================================== --}}

                    <div class="reservation-hero-red-panel"></div>

                    {{-- =====================================================
                 CONTENT
            ====================================================== --}}

                    <div
                        class="reservation-mobile-content reservation-hero-content relative h-full w-full flex items-center">
                        <div
                            class="w-full grid lg:grid-cols-[1.15fr_.85fr] gap-6 lg:gap-10 items-center px-6 sm:px-8 lg:px-12 py-8 sm:py-0">
                            {{-- =================================================
                         KIRI
                    ================================================== --}}

                            <div
                                class="text-white max-w-2xl fade-section opacity-0 translate-y-8 transition-all duration-700">
                                {{-- =================================================
                             BADGE
                        ================================================== --}}

                                <span
                                    class="inline-flex items-center px-5 py-2 rounded-full border border-yellow-400/70 bg-black/25 backdrop-blur-sm text-yellow-300 text-[10px] sm:text-xs font-bold tracking-[0.16em] uppercase shadow-lg">
                                    {{ $setting->hero_badge ?? '' }}
                                </span>

                                {{-- =================================================
                             JUDUL
                        ================================================== --}}

                                <h1
                                    class="mt-6 font-serif font-bold text-[30px] sm:text-[36px] md:text-[44px] lg:text-[50px] leading-[1.15] tracking-[-0.02em] max-w-[680px] drop-shadow-[0_4px_10px_rgba(0,0,0,0.55)] text-transparent bg-clip-text bg-gradient-to-r from-white via-orange-200 to-red-400">
                                    {{ $setting->hero_title ?? '' }}
                                </h1>

                                {{-- =================================================
                             DESKRIPSI
                        ================================================== --}}

                                <p
                                    class="mt-6 max-w-[620px] text-gray-100 text-sm sm:text-base lg:text-lg leading-relaxed drop-shadow-md">
                                    {{ $setting->hero_description ?? '' }}
                                </p>

                                {{-- =================================================
                             WHATSAPP
                        ================================================== --}}

                                <a href="{{ $setting->hero_whatsapp_link ?? '#' }}" target="_blank"
                                    rel="noopener noreferrer"
                                    onclick="
                                        trackWhatsappClick('reservation-hero')
                                    "
                                    class="mt-7 inline-flex items-center gap-3 bg-white text-red-700 px-6 sm:px-8 py-3 sm:py-3.5 rounded-full font-bold text-sm sm:text-base shadow-[0_8px_24px_rgba(0,0,0,0.25)] hover:scale-105 hover:bg-red-50 transition-all duration-300">
                                    <i class="uil uil-whatsapp text-xl text-green-500">
                                    </i>

                                    <span> Reservasi via WhatsApp </span>

                                    <i class="uil uil-arrow-right"></i>
                                </a>

                                {{-- =================================================
                             RESPON CEPAT
                        ================================================== --}}

                                <div class="mt-4 flex items-center gap-2 text-[11px] sm:text-xs text-gray-200">
                                    <i class="uil uil-clock"></i>

                                    <span>
                                        {{ $setting->response_time ?? '' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- =========================================================
     CARA RESERVASI
========================================================= --}}

        <section
            class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-14 fade-section opacity-0 translate-y-10 transition-all duration-1000">
            {{-- JUDUL --}}
            <div class="text-center mb-9">
                <h2 class="font-serif font-bold text-2xl sm:text-3xl md:text-4xl text-gray-800">
                    {{ $setting->steps_title ?? 'Cara Reservasi' }}
                </h2>

                {{-- GARIS DEKORASI --}}
                <div class="flex items-center justify-center gap-1 mt-3">
                    <span class="w-5 h-0.5 bg-red-500 rounded-full"> </span>

                    <span class="w-10 h-0.5 bg-gradient-to-r from-red-500 to-yellow-400 rounded-full">
                    </span>

                    <span class="w-5 h-0.5 bg-yellow-400 rounded-full"> </span>
                </div>
            </div>

            {{-- ==============================================
         DATA CARA RESERVASI
    =============================================== --}}

            @if ($steps->count())
                <div class="relative px-6 sm:px-8">
                    {{-- VIEWPORT --}}
                    <div id="reservationStepViewport" class="overflow-hidden">
                        {{-- TRACK --}}
                        <div id="reservationStepTrack" class="flex transition-transform duration-500 ease-out">
                            @foreach ($steps as $step)
                                @php

                                    $stepIcon = null;

                                    if ($step->icon) {
                                        $stepIcon = filter_var($step->icon, FILTER_VALIDATE_URL)
                                            ? $step->icon
                                            : asset('storage/' . ltrim($step->icon, '/'));
                                    }

                                @endphp

                                {{-- CARD --}}
                                <div class="reservation-step-card flex-shrink-0 w-1/2 md:w-1/3 px-2 md:px-3">
                                    <div class="reservation-step-inner">
                                        {{-- NOMOR --}}
                                        <div class="reservation-step-number">
                                            {{ sprintf('%02d', $loop->iteration) }}
                                        </div>

                                        {{-- ICON --}}
                                        <div class="reservation-step-icon">
                                            @if ($stepIcon)
                                                <img src="{{ $stepIcon }}" alt="{{ $step->title }}" />
                                            @else
                                                <i class="uil uil-image text-3xl text-red-500">
                                                </i>
                                            @endif
                                        </div>

                                        {{-- JUDUL --}}
                                        <h3 class="relative z-10 text-base sm:text-lg font-bold text-gray-800">
                                            {{ $step->title }}
                                        </h3>

                                        {{-- DESKRIPSI --}}
                                        <p
                                            class="relative z-10 mt-2 text-xs sm:text-sm leading-relaxed text-gray-500 max-w-[230px] mx-auto">
                                            {{ $step->description }}
                                        </p>

                                        {{-- AKSEN BAWAH --}}
                                        <div class="reservation-step-wave"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- =================================================
                 PANAH
            ================================================== --}}

                    @if ($steps->count() > 2)
                        <button id="reservationStepPrev" type="button" aria-label="Langkah sebelumnya"
                            class="reservation-step-arrow absolute left-0 top-1/2 -translate-y-1/2">
                            <i class="uil uil-angle-left text-xl"> </i>
                        </button>

                        <button id="reservationStepNext" type="button" aria-label="Langkah berikutnya"
                            class="reservation-step-arrow absolute right-0 top-1/2 -translate-y-1/2">
                            <i class="uil uil-angle-right text-xl"> </i>
                        </button>
                    @endif
                </div>
            @else
                <div class="py-10 text-center text-sm text-gray-400">
                    Belum ada langkah reservasi.
                </div>

            @endif
        </section>

        {{-- =========================================================

     KETENTUAN RESERVASI

========================================================= --}}

        <section
            class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-14 fade-section opacity-0 translate-y-10 transition-all duration-1000 delay-100">
            {{-- JUDUL --}}

            <div class="text-center mb-8">
                <h2 class="font-serif font-bold text-2xl sm:text-3xl md:text-4xl text-gray-800">
                    {{ $setting->terms_title ?? 'Ketentuan Reservasi' }}
                </h2>

                <div class="flex items-center justify-center mt-2">
                    <span class="w-8 h-[2px] bg-red-500 rounded-full"></span>

                    <span class="w-7 h-[2px] bg-red-400 rounded-full mx-1"></span>

                    <span class="w-8 h-[2px] bg-yellow-400 rounded-full"></span>
                </div>
            </div>

            {{-- KETENTUAN DINAMIS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($terms as $term)
                    @php
                        $termIcon = null;
                        if ($term->icon) {
                            $termIcon = filter_var($term->icon, FILTER_VALIDATE_URL)
                                ? $term->icon
                                : asset('storage/' . ltrim($term->icon, '/'));
                        }
                    @endphp
                    <div
                        class="relative bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center hover:shadow-md transition-all duration-300 {{ $loop->iteration > 4 ? 'hidden extra-term' : '' }}">
                        <span
                            class="absolute top-4 left-4 w-8 h-8 rounded-full bg-red-600 text-white flex items-center justify-center text-sm font-bold">
                            {{ sprintf('%02d', $loop->iteration) }}
                        </span>
                        <div
                            class="mx-auto w-16 h-16 rounded-full bg-red-50 text-red-600 flex items-center justify-center overflow-hidden">
                            @if ($termIcon)
                                <img src="{{ $termIcon }}" alt="{{ $term->title }}"
                                    class="w-9 h-9 object-contain" />
                            @else
                                <i class="uil uil-image text-3xl"></i>
                            @endif
                        </div>
                        <h3 class="mt-4 font-bold text-gray-800 text-sm sm:text-base">
                            {{ $term->title }}
                        </h3>
                        <p class="mt-2 text-xs sm:text-sm text-gray-500 leading-relaxed">
                            {{ $term->description }}
                        </p>
                    </div>
                @endforeach
            </div>
            @if ($terms->count() > 4)
                <div class="flex justify-center mt-6">
                    <button type="button" id="toggleTermsButton"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-red-300 text-red-600 font-semibold text-sm hover:bg-red-50 transition">
                        <span>Lihat Selengkapnya</span>
                        <i class="uil uil-angle-down"></i>
                    </button>
                </div>
            @endif
        </section>

        {{-- =========================================================
     KENALI AREA RESTO
========================================================= --}}

        <section
            class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-14 fade-section opacity-0 translate-y-10 transition-all duration-1000 delay-200">
            {{-- =====================================================
         WRAPPER BESAR
    ====================================================== --}}

            <div class="reservation-area-wrapper">
                {{-- DEKORASI --}}
                <div class="area-decoration-left"></div>
                <div class="area-decoration-right"></div>

                {{-- =================================================
             JUDUL
        ================================================== --}}

                <div class="relative z-10 text-center mb-10">
                    <h2 class="font-serif font-bold text-2xl sm:text-3xl md:text-4xl text-gray-800">
                        {{ $setting->areas_title ?? 'Kenali Area Resto' }}
                    </h2>

                    <p class="mt-2 text-sm sm:text-base text-gray-600">
                        {{ $setting->areas_subtitle ?? 'Pilih suasana yang sesuai untuk momen Anda.' }}
                    </p>

                    {{-- GARIS DEKORASI --}}
                    <div class="flex items-center justify-center gap-1 mt-3">
                        <span class="w-5 h-0.5 bg-red-500 rounded-full"> </span>

                        <span class="w-10 h-0.5 bg-gradient-to-r from-red-500 to-yellow-400 rounded-full">
                        </span>

                        <span class="w-5 h-0.5 bg-yellow-400 rounded-full">
                        </span>
                    </div>
                </div>

                {{-- =================================================
             3 AREA DARI DATABASE
        ================================================== --}}

                <div class="relative z-10 grid grid-cols-1 md:grid-cols-3 gap-5">
                    @foreach ($areas->take(3) as $area)
                        @php

                            $areaImage = null;

                            if ($area->image) {
                                $areaImage = filter_var($area->image, FILTER_VALIDATE_URL)
                                    ? $area->image
                                    : asset('storage/' . ltrim($area->image, '/'));
                            }

                        @endphp

                        {{-- =================================================
                     CARD AREA
                ================================================== --}}

                        <div class="reservation-area-card">
                            {{-- FOTO --}}
                            <div class="reservation-area-image bg-gray-100">
                                @if ($areaImage)
                                    <img src="{{ $areaImage }}" alt="{{ $area->title }}" />
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-sm text-gray-400">
                                        Preview gambar area
                                    </div>
                                @endif
                            </div>

                            {{-- =================================================
                         ISI CARD
                    ================================================== --}}

                            <div class="reservation-area-content">
                                <h3 class="font-serif font-bold text-xl sm:text-2xl text-gray-800">
                                    {{ $area->title }}
                                </h3>

                                {{-- GARIS MERAH --}}
                                <div class="reservation-area-title-line"></div>

                                <p class="mt-3 text-sm text-gray-500 leading-relaxed">
                                    {{ $area->description }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- =================================================
             BUTTON GALLERY
        ================================================== --}}

                <div class="relative z-10 flex justify-center mt-8">
                    <a href="{{ route('gallery.front') }}?category=facility"
                        class="inline-flex items-center justify-center gap-3 w-full sm:w-auto min-w-[280px] px-7 py-3 rounded-full bg-red-600 text-white font-semibold text-sm shadow-lg shadow-red-600/20 hover:bg-red-700 hover:scale-[1.02] transition-all duration-300">
                        <i class="uil uil-image text-lg"> </i>

                        <span> Lihat Fasilitas Lainnya di Galeri </span>

                        <i class="uil uil-arrow-right text-lg"> </i>
                    </a>
                </div>
            </div>
        </section>

        {{-- =========================================================

     LOKASI & INFORMASI

========================================================= --}}

        <section
            class="mb-20 max-w-6xl mx-auto fade-section opacity-0 translate-y-10 transition-all duration-1000 delay-100">
            <div
                class="relative bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden p-6 md:p-8 lg:p-10">
                {{-- Dekorasi --}}

                <div class="absolute top-0 right-0 w-36 h-36 bg-red-50 rounded-bl-full opacity-70 pointer-events-none">
                </div>

                {{-- =====================================================

             JUDUL

        ====================================================== --}}

                <div class="relative z-10 text-center mb-8">
                    <h3 class="font-serif font-bold text-3xl md:text-4xl text-gray-800">
                        {{ $setting->location_title ?? 'Lokasi & Informasi' }}
                    </h3>

                    <div class="flex justify-center items-center gap-1 mt-3">
                        <span class="w-5 h-0.5 bg-red-500 rounded-full"></span>

                        <span class="w-8 h-0.5 bg-gradient-to-r from-red-500 to-yellow-400 rounded-full">
                        </span>

                        <span class="w-5 h-0.5 bg-yellow-400 rounded-full"></span>
                    </div>
                </div>

                {{-- =====================================================

             GRID

        ====================================================== --}}

                <div class="relative z-10 grid lg:grid-cols-[0.85fr_1.15fr] gap-8 lg:gap-10">
                    {{-- =================================================

     KIRI — INFORMASI

================================================== --}}

                    <div class="flex flex-col justify-start">
                        {{-- IDENTITAS OUTLET --}}

                        <div class="mb-10 pt-0">
                            <div class="flex items-start gap-4">
                                {{-- ICON OUTLET --}}

                                <div
                                    class="w-14 h-14 flex-shrink-0 rounded-full bg-red-50 border border-red-100 text-red-600 flex items-center justify-center">
                                    <i class="uil uil-shop text-2xl"> </i>
                                </div>

                                {{-- NAMA OUTLET --}}

                                <div>
                                    <h4 class="font-serif font-bold text-2xl md:text-3xl text-gray-800 leading-tight">
                                        {{ $setting->location_name ?? '' }}
                                    </h4>

                                    <p class="mt-1.5 text-sm md:text-base text-gray-500">
                                        {{ $setting->location_subtitle ?? '' }}
                                    </p>
                                </div>
                            </div>

                            {{-- GARIS PEMISAH --}}

                            <div class="mt-6 w-full h-px bg-gray-200"></div>
                        </div>

                        {{-- ALAMAT --}}

                        <div class="flex gap-4 items-start mb-5">
                            <div
                                class="w-12 h-12 flex-shrink-0 rounded-full bg-red-50 border border-red-100 text-red-600 flex items-center justify-center">
                                <i class="uil uil-map-marker text-2xl"> </i>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500 mb-1">Alamat</p>

                                <p class="font-semibold text-gray-800 text-sm md:text-base leading-relaxed">
                                    {{ $setting->address ?? '' }}
                                </p>
                            </div>
                        </div>

                        {{-- JAM --}}

                        <div class="flex gap-4 items-start mb-5">
                            <div
                                class="w-12 h-12 flex-shrink-0 rounded-full bg-red-50 border border-red-100 text-red-600 flex items-center justify-center">
                                <i class="uil uil-clock text-2xl"> </i>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500 mb-1">Jam Operasional</p>

                                <p class="font-semibold text-gray-800 text-sm md:text-base">
                                    {{ $setting->operating_hours ?? '' }}
                                </p>
                            </div>
                        </div>

                        {{-- WHATSAPP --}}

                        <div class="flex gap-4 items-start mb-6">
                            <div
                                class="w-12 h-12 flex-shrink-0 rounded-full bg-red-50 border border-red-100 text-red-600 flex items-center justify-center">
                                <i class="uil uil-phone text-2xl"> </i>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500 mb-1">WhatsApp</p>

                                <p class="font-semibold text-gray-800 text-sm md:text-base">
                                    {{ $setting->whatsapp_number ?? '' }}
                                </p>
                            </div>
                        </div>

                        {{-- SOSIAL MEDIA --}}

                        <div>
                            <p class="text-sm font-semibold text-gray-800 mb-3">Ikuti kami di</p>

                            <div class="flex gap-3">
                                <a href="{{ $setting->instagram_link ?? '#' }}" target="_blank"
                                    class="w-10 h-10 rounded-full bg-pink-50 text-pink-600 flex items-center justify-center hover:bg-pink-600 hover:text-white transition">
                                    <i class="uil uil-instagram text-xl"> </i>
                                </a>

                                <a href="{{ $setting->facebook_link ?? '#' }}" target="_blank"
                                    class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition">
                                    <i class="uil uil-facebook-f text-xl"> </i>
                                </a>

                                <a href="{{ $setting->tiktok_link ?? '#' }}" target="_blank"
                                    rel="noopener noreferrer" aria-label="TikTok"
                                    class="w-10 h-10 rounded-full bg-gray-100 text-gray-900 flex items-center justify-center">

                                    <img src="{{ asset('storage/order-buttons/tiktok.svg') }}" alt="TikTok"
                                        class="w-5 h-5 object-contain">
                                </a>

                                <a href="{{ $setting->whatsapp_link ?? '#' }}" target="_blank"
                                    onclick="
                                        trackWhatsappClick('reservation-social')
                                    "
                                    class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center hover:bg-green-600 hover:text-white transition">
                                    <i class="uil uil-whatsapp text-xl"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- =================================================

                 KANAN — FOTO + GOOGLE MAPS

            ================================================== --}}

                    <div class="flex flex-col gap-4">
                        {{-- FOTO LOKASI --}}

                        <div
                            class="relative w-full h-[240px] md:h-[280px] overflow-hidden rounded-[1.5rem] shadow-lg bg-gray-100">
                            <img src="{{ $setting->location_image ?? '' }}" alt="Resto Joss Gandos Jemursari"
                                class="w-full h-full object-cover" />

                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent">
                            </div>
                        </div>

                        {{-- GOOGLE MAPS --}}

                        <div
                            class="relative w-full h-[230px] md:h-[270px] overflow-hidden rounded-[1.5rem] border border-gray-200 shadow-inner bg-gray-100">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.254930294519!2d112.734773874761!3d-7.325237292682985!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fb597129038d%3A0x1ed010a8c48ea678!2sResto%20Joss%20Gandos!5e0!3m2!1sid!2sid!4v1755244684155!5m2!1sid!2sid"
                                width="100%" height="100%" style="border: 0" allowfullscreen="" loading="lazy"
                                class="w-full h-full">
                            </iframe>
                        </div>

                        {{-- BUTTON GOOGLE MAPS --}}

                        <a href="https://www.google.com/maps/search/?api=1&query=Resto+Joss+Gandos+Jemursari"
                            target="_blank"
                            class="w-full h-12 rounded-xl border border-gray-200 bg-white flex items-center justify-center gap-2 text-gray-800 font-semibold hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-all duration-300 shadow-sm">
                            Lihat di Google Maps

                            <i class="uil uil-external-link-alt text-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        @php
            $ctaBackground = $setting->cta_background_image ?? '';
            $ctaBackgroundUrl = '';

            if (\Illuminate\Support\Str::startsWith($ctaBackground, ['http://', 'https://'])) {
                $ctaBackgroundUrl = $ctaBackground;
            } elseif ($ctaBackground) {
                $ctaBackgroundUrl = asset('storage/' . ltrim($ctaBackground, '/'));
            }
        @endphp

        <section class="fade-section opacity-0 translate-y-10 transition-all duration-1000 delay-100">
            <div
                class="relative w-full rounded-[3rem] overflow-hidden shadow-2xl group cursor-pointer h-[480px] md:h-[450px]">
                <div class="absolute inset-0 z-0">
                    <img src="{{ $ctaBackgroundUrl ?: asset('img/reservation/fullteam.jpg') }}"
                        alt="Background Joss Gandos"
                        class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-105" />
                    <div class="absolute inset-0 bg-gradient-to-br from-red-900/80 via-red-800/60 to-black/50"></div>
                </div>
                <div class="relative z-10 px-6 h-full flex flex-col items-center justify-center text-center">
                    <span
                        class="inline-block py-1.5 px-4 rounded-full bg-white/20 border border-white/30 text-white text-xs font-bold tracking-[0.2em] mb-6 uppercase backdrop-blur-md shadow-lg">
                        {{ $setting->cta_badge ?? '' }}
                    </span>
                    <h3
                        class="text-4xl md:text-6xl font-serif font-bold text-white leading-tight mb-6 drop-shadow-2xl">
                        {{ $setting->cta_title ?? '' }}
                    </h3>
                    <p class="text-gray-100 text-lg md:text-xl mb-10 max-w-2xl mx-auto font-light leading-relaxed">
                        {{ $setting->cta_description ?? '' }}
                    </p>
                    <a href="{{ $setting->cta_whatsapp_link ?? '#' }}" target="_blank"
                        onclick="trackWhatsappClick('reservation-cta')"
                        class="group/btn relative inline-flex items-center gap-3 bg-white text-red-700 px-10 py-4 rounded-full font-bold text-lg shadow-[0_0_20px_rgba(255,255,255,0.3)] transition-all duration-300 transform hover:scale-105 hover:shadow-[0_0_30px_rgba(255,255,255,0.5)] overflow-hidden focus:outline-none">
                        <span
                            class="absolute inset-0 bg-red-50 transform scale-x-0 group-hover/btn:scale-x-100 transition-transform origin-left duration-300"></span>
                        <span class="relative flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                                <path
                                    d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                            </svg>
                            Reservasi Sekarang
                        </span>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <script>
        function trackWhatsappClick(page) {
            fetch("{{ route('whatsapp.click') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    Accept: "application/json",
                },
                body: JSON.stringify({
                    page: page,
                }),
            }).catch(() => {
                // Jangan mengganggu proses membuka WhatsApp
            });
        }

        function togglePromoWa() {
            const menu = document.getElementById("promo-wa-menu");

            menu.classList.toggle("hidden");
        }

        if (typeof kirimWa !== "function") {
            function kirimWa(element) {
                const nomor = element.getAttribute("data-nomor");

                const pesan = element.getAttribute("data-pesan");

                const pesanEncoded = encodeURIComponent(pesan);

                const url = `https://api.whatsapp.com/send?phone=${nomor}&text=${pesanEncoded}`;

                window.open(url, "_blank");
            }
        }

        // Menutup menu jika klik di luar

        window.addEventListener("click", function(e) {
            const btn = document.querySelector('button[onclick="togglePromoWa()"]');

            const menu = document.getElementById("promo-wa-menu");

            if (btn && menu && !btn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add("hidden");
            }
        });
    </script>

    <script>
        // ============================

        // 1. ROOM SLIDER LOGIC

        // ============================

        let roomIndex = 0;

        const roomTrack = document.getElementById("roomTrack");

        // Cek apakah element ada untuk menghindari error jika halaman lain tidak punya roomTrack

        if (roomTrack) {
            const totalRooms = roomTrack.children.length;

            function updateRoomSlide() {
                const translateXValue = -(roomIndex * 100);

                roomTrack.style.transform = `translateX(${translateXValue}%)`;
            }

            function nextRoomImage() {
                roomIndex = (roomIndex + 1) % totalRooms;

                updateRoomSlide();
            }

            function prevRoomImage() {
                roomIndex = (roomIndex - 1 + totalRooms) % totalRooms;

                updateRoomSlide();
            }
        }

        // ============================

        // 2. INIT & FADE ANIMATION

        // ============================

        document.addEventListener("DOMContentLoaded", () => {
            // Intersection Observer untuk Fade Section

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

            sections.forEach((section) => observer.observe(section));
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const track = document.getElementById("reservationStepTrack");

            const prev = document.getElementById("reservationStepPrev");

            const next = document.getElementById("reservationStepNext");

            if (!track) {
                return;
            }

            const cards = track.querySelectorAll(".reservation-step-card");

            if (!cards.length) {
                return;
            }

            let index = 0;

            /* =====================================================
               JUMLAH CARD YANG TERLIHAT
            ====================================================== */

            function getVisible() {
                return window.innerWidth <= 767 ? 2 : 3;
            }

            /* =====================================================
               UPDATE SLIDER
            ====================================================== */

            function updateSlider() {
                const visible = getVisible();

                const maxIndex = Math.max(cards.length - visible, 0);

                if (index > maxIndex) {
                    index = maxIndex;
                }

                /*
                | Kalau card tidak lebih dari
                | jumlah yang terlihat,
                | tidak perlu slider.
                */

                if (index < 0) {
                    index = 0;
                }

                const move = (100 / visible) * index;

                track.style.transform = `translateX(-${move}%)`;

                updateArrowVisibility();
            }

            /* =====================================================
               TAMPILKAN / SEMBUNYIKAN PANAH
            ====================================================== */

            function updateArrowVisibility() {
                if (!prev || !next) {
                    return;
                }

                const visible = getVisible();

                const maxIndex = Math.max(cards.length - visible, 0);

                /*
                |--------------------------------------------------------------------------
                | Tidak ada slider kalau jumlah card:
                |
                | Desktop = 3 atau kurang
                | Mobile  = 2 atau kurang
                |--------------------------------------------------------------------------
                */

                if (cards.length <= visible) {
                    prev.classList.add("hidden");
                    next.classList.add("hidden");

                    return;
                }

                /*
                |--------------------------------------------------------------------------
                | ADA SLIDER
                |--------------------------------------------------------------------------
                */

                prev.classList.remove("hidden");
                next.classList.remove("hidden");

                /*
                |--------------------------------------------------------------------------
                | PANAH KIRI
                |
                | Hanya muncul kalau sudah bergeser.
                |
                | index = 0
                |     → kiri disembunyikan
                |
                | index > 0
                |     → kiri muncul
                |--------------------------------------------------------------------------
                */

                if (index <= 0) {
                    prev.classList.add("hidden");
                } else {
                    prev.classList.remove("hidden");
                }

                /*
                |--------------------------------------------------------------------------
                | PANAH KANAN
                |
                | Kalau sudah sampai posisi terakhir,
                | panah kanan disembunyikan.
                |--------------------------------------------------------------------------
                */

                if (index >= maxIndex) {
                    next.classList.add("hidden");
                } else {
                    next.classList.remove("hidden");
                }
            }

            /* =====================================================
               NEXT
            ====================================================== */

            if (next) {
                next.addEventListener("click", function() {
                    const visible = getVisible();

                    const maxIndex = Math.max(cards.length - visible, 0);

                    if (index < maxIndex) {
                        index++;

                        updateSlider();
                    }
                });
            }

            /* =====================================================
               PREVIOUS
            ====================================================== */

            if (prev) {
                prev.addEventListener("click", function() {
                    if (index > 0) {
                        index--;

                        updateSlider();
                    }
                });
            }

            /* =====================================================
               RESPONSIVE
            ====================================================== */

            window.addEventListener("resize", function() {
                updateSlider();
            });

            updateSlider();
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const button = document.getElementById("toggleTermsButton");

            if (!button) {
                return;
            }

            const extraTerms = document.querySelectorAll(".extra-term");
            const text = button.querySelector("span");
            const icon = button.querySelector("i");

            button.addEventListener("click", function() {
                const currentlyHidden =
                    extraTerms.length > 0 &&
                    extraTerms[0].classList.contains("hidden");

                extraTerms.forEach(function(term) {
                    term.classList.toggle("hidden", !currentlyHidden);
                });

                if (currentlyHidden) {
                    text.textContent = "Sembunyikan";

                    icon.classList.remove("uil-angle-down");
                    icon.classList.add("uil-angle-up");
                } else {
                    text.textContent = "Lihat Selengkapnya";

                    icon.classList.remove("uil-angle-up");
                    icon.classList.add("uil-angle-down");
                }
            });
        });
    </script>
</x-layout>
