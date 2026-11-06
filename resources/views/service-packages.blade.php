@php
    /*
    |--------------------------------------------------------------------------
    | DATA UNTUK JAVASCRIPT
    |--------------------------------------------------------------------------
    */
    $packageData = $packages
        ->map(function ($package) {
            $imagePath = trim((string) ($package->image_path ?? ''));

            // Abaikan URL gambar eksternal; gunakan path penyimpanan lokal saja.
            if (
                preg_match('/^(?:[a-z][a-z0-9+.-]*:)?\/\//i', $imagePath) === 1 ||
                preg_match('/^(?:data|blob):/i', $imagePath) === 1
            ) {
                $image = '';
            } elseif (\Illuminate\Support\Str::startsWith($imagePath, '/storage/')) {
                $image = asset(ltrim($imagePath, '/'));
            } elseif (\Illuminate\Support\Str::startsWith($imagePath, 'storage/')) {
                $image = asset($imagePath);
            } elseif (\Illuminate\Support\Str::startsWith($imagePath, 'public/storage/')) {
                $image = asset(substr($imagePath, strlen('public/')));
            } else {
                $image = asset('storage/' . ltrim($imagePath, '/'));
            }

            return [
                'id' => $package->id,
                'title' => $package->title,
                'price' => $package->price,
                'capacity' => $package->capacity,
                'description' => $package->description,
                'category' => $package->category,
                'image' => $image,
            ];
        })
        ->values()
        ->toArray();
    /*
    |--------------------------------------------------------------------------
    | JUMLAH PER KATEGORI
    |--------------------------------------------------------------------------
    */
    $allCount = $packages->count();
    $packageMenuCount = $packages->where('category', 'package_menu')->count();
    $cateringPackageCount = $packages->where('category', 'catering_package')->count();
    $weddingPackageCount = $packages->where('category', 'wedding_package')->count();
