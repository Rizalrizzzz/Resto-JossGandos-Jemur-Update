<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Resto Joss Gandos</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logojossgandos.png') }}" />

    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>

    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css" />

    <style>
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition:
                opacity 0.8s ease-out,
                transform 0.8s ease-out;
        }

        .fade-in.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* =========================================================
           FOOTER JOSS GANDOS
           ========================================================= */

        .jg-footer {
            background:
                radial-gradient(circle at 8% 20%, rgba(185, 132, 52, 0.08), transparent 24%),
                radial-gradient(circle at 92% 18%, rgba(157, 28, 28, 0.05), transparent 22%),
                linear-gradient(180deg, #fffdf8 0%, #fff8ec 100%);
            color: #29231f;
            border-top: 1px solid rgba(157, 28, 28, 0.18);
        }

        .jg-footer-main {
            position: relative;
            z-index: 2;
            max-width: 1280px;
            margin: 0 auto;
            padding: 48px 32px 0;
        }

        .jg-footer-grid {
            display: grid;
            grid-template-columns: 1.4fr 0.75fr 1.3fr 0.95fr;
            gap: 0;
        }

        .jg-footer-column {
            min-width: 0;
            padding: 0 30px;
        }

        .jg-footer-column+.jg-footer-column {
            border-left: 1px solid rgba(122, 84, 42, 0.18);
        }

        .jg-footer-brand {
            padding-left: 0;
        }

        .jg-footer-hours-column {
            padding-right: 0;
        }

        .jg-footer-brand-head {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .jg-footer-logo {
            width: 112px;
            height: 112px;
            object-fit: contain;
            flex: 0 0 112px;
        }

        .jg-footer-brand-name {
            margin: 0;
            color: #8c1017;
            font-size: 2rem;
            line-height: 1;
            font-weight: 900;
            letter-spacing: 0.02em;
            white-space: nowrap;
        }

        .jg-footer-brand-subtitle {
            margin: 8px 0 0;
            color: #cf952f;
            font-size: 0.96rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            white-space: nowrap;
        }

        .jg-footer-brand-location {
            display: inline-block;
            margin: 7px 0 0;
            padding-bottom: 3px;
            color: #9b1a1d;
            font-size: 0.84rem;
            font-weight: 800;
            letter-spacing: 0.13em;
            border-bottom: 2px solid #c98932;
            white-space: nowrap;
        }

        .jg-footer-brand-line {
            width: 58px;
            height: 3px;
            margin-top: 18px;
            background: linear-gradient(90deg, #9d1c1c 0%, #c98932 100%);
            border-radius: 999px;
        }

        .jg-footer-description {
            margin: 18px 0 0;
            max-width: 470px;
            color: #4f4945;
            font-size: 0.95rem;
            line-height: 1.75;
        }

        .jg-footer-socials {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

        .jg-footer-social {
            width: 46px;
            height: 46px;
            border: 1.5px solid #a51d22;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #27211f;
            background: rgba(255, 255, 255, 0.72);
            box-shadow: 0 6px 18px rgba(82, 40, 20, 0.06);
            transition:
                transform 0.25s ease,
                background-color 0.25s ease,
                color 0.25s ease;
        }

        .jg-footer-social:hover {
            transform: translateY(-2px);
            background: #9d1c1c;
            color: white;
        }

        .jg-footer-social i {
            font-size: 1.25rem;
        }

        .jg-footer-heading,
        .jg-footer-hours-title {
            margin: 0;
            color: #8c1017;
            font-size: 1.25rem;
            line-height: 1.2;
            font-weight: 900;
        }

        .jg-footer-heading-line {
            width: 68px;
            height: 4px;
            margin-top: 12px;
            background: linear-gradient(90deg, #c98932 0%, #e2b75f 100%);
            border-radius: 999px;
        }

        .jg-footer-links {
            display: flex;
            flex-direction: column;
            gap: 17px;
            margin: 25px 0 0;
            padding: 0;
            list-style: none;
        }

        .jg-footer-links a {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: #3f3935;
            font-size: 0.98rem;
            font-weight: 600;
            text-decoration: none;
            transition:
                color 0.25s ease,
                transform 0.25s ease;
        }

        .jg-footer-links a i {
            color: #a51d22;
            font-size: 1.05rem;
        }

        .jg-footer-links a:hover {
            color: #a51d22;
            transform: translateX(3px);
        }

        .jg-footer-contact-list {
            display: flex;
            flex-direction: column;
            gap: 22px;
            margin: 25px 0 0;
            padding: 0;
            list-style: none;
        }

        .jg-footer-contact-list li {
            display: flex;
            align-items: flex-start;
            gap: 13px;
        }

        .jg-footer-contact-icon {
            width: 44px;
            height: 44px;
            flex: 0 0 44px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #b41d24;
            color: white;
            box-shadow: 0 6px 16px rgba(180, 29, 36, 0.15);
        }

        .jg-footer-contact-icon i {
            font-size: 1.2rem;
        }

        .jg-footer-contact-text {
            padding-top: 7px;
            color: #47413d;
            font-size: 0.94rem;
            line-height: 1.6;
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .jg-footer-email {
            font-size: 0.94rem;
            white-space: nowrap;
            overflow-wrap: normal;
        }

        .jg-footer-hours-card {
            padding: 23px 23px 24px;
            border: 1px solid rgba(185, 132, 52, 0.28);
            border-radius: 22px;
            background: rgba(255, 252, 246, 0.88);
            box-shadow: 0 12px 32px rgba(71, 38, 15, 0.07);
        }

        .jg-footer-hours-main {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-top: 23px;
        }

        .jg-footer-clock-icon {
            width: 52px;
            height: 52px;
            flex: 0 0 52px;
            border: 1px solid rgba(201, 137, 50, 0.22);
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #fffaf0;
            color: #c98932;
        }

        .jg-footer-clock-icon i {
            font-size: 1.65rem;
        }

        .jg-footer-hours-day {
            margin: 0;
            color: #8a2629;
            font-size: 0.92rem;
            font-weight: 600;
        }

        .jg-footer-hours-time {
            margin: 3px 0 0;
            color: #781319;
            font-size: 1.62rem;
            line-height: 1.1;
            font-weight: 900;
            letter-spacing: 0.01em;
        }

        .jg-footer-hours-divider {
            height: 1px;
            margin: 20px 0 17px;
            background: rgba(122, 84, 42, 0.15);
        }

        .jg-footer-close-order {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #a51d22;
            font-size: 0.9rem;
            font-weight: 800;
        }

        .jg-footer-close-order i {
            font-size: 1.05rem;
        }

        .jg-footer-status {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            margin-top: 20px;
            padding: 10px 16px;
            border: 1px solid rgba(34, 197, 94, 0.3);
            border-radius: 999px;
            background: #effcf2;
            color: #15803d;
            font-size: 0.84rem;
            line-height: 1;
            font-weight: 800;
            transition:
                color 0.25s ease,
                background-color 0.25s ease,
                border-color 0.25s ease;
        }

        .jg-footer-status-dot {
            position: relative;
            width: 10px;
            height: 10px;
            display: inline-flex;
            flex: 0 0 10px;
        }

        .jg-footer-status-ping,
        .jg-footer-status-inner {
            position: absolute;
            inset: 0;
            border-radius: 999px;
        }

        .jg-footer-status-ping {
            opacity: 0.75;
        }

        .jg-footer-status-inner {
            position: relative;
        }

        .jg-footer-bottom {
            position: relative;
            z-index: 2;
            margin-top: 45px;
            margin-left: -32px;
            margin-right: -32px;
            padding: 19px 32px 21px;
            background:
                radial-gradient(circle at 8% 110%, rgba(255, 255, 255, 0.08), transparent 16%),
                radial-gradient(circle at 92% -20%, rgba(255, 205, 110, 0.08), transparent 18%),
                linear-gradient(90deg, #7e070e 0%, #980c14 50%, #78060d 100%);
            border-top: 2px solid #c98932;
            color: white;
            text-align: center;
        }

        .jg-footer-bottom::before,
        .jg-footer-bottom::after {
            content: "";
            position: absolute;
            width: 110px;
            height: 60px;
            opacity: 0.14;
            background:
                radial-gradient(circle at 25% 60%, rgba(255, 255, 255, 0.25) 0 2px, transparent 3px),
                radial-gradient(circle at 55% 40%, rgba(255, 255, 255, 0.2) 0 2px, transparent 3px),
                radial-gradient(circle at 78% 64%, rgba(255, 255, 255, 0.2) 0 2px, transparent 3px);
            pointer-events: none;
        }

        .jg-footer-bottom::before {
            left: 0;
            bottom: 0;
        }

        .jg-footer-bottom::after {
            right: 0;
            top: 0;
        }

        .jg-footer-bottom p {
            position: relative;
            z-index: 1;
            margin: 0;
            font-size: 0.91rem;
            font-weight: 500;
        }

        .jg-footer-motif {
            position: absolute;
            z-index: 1;
            pointer-events: none;
        }

        .jg-footer-motif svg {
            width: 100%;
            height: 100%;
            display: block;
        }

        .jg-footer-motif-left-top {
            left: -12px;
            top: 0;
            width: 220px;
            height: 180px;
        }

        .jg-footer-motif-right-top {
            right: -12px;
            top: 0;
            width: 220px;
            height: 180px;
        }

        .jg-footer-motif-left-bottom {
            left: -5px;
            bottom: 44px;
            width: 220px;
            height: 120px;
        }

        .jg-footer-motif-right-bottom {
            right: -5px;
            bottom: 44px;
            width: 220px;
            height: 120px;
        }

        @media (max-width: 1023px) {
            .jg-footer-main {
                padding-left: 22px;
                padding-right: 22px;
            }

            .jg-footer-grid {
                grid-template-columns: 1.2fr 0.8fr;
                row-gap: 34px;
            }

            .jg-footer-column+.jg-footer-column {
                border-left: 0;
            }

            .jg-footer-contact-column,
            .jg-footer-hours-column {
                border-top: 1px solid rgba(122, 84, 42, 0.18);
                padding-top: 32px;
            }

            .jg-footer-column:nth-child(2),
            .jg-footer-column:nth-child(4) {
                padding-right: 0;
            }

            .jg-footer-column:nth-child(1),
            .jg-footer-column:nth-child(3) {
                padding-left: 0;
            }

            .jg-footer-bottom {
                margin-left: -22px;
                margin-right: -22px;
                padding-left: 22px;
                padding-right: 22px;
            }
        }

        @media (max-width: 639px) {
            .jg-footer-main {
                padding: 38px 18px 0;
            }

            .jg-footer-grid {
                grid-template-columns: 1fr;
                row-gap: 0;
            }

            .jg-footer-column,
            .jg-footer-column:nth-child(1),
            .jg-footer-column:nth-child(2),
            .jg-footer-column:nth-child(3),
            .jg-footer-column:nth-child(4) {
                padding: 0;
            }

            .jg-footer-column+.jg-footer-column {
                margin-top: 30px;
                padding-top: 30px;
                border-top: 1px solid rgba(122, 84, 42, 0.16);
            }

            .jg-footer-brand-head {
                align-items: center;
                gap: 13px;
            }

            .jg-footer-logo {
                width: 88px;
                height: 88px;
                flex-basis: 88px;
            }

            .jg-footer-brand-name {
                font-size: 1.55rem;
            }

            .jg-footer-brand-subtitle {
                font-size: 0.72rem;
                letter-spacing: 0.07em;
                margin-top: 5px;
            }

            .jg-footer-brand-location {
                font-size: 0.7rem;
                margin-top: 5px;
            }

            .jg-footer-description {
                margin-top: 15px;
                font-size: 0.87rem;
                line-height: 1.65;
            }

            .jg-footer-social {
                width: 42px;
                height: 42px;
            }

            .jg-footer-heading,
            .jg-footer-hours-title {
                font-size: 1.12rem;
            }

            .jg-footer-links {
                gap: 14px;
                margin-top: 20px;
            }

            .jg-footer-links a {
                font-size: 0.92rem;
            }

            .jg-footer-contact-list {
                gap: 17px;
                margin-top: 20px;
            }

            .jg-footer-contact-icon {
                width: 40px;
                height: 40px;
                flex-basis: 40px;
            }

            .jg-footer-contact-text {
                padding-top: 5px;
                font-size: 0.86rem;
            }

            .jg-footer-email {
                font-size: 0.8rem;
            }

            .jg-footer-hours-card {
                padding: 20px;
            }

            .jg-footer-hours-main {
                margin-top: 20px;
            }

            .jg-footer-clock-icon {
                width: 46px;
                height: 46px;
                flex-basis: 46px;
            }

            .jg-footer-hours-time {
                font-size: 1.42rem;
            }

            .jg-footer-bottom {
                margin-top: 34px;
                margin-left: -18px;
                margin-right: -18px;
                padding: 16px 18px 18px;
            }

            .jg-footer-bottom p {
                font-size: 0.78rem;
                line-height: 1.5;
            }

            .jg-footer-motif-left-top,
            .jg-footer-motif-right-top {
                width: 140px;
                height: 115px;
            }

            .jg-footer-motif-left-bottom,
            .jg-footer-motif-right-bottom {
                width: 145px;
                height: 80px;
                bottom: 45px;
            }
        }
    </style>
</head>

<body class="relative z-20">
    {{-- Header hanya tampil di Home --}}
    @if (request()->is('/'))
        <x-header :header="$header ?? null" :settings="$settings ?? null" />
    @endif

    {{-- =========================================================
         ORDER NOW
         Data diambil dari database order_buttons
         ========================================================= --}}

    @php
        $orderButtons = \App\Models\OrderButton::orderBy('id')->get();
    @endphp

    <div class="fixed top-1/2 right-0 -translate-y-1/2 z-50">
        {{-- PANEL ORDER NOW --}}
        <div id="orderPanel"
            class="absolute right-0 top-1/2 -translate-y-1/2 w-36 bg-white/85 backdrop-blur-xl rounded-l-2xl shadow-2xl p-4 transition-all duration-500 ease-in-out translate-x-full">
            <p class="text-center text-red-600 font-bold text-sm mb-3">ORDER NOW</p>

            <div class="space-y-3">
                @foreach ($orderButtons as $orderButton)
                    @php
                        $icon = trim($orderButton->icon ?? '');

                        if (filter_var($icon, FILTER_VALIDATE_URL)) {
                            // URL gambar dari internet
                            $iconUrl = $icon;
                        } elseif (str_starts_with($icon, 'img/')) {
                            // Gambar dari public/img
                            $iconUrl = asset($icon);
                        } elseif (str_starts_with($icon, 'public/')) {
                            // Contoh: public/img/gofood.jpg
                            $iconUrl = asset(substr($icon, 7));
                        } elseif (str_starts_with($icon, '/storage/')) {
                            // Contoh: /storage/order-buttons/gofood.jpg
                            $iconUrl = asset(ltrim($icon, '/'));
                        } elseif (str_starts_with($icon, 'storage/')) {
                            // Contoh: storage/order-buttons/gofood.jpg
                            $iconUrl = asset($icon);
                        } else {
                            // File upload di storage/app/public
                            $iconUrl = asset('storage/' . ltrim($icon, '/'));
                        }
                    @endphp

                    <a href="{{ $orderButton->link }}" target="_blank" rel="noopener noreferrer"
                        class="block bg-white rounded-xl p-2 hover:scale-105 transition">
                        <img src="{{ $iconUrl }}" class="w-14 h-14 mx-auto object-contain"
                            alt="{{ $orderButton->title }}" loading="lazy" />
                    </a>
                @endforeach
            </div>
        </div>

        {{-- TOGGLE ORDER NOW --}}
        <button id="toggleOrder" type="button"
            class="fixed right-0 top-1/2 -translate-y-1/2 w-8 h-16 rounded-l-xl bg-white/5 backdrop-blur-x0.5 shadow-xl border border-white/60 flex items-center justify-center transition-all duration-300 hover:bg-white hover:shadow-2xl">
            <svg id="toggleIcon" xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 text-gray-700 transition-transform duration-300" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
    </div>

    {{-- =========================================================
         SCRIPT ORDER NOW
         ========================================================= --}}

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const panel = document.getElementById("orderPanel");
            const toggle = document.getElementById("toggleOrder");
            const icon = document.getElementById("toggleIcon");

            if (!panel || !toggle || !icon) {
                return;
            }

            toggle.addEventListener("click", function() {
                panel.classList.toggle("translate-x-full");

                if (panel.classList.contains("translate-x-full")) {
                    icon.style.transform = "rotate(0deg)";
                } else {
                    icon.style.transform = "rotate(180deg)";
                }
            });
        });
    </script>

    {{-- =========================================================
         MAIN CONTENT
         ========================================================= --}}

    <div class="min-h-full">
        {{-- Navbar tidak tampil di halaman service package --}}
        @if (!request()->routeIs('service-packages.front'))
            <x-navbar></x-navbar>
        @endif

        <main class="fade-in">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
    </div>

    {{-- =========================================================
         FADE IN
         ========================================================= --}}

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const elements = document.querySelectorAll(".fade-in");

            const observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add("show");
                        }
                    });
                }, {
                    threshold: 0.1,
                },
            );

            elements.forEach((el) => observer.observe(el));
        });
    </script>

    {{-- =========================================================
         FOOTER
         ========================================================= --}}

    <footer class="jg-footer relative overflow-hidden">
        {{-- MOTIF DEKORASI --}}
        <div class="jg-footer-motif jg-footer-motif-left-top" aria-hidden="true">
            <svg viewBox="0 0 220 180" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M-12 80C18 42 51 34 83 49C111 63 128 54 148 30" stroke="#c98932" stroke-opacity=".18"
                    stroke-width="2" />
                <path d="M-8 111C24 76 56 68 88 81C115 92 143 84 172 56" stroke="#9d1c1c" stroke-opacity=".10"
                    stroke-width="2" />
                <path d="M36 14C53 36 54 55 47 76C31 67 23 49 24 31C25 23 29 17 36 14Z" fill="#c98932"
                    fill-opacity=".08" />
                <path d="M75 18C93 38 94 59 87 80C72 70 64 52 65 35C66 27 69 22 75 18Z" fill="#9d1c1c"
                    fill-opacity=".06" />
                <circle cx="20" cy="20" r="4" fill="#c98932" fill-opacity=".2" />
                <circle cx="34" cy="32" r="3" fill="#9d1c1c" fill-opacity=".12" />
            </svg>
        </div>

        <div class="jg-footer-motif jg-footer-motif-right-top" aria-hidden="true">
            <svg viewBox="0 0 220 180" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M232 73C201 39 166 32 135 48C108 62 92 53 71 31" stroke="#c98932" stroke-opacity=".18"
                    stroke-width="2" />
                <path d="M228 111C197 77 166 67 134 80C108 91 80 83 49 56" stroke="#9d1c1c" stroke-opacity=".10"
                    stroke-width="2" />
                <path d="M184 14C167 36 166 55 173 76C188 67 197 49 196 31C195 23 191 17 184 14Z" fill="#c98932"
                    fill-opacity=".08" />
                <path d="M145 18C127 38 126 59 133 80C148 70 156 52 155 35C154 27 151 22 145 18Z" fill="#9d1c1c"
                    fill-opacity=".06" />
                <circle cx="200" cy="20" r="4" fill="#c98932" fill-opacity=".2" />
                <circle cx="186" cy="32" r="3" fill="#9d1c1c" fill-opacity=".12" />
            </svg>
        </div>

        <div class="jg-footer-motif jg-footer-motif-left-bottom" aria-hidden="true">
            <svg viewBox="0 0 220 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M-16 96C17 59 49 59 76 72C104 85 133 79 163 48" stroke="#c98932" stroke-opacity=".16"
                    stroke-width="2" />
                <path d="M12 116C46 88 75 87 102 98C124 107 147 102 173 81" stroke="#9d1c1c" stroke-opacity=".09"
                    stroke-width="2" />
                <path d="M45 77C61 92 64 105 60 120C46 113 38 100 39 88C40 83 42 79 45 77Z" fill="#c98932"
                    fill-opacity=".08" />
            </svg>
        </div>

        <div class="jg-footer-motif jg-footer-motif-right-bottom" aria-hidden="true">
            <svg viewBox="0 0 220 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M236 96C203 59 171 59 144 72C116 85 87 79 57 48" stroke="#c98932" stroke-opacity=".16"
                    stroke-width="2" />
                <path d="M208 116C174 88 145 87 118 98C96 107 73 102 47 81" stroke="#9d1c1c" stroke-opacity=".09"
                    stroke-width="2" />
                <path d="M175 77C159 92 156 105 160 120C174 113 182 100 181 88C180 83 178 79 175 77Z" fill="#c98932"
                    fill-opacity=".08" />
            </svg>
        </div>

        <div class="jg-footer-main">
            <div class="jg-footer-grid">
                {{-- BRAND --}}
                <div class="jg-footer-brand jg-footer-column">
                    <div class="jg-footer-brand-head">
                        <img src="{{ asset('img/logojossgandos.png') }}" alt="Resto Joss Gandos"
                            class="jg-footer-logo" />

                        <div>
                            <h3 class="jg-footer-brand-name">JOSS GANDOS</h3>
                            <p class="jg-footer-brand-subtitle">RESTORAN INDONESIA</p>
                            <p class="jg-footer-brand-location">JEMURSARI</p>
                        </div>
                    </div>

                    <p class="jg-footer-description">
                        Menyajikan hidangan bercita rasa khas Indonesia yang lezat dan berkualitas untuk menemani setiap
                        momen, karena apapun acaranya, Joss Gandos tempatnya.
                    </p>

                    <div class="jg-footer-socials">
                        <a href="https://www.instagram.com/restojossgandos/" target="_blank"
                            rel="noopener noreferrer" aria-label="Instagram" class="jg-footer-social">
                            <i class="uil uil-instagram"></i>
                        </a>

                        <a href="https://www.facebook.com/RestoJossGandos" target="_blank" rel="noopener noreferrer"
                            aria-label="Facebook" class="jg-footer-social">
                            <i class="uil uil-facebook-f"></i>
                        </a>

                        <a href="https://www.tiktok.com/@restojossgandos" target="_blank" rel="noopener noreferrer"
                            aria-label="TikTok" class="jg-footer-social">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="20"
                                height="20" fill="currentColor">
                                <path
                                    d="M448 209.9a210.1 210.1 0 0 1-122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3v89.9a74.6 74.6 0 1 0 52.2 71.2V0h88a121.2 121.2 0 0 0 1.9 22.2h0A122.2 122.2 0 0 0 381 102.4a121.4 121.4 0 0 0 67 20.1z" />
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- MENU CEPAT --}}
                <div class="jg-footer-column jg-footer-link-column">
                    <h4 class="jg-footer-heading">
                        Menu Cepat
                    </h4>

                    <div class="jg-footer-heading-line"></div>

                    <ul class="jg-footer-links">
                        <li>
                            <a href="/">
                                <i class="uil uil-angle-right"></i>
                                <span>Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="/about">
                                <i class="uil uil-angle-right"></i>
                                <span>About</span>
                            </a>
                        </li>
                        <li>
                            <a href="/menu">
                                <i class="uil uil-angle-right"></i>
                                <span>Menu</span>
                            </a>
                        </li>
                        <li>
                            <a href="/gallery">
                                <i class="uil uil-angle-right"></i>
                                <span>Gallery</span>
                            </a>
                        </li>
                        <li>
                            <a href="/reservation">
                                <i class="uil uil-angle-right"></i>
                                <span>Reservation</span>
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- HUBUNGI KAMI --}}
                <div class="jg-footer-column jg-footer-contact-column">
                    <h4 class="jg-footer-heading">
                        Hubungi Kami
                    </h4>

                    <div class="jg-footer-heading-line"></div>

                    <ul class="jg-footer-contact-list">
                        <li>
                            <span class="jg-footer-contact-icon">
                                <i class="uil uil-location-point"></i>
                            </span>

                            <a href="https://www.google.com/maps/search/?api=1&query=Resto+Joss+Gandos+Jemursari"
                                target="_blank" rel="noopener noreferrer"
                                class="jg-footer-contact-text no-underline hover:text-red-700 transition-colors">
                                Jl. Raya Jemursari No.15,<br>
                                Surabaya, Jawa Timur 60237
                            </a>
                        </li>

                        <li>
                            <span class="jg-footer-contact-icon">
                                <i class="uil uil-phone"></i>
                            </span>

                            <a href="https://wa.me/6289699071599" target="_blank" rel="noopener noreferrer"
                                class="jg-footer-contact-text no-underline hover:text-red-700 transition-colors">
                                +62 896-9907-1599
                            </a>
                        </li>

                        <li>
                            <span class="jg-footer-contact-icon">
                                <i class="uil uil-envelope"></i>
                            </span>

                            <a href="mailto:bebekjossgandossby@gmail.com"
                                class="jg-footer-contact-text jg-footer-email no-underline hover:text-red-700 transition-colors">
                                bebekjossgandossby@gmail.com
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- JAM BUKA --}}
                <div class="jg-footer-column jg-footer-hours-column">
                    <div class="jg-footer-hours-card">
                        <h4 class="jg-footer-hours-title">
                            Jam Buka Outlet
                        </h4>

                        <div class="jg-footer-heading-line"></div>

                        <div class="jg-footer-hours-main">
                            <span class="jg-footer-clock-icon">
                                <i class="uil uil-clock"></i>
                            </span>

                            <div>
                                <p class="jg-footer-hours-day">Senin - Minggu</p>
                                <p class="jg-footer-hours-time">10.00 - 22.00</p>
                            </div>
                        </div>

                        <div class="jg-footer-hours-divider"></div>

                        <div class="jg-footer-close-order">
                            <i class="uil uil-info-circle"></i>
                            <span>Close Order: 21.15</span>
                        </div>

                        {{-- STATUS OUTLET --}}
                        <div id="storeStatus" class="jg-footer-status">
                            <span id="statusDot" class="jg-footer-status-dot">
                                <span class="jg-footer-status-ping"></span>
                                <span class="jg-footer-status-inner"></span>
                            </span>

                            <span id="statusText">Checking...</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- COPYRIGHT --}}
            <div class="jg-footer-bottom">
                <p>
                    &copy; 2026 Resto Joss Gandos Jemursari. Hak Cipta Dilindungi.
                </p>
            </div>
        </div>
    </footer>

    {{-- =========================================================
         STATUS OUTLET
         ========================================================= --}}

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const statusBox = document.getElementById("storeStatus");
            const statusText = document.getElementById("statusText");
            const statusDot = document.getElementById("statusDot");

            if (!statusBox || !statusText || !statusDot) {
                return;
            }

            const dotInner = statusDot.querySelector("span:last-child");

            const dotPing = statusDot.querySelector("span:first-child");

            function updateStatus() {
                // Zona waktu Indonesia Barat
                const now = new Date(
                    new Date().toLocaleString("en-US", {
                        timeZone: "Asia/Jakarta",
                    }),
                );

                const hours = now.getHours();

                // Jam buka 10.00 - 22.00
                const isOpen = hours >= 10 && hours < 22;

                if (isOpen) {
                    statusBox.className =
                        "mt-2 flex items-center gap-2 text-xs font-bold px-3 py-1.5 rounded-full w-fit bg-green-100 text-green-700 border border-green-200";

                    statusText.innerText = "Sedang Buka";

                    dotInner.className =
                        "relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500";

                    dotPing.className =
                        "animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75";
                } else {
                    statusBox.className =
                        "mt-2 flex items-center gap-2 text-xs font-bold px-3 py-1.5 rounded-full w-fit bg-red-50 text-red-600 border border-red-100";

                    statusText.innerText = "Sedang Tutup";

                    dotInner.className =
                        "relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500";

                    dotPing.className = "hidden";
                }
            }

            updateStatus();

            // Perbarui setiap 1 menit
            setInterval(updateStatus, 60000);
        });
    </script>
</body>

</html>
