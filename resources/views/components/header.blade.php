@php
    use App\Models\HeaderSetting;
    use App\Models\HomeSetting;

    $header = HeaderSetting::first();
    $settings = HomeSetting::first();

    // =========================================================
    // JUDUL HERO
    // Tetap menerima input Admin, tetapi bagian setelah kata
    // pertama dibuat gradasi seperti desain awal.
    // =========================================================
    $heroTitle = trim($settings?->hero_title ?? 'Resto Joss Gandos');

    $titleParts = preg_split('/\s+/', $heroTitle, 2);

    $heroFirstWord = $titleParts[0] ?? 'Resto';
    $heroGradientText = $titleParts[1] ?? '';
@endphp

<section
    class="relative fade-section opacity-0 translate-y-10 transition-all duration-1000 pt-24 pb-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto relative h-[600px] md:h-[650px] rounded-[2.5rem] overflow-hidden shadow-2xl">
        {{-- =========================================================
             VIDEO HEADER
        ========================================================== --}}
        <div class="absolute inset-0 z-0 bg-black">
            @if ($header && $header->video_type === 'youtube' && !empty($header->youtube_id))
                <iframe id="bg-video"
                    class="absolute top-1/2 left-1/2 h-full w-auto aspect-video -translate-x-1/2 -translate-y-1/2 pointer-events-none transform scale-[2] md:w-full md:h-full md:scale-[1.5]"
                    src="https://www.youtube.com/embed/{{ $header->youtube_id }}?autoplay=1&mute=1&controls=0&loop=1&playlist={{ $header->youtube_id }}&playsinline=1&rel=0&modestbranding=1&iv_load_policy=3&disablekb=1&fs=0&enablejsapi=1&origin={{ url('/') }}"
                    title="Header Video Resto Joss Gandos" frameborder="0" allow="autoplay; encrypted-media"
                    allowfullscreen></iframe>
            @elseif ($header && $header->video_type === 'tiktok' && !empty($header->tiktok_url))
                @php

                    $tiktokId = null;

                    if (preg_match('~video/(\d+)~', $header->tiktok_url, $tiktokMatch)) {
                        $tiktokId = $tiktokMatch[1];
                    }

                @endphp

                @if ($tiktokId)
                    <iframe id="bg-video"
                        class="absolute top-1/2 left-1/2 w-full h-full -translate-x-1/2 -translate-y-1/2 pointer-events-none scale-[1.8] md:scale-[1.8]"
                        src="https://www.tiktok.com/player/v1/{{ $tiktokId }}?autoplay=1&loop=1&muted=1&controls=0&description=0&music_info=0"
                        title="Header Video Resto Joss Gandos" frameborder="0" allow="autoplay; fullscreen"
                        allowfullscreen></iframe>
                @endif
            @elseif ($header && $header->video_type === 'file' && !empty($header->video_path))
                <video id="bg-video" class="w-full h-full object-cover pointer-events-none transform scale-[1.35]"
                    autoplay muted loop playsinline preload="auto">
                    <source src="{{ asset('storage/' . ltrim($header->video_path, '/')) }}" type="video/mp4" />
                </video>
            @else
                {{-- FALLBACK --}}
                <iframe id="bg-video" class="w-full h-full object-cover pointer-events-none"
                    src="https://www.youtube.com/embed/b2y8iRP0eXg?autoplay=1&mute=1&controls=0&loop=1&playlist=b2y8iRP0eXg&playsinline=1&rel=0&modestbranding=1&iv_load_policy=3&disablekb=1&fs=0&enablejsapi=1&origin={{ url('/') }}"
                    title="Header Video Resto Joss Gandos" frameborder="0" allow="autoplay; encrypted-media"
                    allowfullscreen></iframe>
            @endif
        </div>

        {{-- =========================================================
             OVERLAY
        ========================================================== --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-black/30 z-10"></div>

        {{-- =========================================================
             CONTENT
        ========================================================== --}}
        <div class="relative z-20 flex flex-col items-center justify-center h-full text-center px-4">
            {{-- =====================================================
                 BADGE
            ====================================================== --}}
            <span
                class="inline-block py-1 px-4 rounded-full bg-red-600/90 backdrop-blur-md text-white text-xs md:text-sm font-bold tracking-[0.2em] uppercase mb-6 border border-red-500/50">
                {{ $settings?->hero_badge ?? 'Est. 2017' }}
            </span>

            {{-- =====================================================
                 JUDUL
            ====================================================== --}}
            <h1
                class="text-4xl sm:text-6xl md:text-7xl font-serif font-bold text-white mb-4 drop-shadow-lg tracking-wide">
                {{ $heroFirstWord }}

                @if ($heroGradientText)
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-yellow-400">
                        {{ $heroGradientText }}
                    </span>
                @endif
            </h1>

            {{-- =====================================================
                 SUBTITLE
            ====================================================== --}}
            <p class="mt-2 text-lg sm:text-xl font-light text-gray-100 tracking-wider mb-10">
                {{ $settings?->hero_subtitle ?? 'Pelopor No. 1 Resto dan Cafe di Jemursari' }}
            </p>

            {{-- =====================================================
                 TOMBOL
            ====================================================== --}}
            <div class="grid grid-cols-2 sm:flex sm:flex-wrap justify-center gap-4 w-full max-w-3xl">
                {{-- ================= TENTANG ================= --}}
                <a href="{{ url('/about') }}"
                    class="group relative px-6 py-3.5 rounded-full bg-white/10 backdrop-blur-md border border-white/30 text-white font-medium transition-all duration-300 hover:bg-white hover:text-red-700 hover:scale-105 hover:border-white shadow-lg flex items-center justify-center gap-2">
                    <span>Tentang Kami</span>

                    <svg class="w-5 h-5 flex-shrink-0 transition-transform group-hover:translate-x-1" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </a>

                {{-- ================= MENU ================= --}}
                <a href="{{ url('/menu') }}"
                    class="group relative px-6 py-3.5 rounded-full bg-white/10 backdrop-blur-md border border-white/30 text-white font-medium transition-all duration-300 hover:bg-white hover:text-red-700 hover:scale-105 hover:border-white shadow-lg flex items-center justify-center gap-2">
                    <span>Menu Kami</span>

                    <svg class="w-5 h-5 flex-shrink-0 transition-transform group-hover:-translate-y-1" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M9 4.5h6M9 4.5A1.5 1.5 0 0110.5 3h3A1.5 1.5 0 0115 4.5M9 4.5H7.5A1.5 1.5 0 006 6v13.5A1.5 1.5 0 007.5 21h9a1.5 1.5 0 001.5-1.5V6A1.5 1.5 0 0016.5 4.5H15M9 9h6M9 13h6M9 17h3">
                        </path>
                    </svg>
                </a>

                {{-- ================= GALERI ================= --}}
                <a href="{{ url('/gallery') }}"
                    class="group relative px-6 py-3.5 rounded-full bg-white/10 backdrop-blur-md border border-white/30 text-white font-medium transition-all duration-300 hover:bg-white hover:text-red-700 hover:scale-105 hover:border-white shadow-lg flex items-center justify-center gap-2">
                    <span>Galeri Kami</span>

                    <svg class="w-5 h-5 flex-shrink-0 transition-transform group-hover:rotate-6" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </a>

                {{-- ================= RESERVASI ================= --}}
                <a href="{{ url('/reservation') }}"
                    class="group relative px-6 py-3.5 rounded-full bg-white/10 backdrop-blur-md border border-white/30 text-white font-medium transition-all duration-300 hover:bg-white hover:text-red-700 hover:scale-105 hover:border-white shadow-lg flex items-center justify-center gap-2">
                    <span>Reservasi</span>

                    <svg class="w-5 h-5 flex-shrink-0 transition-transform group-hover:scale-110" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    {{-- =========================================================
         FADE ANIMATION + YOUTUBE AUTOPLAY
    ========================================================== --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const sections = document.querySelectorAll(".fade-section");

            if (sections.length) {
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
                        threshold: 0.2,
                    },
                );

                sections.forEach((section) => {
                    observer.observe(section);
                });
            }

            // =====================================================
            // PAKSA YOUTUBE PLAY
            // Supaya tombol Play dari embed tidak terus muncul
            // =====================================================
            const bgVideo = document.getElementById("bg-video");

            if (bgVideo && bgVideo.tagName === "IFRAME") {
                bgVideo.addEventListener("load", function() {
                    setTimeout(() => {
                        bgVideo.contentWindow.postMessage(
                            JSON.stringify({
                                event: "command",
                                func: "playVideo",
                                args: [],
                            }),
                            "*",
                        );
                    }, 1000);
                });
            }
        });
    </script>
</section>