@endphp
<x-layout>
    <style>
        /* =========================================================
                   BACKGROUND
                ========================================================== */
        html,
        body {
            margin: 0;
            min-height: 100%;
            background: #fffaf3;
            overflow-x: hidden;
            overflow-y: scroll;
        }

        .package-page-bg {
            min-height: 100vh;
            width: 100%;
            overflow: visible !important;
            background:
                radial-gradient(circle at 8% 18%,
                    rgba(220, 38, 38, 0.05),
                    transparent 24%),
                radial-gradient(circle at 92% 72%,
                    rgba(234, 179, 8, 0.05),
                    transparent 24%),
                linear-gradient(180deg,
                    #fffdf9 0%,
                    #fffaf3 52%,
                    #fffdf9 100%);
        }

        .package-page-bg::before {
            content: "";
            position: fixed;
            inset: 0;
            z-index: -1;
            pointer-events: none;
            background:
                radial-gradient(circle at 8% 18%,
                    rgba(220, 38, 38, 0.05),
                    transparent 24%),
                radial-gradient(circle at 92% 72%,
                    rgba(234, 179, 8, 0.05),
                    transparent 24%),
                linear-gradient(180deg, #fffdf9 0%, #fffaf3 52%, #fffdf9 100%);
        }

        /* =========================================================
                   ORNAMEN
                ========================================================== */
        .package-decoration {
            pointer-events: none;
            position: absolute;
            opacity: 0.45;
        }

        .package-decoration-left {
            left: -40px;
            top: 180px;
        }

        .package-decoration-right {
            right: -40px;
            top: 560px;
        }

        /* =========================================================
                   FILTER
                ========================================================== */
        .package-filter {
            transition:
                background-color 250ms ease,
                color 250ms ease,
                border-color 250ms ease,
                transform 250ms ease,
                box-shadow 250ms ease;
        }

        .package-filter:hover {
            transform: translateY(-1px);
        }

        /* =========================================================
                   PACKAGE CARD
                ========================================================== */
        .package-card {
            background: #ffffff;
            transition:
                transform 300ms ease,
                box-shadow 300ms ease;
        }

        .package-card:hover {
            transform: translateY(-5px);
        }

        .package-card-image {
            aspect-ratio: 4 / 3;
        }

        .package-price {
            color: #ef1f25;
            font-size: 0.875rem;
            line-height: 1.25rem;
            font-weight: 700;
        }

        .package-card-detail {
            transition: background-color 250ms ease, color 250ms ease, border-color 250ms ease;
        }

        /* =========================================================
                   CATEGORY BADGE
                ========================================================== */
        .package-category-badge {
            backdrop-filter: blur(8px);
        }

        /* =========================================================
                   MODAL
                ========================================================== */
        .package-modal-image {
            max-height: 78vh;
        }

        .package-modal-panel {
            width: min(1100px, 94vw);
            height: min(760px, 88vh);
            max-height: 88vh;
            overflow: hidden;
        }

        .package-modal-left {
            min-height: 0;
            display: flex;
            flex-direction: column;
        }

        .package-modal-gallery {
            min-height: 0;
            flex: 1;
        }

        .package-modal-right {
            min-height: 0;
            display: flex;
            flex-direction: column;
        }

        .package-modal-content {
            min-height: 0;
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .package-modal-content::-webkit-scrollbar {
            width: 10px;
        }

        .package-modal-content::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 999px;
        }

        .package-modal-content::-webkit-scrollbar-track {
            background: transparent;
        }

        #packageModalDescription {
            max-height: none;
            overflow: visible;
            padding-right: 0;
        }

        #packageModalDescription::-webkit-scrollbar {
            width: 6px;
        }

        #packageModalDescription::-webkit-scrollbar-thumb {
            background: #ef4444;
            border-radius: 999px;
        }

        #packageModalDescription::-webkit-scrollbar-track {
            background: #fee2e2;
            border-radius: 999px;
        }

        .package-modal-info-box {
            background: #fff1f2;
            border: 1px solid #fecdd3;
            border-radius: 16px;
        }

        .package-modal-thumbnails {
            display: flex;
            gap: 0.6rem;
            overflow-x: auto;
            padding: 0.1rem 0.05rem 0.35rem;
            scrollbar-width: thin;
        }

        .package-modal-thumbnail {
            width: 54px;
            height: 42px;
            flex: 0 0 auto;
            border-radius: 0.7rem;
            overflow: hidden;
            border: 2px solid transparent;
            background: #e2e8f0;
            transition: border-color 180ms ease, transform 180ms ease, opacity 180ms ease;
        }

        .package-modal-thumbnail:hover {
            transform: translateY(-1px);
        }

        .package-modal-thumbnail.active {
            border-color: #ef1f25;
        }

        .package-modal-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .package-modal-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        @media (max-width: 767px) {
            .package-modal-actions {
                grid-template-columns: 1fr;
            }

            .package-modal-thumbnail {
                width: 50px;
                height: 40px;
            }

            .package-modal-panel {
                height: 88vh;
                overflow-y: auto;
                overflow-x: hidden;
                scrollbar-width: auto;
                scrollbar-color: #94a3b8 transparent;
            }

            .package-modal-right {
                display: block;
                overflow: visible;
            }

            .package-modal-content {
                min-height: auto;
                flex: none;
                overflow: visible;
            }

            .package-category-badge {
                top: 3px;
                left: 3px;
                padding: 4px 9px;
                gap: 4px;
                font-size: 10px;
            }

            .package-category-badge i {
                font-size: 11px;
            }

            .package-modal-gallery {
                height: 290px;
                min-height: 290px;
                max-height: 290px;
                flex: 0 0 290px;
            }

            .package-modal-gallery img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        }

        .package-modal-check {
            width: 20px;
            height: 20px;
            flex: 0 0 20px;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #ef1f25;
            color: #ffffff;
            font-size: 12px;
            margin-top: 2px;
        }

        /* =========================================================
           MODAL ANIMATION
        ========================================================= */
        #packageModal .package-modal-panel {
            opacity: 0;
            transform: scale(0.96) translateY(12px);
            transition:
                opacity 0.3s ease,
                transform 0.3s ease;
        }

        #packageModal.flex .package-modal-panel {
            opacity: 1;
            transform: scale(1) translateY(0);
        }

        #packageModalImage {
            opacity: 1;
            transform: scale(1);
            transition:
                opacity 0.25s ease,
                transform 0.35s ease;
        }

        #packageModalImage.package-changing {
            opacity: 0;
            transform: scale(0.97);
        }

        #packageModalTitle,
        #packageModalCategory,
        #packageModalPrice,
        #packageModalDescription {
            transition:
                opacity 0.25s ease,
                transform 0.25s ease;
        }

        .modal-content-changing {
            opacity: 0;
            transform: translateY(8px);
        }
    </style>
    <main class="package-page-bg min-h-screen w-full relative">
        {{-- =========================================================
             ORNAMEN KIRI
        ========================================================== --}}
        <div class="package-decoration package-decoration-left">
            <svg width="190" height="250" viewBox="0 0 190 250" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 238C42 193 72 155 118 137C145 126 161 108 171 77" stroke="#ef4444" stroke-opacity=".12"
                    stroke-width="2" />
                <path d="M39 201C29 180 29 158 42 140C62 153 72 172 69 192" stroke="#ef4444" stroke-opacity=".12"
                    stroke-width="2" />
                <path d="M70 165C72 139 84 119 104 107C113 132 104 154 85 170" stroke="#ef4444" stroke-opacity=".12"
                    stroke-width="2" />
                <path d="M96 137C110 115 131 102 152 101C151 126 132 140 106 143" stroke="#ef4444" stroke-opacity=".12"
                    stroke-width="2" />
            </svg>
        </div>
        {{-- =========================================================
             ORNAMEN KANAN
        ========================================================== --}}
        <div class="package-decoration package-decoration-right">
            <svg width="200" height="260" viewBox="0 0 200 260" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M181 18C157 61 129 97 78 118C48 130 32 149 21 180" stroke="#eab308" stroke-opacity=".10"
                    stroke-width="2" />
                <path d="M163 56C170 80 166 101 151 116C130 104 124 83 133 63" stroke="#eab308" stroke-opacity=".10"
                    stroke-width="2" />
                <path d="M124 93C123 117 111 136 92 147C83 123 94 103 115 91" stroke="#eab308" stroke-opacity=".10"
                    stroke-width="2" />
                <path d="M94 125C79 147 58 158 37 157C40 134 60 121 84 119" stroke="#eab308" stroke-opacity=".10"
                    stroke-width="2" />
            </svg>
        </div>
        {{-- =========================================================
             KONTEN UTAMA
        ========================================================== --}}
        <section class="relative z-10 py-10 md:py-14 lg:py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- =================================================
                     KEMBALI KE MENU
                ================================================== --}}
                <div class="mb-8">
                    <a href="{{ route('menu.front') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-red-500 bg-white text-red-600 text-sm font-semibold hover:bg-red-500 hover:text-white transition-all duration-300 shadow-sm">
                        <i class="uil uil-arrow-left text-base"> </i>
                        <span> Kembali ke Menu </span>
                    </a>
                </div>
                {{-- =================================================
                     JUDUL
                ================================================== --}}
                <div class="text-center max-w-3xl mx-auto mb-9">
                    <h1 class="font-serif font-bold text-gray-800 text-4xl md:text-5xl leading-tight">
                        {{ $packageSettings?->section_title ?? 'Paket & Layanan' }}
                    </h1>
                    <p class="mt-3 text-gray-500 text-sm md:text-base">
                        {{ $packageSettings?->section_description ?? 'Pilihan paket untuk berbagai kebutuhan acara.' }}
                    </p>
                    <div class="flex items-center justify-center gap-2 mt-4">
                        <span class="w-2 h-2 rounded-full bg-red-500"> </span>
                        <span class="w-12 h-1 rounded-full bg-red-500"> </span>
                        <span class="w-2 h-2 rounded-full bg-red-500"> </span>
                    </div>
                </div>
                {{-- =================================================
                     FILTER
                ================================================== --}}
                <div class="grid grid-cols-2 gap-3 mb-8 sm:flex sm:flex-wrap sm:justify-center sm:items-center">
                    {{-- SEMUA --}}
                    <button type="button" onclick="filterPackage('all')" data-package-filter="all"
                        class="package-filter
                               inline-flex
                               items-center
                               justify-center
                               gap-2
                               px-5
                               py-2.5
                               rounded-full
                               border
                               {{ empty($selectedCategory)
                                   ? 'bg-red-500 text-white border-red-500 shadow-md shadow-red-500/20'
                                   : 'bg-white text-gray-700 border-gray-200 sm:hover:bg-gray-50' }}
                               text-sm
                               font-semibold">
                        <i class="uil uil-apps"></i>
                        <span> Semua </span>
                        <span
                            class="min-w-[26px]
                                   h-6
                                   px-2
                                   rounded-full
                                   flex
                                   items-center
                                   justify-center
                                   text-xs
                                   font-bold
                                   {{ empty($selectedCategory) ? 'bg-white/20 text-white' : 'bg-red-50 text-red-600' }}">
                            {{ $allCount }}
                        </span>
                    </button>
                    {{-- PACKAGE MENU --}}
                    <button type="button" onclick="filterPackage('package_menu')" data-package-filter="package_menu"
                        class="package-filter
                               inline-flex
                               items-center
                               justify-center
                               gap-2
                               px-5
                               py-2.5
                               rounded-full
                               border
                               {{ $selectedCategory === 'package_menu'
                                   ? 'bg-red-500 text-white border-red-500 shadow-md shadow-red-500/20'
                                   : 'bg-white text-gray-700 border-gray-200 sm:hover:bg-gray-50' }}
                               text-sm
                               font-semibold">
                        <i class="uil uil-utensils"></i>
                        <span> Package Menu </span>
                        <span
                            class="min-w-[26px]
                                   h-6
                                   px-2
                                   rounded-full
                                   flex
                                   items-center
                                   justify-center
                                   text-xs
                                   font-bold
                                   {{ $selectedCategory === 'package_menu' ? 'bg-white/20 text-white' : 'bg-red-50 text-red-600' }}">
                            {{ $packageMenuCount }}
                        </span>
                    </button>
                    {{-- CATERING PACKAGE --}}
                    <button type="button" onclick="filterPackage('catering_package')"
                        data-package-filter="catering_package"
                        class="package-filter inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full border
                               {{ $selectedCategory === 'catering_package'
                                   ? 'bg-red-500 text-white border-red-500 shadow-md shadow-red-500/20'
                                   : 'bg-white text-gray-700 border-gray-200 sm:hover:bg-gray-50' }}
                               text-sm font-semibold">
                        <i class="uil uil-gift"></i>
                        <span>Catering Package</span>
                        <span
                            class="min-w-[26px] h-6 px-2 rounded-full flex items-center justify-center text-xs font-bold
                                   {{ $selectedCategory === 'catering_package' ? 'bg-white/20 text-white' : 'bg-red-50 text-red-600' }}">
                            {{ $cateringPackageCount }}
                        </span>
                    </button>
                    {{-- WEDDING PACKAGE --}}
                    <button type="button" onclick="filterPackage('wedding_package')"
                        data-package-filter="wedding_package"
                        class="package-filter
                               inline-flex
                               items-center
                               justify-center
                               gap-2
                               px-5
                               py-2.5
                               rounded-full
                               border
                               {{ $selectedCategory === 'wedding_package'
                                   ? 'bg-red-500 text-white border-red-500 shadow-md shadow-red-500/20'
                                   : 'bg-white text-gray-700 border-gray-200 sm:hover:bg-gray-50' }}
                               text-sm
                               font-semibold">
                        <i class="uil uil-heart-alt"></i>
                        <span> Wedding Package </span>
                        <span
                            class="min-w-[26px]
                                   h-6
                                   px-2
                                   rounded-full
                                   flex
                                   items-center
                                   justify-center
                                   text-xs
                                   font-bold
                                   {{ $selectedCategory === 'wedding_package' ? 'bg-white/20 text-white' : 'bg-red-50 text-red-600' }}">
                            {{ $weddingPackageCount }}
                        </span>
                    </button>
                </div>
                {{-- =================================================
                     GRID PACKAGE 4 x 2
                ================================================== --}}
                <div id="packageGrid" class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
                    @forelse ($packages as $package)
                        @php
                            $imagePath = trim((string) ($package->image_path ?? ''));

                            // Abaikan URL gambar eksternal pada kartu paket.
                            if (
                                preg_match('/^(?:[a-z][a-z0-9+.-]*:)?\/\//i', $imagePath) === 1 ||
                                preg_match('/^(?:data|blob):/i', $imagePath) === 1
                            ) {
                                $packageImage = '';
                            } elseif (\Illuminate\Support\Str::startsWith($imagePath, '/storage/')) {
                                $packageImage = asset(ltrim($imagePath, '/'));
                            } elseif (\Illuminate\Support\Str::startsWith($imagePath, 'storage/')) {
                                $packageImage = asset($imagePath);
                            } elseif (\Illuminate\Support\Str::startsWith($imagePath, 'public/storage/')) {
                                $packageImage = asset(substr($imagePath, strlen('public/')));
                            } else {
                                $packageImage = asset('storage/' . ltrim($imagePath, '/'));
                            }

                            $categoryLabel = match ($package->category) {
                                'package_menu' => 'Package Menu',
                                'catering_package', 'box_package' => 'Catering Package',
                                'wedding_package' => 'Wedding Package',
                                default => 'Paket',
                            };
                            $categoryIcon = match ($package->category) {
                                'package_menu' => 'uil-utensils',
                                'catering_package', 'box_package' => 'uil-gift',
                                'wedding_package' => 'uil-heart-alt',
                                default => 'uil-box',
                            };
                        @endphp
                        <article data-id="{{ $package->id }}" data-category="{{ $package->category }}"
                            class="package-card overflow-hidden rounded-2xl border border-gray-100 shadow-sm">
                            {{-- =================================================
                                 GAMBAR
                            ================================================== --}}
                            <button type="button" onclick="openPackageModalById({{ $package->id }})"
                                class="block w-full text-left focus:outline-none">
                                <div class="relative package-card-image overflow-hidden bg-gray-100">
                                    @if ($packageImage !== '')
                                        <img src="{{ $packageImage }}" alt="{{ $package->title }}"
                                            class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" />
                                    @else
                                        <div
                                            class="w-full h-full flex items-center justify-center text-gray-400 text-xs sm:text-sm">
                                            Gambar belum tersedia
                                        </div>
                                    @endif
                                    {{-- BADGE KATEGORI --}}
                                    <div
                                        class="package-category-badge absolute top-3 left-3 inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-red-500 text-white text-xs font-bold shadow-md">
                                        <i class="uil {{ $categoryIcon }} text-xs"></i>
                                        <span>{{ $categoryLabel }}</span>
                                    </div>
                                </div>
                            </button>
                            {{-- =================================================
                                 INFO CARD
                            ================================================== --}}
                            <div class="p-4 bg-white flex flex-col h-[200px]">
                                <h3 class="font-bold text-gray-800 text-sm sm:text-base leading-tight min-h-[36px]">
                                    {{ $package->title }}
                                </h3>
                                <div class="mt-2 min-h-[32px] flex items-start">
                                    @if ($package->price)
                                        <div class="package-price">
                                            Harga
                                            {{ preg_replace_callback(
                                                '/\b\d+(?:[.,]\d+)?\b/',
                                                fn($m) => number_format((float) str_replace(['.', ','], '', $m[0]), 0, ',', '.'),
                                                $package->price,
                                            ) }}
                                        </div>
                                    @endif
                                </div>
                                <button type="button" onclick="openPackageModalById({{ $package->id }})"
                                    class="package-card-detail mt-auto w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-red-500 bg-white text-red-600 text-sm font-semibold hover:bg-red-500 hover:text-white">
                                    <i class="uil uil-list-ul"></i>
                                    <span>Lihat Detail</span>
                                    <i class="uil uil-arrow-right text-base"></i>
                                </button>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full py-16 text-center text-gray-500">
                            Belum ada paket & layanan yang tersedia.
                        </div>
                    @endforelse
                </div>
                {{-- =================================================
                     EMPTY FILTER
                ================================================== --}}
                <div id="emptyPackageMessage" class="hidden py-14 text-center">
                    <div
                        class="mx-auto w-14 h-14 rounded-full bg-red-50 flex items-center justify-center text-red-500 mb-4">
                        <i class="uil uil-folder-open text-2xl"> </i>
                    </div>
                    <p class="text-gray-500 text-sm">Belum ada paket pada kategori ini.</p>
                </div>
                {{-- =================================================
                     LIHAT SEMUA
                ================================================== --}}
                <div id="showAllWrapper" class="hidden flex justify-center mt-10">
                    <button type="button" onclick="toggleShowAll()"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-full border border-red-500 bg-white text-red-600 text-sm font-semibold hover:bg-red-500 hover:text-white transition-all duration-300">
                        <span id="showAllText"> Lihat Semua Paket </span>
                        <i id="showAllIcon" class="uil uil-angle-down text-lg">
                        </i>
                    </button>
                </div>
                {{-- =================================================
                     CTA KONSULTASI
                ================================================== --}}
                <div
                    class="mt-10 rounded-2xl border border-red-100 bg-red-50/80 px-5 py-4 md:px-6 md:py-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex items-start gap-3">
                        <div
                            class="w-11 h-11 shrink-0 rounded-full bg-red-100 text-red-500 flex items-center justify-center">
                            <i class="uil uil-calendar-alt text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-base md:text-lg font-bold text-red-600">
                                {{ $packageSettings?->cta_title ?? 'Butuh paket khusus atau ingin konsultasi?' }}
                            </h2>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $packageSettings?->cta_description ?? 'Hubungi kami untuk mendapatkan penawaran terbaik sesuai kebutuhan acara Anda.' }}
                            </p>
                        </div>
                    </div>
                    <a href="/reservation"
                        class="shrink-0 inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-red-500 text-white text-sm font-bold shadow-sm hover:bg-red-600 transition-all">
                        <i class="uil uil-whatsapp text-lg"></i>
                        <span>Reservasi via WhatsApp</span>
                        <i class="uil uil-arrow-right text-lg"></i>
                    </a>
                </div>
            </div>
        </section>
    </main>
    {{-- =========================================================
     MODAL DETAIL PAKET
    ========================================================== --}}
    <div id="packageModal"
        class="hidden fixed inset-0 z-[9999] bg-black/60 backdrop-blur-sm items-center justify-center p-4">
        <div
            class="package-modal-panel relative bg-white rounded-3xl overflow-hidden shadow-2xl grid grid-cols-1 md:grid-cols-[48%_52%]">
            {{-- =====================================================
                 BAGIAN KIRI — GAMBAR
            ====================================================== --}}
            <div class="package-modal-left relative bg-slate-100 p-4 md:p-5 overflow-hidden">
                {{-- TOMBOL TUTUP KHUSUS MOBILE --}}
                <button type="button" onclick="closePackageModal()"
                    class="md:hidden absolute top-5 right-5 z-30 w-10 h-10 rounded-full bg-white/95 text-slate-500 shadow-lg flex items-center justify-center hover:bg-red-500 hover:text-white transition">
                    <i class="uil uil-times text-xl"></i>
                </button>
                <div
                    class="package-modal-gallery relative min-h-[360px] md:min-h-0 rounded-2xl overflow-hidden bg-white">
                    <img id="packageModalImage" src="" alt="Poster Paket"
                        class="w-full h-full object-cover transition-all duration-300" />
                    {{-- PANAH KIRI --}}
                    <button id="packageModalPreviousButton" type="button" onclick="previousPackage()"
                        class="absolute left-4 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-white text-gray-800 shadow-lg flex items-center justify-center hover:bg-red-500 hover:text-white transition">
                        <i class="uil uil-angle-left text-2xl"></i>
                    </button>
                    {{-- PANAH KANAN --}}
                    <button id="packageModalNextButton" type="button" onclick="nextPackage()"
                        class="absolute right-4 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-white text-gray-800 shadow-lg flex items-center justify-center hover:bg-red-500 hover:text-white transition">
                        <i class="uil uil-angle-right text-2xl"></i>
                    </button>
                    {{-- COUNTER --}}
                    <div
                        class="absolute bottom-4 left-1/2 -translate-x-1/2 px-4 py-1.5 rounded-full bg-black/45 text-white text-xs font-semibold">
                        <span id="packageModalCounter">1 / 1</span>
                    </div>
                </div>
                {{-- THUMBNAIL SESUAI FILTER --}}
                <div id="packageModalThumbnails" class="package-modal-thumbnails mt-3"></div>
            </div>
            {{-- =====================================================
                 BAGIAN KANAN — INFORMASI
            ====================================================== --}}
            <div class="package-modal-right relative bg-white">
                <button type="button" onclick="closePackageModal()"
                    class="hidden md:flex absolute top-4 right-4 z-20 w-10 h-10 rounded-full bg-slate-100 text-slate-500 items-center justify-center hover:bg-red-500 hover:text-white transition">
                    <i class="uil uil-times text-xl"></i>
                </button>
                <div class="package-modal-content relative z-10 w-full p-6 md:p-8 lg:p-10">
                    {{-- KATEGORI --}}
                    <div id="packageModalCategory"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-500 text-white shadow-sm">
                        <i id="packageModalCategoryIcon" class="uil uil-utensils text-base"></i>
                        <span id="packageModalCategoryText" class="text-sm font-bold">
                            Package Menu
                        </span>
                    </div>
                    {{-- JUDUL --}}
                    <h2 id="packageModalTitle"
                        class="mt-5 pr-10 font-sans font-extrabold tracking-tight text-slate-800 text-2xl md:text-3xl leading-tight">
                    </h2>
                    {{-- HARGA --}}
                    <div id="packageModalPrice"
                        class="mt-3 text-red-500 font-black tracking-tight text-xl md:text-2xl leading-tight"></div>
                    {{-- INFO KAPASITAS / MINIMAL PEMESANAN --}}
                    <div id="packageModalInfoBox" class="package-modal-info-box hidden mt-5 p-4">
                        <div id="packageModalCapacityBlock" class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-red-500 text-white flex items-center justify-center shrink-0">
                                <i class="uil uil-users-alt text-lg"></i>
                            </div>
                            <div>
                                <p id="packageModalCapacityLabel" class="text-xs text-slate-500">
                                    Kapasitas
                                </p>
                                <p id="packageModalCapacity" class="text-sm font-bold text-slate-800"></p>
                            </div>
                        </div>
                    </div>
                    {{-- DESKRIPSI --}}
                    <div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4 md:px-5 md:py-5">
                        <h3 class="text-base md:text-lg font-bold text-slate-800 mb-3">
                            Daftar Menu
                        </h3>
                        <div id="packageModalDescription"
                            class="space-y-2.5 text-sm md:text-base text-slate-500 leading-relaxed"></div>
                    </div>
                </div>
                {{-- AKSI --}}
                <div class="package-modal-actions shrink-0 p-6 pt-3 md:p-8 md:pt-3 lg:p-10 lg:pt-3">
                    <a href="/reservation"
                        class="inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-red-500 text-white text-sm font-bold hover:bg-red-600 transition">
                        <i class="uil uil-whatsapp text-lg"></i>
                        <span>Pesan via WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- =========================================================
         JAVASCRIPT
    ========================================================== --}}
    <script>
        const packageData = @json ($packageData);
        let packageModalIndex = 0;
        let activeCategory = @json ($selectedCategory) || "all";
        if (activeCategory === "box_package") activeCategory = "catering_package";
        let showAll = false;
        let modalPackages = [];
        /*
        |--------------------------------------------------------------------------
        | MODAL
        |--------------------------------------------------------------------------
        */
        function getModalPackages() {
            if (activeCategory === "all") {
                return packageData;
            }
            return packageData.filter((item) => {
                if (activeCategory === "catering_package") {
                    return (
                        item.category === "catering_package" ||
                        item.category === "box_package"
                    );
                }
                return item.category === activeCategory;
            });
        }

        function openPackageModal(index) {
            modalPackages = getModalPackages();
            if (!modalPackages.length) {
                return;
            }
            packageModalIndex = Number(index);
            updatePackageModal();
            const modal = document.getElementById("packageModal");
            modal.classList.remove("hidden");
            modal.classList.add("flex");
            document.body.classList.add("overflow-hidden");
        }

        function openPackageModalById(id) {
            modalPackages = getModalPackages();
            const index = modalPackages.findIndex(
                (item) => Number(item.id) === Number(id),
            );
            if (index === -1) {
                return;
            }
            openPackageModal(index);
        }

        function formatPackagePrice(value) {
            const text = String(value ?? "").trim();
            if (!text) {
                return "Harga belum tersedia.";
            }
            const formatted = text.replace(/\b\d+(?:[.,]\d+)?\b/g, function(match) {
                const normalized = match.replace(/[.,]/g, "");
                if (!/^\d+$/.test(normalized)) {
                    return match;
                }
                return Number(normalized).toLocaleString("id-ID");
            });
            return `Harga ${formatted}`;
        }

        function updatePackageModal() {
            modalPackages = getModalPackages();
            const item = modalPackages[packageModalIndex];
            if (!item) {
                return;
            }
            const modalTitle = document.getElementById("packageModalTitle");
            const modalCategory = document.getElementById("packageModalCategory");
            const modalDescription = document.getElementById("packageModalDescription");
            modalTitle.classList.add("modal-content-changing");
            modalCategory.classList.add("modal-content-changing");
            modalDescription.classList.add("modal-content-changing");
            const modalPrice = document.getElementById("packageModalPrice");
            modalPrice.classList.add("modal-content-changing");
            const image = document.getElementById("packageModalImage");
            /*
            |--------------------------------------------------------------------------
            | ANIMASI GAMBAR
            |--------------------------------------------------------------------------
            */
            image.classList.add("package-changing");
            setTimeout(() => {
                if (item.image) {
                    image.src = item.image;
                    image.classList.remove("hidden");
                    image.onload = () => {
                        image.classList.remove("package-changing");
                    };
                } else {
                    image.removeAttribute("src");
                    image.classList.add("hidden");
                    image.classList.remove("package-changing");
                }
            }, 120);
            // Thumbnail hanya menampilkan paket pada kategori yang sedang aktif.
            renderPackageThumbnails();
            /*
            |--------------------------------------------------------------------------
            | TITLE
            |--------------------------------------------------------------------------
            */
            document.getElementById("packageModalTitle").textContent = item.title;
            document.getElementById("packageModalPrice").textContent =
                formatPackagePrice(item.price);
            /*
            |--------------------------------------------------------------------------
            | DESCRIPTION
            |--------------------------------------------------------------------------
            */
            const descriptionElement = document.getElementById(
                "packageModalDescription",
            );
            const description = item.description || "Informasi paket belum tersedia.";
            descriptionElement.innerHTML = description
                .split(/\r?\n+/)
                .filter((line) => line.trim() !== "")
                .map(
                    (line) => `
                        <div class="flex items-start gap-2.5">
                            <span class="package-modal-check">✓</span>
                            <span>${line.trim()}</span>
                        </div>
                    `,
                )
                .join("");
            /*
            |--------------------------------------------------------------------------
            | CATEGORY
            |--------------------------------------------------------------------------
            */
            let categoryLabel = "Paket";
            let categoryIcon = "uil-box";
            if (item.category === "package_menu") {
                categoryLabel = "Package Menu";
                categoryIcon = "uil-utensils";
            } else if (
                item.category === "catering_package" ||
                item.category === "box_package"
            ) {
                categoryLabel = "Catering Package";
                categoryIcon = "uil-gift";
            } else if (item.category === "wedding_package") {
                categoryLabel = "Wedding Package";
                categoryIcon = "uil-heart-alt";
            }
            document.getElementById("packageModalCategoryText").textContent =
                categoryLabel;
            document.getElementById("packageModalCategoryIcon").className =
                `uil ${categoryIcon} text-base`;
            const infoBox = document.getElementById("packageModalInfoBox");
            const capacityBlock = document.getElementById("packageModalCapacityBlock");
            const capacityElement = document.getElementById("packageModalCapacity");
            const capacityLabel = document.getElementById("packageModalCapacityLabel");
            if (item.capacity) {
                infoBox.classList.remove("hidden");
                capacityBlock.classList.remove("hidden");
                capacityElement.textContent = item.capacity;
                if (item.category === "package_menu") {
                    capacityLabel.textContent = "Kapasitas";
                } else {
                    capacityLabel.textContent = "Minimal Pemesanan";
                }
            } else {
                infoBox.classList.add("hidden");
                capacityBlock.classList.add("hidden");
                capacityElement.textContent = "";
            }
            /*
            |--------------------------------------------------------------------------
            | COUNTER
            |--------------------------------------------------------------------------
            */
            document.getElementById("packageModalCounter").textContent =
                `${packageModalIndex + 1} / ${modalPackages.length}`;
            const previousButton = document.getElementById(
                "packageModalPreviousButton",
            );
            const nextButton = document.getElementById("packageModalNextButton");
            if (previousButton) {
                previousButton.classList.toggle("hidden", modalPackages.length <= 1);
            }
            if (nextButton) {
                nextButton.classList.toggle("hidden", modalPackages.length <= 1);
            }
            setTimeout(() => {
                modalTitle.classList.remove("modal-content-changing");
                modalCategory.classList.remove("modal-content-changing");
                modalDescription.classList.remove("modal-content-changing");
                modalPrice.classList.remove("modal-content-changing");
            }, 80);
        }

        function renderPackageThumbnails() {
            const container = document.getElementById("packageModalThumbnails");
            if (!container) return;
            container.innerHTML = "";
            modalPackages.forEach((item, index) => {
                const button = document.createElement("button");
                button.type = "button";
                button.className = `package-modal-thumbnail ${index === packageModalIndex ? "active" : ""}`;
                button.title = item.title || "Paket";
                button.addEventListener("click", () => {
                    packageModalIndex = index;
                    updatePackageModal();
                });
                if (item.image) {
                    const image = document.createElement("img");
                    image.src = item.image;
                    image.alt = item.title || "Paket";
                    image.loading = "lazy";
                    button.appendChild(image);
                } else {
                    button.textContent = "—";
                    button.setAttribute("aria-label", `${item.title || "Paket"} (gambar belum tersedia)`);
                }

                container.appendChild(button);
            });
        }

        function previousPackage() {
            modalPackages = getModalPackages();
            if (!modalPackages.length) {
                return;
            }
            packageModalIndex--;
            if (packageModalIndex < 0) {
                packageModalIndex = modalPackages.length - 1;
            }
            updatePackageModal();
        }

        function nextPackage() {
            modalPackages = getModalPackages();
            if (!modalPackages.length) {
                return;
            }
            packageModalIndex++;
            if (packageModalIndex >= modalPackages.length) {
                packageModalIndex = 0;
            }
            updatePackageModal();
        }

        function closePackageModal() {
            const modal = document.getElementById("packageModal");
            modal.classList.add("hidden");
            modal.classList.remove("flex");
            document.body.classList.remove("overflow-hidden");
        }
        document.addEventListener("click", function(event) {
            const modal = document.getElementById("packageModal");
            if (modal && event.target === modal) {
                closePackageModal();
            }
        });
        /*
        |--------------------------------------------------------------------------
        | FILTER PACKAGE
        |--------------------------------------------------------------------------
        */
        function filterPackage(selectedCategory) {
            activeCategory = selectedCategory;
            if (activeCategory === "box_package") activeCategory = "catering_package";
            modalPackages = getModalPackages();
            packageModalIndex = 0;
            showAll = false;
            /*
            |------------------------------------------------------
            | BUTTON ACTIVE
            |------------------------------------------------------
            */
            document.querySelectorAll(".package-filter").forEach((button) => {
                button.classList.remove(
                    "bg-red-500",
                    "text-white",
                    "border-red-500",
                    "shadow-md",
                    "shadow-red-500/20",
                );
                button.classList.add("bg-white", "text-gray-700", "border-gray-200");
                const count = button.querySelector("span:last-child");
                if (count) {
                    count.classList.remove("bg-white/20", "text-white");
                    count.classList.add("bg-red-50", "text-red-600");
                }
            });
            const activeButton = document.querySelector(
                `[data-package-filter="${selectedCategory}"]`,
            );
            if (activeButton) {
                activeButton.classList.remove(
                    "bg-white",
                    "text-gray-700",
                    "border-gray-200",
                );
                activeButton.classList.add(
                    "bg-red-500",
                    "text-white",
                    "border-red-500",
                    "shadow-md",
                    "shadow-red-500/20",
                );
                const activeCount = activeButton.querySelector("span:last-child");
                if (activeCount) {
                    activeCount.classList.remove("bg-red-50", "text-red-600");
                    activeCount.classList.add("bg-white/20", "text-white");
                }
            }
            /*
            |------------------------------------------------------
            | UPDATE CARD
            |------------------------------------------------------
            */
            updateVisiblePackages();
        }
        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN CARD
        |--------------------------------------------------------------------------
        */
        function updateVisiblePackages() {
            const cards = Array.from(document.querySelectorAll(".package-card"));
            const emptyMessage = document.getElementById("emptyPackageMessage");
            const showAllWrapper = document.getElementById("showAllWrapper");
            /*
            |------------------------------------------------------
            | AMBIL HANYA KATEGORI YANG DIPILIH
            |------------------------------------------------------
            */
            const filteredCards = cards.filter((card) => {
                const category = card.dataset.category;
                const matchCategory =
                    activeCategory === "all" ||
                    category === activeCategory ||
                    (activeCategory === "catering_package" &&
                        category === "box_package");
                return matchCategory;
            });
            /*
            |------------------------------------------------------
            | SEMBUNYIKAN SEMUA
            |------------------------------------------------------
            */
            cards.forEach((card) => {
                card.classList.add("hidden");
            });
            /*
            |------------------------------------------------------
            | MAKSIMAL 8
            |------------------------------------------------------
            */
            const visibleCards = showAll ? filteredCards : filteredCards.slice(0, 8);
            visibleCards.forEach((card) => {
                card.classList.remove("hidden");
            });
            /*
            |------------------------------------------------------
            | EMPTY
            |------------------------------------------------------
            */
            if (filteredCards.length === 0) {
                emptyMessage.classList.remove("hidden");
            } else {
                emptyMessage.classList.add("hidden");
            }
            /*
            |------------------------------------------------------
            | LIHAT SEMUA
            |
            | HANYA JIKA DATA > 8
            |------------------------------------------------------
            */
            if (filteredCards.length > 8) {
                showAllWrapper.classList.remove("hidden");
                const text = document.getElementById("showAllText");
                const icon = document.getElementById("showAllIcon");
                if (showAll) {
                    text.textContent = "Sembunyikan Paket";
                    icon.className = "uil uil-angle-up text-lg";
                } else {
                    text.textContent = "Lihat Semua Paket";
                    icon.className = "uil uil-angle-down text-lg";
                }
            } else {
                showAllWrapper.classList.add("hidden");
            }
        }
        /*
        |--------------------------------------------------------------------------
        | TOGGLE
        |--------------------------------------------------------------------------
        */
        function toggleShowAll() {
            showAll = !showAll;
            updateVisiblePackages();
        }
        /*
        |--------------------------------------------------------------------------
        | KEYBOARD MODAL
        |--------------------------------------------------------------------------
        */
        document.addEventListener("keydown", function(event) {
            const modal = document.getElementById("packageModal");
            if (!modal || modal.classList.contains("hidden")) {
                return;
            }
            if (event.key === "Escape") {
                closePackageModal();
            }
            if (event.key === "ArrowRight") {
                nextPackage();
            }
        });
        /*
        |--------------------------------------------------------------------------
        | INIT
        |--------------------------------------------------------------------------
        */
        document.addEventListener("DOMContentLoaded", function() {
            const packageModal = document.getElementById("packageModal");
            if (packageModal) {
                document.body.appendChild(packageModal);
            }
            activeCategory = @json ($selectedCategory) || "all";
            if (activeCategory === "box_package") activeCategory = "catering_package";
            filterPackage(activeCategory);
            history.replaceState(null, "", window.location.pathname);
        });
    </script>
</x-layout>
