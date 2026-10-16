<x-layout>
    <main class="min-h-screen bg-white w-full overflow-x-hidden">
        {{-- ================= HEADER ABOUT ================= --}}
        <section class="bg-white pt-6 pb-2">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- CARD HEADER --}}
                <div
                    class="relative h-[350px] sm:h-[390px] lg:h-[420px] overflow-hidden rounded-[2rem] shadow-[0_12px_30px_rgba(0,0,0,0.16)]">
                    {{-- GAMBAR HEADER DARI ADMIN --}}
                    @if ($about && $about->hero_image)
                        <img src="{{ $about->hero_image }}" alt="{{ $about->hero_title }}"
                            class="absolute inset-0 w-full h-full object-cover" />
                    @else
                        <div class="absolute inset-0 bg-stone-100"></div>
                    @endif

                    {{-- ================= TEKS KIRI ================= --}}
                    <div class="absolute left-0 top-0 h-full w-[40%] flex items-start z-10">
                        <div class="relative pt-[88px] pl-8 sm:pl-10 lg:pl-12 pr-3 max-w-[390px]">
                            {{-- LABEL --}}
                            <div class="mb-4">
                                <p class="text-[10px] sm:text-[11px] font-bold tracking-[3px] uppercase text-red-600">
                                    Tentang Kami</p>

                                {{-- GARIS --}}
                                <div class="mt-2 w-12 h-[2px] bg-[#B65F18]"></div>
                            </div>

                            {{-- JUDUL --}}
                            <h1
                                class="text-[30px] sm:text-[35px] lg:text-[40px] font-serif font-bold tracking-[-0.5px] leading-[1.05] text-[#111827] max-w-[350px]">
                                {{ $about->hero_title }}
                            </h1>

                            {{-- SUBTITLE --}}
                            @if ($about->hero_subtitle)
                                <p
                                    class="mt-4 text-[15px] sm:text-[17px] lg:text-[18px] font-serif italic leading-[1.4] text-[#B65F18] max-w-[340px]">
                                    {{ $about->hero_subtitle }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="h-8"></div>

        <div id="about-page" class="page-content relative z-10 pb-20">
            {{-- ================= SEJARAH + VISI + MISI + TIMELINE ================= --}}
            {{-- =========================================================
     SEJARAH + VISI + MISI + PERJALANAN
========================================================= --}}
            <section class="pb-14">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid lg:grid-cols-12 gap-6 items-stretch">
                        {{-- =====================================================
                 KOLOM KIRI
                 SEJARAH
                 VISI
                 MISI
            ===================================================== --}}
                        <div class="lg:col-span-6 flex flex-col gap-5">
                            {{-- =================================================
                     CARD SEJARAH
                ================================================= --}}
                            <div
                                class="about-story-card bg-white rounded-[1.8rem] border border-stone-200 shadow-[0_8px_25px_rgba(0,0,0,0.07)] p-7 md:p-8">
                                {{-- HEADER SEJARAH --}}
                                <div class="flex items-center gap-4 mb-5">
                                    <h2
                                        class="about-title-animate text-[25px] md:text-[32px] lg:text-[34px] font-serif font-bold tracking-[-0.4px] bg-gradient-to-r from-[#172033] via-[#5E3A20] to-[#B65F18] bg-clip-text text-transparent whitespace-nowrap">
                                        Sejarah Kami
                                    </h2>

                                    <div
                                        class="about-line-animate h-[2px] bg-gradient-to-r from-[#B65F18] to-transparent flex-1">
                                    </div>
                                </div>

                                {{-- JUDUL STORY --}}
                                <h3
                                    class="about-content-animate font-serif font-bold text-[21px] md:text-[23px] leading-[1.25] tracking-[-0.3px] text-[#172033] mb-4">
                                    {{ $about->story_title }}
                                </h3>

                                {{-- ISI STORY --}}
                                <div
                                    class="about-content-animate text-[12.5px] md:text-[15px] lg:text-[15.5px] leading-[1.75] tracking-[0.05px] text-slate-500 space-y-4">
                                    {!! nl2br(e($about->story_content)) !!}
                                </div>
                            </div>

                            {{-- =================================================
                     CARD VISI
                     BERDIRI SENDIRI
                ================================================= --}}
                            <div
                                class="about-vision-card bg-white rounded-[1.6rem] border border-stone-200 shadow-[0_7px_22px_rgba(0,0,0,0.06)] p-5">
                                <div class="flex gap-4">
                                    {{-- ICON VISI --}}
                                    <div
                                        class="about-icon-animate flex-shrink-0 w-10 h-10 rounded-full bg-red-50 text-red-600 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />

                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </div>

                                    {{-- CONTENT VISI --}}
                                    <div class="flex-1">
                                        <button type="button" class="vision-toggle text-left">
                                            <h4
                                                class="font-serif font-bold text-[15px] md:text-[18px] lg:text-[19px] text-[#172033]">
                                                Visi Kami
                                            </h4>

                                            <span
                                                class="vision-underline block mt-1 h-[2px] w-7 rounded-full bg-gradient-to-r from-red-500 to-[#B65F18] transition-all duration-500">
                                            </span>
                                        </button>

                                        <p
                                            class="about-content-animate mt-2 text-[12px] md:text-[14px] lg:text-[14.5px] leading-[1.7] text-slate-500">
                                            {{ $about->vision }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- =================================================
                     CARD MISI
                     BERDIRI SENDIRI
                ================================================= --}}
                            <div
                                class="about-mission-card bg-white rounded-[1.6rem] border border-stone-200 shadow-[0_7px_22px_rgba(0,0,0,0.06)] p-5">
                                <div class="flex gap-4">
                                    {{-- ICON MISI --}}
                                    <div
                                        class="about-icon-animate flex-shrink-0 w-10 h-10 rounded-full bg-orange-50 text-[#B65F18] flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v12M6 12h12" />
                                        </svg>
                                    </div>

                                    {{-- CONTENT MISI --}}
                                    <div class="flex-1">
                                        <button type="button" class="mission-toggle text-left">
                                            <h4
                                                class="font-serif font-bold text-[15px] md:text-[18px] lg:text-[19px] text-[#172033]">
                                                Misi Kami
                                            </h4>

                                            <span
                                                class="mission-underline block mt-1 h-[2px] w-7 rounded-full bg-gradient-to-r from-[#B65F18] to-red-500 transition-all duration-500">
                                            </span>
                                        </button>

                                        {{-- MISI BERNOMOR --}}
                                        <ol class="mt-3 space-y-2.5">
                                            @foreach ($missions as $index => $mission)
                                                <li class="mission-item flex items-start gap-3">
                                                    {{-- NOMOR --}}
                                                    <span
                                                        class="flex-shrink-0 w-5 h-5 rounded-full bg-red-50 text-red-600 text-[9px] font-bold flex items-center justify-center mt-[1px]">
                                                        {{ $index + 1 }}
                                                    </span>

                                                    {{-- TEKS MISI --}}
                                                    <span
                                                        class="text-[11.5px] md:text-[14px] lg:text-[14.5px] leading-[1.7] text-slate-500">
                                                        {{ $mission->mission }}
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- =====================================================
                 KOLOM KANAN
                 PERJALANAN RESTO JOSS GANDOS
            ===================================================== --}}
                        <div class="lg:col-span-6 h-full timeline-column">
                            <div
                                class="timeline-card -mx-2 md:mx-0 bg-white rounded-[1.8rem] border border-stone-200 shadow-[0_10px_30px_rgba(0,0,0,0.08)] px-4 py-7 md:p-8 flex flex-col h-full min-h-0 overflow-visible md:overflow-hidden">
                                {{-- =================================================
                         HEADER PERJALANAN
                    ================================================= --}}
                                <div class="mb-6">
                                    <div class="flex items-center gap-4">
                                        <h2
                                            class="about-title-animate text-[22px] md:text-[20px] font-serif font-bold tracking-[-0.4px] bg-gradient-to-r from-[#172033] via-[#5E3A20] to-[#C62828] bg-clip-text text-transparent whitespace-nowrap">
                                            PERJALANAN RESTO JOSS GANDOS
                                        </h2>

                                        <div
                                            class="about-line-animate h-[2px] flex-1 bg-gradient-to-r from-[#B65F18] to-transparent">
                                        </div>
                                    </div>

                                    {{-- SUBTITLE --}}
                                    <p
                                        class="timeline-subtitle mt-2 text-[13px] md:text-[14px] font-serif italic text-[#B65F18]">
                                        "Dari langkah kecil hingga menjadi resto kebanggaan bersama"</p>
                                </div>

                                {{-- =================================================
                         TIMELINE
                    ================================================= --}}
                                <div class="relative flex-1 min-h-0 overflow-y-auto pr-3 timeline-scroll">
                                    {{-- LIST TIMELINE --}}
                                    <div class="relative timeline-list space-y-4 pb-4">
                                        {{-- GARIS TIMELINE
                                 TINGGI OTOMATIS SESUAI ISI --}}
                                        <div
                                            class="timeline-line absolute left-[28px] top-[27px] bottom-[27px] w-[2px] bg-gradient-to-b from-red-500 via-red-500 to-red-300">
                                        </div>

                                        {{-- DATA TIMELINE DARI DATABASE --}}
                                        @foreach ($timelines as $timeline)
                                            <div class="relative grid grid-cols-[58px_minmax(0,1fr)] gap-4 items-start">
                                                {{-- =============================
                                         TAHUN
                                    ============================== --}}
                                                <div class="relative z-10 flex justify-center">
                                                    <div
                                                        class="timeline-year w-[54px] h-[54px] rounded-full bg-gradient-to-br from-red-600 to-red-700 text-white flex items-center justify-center text-[10px] font-bold text-center leading-[1.15] border-4 border-white shadow-[0_4px_12px_rgba(185,28,28,0.25)]">
                                                        {{ $timeline->year }}
                                                    </div>
                                                </div>

                                                {{-- =============================
                                         CONTENT TIMELINE
                                    ============================== --}}
                                                <div
                                                    class="timeline-content min-w-0 bg-white border border-stone-200 rounded-[1rem] px-5 py-3.5 shadow-[0_3px_12px_rgba(0,0,0,0.04)]">
                                                    <div class="flex items-center justify-between gap-4">
                                                        {{-- JUDUL --}}
                                                        <h3
                                                            class="timeline-title font-semibold text-[13px] md:text-[14px] text-[#C62828] tracking-[-0.1px]">
                                                            {{ $timeline->title }}
                                                        </h3>

                                                        {{-- BUTTON --}}
                                                        <button type="button"
                                                            class="timeline-toggle flex-shrink-0 w-7 h-7 rounded-full border border-stone-200 flex items-center justify-center text-slate-400 hover:text-red-600 hover:border-red-200 transition">
                                                            <svg class="w-3.5 h-3.5 transition-transform duration-300"
                                                                fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M19 9l-7 7-7-7" />
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    {{-- =============================
                                             DESKRIPSI TIMELINE
                                        ============================== --}}
                                                    <div
                                                        class="timeline-description hidden mt-3 pt-3 border-t border-stone-100">
                                                        @php
                                                            $description = trim($timeline->description ?? '');

                                                            // Pecah berdasarkan baris atau sebelum nomor baru
                                                            $descriptionParts = preg_split(
                                                                '/(?:\r\n|\r|\n)+|(?=\d+\.\s+)/',
                                                                $description,
                                                                -1,
                                                                PREG_SPLIT_NO_EMPTY,
                                                            );

                                                            // Aktif jika isi diawali pola "1. "
                                                            $isNumbered = preg_match('/^\s*1\.\s+/', $description);
                                                        @endphp

                                                        @if ($isNumbered)
                                                            <ol
                                                                class="list-decimal list-outside ml-5 space-y-2 break-words text-[11.5px] md:text-[13.5px] lg:text-[14px] leading-[1.7] text-slate-500">
                                                                @foreach ($descriptionParts as $part)
                                                                    @php
                                                                        // Buang nomor "1.", "2.", "3." dari teks
                                                                        $cleanPart = preg_replace(
                                                                            '/^\s*\d+\.\s*/',
                                                                            '',
                                                                            trim($part),
                                                                        );
                                                                    @endphp

                                                                    @if ($cleanPart !== '')
                                                                        <li>
                                                                            {{ $cleanPart }}
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            </ol>
                                                        @else
                                                            <p
                                                                class="text-[11.5px] md:text-[13.5px] lg:text-[14px] leading-[1.7] text-slate-500">
                                                                {!! nl2br(e($description)) !!}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="pt-4 pb-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div
                        class="bg-white/80 backdrop-blur-md rounded-[2.5rem] p-8 md:p-12 shadow-2xl border border-white relative overflow-hidden">
                        {{-- DEKORASI --}}
                        <div class="absolute -top-20 -left-20 w-64 h-64 bg-yellow-100 rounded-full blur-3xl opacity-70">
                        </div>

                        <div
                            class="absolute -bottom-20 -right-20 w-64 h-64 bg-red-100 rounded-full blur-3xl opacity-70">
                        </div>

                        <div class="grid md:grid-cols-2 gap-12 items-center relative z-10">
                            {{-- FOTO PENDIRI --}}
                            <div class="relative group">
                                <div
                                    class="absolute inset-0 bg-gradient-to-tr from-red-600 to-yellow-400 rounded-[2rem] rotate-3 opacity-70 group-hover:rotate-6 transition-transform duration-500">
                                </div>

                                <div
                                    class="relative rounded-[1.5rem] overflow-hidden shadow-lg border-4 border-white bg-white aspect-square founder-photo">
                                    @if ($about && $about->founder_photo)
                                        <img src="{{ $about->founder_photo }}" alt="{{ $about->founder_name }}"
                                            class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700" />
                                    @endif
                                </div>
                            </div>

                            {{-- INFORMASI PENDIRI --}}
                            <div class="text-center md:text-left">
                                <p
                                    class="founder-label text-[10px] md:text-[11px] lg:text-[11px] font-bold tracking-[3px] uppercase text-red-600 mb-3">
                                    {{ $about->founder_position }}
                                </p>

                                <h2
                                    class="founder-name text-[23px] md:text-[23px] lg:text-[23px] font-serif font-bold text-gray-800 mb-4">
                                    {{ $about->founder_name }}
                                </h2>

                                <div
                                    class="founder-description space-y-5 text-[12.5px] md:text-[15px] lg:text-[15.5px] leading-[1.75] text-slate-500">
                                    <p>
                                        {!! nl2br(e($about->founder_description)) !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ================= TIM KAMI ================= --}}
            <section class="pt-8 pb-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {{-- HEADER --}}
                    <div class="text-center mb-8">
                        {{-- JUDUL UTAMA --}}
                        <h2
                            class="text-3xl md:text-4xl lg:text-5xl font-serif font-bold tracking-tight text-[#172033]">
                            TIM KAMI
                        </h2>

                        {{-- GARIS --}}
                        <div class="mx-auto mt-3 mb-3 w-12 h-[2px] bg-gradient-to-r from-red-500 to-yellow-400"></div>

                        {{-- DESKRIPSI KECIL --}}
                        <p class="max-w-xl mx-auto text-xs md:text-sm leading-relaxed text-slate-500">Orang-orang
                            berdedikasi di balik layar yang memastikan pengalaman bersantap Anda sempurna.</p>
                    </div>

                    {{-- ================= CAROUSEL ================= --}}
                    <div class="relative">
                        {{-- TOMBOL KIRI --}}
                        @if ($teams->count() > 3)
                            <button type="button" id="team-prev"
                                class="team-arrow team-prev absolute left-0 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white border border-stone-200 shadow-md flex items-center justify-center text-gray-700 hover:bg-red-600 hover:text-white transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                        @endif

                        {{-- AREA CARD --}}
                        <div id="team-viewport" class="overflow-hidden mx-12">
                            <div id="team-track" class="flex gap-5 transition-transform duration-500 ease-out">
                                @foreach ($teams as $team)
                                    <div
                                        class="team-card group relative flex-shrink-0 w-full sm:w-[calc((100%_-_20px)/2)] lg:w-[calc((100%_-_40px)/3)] h-[400px] rounded-2xl overflow-hidden bg-gray-100 shadow-sm cursor-pointer">
                                        {{-- FOTO --}}
                                        <img src="{{ $team->photo }}" alt="{{ $team->name }}"
                                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />

                                        {{-- OVERLAY --}}
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent transition-opacity duration-300">
                                        </div>

                                        {{-- INFO --}}
                                        <div class="team-info absolute left-0 bottom-0 w-full p-6">
                                            {{-- NAMA --}}
                                            <h3 class="text-xl md:text-2xl font-bold text-white leading-tight mb-1">
                                                {{ $team->name }}
                                            </h3>

                                            {{-- JABATAN --}}
                                            <p
                                                class="text-yellow-400 font-semibold uppercase tracking-wide text-xs md:text-sm">
                                                {{ $team->position }}
                                            </p>

                                            {{-- GARIS KUNING --}}
                                            <div
                                                class="team-line mt-3 mb-3 w-10 h-[2px] bg-yellow-400 opacity-0 scale-x-0 origin-left group-hover:opacity-100 group-hover:scale-x-100 transition-all duration-500">
                                            </div>

                                            {{-- DESKRIPSI --}}
                                            <p
                                                class="team-description text-gray-200 text-xs md:text-sm leading-relaxed max-w-full opacity-0 translate-y-3 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-500">
                                                {{ $team->description }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- TOMBOL KANAN --}}
                        @if ($teams->count() > 3)
                            <button type="button" id="team-next"
                                class="team-arrow team-next absolute right-0 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-red-600 text-white shadow-md flex items-center justify-center hover:bg-red-700 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        @endif
                    </div>

                    {{-- INDICATOR --}}
                    <div id="team-dots" class="flex justify-center gap-2 mt-6"></div>
                </div>
            </section>
        </div>
    </main>

    @include ('layouts.aboutstyle')
</x-layout>
