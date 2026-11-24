<x-layout>
    <style>
        main::-webkit-scrollbar {
            display: none;
        }

        main {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .text-shadow-strong {
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.25);
        }

        /* =========================================================
           BINGKAI FOTO HEADER
           Hanya tambahan visual, ukuran header tidak diubah
        ========================================================= */

        .gallery-polaroid {
            position: absolute;
            z-index: 8;
            width: 190px;
            padding: 9px 9px 30px;
            background: #ffffff;

            box-shadow:
                0 18px 35px rgba(0, 0, 0, 0.22),
                0 5px 12px rgba(0, 0, 0, 0.10);

            transition:
                transform 0.3s ease,
                box-shadow 0.3s ease;
        }

        .gallery-polaroid img {
            display: block;
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .gallery-polaroid-caption {
            display: block;
            margin-top: 9px;
            text-align: center;

            font-family: "Brush Script MT", "Segoe Script", cursive;
            font-size: 16px;
            font-style: italic;
            font-weight: 700;

            color: #111827;
            line-height: 1.15;

            text-shadow: none;
            filter: none;
            opacity: 1;
        }

        .gallery-polaroid-one {
            right: 18%;
            top: 88px;
            transform: rotate(-10deg);
            z-index: 10;
        }

        .gallery-polaroid-two {
            right: 5%;
            top: 155px;
            transform: rotate(9deg);
            z-index: 8;
        }

        .gallery-polaroid:hover {
            transform: scale(1.03);

            box-shadow:
                0 22px 40px rgba(0, 0, 0, 0.26),
                0 7px 15px rgba(0, 0, 0, 0.12);
        }

        .gallery-polaroid-one:hover {
            z-index: 10;
        }

        .gallery-polaroid-two:hover {
            z-index: 8;
        }

        /* Jangan tampilkan bingkai di mobile agar header tetap rapi */
        @media (max-width: 767px) {
            .gallery-polaroid {
                display: none;
            }
        }

        /* =========================================================
                   HASIL FILTER KATEGORI
                   Momen / Fasilitas / Event = grid 3 kolom
                ========================================================= */
        .category-detail-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
        }

        @media (max-width: 1023px) {
            .category-detail-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 639px) {
            .category-detail-grid {
                grid-template-columns: 1fr;
            }
        }

        .category-page-btn {
            min-width: 34px;
            height: 34px;
            padding: 0 10px;
            border-radius: 9px;
            border: 1px solid #e5e7eb;
            background: #fff;
            color: #4b5563;
            font-size: 14px;
            font-weight: 600;
            transition: all .2s ease;
        }

        .category-page-btn:hover {
            border-color: #fecaca;
            color: #dc2626;
            background: #fef2f2;
        }

        .category-page-btn.active {
            border-color: #dc2626;
            background: #dc2626;
            color: #fff;
        }

        /* =========================================================
           WHATSAPP ADMIN POPOVER
        ========================================================= */

        .whatsapp-admin-popover {
            position: absolute;

            /* Muncul tepat di kanan tombol */
            left: calc(100% - 120px);

            /* Naik sedikit dari posisi tengah tombol */
            top: 35%;

            z-index: 9999;

            width: 360px;
            max-width: calc(100vw - 32px);

            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 18px;

            box-shadow:
                0 20px 45px rgba(0, 0, 0, 0.16),
                0 8px 20px rgba(0, 0, 0, 0.08);

            overflow: hidden;

            opacity: 0;
            visibility: hidden;

            transform: translateY(-50%) translateX(8px) scale(0.98);

            transition:
                opacity 0.2s ease,
                transform 0.2s ease,
                visibility 0.2s ease;
        }

        .whatsapp-admin-popover.show {
            opacity: 1;
            visibility: visible;

            transform: translateY(-50%) translateX(0) scale(1);
        }

        /* =========================================================
                   CTA CARD
                   Ornamen botanical + responsive mobile
                ========================================================= */

        .gallery-cta-card {
            position: relative;
            overflow: hidden;
            isolation: isolate;
        }

        .gallery-cta-content {
            position: relative;
            z-index: 3;
            min-width: 0;
            width: 100%;
        }

        .gallery-cta-content>div:last-child {
            min-width: 0;
            width: 100%;
        }

        /* =========================================================
                   ORNAMEN BOTANICAL
                   Tangkai + daun yang terlihat jelas, tetapi tetap lembut
                ========================================================= */

        .gallery-cta-botanical {
            position: absolute;
            pointer-events: none;
            z-index: 1;
            width: 170px;
            height: 190px;
            opacity: 0.34;
        }

        .gallery-cta-botanical svg {
            display: block;
            width: 100%;
            height: 100%;
        }

        .gallery-cta-botanical.instagram {
            top: -18px;
            right: -8px;
        }

        .gallery-cta-botanical.whatsapp {
            right: -8px;
            bottom: -28px;
            transform: rotate(180deg) scale(0.92);
        }

        /* Sedikit highlight agar ornamen menyatu dengan background */
        .gallery-cta-card::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            background:
                radial-gradient(circle at 92% 18%,
                    rgba(255, 255, 255, 0.42) 0,
                    rgba(255, 255, 255, 0.14) 28%,
                    transparent 54%);
        }

        /* =========================================================
                   MOBILE CTA
                ========================================================= */

        @media (max-width: 639px) {

            .gallery-cta-card {
                padding-left: 18px !important;
                padding-right: 18px !important;
            }

            .gallery-cta-content {
                gap: 14px !important;
                align-items: flex-start !important;
            }

            .gallery-cta-content>div:last-child {
                width: 100%;
                min-width: 0;
            }

            .gallery-cta-button {
                width: 100% !important;
                min-width: 0 !important;
                max-width: 100% !important;
                box-sizing: border-box;

                display: flex !important;
                align-items: center !important;
                justify-content: flex-start !important;

                gap: 12px !important;
                padding-left: 18px !important;
                padding-right: 16px !important;
            }

            .gallery-cta-button .cta-arrow:last-child {
                margin-left: auto;
            }

            .gallery-cta-botanical {
                width: 135px;
                height: 155px;
                opacity: 0.24;
            }

            .gallery-cta-botanical.instagram {
                top: -26px;
                right: -28px;
            }

            .gallery-cta-botanical.whatsapp {
                right: -26px;
                bottom: -38px;
            }
        }

        /* =========================================================
           HORIZONTAL GALLERY
           Scrollbar disembunyikan, tetapi tetap bisa digeser
           dengan mouse, trackpad, dan touch.
        ========================================================= */

        .gallery-track {
            overflow-x: auto;
            overflow-y: hidden;

            scrollbar-width: none;
            -ms-overflow-style: none;
            -webkit-overflow-scrolling: touch;

            scroll-behavior: smooth;

            /* Mobile: bisa swipe dengan jari */
            touch-action: auto;
        }

        .gallery-track::-webkit-scrollbar {
            display: none;
        }

        .gallery-track:active {
            cursor: grabbing;
        }

        /* =========================================================
                   GALLERY DETAIL MODAL
                   Perbaikan visual + posisi tetap terhadap viewport
                ========================================================= */
        #gallery-detail-modal.gallery-modal-root {
            position: fixed !important;
            inset: 0 !important;
            width: 100vw !important;
            height: 100dvh !important;
            margin: 0 !important;
            transform: none !important;
            z-index: 999999 !important;

            display: none;
            align-items: center;
            justify-content: center;

            padding: 16px;
            overflow: hidden;
            overflow-x: hidden;
            overscroll-behavior: contain;
        }

        #gallery-detail-modal.gallery-modal-root.is-open {
            display: flex !important;
        }

        #gallery-detail-modal .gallery-modal-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(15, 18, 24, 0.76);
            backdrop-filter: blur(7px);
        }

        #gallery-detail-modal .gallery-modal-shell {
            position: relative;
            z-index: 2;

            width: min(1100px, 94vw);
            height: min(530px, 88vh);
            max-height: 88vh;

            display: grid;
            grid-template-columns: 48% 52%;

            overflow: hidden;
            border-radius: 28px;
            background: #fff;

            box-shadow:
                0 30px 80px rgba(0, 0, 0, 0.38),
                0 10px 30px rgba(0, 0, 0, 0.18);

            scrollbar-width: auto;
            scrollbar-color: #94a3b8 transparent;
        }

        #gallery-detail-modal .gallery-modal-shell::-webkit-scrollbar {
            width: 10px;
        }

        #gallery-detail-modal .gallery-modal-shell::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 999px;
        }

        #gallery-detail-modal .gallery-modal-shell::-webkit-scrollbar-track {
            background: transparent;
        }

        /* ================= KIRI ================= */

        #gallery-detail-modal .gallery-modal-media {
            position: relative;
            min-width: 0;
            min-height: 0;

            display: flex;
            flex-direction: column;

            padding: 16px;
            background: #f5f7fa;
        }

        #gallery-detail-modal .gallery-modal-main-image-wrap {
            position: relative;
            width: 100%;
            min-height: 0;
            overflow: hidden;
            border-radius: 22px;
            background: #e5e7eb;

            flex: 0 0 auto;
            height: auto;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        #gallery-detail-modal .gallery-modal-main-image {
            display: block;
            width: 100%;
            height: min(430px, 52vh);
            object-fit: cover;
        }

        #gallery-detail-modal .gallery-modal-nav {
            position: absolute;
            top: 50%;
            z-index: 4;

            width: 44px;
            height: 44px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.85);
            background: rgba(255, 255, 255, 0.95);
            color: #334155;

            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.15);
            transform: translateY(-50%);
            transition: 0.25s ease;
        }

        #gallery-detail-modal .gallery-modal-nav:hover {
            background: #ef4444;
            border-color: #ef4444;
            color: #fff;
            transform: translateY(-50%) scale(1.03);
        }

        #gallery-detail-modal .gallery-modal-prev {
            left: 14px;
        }

        #gallery-detail-modal .gallery-modal-next {
            right: 14px;
        }

        #gallery-detail-modal .gallery-modal-thumbs {
            display: flex;
            align-items: center;
            gap: 0.6rem;

            overflow-x: auto;
            overflow-y: hidden;

            padding: 0.1rem 0.05rem 0.35rem;
            margin-top: 12px;

            flex-shrink: 0;
            scrollbar-width: none;
            -ms-overflow-style: none;

            touch-action: pan-x;
        }

        #gallery-detail-modal .gallery-modal-thumbs::-webkit-scrollbar {
            display: none;
        }

        #gallery-detail-modal .gallery-modal-thumb {
            width: 54px;
            height: 42px;
            flex: 0 0 auto;

            border-radius: 0.7rem;
            overflow: hidden;

            border: 2px solid transparent;
            background: #e2e8f0;

            opacity: 0.68;
            cursor: pointer;

            transition: border-color 180ms ease,
                transform 180ms ease,
                opacity 180ms ease;
        }

        #gallery-detail-modal .gallery-modal-thumb:hover {
            transform: translateY(-1px);
        }

        #gallery-detail-modal .gallery-modal-thumb.active {
            border-color: #ef1f25;
            opacity: 1;
        }

        #gallery-detail-modal .gallery-modal-thumb img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }

        #gallery-detail-modal .gallery-modal-dots {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 7px;
            padding-top: 10px;
            min-height: 18px;
        }

        #gallery-detail-modal .gallery-modal-dot {
            width: 8px;
            height: 8px;
            padding: 0;
            border: 0;
            border-radius: 999px;
            background: #d1d5db;
            transition: 0.25s ease;
        }

        #gallery-detail-modal .gallery-modal-dot.active {
            width: 24px;
            background: linear-gradient(90deg, #ef4444, #f59e0b);
        }

        /* ================= KANAN ================= */

        #gallery-detail-modal .gallery-modal-info {
            position: relative;
            min-width: 0;
            min-height: 0;
            overflow: hidden;

            display: flex;
            flex-direction: column;
            justify-content: flex-start;

            padding: 44px 42px 38px;
            background: #fff;
        }

        #gallery-detail-modal .gallery-modal-close {
            position: absolute;
            top: 18px;
            right: 18px;
            z-index: 8;

            width: 46px;
            height: 46px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 999px;
            border: 1px solid #e5e7eb;
            background: rgba(255, 255, 255, 0.96);
            color: #334155;

            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.12);
            transition: 0.25s ease;
        }

        #gallery-detail-modal .gallery-modal-close:hover {
            color: #dc2626;
            border-color: #fecaca;
            transform: rotate(5deg);
        }

        #gallery-detail-modal .gallery-modal-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            width: fit-content;
            padding: 8px 13px;

            border-radius: 10px;
            background: #fef2f2;
            color: #dc2626;

            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.04em;
        }

        #gallery-detail-modal .gallery-modal-title {
            margin-top: 16px;
            max-width: 560px;

            color: #172033;
            font-family: Georgia, "Times New Roman", serif;
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.08;
            letter-spacing: -0.02em;
        }

        #gallery-detail-modal .gallery-modal-accent {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 16px;
        }

        #gallery-detail-modal .gallery-modal-accent span:first-child {
            width: 42px;
            height: 4px;
            border-radius: 999px;
            background: #ef4444;
        }

        #gallery-detail-modal .gallery-modal-accent span:last-child {
            width: 22px;
            height: 4px;
            border-radius: 999px;
            background: #f59e0b;
        }

        #gallery-detail-modal .gallery-modal-description-box {
            margin-top: 20px;
            width: 100%;
            max-width: 520px;

            /* Ukuran kotak tetap sama untuk semua foto.
                       Scrollbar hanya muncul jika isi melebihi tinggi ini. */
            height: 230px;
            flex: 0 0 230px;

            padding: 16px 17px;
            border: 1px solid #e5e7eb;
            border-radius: 15px;
            background: #fafafa;

            overflow-y: auto;
            overflow-x: hidden;

            scrollbar-width: thin;
            scrollbar-color: #ef4444 #fee2e2;

            overscroll-behavior: contain;
        }

        #gallery-detail-modal .gallery-modal-description-box::-webkit-scrollbar {
            width: 6px;
        }

        #gallery-detail-modal .gallery-modal-description-box::-webkit-scrollbar-track {
            background: #fee2e2;
            border-radius: 999px;
        }

        #gallery-detail-modal .gallery-modal-description-box::-webkit-scrollbar-thumb {
            background: #ef4444;
            border-radius: 999px;
        }

        #gallery-detail-modal .gallery-modal-description-box::-webkit-scrollbar-thumb:hover {
            background: #dc2626;
        }

        #gallery-detail-modal .gallery-modal-description {
            margin: 0;
            color: #5b6678;
            font-size: 15px;
            line-height: 1.8;
        }

        #gallery-detail-modal .gallery-modal-description-list {
            margin: 0;
            padding-left: 22px;
            list-style: disc;
        }

        #gallery-detail-modal .gallery-modal-numbered-list {
            list-style: decimal;
        }

        #gallery-detail-modal .gallery-modal-numbered-list li::marker {
            color: #ef4444;
            font-weight: 700;
        }

        #gallery-detail-modal .gallery-modal-description-list li {
            padding-left: 6px;
        }

        #gallery-detail-modal .gallery-modal-description-list li::marker {
            color: #ef4444;
            font-size: 0.8em;
        }

        #gallery-detail-modal .gallery-modal-description-list li+li {
            margin-top: 9px;
        }

        #gallery-detail-modal .gallery-modal-wa {
            display: inline-flex;
            align-items: center;
            gap: 12px;

            width: fit-content;
            margin-top: 20px;
            padding: 13px 18px;

            border-radius: 13px;
            background: #16a34a;
            color: #fff;

            font-size: 15px;
            font-weight: 700;

            box-shadow: 0 12px 25px rgba(22, 163, 74, 0.2);
            transition: 0.25s ease;
        }

        #gallery-detail-modal .gallery-modal-wa:hover {
            background: #15803d;
            transform: translateY(-1px);
            box-shadow: 0 15px 30px rgba(22, 163, 74, 0.26);
        }

        @media (max-width: 767px) {
            #gallery-detail-modal.gallery-modal-root {
                padding: 12px;
                overflow: hidden;
                align-items: center;
            }

            #gallery-detail-modal .gallery-modal-shell {
                grid-template-columns: 1fr;
                height: auto;
                max-height: 88vh;
                overflow-y: auto;
                overflow-x: hidden;
                scrollbar-width: auto;
                scrollbar-color: #94a3b8 transparent;
            }

            #gallery-detail-modal .gallery-modal-shell::-webkit-scrollbar {
                width: 10px;
            }

            #gallery-detail-modal .gallery-modal-shell::-webkit-scrollbar-thumb {
                background: #94a3b8;
                border-radius: 999px;
            }

            #gallery-detail-modal .gallery-modal-shell::-webkit-scrollbar-track {
                background: transparent;
            }

            #gallery-detail-modal .gallery-modal-main-image {
                height: min(52vh, 460px);
            }

            #gallery-detail-modal .gallery-modal-info {
                padding: 30px 26px 28px;
                display: block;
                overflow: visible;
            }
        }

        @media (max-width: 639px) {
            #gallery-detail-modal.gallery-modal-root {
                padding: 8px;
                overflow: hidden;
            }

            /* Diubah: pakai flex column agar media berhenti pas di bawah dots */
            #gallery-detail-modal .gallery-modal-shell {
                display: flex;
                flex-direction: column;
                border-radius: 22px;
                height: 88vh;
                max-height: 88vh;
                overflow-y: auto;
                overflow-x: hidden;
                scrollbar-width: auto;
                scrollbar-color: #94a3b8 transparent;
            }

            #gallery-detail-modal .gallery-modal-shell::-webkit-scrollbar {
                width: 10px;
            }

            #gallery-detail-modal .gallery-modal-shell::-webkit-scrollbar-thumb {
                background: #94a3b8;
                border-radius: 999px;
            }

            #gallery-detail-modal .gallery-modal-shell::-webkit-scrollbar-track {
                background: transparent;
            }

            /* Diubah: tinggi auto & tidak melar */
            #gallery-detail-modal .gallery-modal-media {
                padding: 10px 10px 8px;
                height: auto !important;
                min-height: 0 !important;
                flex: 0 0 auto !important;
            }

            #gallery-detail-modal .gallery-modal-main-image-wrap {
                border-radius: 16px;
            }

            #gallery-detail-modal .gallery-modal-main-image {
                height: 30vh;
                min-height: 180px;
                max-height: 230px;
                object-fit: cover;
            }

            #gallery-detail-modal .gallery-modal-thumbs {
                margin-top: 12px;
                margin-bottom: 0;
                overflow-x: auto;
                overflow-y: hidden;
                touch-action: pan-x;
                overscroll-behavior-y: none;
            }

            #gallery-detail-modal .gallery-modal-thumb {
                width: 50px;
                height: 40px;
                flex: 0 0 auto;
            }

            /* Ditambahkan: rapikan jarak & tinggi dots */
            #gallery-detail-modal .gallery-modal-dots {
                padding-top: 8px;
                padding-bottom: 4px;
                min-height: 0 !important;
                height: auto !important;
                flex: 0 0 auto !important;
            }

            /* Diubah: padding atas dirapikan agar tidak terlalu jauh dari dots */
            #gallery-detail-modal .gallery-modal-info {
                padding: 20px 20px 38px;
                display: block;
                overflow: visible;
                flex: 1 0 auto;
            }

            #gallery-detail-modal .gallery-modal-close {
                top: 12px;
                right: 12px;
                width: 42px;
                height: 42px;
            }

            #gallery-detail-modal .gallery-modal-nav {
                width: 38px;
                height: 38px;
            }

            #gallery-detail-modal .gallery-modal-prev {
                left: 9px;
            }

            #gallery-detail-modal .gallery-modal-next {
                right: 9px;
            }

            #gallery-detail-modal .gallery-modal-title {
                font-size: 1.8rem;
                line-height: 1.15;
            }

            #gallery-detail-modal .gallery-modal-description-box {
                height: 210px;
                flex-basis: 210px;
                max-height: 210px;
                overflow-y: auto;
                overflow-x: hidden;
                scrollbar-width: thin;
                scrollbar-color: #ef4444 #fee2e2;
            }

            #gallery-detail-modal .gallery-modal-description {
                font-size: 14px;
                line-height: 1.7;
            }

            #gallery-detail-modal .gallery-modal-wa {
                width: 100%;
                justify-content: center;
                margin-bottom: 14px;
            }
        }
    </style>

    <main class="min-h-screen bg-white w-full overflow-x-hidden">
        {{-- ================= HEADER GALLERY ================= --}}
        <section class="relative z-10 pt-6 pb-8 fade-section opacity-0 translate-y-10 transition-all duration-1000">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="relative min-h-[390px] sm:min-h-[450px] lg:min-h-[490px] overflow-hidden rounded-[1.5rem] sm:rounded-[2rem] shadow-[0_12px_30px_rgba(0,0,0,0.16)]">
                    {{-- BACKGROUND IMAGE --}}
                    @if (!empty($gallerySetting?->hero_image))
                        @php
                            $heroImagePath = ltrim($gallerySetting->hero_image, '/');

                            if (str_starts_with($heroImagePath, 'storage/')) {
                                $heroImageUrl = asset($heroImagePath);
                            } elseif (str_starts_with($heroImagePath, 'public/storage/')) {
                                $heroImageUrl = asset(substr($heroImagePath, 7));
                            } elseif (str_starts_with($heroImagePath, 'public/')) {
                                $heroImageUrl = asset('storage/' . substr($heroImagePath, 7));
                            } else {
                                $heroImageUrl = asset('storage/' . $heroImagePath);
                            }
                        @endphp
                        <img src="{{ $heroImageUrl }}"
                            alt="{{ $gallerySetting->hero_title ?? 'Gallery Resto Joss Gandos' }}"
                            class="absolute inset-0 w-full h-full object-cover" />
                    @else
                        <div class="absolute inset-0 bg-gradient-to-br from-stone-700 via-stone-600 to-amber-800"></div>
                    @endif

                    {{-- OVERLAY --}}
                    <div class="absolute inset-0 bg-black/50"></div>

                    {{-- =========================================================
     BINGKAI FOTO HEADER
     Mengambil FOTO + DESKRIPSI dari pengaturan Bingkai Admin
========================================================= --}}

                    @php
                        // ================= BINGKAI 1 =================
                        $frame1Path = ltrim($gallerySetting->frame_1_image ?? '', '/');

                        if (!$frame1Path) {
                            $frame1Image = '';
                        } elseif (str_starts_with($frame1Path, 'storage/')) {
                            $frame1Image = asset($frame1Path);
                        } elseif (str_starts_with($frame1Path, 'public/storage/')) {
                            $frame1Image = asset(substr($frame1Path, 7));
                        } elseif (str_starts_with($frame1Path, 'public/')) {
                            $frame1Image = asset('storage/' . substr($frame1Path, 7));
                        } else {
                            $frame1Image = asset('storage/' . $frame1Path);
                        }

                        // ================= BINGKAI 2 =================
                        $frame2Path = ltrim($gallerySetting->frame_2_image ?? '', '/');

                        if (!$frame2Path) {
                            $frame2Image = '';
                        } elseif (str_starts_with($frame2Path, 'storage/')) {
                            $frame2Image = asset($frame2Path);
                        } elseif (str_starts_with($frame2Path, 'public/storage/')) {
                            $frame2Image = asset(substr($frame2Path, 7));
                        } elseif (str_starts_with($frame2Path, 'public/')) {
                            $frame2Image = asset('storage/' . substr($frame2Path, 7));
                        } else {
                            $frame2Image = asset('storage/' . $frame2Path);
                        }
                    @endphp

                    {{-- ================= BINGKAI 1 ================= --}}
                    @if ($frame1Image)
                        <div class="gallery-polaroid gallery-polaroid-one">
                            <img src="{{ $frame1Image }}" alt="Bingkai 1" />

                            <span class="gallery-polaroid-caption">
                                {{ $gallerySetting->frame_1_description ?? '' }}
                            </span>
                        </div>
                    @endif

                    {{-- ================= BINGKAI 2 ================= --}}
                    @if ($frame2Image)
                        <div class="gallery-polaroid gallery-polaroid-two">
                            <img src="{{ $frame2Image }}" alt="Bingkai 2" />

                            <span class="gallery-polaroid-caption">
                                {{ $gallerySetting->frame_2_description ?? '' }}
                            </span>
                        </div>
                    @endif

                    {{-- KONTEN HEADER --}}
                    <div class="relative z-10 min-h-[390px] sm:min-h-[450px] lg:min-h-[490px] flex items-start">
                        <div class="max-w-3xl px-6 pt-16 pb-10 sm:px-10 sm:pt-20 lg:px-16 lg:pt-24 text-white">
                            {{-- BADGE --}}
                            @if (!empty($gallerySetting?->hero_badge))
                                <span
                                    class="inline-flex items-center px-4 py-2 rounded-full bg-black/30 border border-yellow-400/40 backdrop-blur-sm text-yellow-300 text-sm font-semibold tracking-widest uppercase mb-6">
                                    {{ $gallerySetting->hero_badge }}
                                </span>
                            @endif

                            {{-- TITLE --}}
                            @php
                                $title = $gallerySetting->hero_title ?? 'Galeri Kami';

                                $words = preg_split('/\s+/', trim($title));

                                if (count($words) >= 3) {
                                    $mainTitle = implode(' ', array_slice($words, 0, -3));
                                    $accentTitle = implode(' ', array_slice($words, -3));
                                } else {
                                    $mainTitle = $title;
                                    $accentTitle = '';
                                }
                            @endphp

                            <h1
                                class="text-4xl sm:text-5xl lg:text-6xl font-serif font-bold leading-[1.05] max-w-4xl text-white drop-shadow-lg">
                                {{ $mainTitle }}

                                @if ($accentTitle)
                                    <span
                                        class="bg-gradient-to-r from-red-500 via-red-400 to-yellow-400 bg-clip-text text-transparent">
                                        {{ $accentTitle }}
                                    </span>
                                @endif
                            </h1>

                            {{-- DESKRIPSI --}}
                            @if (!empty($gallerySetting?->hero_description))
                                <p
                                    class="mt-6 max-w-2xl text-base sm:text-lg lg:text-xl text-white/90 leading-relaxed drop-shadow-md">
                                    {{ $gallerySetting->hero_description }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section
            class="relative z-10 pb-6 fade-section opacity-0 translate-y-10 transition-all duration-1000 delay-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @php
                    $galleryCounts = [
                        'all' => $photos->count(),

                        'momen' => $photos
                            ->filter(function ($photo) {
                                return strtolower(trim($photo->category)) === 'momen';
                            })
                            ->count(),

                        'facility' => $photos
                            ->filter(function ($photo) {
                                return in_array(strtolower(trim($photo->category)), [
                                    'facility',
                                    'facilities',
                                    'fasilitas',
                                ]);
                            })
                            ->count(),

                        'event' => $photos
                            ->filter(function ($photo) {
                                return in_array(strtolower(trim($photo->category)), ['event', 'events']);
                            })
                            ->count(),
                    ];
                @endphp

                <div class="flex justify-center mb-10 px-4">
                    <div
                        class="w-full max-w-[760px] grid grid-cols-2 sm:grid-cols-4 gap-1.5 rounded-2xl bg-white border border-stone-200 p-1.5 shadow-[0_5px_20px_rgba(0,0,0,0.06)]">
                        {{-- ================= SEMUA ================= --}}
                        <button type="button"
                            class="filter-btn flex items-center justify-center gap-2 min-h-[48px] px-3 rounded-xl bg-red-500 text-white shadow-sm transition-all duration-300 hover:bg-red-600"
                            data-filter="all">
                            {{-- ICON --}}
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-white/20">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="4" y="4" width="6" height="6" rx="1" stroke-width="2" />

                                    <rect x="14" y="4" width="6" height="6" rx="1" stroke-width="2" />

                                    <rect x="4" y="14" width="6" height="6" rx="1" stroke-width="2" />

                                    <rect x="14" y="14" width="6" height="6" rx="1" stroke-width="2" />
                                </svg>
                            </span>

                            <span class="font-semibold text-sm"> Semua </span>

                            <span
                                class="min-w-[22px] h-[22px] px-1.5 rounded-full flex items-center justify-center text-[11px] font-bold bg-white/20">
                                {{ $galleryCounts['all'] }}
                            </span>
                        </button>

                        {{-- ================= MOMEN ================= --}}
                        <button type="button"
                            class="filter-btn flex items-center justify-center gap-2 min-h-[48px] px-3 rounded-xl text-gray-600 bg-stone-50 hover:bg-stone-100 transition-all duration-300"
                            data-filter="momen">
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 3v8m0 0c0 1.1.9 2 2 2s2-.9 2-2V3
                           M18 3v7c0 1.1-.9 2-2 2v9
                           M7 3v18" />
                                </svg>
                            </span>

                            <span class="font-semibold text-sm"> Momen </span>

                            <span
                                class="min-w-[22px] h-[22px] px-1.5 rounded-full flex items-center justify-center text-[11px] font-bold bg-red-50 text-red-600">
                                {{ $galleryCounts['momen'] }}
                            </span>
                        </button>

                        {{-- ================= FASILITAS ================= --}}
                        <button type="button"
                            class="filter-btn flex items-center justify-center gap-2 min-h-[48px] px-3 rounded-xl text-gray-600 bg-stone-50 hover:bg-stone-100 transition-all duration-300"
                            data-filter="facility">
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 21h16
                           M6 21V8h12v13
                           M9 8V4h6v4
                           M9 12h2
                           M13 12h2
                           M9 16h2
                           M13 16h2" />
                                </svg>
                            </span>

                            <span class="font-semibold text-sm">
                                Fasilitas
                            </span>

                            <span
                                class="min-w-[22px] h-[22px] px-1.5 rounded-full flex items-center justify-center text-[11px] font-bold bg-red-50 text-red-600">
                                {{ $galleryCounts['facility'] }}
                            </span>
                        </button>

                        {{-- ================= EVENT ================= --}}
                        <button type="button"
                            class="filter-btn flex items-center justify-center gap-2 min-h-[48px] px-3 rounded-xl text-gray-600 bg-stone-50 hover:bg-stone-100 transition-all duration-300"
                            data-filter="event">
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="3" y="5" width="18" height="16" rx="2" stroke-width="2" />

                                    <path stroke-linecap="round" stroke-width="2" d="M16 3v4
                           M8 3v4
                           M3 10h18" />
                                </svg>
                            </span>

                            <span class="font-semibold text-sm"> Event </span>

                            <span
                                class="min-w-[22px] h-[22px] px-1.5 rounded-full flex items-center justify-center text-[11px] font-bold bg-red-50 text-red-600">
                                {{ $galleryCounts['event'] }}
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- ================= GALERI PER KATEGORI ================= --}}

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @php
                    $categories = [
                        'momen' => [
                            'title' => 'Momen',
                            'icon' => '
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M7 3v8m0 0c0 1.1.9 2 2 2s2-.9 2-2V3
                               M18 3v7c0 1.1-.9 2-2 2v9
                               M7 3v18" />
                    </svg>
                ',
                        ],

                        'facility' => [
                            'title' => 'Fasilitas',
                            'icon' => '
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 21h16
                               M6 21V8h12v13
                               M9 8V4h6v4
                               M9 12h2
                               M13 12h2
                               M9 16h2
                               M13 16h2" />
                    </svg>
                ',
                        ],

                        'event' => [
                            'title' => 'Event',
                            'icon' => '
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect
                            x="3"
                            y="5"
                            width="18"
                            height="16"
                            rx="2"
                            stroke-width="2" />

                        <path
                            stroke-linecap="round"
                            stroke-width="2"
                            d="M16 3v4
                               M8 3v4
                               M3 10h18" />
                    </svg>
                ',
                        ],
                    ];
                @endphp

                @foreach ($categories as $category => $categoryData)
                    @php

                        $categoryTitle = $categoryData['title'];

                        $categoryPhotos = $photos->filter(function ($photo) use ($category) {
                            $value = strtolower(trim($photo->category));

                            if ($category === 'momen') {
                                return $value === 'momen';
                            }

                            if ($category === 'facility') {
                                return in_array($value, ['facility', 'facilities', 'fasilitas']);
                            }

                            if ($category === 'event') {
                                return in_array($value, ['event', 'events']);
                            }

                            return false;
                        });

                    @endphp

                    {{-- ==================================================
             CATEGORY
        ================================================== --}}

                    <section
                        class="gallery-category mb-8 sm:mb-10 p-4 sm:p-6 lg:p-7 rounded-3xl bg-white border border-stone-200 shadow-sm hover:shadow-md transition-shadow duration-300"
                        data-category-section="{{ $category }}">
                        {{-- ================= JUDUL CATEGORY ================= --}}

                        <div class="flex items-center justify-between mb-5">
                            {{-- JUDUL + IKON --}}

                            <div class="flex items-center gap-3">
                                {{-- ICON CATEGORY --}}

                                <div
                                    class="w-9 h-9 rounded-full bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                                    {!! $categoryData['icon'] !!}
                                </div>

                                {{-- JUDUL --}}

                                <div>
                                    <h2 class="text-2xl md:text-3xl font-serif font-bold text-[#172033]">
                                        {{ $categoryTitle }}
                                    </h2>

                                    <div class="mt-1 w-10 h-[2px] bg-gradient-to-r from-red-500 to-yellow-400"></div>
                                </div>
                            </div>

                            {{-- ================= PANAH ================= --}}

                            <div class="flex items-center gap-2">
                                {{-- KIRI --}}

                                <button type="button"
                                    class="category-arrow w-10 h-10 rounded-full border border-stone-300 bg-white text-gray-600 flex items-center justify-center shadow-sm hover:bg-gray-100 hover:text-red-600 transition-all duration-300"
                                    data-target="{{ $category }}" data-direction="prev"
                                    aria-label="Geser ke kiri">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>

                                {{-- KANAN --}}

                                <button type="button"
                                    class="category-arrow w-10 h-10 rounded-full border border-stone-300 bg-white text-gray-600 flex items-center justify-center shadow-sm hover:bg-gray-100 hover:text-red-600 transition-all duration-300"
                                    data-target="{{ $category }}" data-direction="next"
                                    aria-label="Geser ke kanan">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- ==================================================
                 TRACK
            ================================================== --}}

                        @if ($categoryPhotos->count() > 0)
                            <div id="gallery-track-{{ $category }}" class="gallery-track flex gap-5 pb-2">
                                @foreach ($categoryPhotos as $photo)
                                    @php

                                        $imagePath = ltrim($photo->image_path ?? '', '/');

                                        if (str_starts_with($imagePath, 'storage/')) {
                                            $imageUrl = asset($imagePath);
                                        } elseif (str_starts_with($imagePath, 'public/')) {
                                            $imageUrl = asset(substr($imagePath, 7));
                                        } else {
                                            $imageUrl = asset('storage/' . $imagePath);
                                        }

                                        $categoryLabel = match ($category) {
                                            'momen' => 'MOMEN',
                                            'facility' => 'FASILITAS',
                                            'event' => 'EVENT',
                                            default => strtoupper($category),
                                        };

                                    @endphp

                                    {{-- ==================================================
                             CARD
                        ================================================== --}}

                                    <article class="flex-shrink-0 w-[85%] sm:w-[48%] lg:w-[31.8%]">
                                        <div
                                            class="group w-full h-[365px] overflow-hidden rounded-2xl bg-white border border-gray-200 shadow-sm hover:shadow-lg transition-all duration-300">
                                            {{-- ==================================================
                                     GAMBAR
                                ================================================== --}}

                                            <div class="relative w-full h-[175px] bg-gray-100 overflow-hidden">
                                                {{-- PLACEHOLDER KOSONG --}}

                                                <div class="absolute inset-0 bg-gray-100"></div>

                                                {{-- GAMBAR --}}

                                                <img src="{{ $imageUrl }}" alt="{{ $photo->title }}"
                                                    class="relative z-10 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                                    onerror="
                                                        this.style.display =
                                                            'none'
                                                    " />
                                            </div>

                                            {{-- ==================================================
     ISI CARD
================================================== --}}

                                            <div class="h-[190px] p-4 sm:p-5 flex flex-col min-h-0">
                                                {{-- ================= CATEGORY BADGE ================= --}}

                                                <div class="shrink-0">
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-md bg-red-50 text-red-600 text-[10px] sm:text-[11px] font-bold">
                                                        {{ $categoryLabel }}
                                                    </span>
                                                </div>

                                                {{-- ================= JUDUL ================= --}}

                                                <h3
                                                    class="mt-2 shrink-0 font-bold text-gray-900 text-sm sm:text-base leading-tight line-clamp-1">
                                                    {{ ucwords(strtolower($photo->title)) }}
                                                </h3>

                                                {{-- ================= DESKRIPSI ================= --}}

                                                <p
                                                    class="mt-2 text-xs sm:text-[13px] text-gray-600 leading-[1.5] line-clamp-2 min-h-[40px]">
                                                    {{ $photo->description }}
                                                </p>

                                                {{-- ================= BACA SELENGKAPNYA ================= --}}

                                                <div class="mt-auto pt-3 shrink-0">
                                                    <button type="button" data-photo-id="{{ $photo->id }}"
                                                        data-category="{{ $category }}"
                                                        class="inline-flex items-center gap-1 text-xs sm:text-[13px] font-semibold text-red-600 hover:text-red-700 transition-colors">
                                                        <span>
                                                            Lihat selengkapnya
                                                        </span>

                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M9 5l7 7-7 7" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                    </article>
                                @endforeach
                            </div>
                        @else
                            {{-- ==================================================
                     TIDAK ADA FOTO
                ================================================== --}}

                            <div
                                class="w-full h-[340px] rounded-2xl border border-dashed border-stone-200 bg-gray-50 flex items-center justify-center text-center">
                                <div>
                                    <div
                                        class="w-12 h-12 mx-auto mb-3 rounded-full bg-white border border-stone-200 text-gray-400 flex items-center justify-center">
                                        {!! $categoryData['icon'] !!}
                                    </div>

                                    <p class="text-sm text-gray-400">Belum ada foto {{ strtolower($categoryTitle) }}.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </section>
                @endforeach
            </div>

            {{-- =========================================================
     DETAIL CATEGORY VIEW
========================================================= --}}
            {{-- =========================================================
                 HASIL FILTER KATEGORI
                 Hanya card + pagination
            ========================================================= --}}
            <section id="category-detail-view" class="hidden relative z-10 pb-24">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div id="category-detail-grid" class="category-detail-grid"></div>

                    <div id="category-pagination" class="flex justify-center items-center gap-2 mt-8"></div>
                </div>
            </section>
            {{-- =========================================================
     SOCIAL / CONTACT BANNER
========================================================= --}}
            <section class="relative z-10 pb-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div
                        class="grid grid-cols-1 lg:grid-cols-2 overflow-hidden rounded-3xl shadow-sm border border-stone-100">
                        {{-- =====================================================
                 INSTAGRAM - KIRI
            ====================================================== --}}
                        <div
                            class="gallery-cta-card relative bg-gradient-to-br from-[#fff7f3] via-[#fffaf8] to-[#f7ece7] px-5 py-7 sm:px-7 md:px-9 md:py-8">
                            <div class="gallery-cta-botanical instagram" aria-hidden="true">
                                <svg viewBox="0 0 170 190" fill="none">
                                    <path d="M136 181C126 147 111 119 92 96C74 74 53 54 27 36" stroke="#9c4b35"
                                        stroke-width="5" stroke-linecap="round" />
                                    <path d="M98 105C120 104 140 93 151 76" stroke="#9c4b35" stroke-width="4"
                                        stroke-linecap="round" />
                                    <path d="M79 83C59 81 40 72 28 58" stroke="#9c4b35" stroke-width="4"
                                        stroke-linecap="round" />
                                    <path d="M61 62C72 44 84 34 98 29" stroke="#9c4b35" stroke-width="4"
                                        stroke-linecap="round" />
                                    <ellipse cx="140" cy="70" rx="10" ry="24"
                                        transform="rotate(45 140 70)" fill="#c66b50" />
                                    <ellipse cx="30" cy="57" rx="10" ry="24"
                                        transform="rotate(-55 30 57)" fill="#d48a70" />
                                    <ellipse cx="92" cy="31" rx="10" ry="24"
                                        transform="rotate(48 92 31)" fill="#c66b50" />
                                    <ellipse cx="107" cy="108" rx="10" ry="24"
                                        transform="rotate(62 107 108)" fill="#d48a70" />
                                    <ellipse cx="70" cy="77" rx="9" ry="21"
                                        transform="rotate(-38 70 77)" fill="#c66b50" />
                                    <ellipse cx="48" cy="49" rx="8" ry="19"
                                        transform="rotate(-55 48 49)" fill="#d48a70" />
                                </svg>
                            </div>

                            <div class="gallery-cta-content flex items-start sm:items-center gap-5">
                                {{-- ICON INSTAGRAM --}}
                                <div
                                    class="flex-shrink-0 w-14 h-14 rounded-full bg-red-100 text-red-600 flex items-center justify-center">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <rect x="3" y="3" width="18" height="18" rx="5"
                                            ry="5" stroke-width="2" />

                                        <circle cx="12" cy="12" r="4" stroke-width="2" />

                                        <circle cx="17.5" cy="6.5" r="1" fill="currentColor" />
                                    </svg>
                                </div>

                                <div class="min-w-0 flex-1">
                                    <h3 class="text-lg md:text-xl font-bold text-[#172033] leading-tight">
                                        {{ $gallerySetting->cta_title ?? 'Punya momen seru di Resto Joss Gandos?' }}
                                    </h3>

                                    <p class="mt-2 text-xs md:text-sm text-gray-600 leading-relaxed">
                                        {{ $gallerySetting->cta_description ?? 'Bagikan momen Anda dan tag kami di media sosial!' }}
                                    </p>

                                    {{-- BUTTON INSTAGRAM --}}
                                    <a href="{{ $gallerySetting->cta_button_1_link ?? 'https://www.instagram.com/restojossgandos?igsh=MW4wM3IxYXJxdG44bw==' }}"
                                        target="_blank" rel="noopener noreferrer"
                                        class="gallery-cta-button mt-4 inline-flex items-center justify-between gap-4 rounded-xl border border-red-300 bg-white px-5 sm:px-6 py-3.5 w-full sm:w-auto min-w-0 sm:min-w-[230px] max-w-full text-sm md:text-base font-semibold text-red-600 shadow-sm hover:bg-red-600 hover:text-white hover:shadow-md transition-all duration-300">
                                        <svg class="cta-arrow w-5 h-5 flex-shrink-0" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <rect x="3" y="3" width="18" height="18" rx="5"
                                                ry="5" stroke-width="2" />

                                            <circle cx="12" cy="12" r="4" stroke-width="2" />
                                        </svg>

                                        Follow Instagram Kami

                                        <svg class="cta-arrow w-5 h-5 flex-shrink-0 ml-auto" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- =====================================================
                 WHATSAPP - KANAN
            ====================================================== --}}
                        <div
                            class="gallery-cta-card relative bg-gradient-to-br from-[#f8fbf3] via-[#f6faf2] to-[#eef5e9] px-5 py-7 sm:px-7 md:px-9 md:py-8 border-t lg:border-t-0 lg:border-l border-stone-200">
                            <div class="gallery-cta-botanical whatsapp" aria-hidden="true">
                                <svg viewBox="0 0 170 190" fill="none">
                                    <path d="M136 181C126 147 111 119 92 96C74 74 53 54 27 36" stroke="#4f8b58"
                                        stroke-width="5" stroke-linecap="round" />
                                    <path d="M98 105C120 104 140 93 151 76" stroke="#4f8b58" stroke-width="4"
                                        stroke-linecap="round" />
                                    <path d="M79 83C59 81 40 72 28 58" stroke="#4f8b58" stroke-width="4"
                                        stroke-linecap="round" />
                                    <path d="M61 62C72 44 84 34 98 29" stroke="#4f8b58" stroke-width="4"
                                        stroke-linecap="round" />
                                    <ellipse cx="140" cy="70" rx="10" ry="24"
                                        transform="rotate(45 140 70)" fill="#6fa977" />
                                    <ellipse cx="30" cy="57" rx="10" ry="24"
                                        transform="rotate(-55 30 57)" fill="#8bbb91" />
                                    <ellipse cx="92" cy="31" rx="10" ry="24"
                                        transform="rotate(48 92 31)" fill="#6fa977" />
                                    <ellipse cx="107" cy="108" rx="10" ry="24"
                                        transform="rotate(62 107 108)" fill="#8bbb91" />
                                    <ellipse cx="70" cy="77" rx="9" ry="21"
                                        transform="rotate(-38 70 77)" fill="#6fa977" />
                                    <ellipse cx="48" cy="49" rx="8" ry="19"
                                        transform="rotate(-55 48 49)" fill="#8bbb91" />
                                </svg>
                            </div>

                            <div class="gallery-cta-content flex items-start sm:items-center gap-5">
                                {{-- ICON WHATSAPP --}}
                                <div
                                    class="flex-shrink-0 w-14 h-14 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2a10 10 0 0 0-8.68 15.01L2 22l5.17-1.36A10 10 0 1 0 12 2Zm5.22 14.28c-.22.62-1.1 1.13-1.78 1.2-.48.05-1.1.09-1.78-.11-.41-.12-.94-.31-1.61-.6-2.82-1.21-4.66-4.04-4.8-4.23-.14-.19-1.15-1.53-1.15-2.92s.73-2.07 1-2.35c.27-.29.59-.36.79-.36h.57c.18 0 .42-.07.65.5.24.58.81 1.98.88 2.13.07.15.12.32.02.51-.09.19-.14.31-.28.48-.14.17-.29.37-.41.49-.14.14-.29.29-.41.49-.14.14-.29.37-.12.58.17.29.75 1.23 1.61 1.99 1.1.98 2.02 1.29 2.31 1.44.29.15.46.13.63-.08.17-.21.72-.84.91-1.13.19-.29.38-.24.65-.14.27.1 1.69.8 1.98.95.29.14.48.22.55.34.07.12.07.7-.15 1.32Z" />
                                    </svg>
                                </div>

                                <div class="min-w-0 flex-1">
                                    <h3 class="text-lg md:text-xl font-bold text-[#172033] leading-tight">
                                        {{ $gallerySetting->cta_whatsapp_title ?? 'Chat kami di WhatsApp!' }}
                                    </h3>

                                    <p class="mt-2 text-xs md:text-sm text-gray-600">
                                        {{ $gallerySetting->cta_whatsapp_description ?? 'Tim kami siap membantu Anda untuk reservasi dan informasi.' }}
                                    </p>

                                    {{-- BUTTON WHATSAPP --}}
                                    <div class="relative inline-block w-full sm:w-auto">
                                        <button type="button" id="open-whatsapp-admin"
                                            data-configured-whatsapp="{{ $gallerySetting->cta_button_2_link ?? '' }}"
                                            onclick="
                                                    trackWhatsappClick(
                                                    'gallery-cta',
                                                    )
                                                    "
                                            class="gallery-cta-button mt-4 inline-flex items-center justify-between gap-4 rounded-xl bg-green-600 px-5 sm:px-6 py-3.5 w-full sm:w-auto min-w-0 sm:min-w-[230px] max-w-full text-sm md:text-base font-semibold text-white shadow-sm hover:bg-green-700 hover:shadow-md transition-all duration-300">

                                            <i class="uil uil-whatsapp text-2xl"></i>

                                            Chat via WhatsApp

                                            <svg class="cta-arrow w-5 h-5 flex-shrink-0 ml-auto" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>

                                        <div id="whatsapp-admin-modal" class="whatsapp-admin-popover">
                                            <div class="px-6 py-5 border-b border-gray-100">
                                                <h3 class="text-lg font-bold text-gray-800">
                                                    PILIH ADMIN
                                                </h3>
                                            </div>

                                            <button type="button"
                                                class="whatsapp-admin-option w-full flex items-center gap-4 px-6 py-5 text-left border-b border-gray-100 hover:bg-gray-50 transition"
                                                data-number="089699071599">
                                                <span
                                                    class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-lg">
                                                    1
                                                </span>

                                                <span class="flex-1">
                                                    <span class="block text-lg font-bold text-gray-800">
                                                        Admin 1
                                                    </span>

                                                    <span class="block mt-1 text-sm text-gray-400">
                                                        089699071599
                                                    </span>
                                                </span>

                                                <span class="text-gray-300 text-2xl">
                                                    ›
                                                </span>
                                            </button>

                                            <button type="button"
                                                class="whatsapp-admin-option w-full flex items-center gap-4 px-6 py-5 text-left hover:bg-gray-50 transition"
                                                data-number="0895326824595">
                                                <span
                                                    class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-lg">
                                                    2
                                                </span>

                                                <span class="flex-1">
                                                    <span class="block text-lg font-bold text-gray-800">
                                                        Admin 2
                                                    </span>

                                                    <span class="block mt-1 text-sm text-gray-400">
                                                        0895326824595
                                                    </span>
                                                </span>

                                                <span class="text-gray-300 text-2xl">
                                                    ›
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    </main>

    {{-- =========================================================
     GALLERY DETAIL POPUP
     Tampilan modern: foto + thumbnail + dots + info
========================================================= --}}
    <div id="gallery-detail-modal" class="gallery-modal-root hidden" aria-hidden="true">
        <div class="gallery-modal-backdrop"></div>

        <div class="gallery-modal-shell">
            {{-- TOMBOL CLOSE --}}
            <button type="button" id="gallery-modal-close" class="gallery-modal-close" aria-label="Tutup">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18" />
                </svg>
            </button>

            {{-- =====================================================
                 KIRI — FOTO
            ====================================================== --}}
            <div class="gallery-modal-media">
                <div class="gallery-modal-main-image-wrap">
                    <img id="gallery-modal-image" src="" alt="" class="gallery-modal-main-image" />

                    {{-- PANAH --}}
                    <button type="button" id="gallery-modal-prev" class="gallery-modal-nav gallery-modal-prev"
                        aria-label="Foto sebelumnya">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    <button type="button" id="gallery-modal-next" class="gallery-modal-nav gallery-modal-next"
                        aria-label="Foto berikutnya">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

                {{-- THUMBNAIL --}}
                <div id="gallery-modal-thumbs" class="gallery-modal-thumbs"></div>

                {{-- DOT INDICATOR --}}
                <div id="gallery-modal-dots" class="gallery-modal-dots"></div>
            </div>

            {{-- =====================================================
                 KANAN — INFORMASI
            ====================================================== --}}
            <div class="gallery-modal-info">
                {{-- BADGE --}}
                <span id="gallery-modal-badge" class="gallery-modal-badge">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>

                    GALERI
                </span>

                {{-- JUDUL --}}
                <h2 id="gallery-modal-title" class="gallery-modal-title">-</h2>

                {{-- AKSEN --}}
                <div class="gallery-modal-accent">
                    <span></span>
                    <span></span>
                </div>

                {{-- DESKRIPSI --}}
                <div class="gallery-modal-description-box">
                    <p id="gallery-modal-description" class="gallery-modal-description">-</p>
                </div>

                {{-- WHATSAPP --}}
                <a id="gallery-modal-whatsapp" href="{{ $gallerySetting->cta_button_2_link ?? '#' }}"
                    target="_blank" rel="noopener noreferrer" onclick="trackWhatsappClick('gallery-modal')"
                    class="gallery-modal-wa">
                    <svg class="w-7 h-7 shrink-0" viewBox="0 0 32 32" fill="none" aria-hidden="true">
                        <circle cx="16" cy="16" r="14" fill="currentColor" opacity="0.18" />
                        <path
                            d="M22.9 19.35c-.37-.19-2.2-1.08-2.54-1.2-.34-.13-.59-.19-.84.19-.25.37-.96 1.2-1.18 1.45-.22.25-.44.28-.81.09-.37-.19-1.57-.58-2.99-1.85-1.1-.98-1.84-2.2-2.06-2.57-.22-.37-.02-.57.17-.76.17-.17.37-.44.56-.66.19-.22.25-.37.37-.62.12-.25.06-.47-.03-.66-.09-.19-.84-2.02-1.15-2.77-.3-.73-.61-.63-.84-.64-.22-.01-.47-.01-.72-.01s-.66.09-1 .47c-.34.37-1.31 1.28-1.31 3.11s1.34 3.61 1.53 3.86c.19.25 2.63 4.02 6.38 5.64.89.38 1.58.61 2.12.78.89.28 1.7.24 2.34.15.71-.11 2.2-.9 2.51-1.77.31-.87.31-1.62.22-1.77-.09-.15-.34-.25-.71-.44Z"
                            fill="currentColor" />
                    </svg>

                    <span> Tanya / Reservasi via WhatsApp </span>

                    <svg class="w-5 h-5 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

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

        document.addEventListener("DOMContentLoaded", () => {
            /* =====================================================
                   FADE ANIMATION
                ====================================================== */

            const sections = document.querySelectorAll(".fade-section");

            const observer = new IntersectionObserver(
                (entries, obs) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            entry.target.classList.remove(
                                "opacity-0",
                                "translate-y-10",
                            );

                            entry.target.classList.add("opacity-100", "translate-y-0");

                            obs.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.1,
                },
            );

            sections.forEach((section) => {
                observer.observe(section);
            });

            /* =====================================================
                   FILTER NAVBAR
                ===================================================== */

            /* =====================================================
                   DATA FOTO DARI DATABASE
                ===================================================== */

            const galleryData = {!! json_encode(
                $photos->map(function ($photo) {
                        $category = strtolower(trim($photo->category));
            
                        if ($category === 'momen') {
                            $normalizedCategory = 'momen';
                        } elseif (in_array($category, ['facility', 'facilities', 'fasilitas'])) {
                            $normalizedCategory = 'facility';
                        } elseif (in_array($category, ['event', 'events'])) {
                            $normalizedCategory = 'event';
                        } else {
                            $normalizedCategory = $category;
                        }
            
                        return [
                            'id' => $photo->id,
                            'category' => $normalizedCategory,
                            'title' => $photo->title,
                            'description' => $photo->description,
                            'image' => (function ($path) {
                                $path = ltrim($path ?? '', '/');
            
                                if (str_starts_with($path, 'storage/')) {
                                    return asset($path);
                                }
            
                                if (str_starts_with($path, 'public/')) {
                                    return asset(substr($path, 7));
                                }
            
                                return asset('storage/' . $path);
                            })($photo->image_path),
                        ];
                    })->values()->toArray(),
            ) !!};

            // Simpan juga secara global agar popup dapat mengakses data foto.
            window.galleryData = galleryData;

            /* =====================================================
                   HELPER CARD KATEGORI
                ===================================================== */

            function escapeHtml(value) {
                return String(value ?? "")
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            function renderCategoryCard(photo) {
                const categoryLabel =
                    photo.category === "momen" ?
                    "MOMEN" :
                    photo.category === "facility" ?
                    "FASILITAS" :
                    photo.category === "event" ?
                    "EVENT" :
                    String(photo.category || "").toUpperCase();

                return `
                    <article class="w-full">
                        <div class="group w-full h-[365px] overflow-hidden rounded-2xl
                                    bg-white border border-gray-200 shadow-sm
                                    hover:shadow-lg transition-all duration-300">

                            <div class="relative w-full h-[175px] bg-gray-100 overflow-hidden">

                                <div class="absolute inset-0 bg-gray-100"></div>

                                <img
                                    src="${escapeHtml(photo.image)}"
                                    alt="${escapeHtml(photo.title || "Gallery")}"
                                    class="relative z-10 w-full h-full object-cover
                                           transition-transform duration-500
                                           group-hover:scale-105"
                                    onerror="this.style.display='none';"
                                />

                            </div>

                            <div class="h-[190px] p-4 sm:p-5 flex flex-col min-h-0">

                                <div class="shrink-0">
                                    <span
                                        class="inline-flex items-center px-2 py-1
                                               rounded-md bg-red-50 text-red-600
                                               text-[10px] sm:text-[11px] font-bold">
                                        ${categoryLabel}
                                    </span>
                                </div>

                                <h3
                                    class="mt-2 shrink-0 font-bold text-gray-900
                                           text-sm sm:text-base leading-tight line-clamp-1">
                                    ${escapeHtml(photo.title || "Tanpa judul")}
                                </h3>

                                <p
                                    class="mt-2 text-xs sm:text-[13px] text-gray-600
                                           leading-[1.5] line-clamp-2 min-h-[40px]">
                                    ${escapeHtml(photo.description || "")}
                                </p>

                                <div class="mt-auto pt-3 shrink-0">
                                    <button
                                        type="button"
                                        data-photo-id="${escapeHtml(photo.id)}"
                                        data-category="${escapeHtml(photo.category)}"
                                        class="inline-flex items-center gap-1
                                               text-xs sm:text-[13px] font-semibold
                                               text-red-600 hover:text-red-700
                                               transition-colors">

                                        <span>Lihat selengkapnya</span>

                                        <svg class="w-3.5 h-3.5"
                                             fill="none"
                                             stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M9 5l7 7-7 7" />
                                        </svg>

                                    </button>
                                </div>

                            </div>
                        </div>
                    </article>
                `;
            }
            /* =====================================================
                   KLIK NAVBAR
                ===================================================== */

            const filterButtons = document.querySelectorAll(".filter-btn");
            const categorySections = document.querySelectorAll(".gallery-category");
            const detailView = document.getElementById("category-detail-view");
            const detailGrid = document.getElementById("category-detail-grid");
            const detailPagination = document.getElementById("category-pagination");

            let currentCategory = null;

            function renderCategoryPagination(
                filteredPhotos,
                currentPage,
                totalPages,
                renderPage,
            ) {
                if (!filteredPhotos.length) {
                    detailPagination.innerHTML = "";
                    return;
                }

                detailPagination.innerHTML = Array.from({
                        length: totalPages,
                    },
                    (_, index) => {
                        const page = index + 1;

                        return `
                            <button
                                type="button"
                                class="category-page-btn ${page === currentPage ? "active" : ""}"
                                data-category-page="${page}">
                                ${page}
                            </button>
                        `;
                    },
                ).join("");

                detailPagination
                    .querySelectorAll("[data-category-page]")
                    .forEach((button) => {
                        button.addEventListener("click", () => {
                            const page = Number(button.dataset.categoryPage);

                            renderPage(page);

                            detailView.scrollIntoView({
                                behavior: "smooth",
                                block: "start",
                            });
                        });
                    });
            }

            function showCategory(category) {
                currentCategory = category;

                const filteredPhotos = galleryData.filter(
                    (photo) => photo.category === category,
                );

                const ITEMS_PER_PAGE = 9;
                const totalPages = Math.max(
                    1,
                    Math.ceil(filteredPhotos.length / ITEMS_PER_PAGE),
                );

                function renderPage(page) {
                    const currentPage = Math.min(Math.max(page, 1), totalPages);

                    const start = (currentPage - 1) * ITEMS_PER_PAGE;
                    const pagePhotos = filteredPhotos.slice(
                        start,
                        start + ITEMS_PER_PAGE,
                    );

                    if (!pagePhotos.length) {
                        detailGrid.innerHTML = `
                            <div class="col-span-full min-h-[180px]
                                        flex items-center justify-center
                                        text-center">
                                <p class="text-sm text-gray-400">
                                    Belum ada foto pada kategori ini.
                                </p>
                            </div>
                        `;

                        detailPagination.innerHTML = "";
                        return;
                    }

                    detailGrid.innerHTML = pagePhotos.map(renderCategoryCard).join("");

                    renderCategoryPagination(
                        filteredPhotos,
                        currentPage,
                        totalPages,
                        renderPage,
                    );
                }

                renderPage(1);

                categorySections.forEach((section) => {
                    section.style.display = "none";
                });

                detailView.classList.remove("hidden");

                requestAnimationFrame(() => {
                    detailView.scrollIntoView({
                        behavior: "smooth",
                        block: "start",
                    });
                });
            }

            filterButtons.forEach((button) => {
                button.addEventListener("click", () => {
                    const filter = button.dataset.filter;

                    /* RESET SEMUA TOMBOL KE WARNA NORMAL */
                    filterButtons.forEach((btn) => {
                        btn.classList.remove(
                            "bg-red-500",
                            "text-white",
                            "shadow-sm",
                            "shadow-md",
                            "hover:bg-red-600"
                        );

                        btn.classList.add(
                            "bg-stone-50",
                            "text-gray-600",
                            "hover:bg-stone-100"
                        );

                        /* RESET WARNA IKON */
                        const icon = btn.querySelector("span");
                        if (icon) {
                            icon.classList.remove("bg-white/20");
                            icon.classList.add("bg-red-50", "text-red-600");
                        }

                        /* RESET WARNA JUMLAH FOTO */
                        const count = btn.querySelector("span:last-child");
                        if (count) {
                            count.classList.remove("bg-white/20");
                            count.classList.add("bg-red-50", "text-red-600");
                        }
                    });

                    /* TOMBOL YANG DIPILIH MENJADI MERAH */
                    button.classList.remove(
                        "bg-stone-50",
                        "text-gray-600",
                        "hover:bg-stone-100"
                    );

                    button.classList.add(
                        "bg-red-500",
                        "text-white",
                        "shadow-md",
                        "hover:bg-red-600"
                    );

                    /* IKON TOMBOL AKTIF */
                    const activeIcon = button.querySelector("span");
                    if (activeIcon) {
                        activeIcon.classList.remove("bg-red-50", "text-red-600");
                        activeIcon.classList.add("bg-white/20");
                    }

                    /* JUMLAH FOTO TOMBOL AKTIF */
                    const activeCount = button.querySelector("span:last-child");
                    if (activeCount) {
                        activeCount.classList.remove("bg-red-50", "text-red-600");
                        activeCount.classList.add("bg-white/20");
                    }

                    /* KATEGORI SEMUA */
                    if (filter === "all") {
                        detailView.classList.add("hidden");

                        categorySections.forEach((section) => {
                            section.style.display = "block";
                        });

                        currentCategory = null;
                        return;
                    }

                    /* KATEGORI MOMEN, FASILITAS, DAN EVENT */
                    showCategory(filter);
                });
            });


            // ==============================
            // AKTIFKAN KATEGORI DARI URL
            // ==============================
            const urlParams = new URLSearchParams(window.location.search);
            const urlCategory = urlParams.get("category");

            if (urlCategory) {
                const targetButton = document.querySelector(
                    `.filter-btn[data-filter="${urlCategory}"]`,
                );

                if (targetButton) {
                    targetButton.click();
                }
            }
        });

        /* =====================================================
               PANAH MODE SEMUA
            ===================================================== */

        const categoryArrows = document.querySelectorAll(".category-arrow");

        categoryArrows.forEach((button) => {
            button.addEventListener("click", () => {
                const target = button.dataset.target;

                const direction = button.dataset.direction;

                const track = document.getElementById("gallery-track-" + target);

                if (!track) {
                    return;
                }

                const scrollAmount = track.clientWidth * 0.9;

                if (direction === "next") {
                    track.scrollBy({
                        left: scrollAmount,
                        behavior: "smooth",
                    });
                } else {
                    track.scrollBy({
                        left: -scrollAmount,
                        behavior: "smooth",
                    });
                }
            });
        });

        /* =====================================================
               WHATSAPP ADMIN POPOVER
            ===================================================== */

        const whatsappButton = document.getElementById("open-whatsapp-admin");

        const whatsappPopover = document.getElementById("whatsapp-admin-modal");

        if (whatsappButton && whatsappPopover) {
            /* KLIK TOMBOL WHATSAPP */

            whatsappButton.addEventListener("click", function(event) {
                const configuredLink =
                    whatsappButton.dataset.configuredWhatsapp?.trim();

                if (configuredLink) {
                    event.preventDefault();
                    event.stopPropagation();

                    let url = configuredLink;

                    if (/^\\d{9,15}$/.test(url)) {
                        url = "https://wa.me/" + url;
                    } else if (/^0\\d{8,14}$/.test(url)) {
                        url = "https://wa.me/62" + url.substring(1);
                    }

                    window.open(url, "_blank", "noopener,noreferrer");
                    return;
                }

                event.stopPropagation();
                whatsappPopover.classList.toggle("show");
            });

            /* KLIK DI LUAR POPUP */

            document.addEventListener("click", function(event) {
                if (
                    !whatsappPopover.contains(event.target) &&
                    !whatsappButton.contains(event.target)
                ) {
                    whatsappPopover.classList.remove("show");
                }
            });

            /* PILIH ADMIN */

            document
                .querySelectorAll(".whatsapp-admin-option")
                .forEach(function(admin) {
                    admin.addEventListener("click", function() {
                        const number = this.dataset.number;

                        const message = encodeURIComponent(
                            "Halo Admin, saya ingin bertanya mengenai Resto Joss Gandos.",
                        );

                        window.open(
                            "https://wa.me/" + number + "?text=" + message,
                            "_blank",
                        );
                    });
                });
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const galleryData = window.galleryData || [];

            const galleryModal = document.getElementById(
                "gallery-detail-modal",
            );
            const galleryModalImage = document.getElementById(
                "gallery-modal-image",
            );
            const galleryModalBadge = document.getElementById(
                "gallery-modal-badge",
            );
            const galleryModalTitle = document.getElementById(
                "gallery-modal-title",
            );
            const galleryModalDescription = document.getElementById(
                "gallery-modal-description",
            );
            const galleryModalWhatsapp = document.getElementById(
                "gallery-modal-whatsapp",
            );
            const galleryModalClose = document.getElementById(
                "gallery-modal-close",
            );
            const galleryModalPrev =
                document.getElementById("gallery-modal-prev");
            const galleryModalNext =
                document.getElementById("gallery-modal-next");
            const galleryModalThumbs = document.getElementById(
                "gallery-modal-thumbs",
            );
            const galleryModalDots =
                document.getElementById("gallery-modal-dots");

            let currentPopupIndex = 0;
            let currentPopupCategory = null;

            if (!galleryModal) {
                return;
            }

            /* =====================================================
               PORTAL KE BODY
            ===================================================== */

            if (galleryModal.parentElement !== document.body) {
                document.body.appendChild(galleryModal);
            }

            galleryModal.classList.add("gallery-modal-root");

            /* =====================================================
               HELPER
            ===================================================== */

            function getPopupPhotos() {
                return galleryData.filter(
                    (photo) => photo.category === currentPopupCategory,
                );
            }

            function getCategoryLabel(category) {
                return category === "momen" ?
                    "MOMEN" :
                    category === "facility" ?
                    "FASILITAS" :
                    category === "event" ?
                    "EVENT" :
                    String(category || "galeri").toUpperCase();
            }

            /* =====================================================
               THUMBNAIL
            ===================================================== */

            function renderThumbnails(photos) {
                galleryModalThumbs.innerHTML = photos
                    .map(
                        (photo, index) => `
                    <button type="button"
                        class="gallery-modal-thumb ${index === currentPopupIndex ? "active" : ""}"
                        data-gallery-thumb-index="${index}"
                        aria-label="Lihat foto ${index + 1}">

                        <img src="${photo.image}"
                            alt="${photo.title || "Gallery"}">

                    </button>
                `,
                    )
                    .join("");

                galleryModalThumbs
                    .querySelectorAll("[data-gallery-thumb-index]")
                    .forEach((button) => {
                        button.addEventListener("click", () => {
                            currentPopupIndex = Number(
                                button.dataset.galleryThumbIndex,
                            );

                            updateGalleryPopup();
                        });
                    });
            }

            /* =====================================================
               DOT
            ===================================================== */

            function renderDots(photos) {
                galleryModalDots.innerHTML = photos
                    .map(
                        (_, index) => `
                    <button type="button"
                        class="gallery-modal-dot ${index === currentPopupIndex ? "active" : ""}"
                        data-gallery-dot-index="${index}"
                        aria-label="Foto ${index + 1}">
                    </button>
                `,
                    )
                    .join("");

                galleryModalDots
                    .querySelectorAll("[data-gallery-dot-index]")
                    .forEach((button) => {
                        button.addEventListener("click", () => {
                            currentPopupIndex = Number(
                                button.dataset.galleryDotIndex,
                            );

                            updateGalleryPopup();
                        });
                    });
            }

            /* =====================================================
               UPDATE POPUP
            ===================================================== */

            function escapeHtml(value) {
                return String(value)
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            function formatGalleryDescription(description) {
                if (!description || !String(description).trim()) {
                    return `
                        <p class="gallery-modal-description">
                            Tidak ada deskripsi.
                        </p>
                    `;
                }

                const rawText = String(description).trim();

                /*
                 * LOGIKA DESKRIPSI:
                 *
                 * 1) Tidak ada nomor "1. ", "2. ", dst.
                 *    -> tampil sebagai teks biasa.
                 *
                 * 2) Ada nomor:
                 *    -> teks sebelum nomor tetap menjadi paragraf biasa.
                 *    -> bagian bernomor diubah menjadi ordered list.
                 *
                 * Contoh:
                 *
                 * "Suasana nyaman untuk keluarga.
                 * 1. Area indoor
                 * 2. Area outdoor"
                 *
                 * menjadi:
                 * Suasana nyaman untuk keluarga.
                 *
                 * 1. Area indoor
                 * 2. Area outdoor
                 */

                const numberedPattern = /(?:^|\s)(\d+)\.\s+/;
                const firstNumberMatch = rawText.match(numberedPattern);

                // Tidak ada nomor -> tetap teks biasa.
                if (!firstNumberMatch) {
                    return `
                        <p class="gallery-modal-description">
                            ${escapeHtml(rawText).replace(/\r?\n/g, "<br>")}
                        </p>
                    `;
                }

                const numberIndex = firstNumberMatch.index ?? -1;

                let introText = rawText.slice(0, numberIndex).trim();

                let listText = rawText.slice(numberIndex).trim();

                /*
                 * Bila nomor berada setelah spasi,
                 * buang spasi pemisah tersebut dari intro.
                 */
                introText = introText.replace(/\s+$/, "");

                const items = listText
                    .split(/(?:^|\s)(?=\d+\.\s+)/)
                    .map((item) => item.trim())
                    .filter(Boolean)
                    .map((item) => item.replace(/^\d+\.\s+/, "").trim())
                    .filter(Boolean);

                let html = "";

                // Teks biasa sebelum daftar.
                if (introText) {
                    html += `
                        <p class="gallery-modal-description">
                            ${escapeHtml(introText).replace(/\r?\n/g, "<br>")}
                        </p>
                    `;
                }

                // Daftar bernomor.
                if (items.length) {
                    html += `
                        <ol class="gallery-modal-description gallery-modal-description-list gallery-modal-numbered-list">
                            ${items
                                .map(
                                    (item) => `
                                                                                                                                                                                                                                                                                                <li>${escapeHtml(item)}</li>
                                                                                                                                                                                                                                                                                            `,
                                )
                                .join("")}
                        </ol>
                    `;
                }

                return (
                    html ||
                    `
                    <p class="gallery-modal-description">
                        ${escapeHtml(rawText).replace(/\r?\n/g, "<br>")}
                    </p>
                `
                );
            }

            function updateGalleryPopup() {
                const photos = getPopupPhotos();

                if (!photos.length) {
                    return;
                }

                if (currentPopupIndex < 0) {
                    currentPopupIndex = photos.length - 1;
                }

                if (currentPopupIndex >= photos.length) {
                    currentPopupIndex = 0;
                }

                const photo = photos[currentPopupIndex];

                galleryModalImage.src = photo.image;
                galleryModalImage.alt = photo.title || "Gallery";

                galleryModalBadge.innerHTML = `
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                    ${getCategoryLabel(photo.category)}
                `;

                galleryModalTitle.textContent = photo.title ?
                    String(photo.title)
                    .toLowerCase()
                    .replace(/\b\w/g, (char) => char.toUpperCase()) :
                    "Tanpa judul";

                galleryModalDescription.innerHTML = formatGalleryDescription(
                    photo.description,
                );

                /* ================= WHATSAPP ================= */

                const whatsappNumber = "089699071599";

                const cleanNumber = whatsappNumber
                    .replace(/\D/g, "")
                    .replace(/^0/, "62");

                const message = encodeURIComponent(
                    `Halo Admin, saya tertarik dengan "${photo.title}". Saya ingin mendapatkan informasi lebih lanjut.`,
                );

                galleryModalWhatsapp.href = `https://wa.me/${cleanNumber}?text=${message}`;

                /* ================= UI FOTO ================= */

                renderThumbnails(photos);
                renderDots(photos);
            }

            /* =====================================================
               BUKA POPUP
            ===================================================== */

            function openGalleryPopup(photoId, category) {
                const photos = galleryData.filter(
                    (photo) => photo.category === category,
                );

                if (!photos.length) {
                    return;
                }

                const index = photos.findIndex(
                    (photo) => String(photo.id) === String(photoId),
                );

                currentPopupCategory = category;

                currentPopupIndex = index >= 0 ? index : 0;

                updateGalleryPopup();

                galleryModal.classList.remove("hidden");
                galleryModal.classList.add("is-open");
                galleryModal.removeAttribute("inert");
                galleryModal.setAttribute("aria-hidden", "false");

                const galleryModalShell = galleryModal.querySelector(
                    ".gallery-modal-shell",
                );

                if (galleryModalShell) {
                    galleryModalShell.scrollTop = 0;
                }

                document.body.classList.add("overflow-hidden");
            }

            /* =====================================================
               KLIK LIHAT SELENGKAPNYA
            ===================================================== */

            document.addEventListener("click", function(event) {
                const button = event.target.closest("[data-photo-id]");

                if (!button) {
                    return;
                }

                event.preventDefault();

                const photoId = button.getAttribute("data-photo-id");

                const category = button.getAttribute("data-category");

                openGalleryPopup(photoId, category);
            });

            /* =====================================================
               PANAH KIRI / KANAN
            ===================================================== */

            galleryModalPrev.addEventListener("click", function(event) {
                event.stopPropagation();

                currentPopupIndex--;

                updateGalleryPopup();
            });

            galleryModalNext.addEventListener("click", function(event) {
                event.stopPropagation();

                currentPopupIndex++;

                updateGalleryPopup();
            });

            /* =====================================================
               TUTUP
            ===================================================== */

            function closeGalleryPopup() {
                if (
                    document.activeElement &&
                    galleryModal.contains(document.activeElement)
                ) {
                    document.activeElement.blur();
                }

                galleryModal.classList.add("hidden");
                galleryModal.classList.remove("is-open");

                galleryModal.setAttribute("inert", "");
                galleryModal.setAttribute("aria-hidden", "true");

                document.body.classList.remove("overflow-hidden");
            }

            galleryModalClose.addEventListener("click", function(event) {
                event.stopPropagation();

                closeGalleryPopup();
            });

            /* Tutup ketika klik area gelap */

            galleryModal
                .querySelector(".gallery-modal-backdrop")
                .addEventListener("click", function() {
                    closeGalleryPopup();
                });

            /* =====================================================
               ESC + KEYBOARD
            ===================================================== */

            document.addEventListener("keydown", function(event) {
                if (!galleryModal.classList.contains("is-open")) {
                    return;
                }

                if (event.key === "Escape") {
                    closeGalleryPopup();
                }

                if (event.key === "ArrowLeft") {
                    currentPopupIndex--;

                    updateGalleryPopup();
                }

                if (event.key === "ArrowRight") {
                    currentPopupIndex++;

                    updateGalleryPopup();
                }
            });

            /* =====================================================
               SWIPE FOTO DI POPUP
            ===================================================== */

            let touchStartX = 0;
            let touchEndX = 0;

            galleryModalImage.addEventListener(
                "touchstart",
                function(event) {
                    touchStartX = event.changedTouches[0].screenX;
                }, {
                    passive: true,
                },
            );

            galleryModalImage.addEventListener(
                "touchend",
                function(event) {
                    touchEndX = event.changedTouches[0].screenX;

                    const distance = touchEndX - touchStartX;

                    if (Math.abs(distance) < 40) {
                        return;
                    }

                    if (distance > 0) {
                        currentPopupIndex--;
                    } else {
                        currentPopupIndex++;
                    }

                    updateGalleryPopup();
                }, {
                    passive: true,
                },
            );
        });
    </script>
</x-layout>
