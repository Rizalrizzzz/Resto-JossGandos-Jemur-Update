<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Statistik - Resto Joss Gandos</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logojossgandos.png') }}" />

    @vite (['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css" />

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: "Inter", sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        .dashboard-title {
            font-family: "Playfair Display", Georgia, serif;
        }

        .stat-card {
            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease,
                border-color 0.25s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 35px rgba(15, 23, 42, 0.08);
        }

        .mini-line {
            width: 82px;
            height: 36px;
        }

        .glass-icon {
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 0.7),
                0 8px 18px rgba(15, 23, 42, 0.05);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f8fafc;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 999px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .fade-enter {
            opacity: 0;
            transform: translateY(10px);
        }

        .fade-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition:
                opacity 0.45s ease,
                transform 0.45s ease;
        }
    </style>
</head>

<body class="bg-[#f5f7fb] text-slate-800 antialiased overflow-hidden">
    <div class="flex h-screen overflow-hidden">
        @include ('layouts.sidebar')

        {{-- OVERLAY MOBILE --}}
        <div id="overlay" class="fixed inset-0 bg-slate-900/50 z-30 hidden md:hidden backdrop-blur-sm"
            onclick="toggleSidebar()"></div>

        <main class="flex-1 flex flex-col h-screen overflow-hidden bg-[#f5f7fb] relative">
            {{-- =========================================================
                HEADER
            ========================================================== --}}
            <header class="flex-shrink-0 px-6 sm:px-7 lg:px-8 pt-6 pb-3">
                <div class="flex items-start justify-between gap-5">

                    {{-- KIRI --}}
                    <div class="flex items-start gap-3 min-w-0">
                        {{-- TOMBOL MENU MOBILE --}}
                        <button type="button" onclick="toggleSidebar()" aria-label="Buka menu"
                            class="md:hidden mt-1 p-2 text-slate-500 hover:bg-white rounded-lg shrink-0">
                            <i class="uil uil-bars text-2xl"></i>
                        </button>

                        {{-- JUDUL DAN DESKRIPSI --}}
                        <div class="min-w-0">
                            <h1
                                class="dashboard-title text-[28px] sm:text-[32px] lg:text-[34px] font-bold leading-tight text-[#14284d]">
                                Analisa & Statistik
                            </h1>

                        </div>
                    </div>


                    {{-- KANAN : HANYA TANGGAL --}}
                    <div
                        class="flex-shrink-0 flex items-center gap-2.5 px-4 py-2.5 rounded-xl bg-white border border-[#e4eaf3] shadow-sm">
                        <i class="uil uil-calendar-alt text-[#6078a7] text-[16px]"></i>

                        <span class="text-xs sm:text-sm font-semibold text-[#60708f] whitespace-nowrap">
                            {{ date('d M Y') }}
                        </span>
                    </div>
                </div>
            </header>

            {{-- =========================================================
                CONTENT
            ========================================================== --}}
            <div id="mainScrollContent" class="flex-1 overflow-y-auto custom-scrollbar px-6 sm:px-7 lg:px-8 pb-8">
                <div class="fade-section">
                    {{-- =====================================================
                        4 STATISTIK UTAMA
                    ====================================================== --}}
                    <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 lg:gap-5 mt-5">
                        {{-- =================================================
                            TOTAL PENGUNJUNG
                        ================================================== --}}
                        <div
                            class="stat-card bg-white rounded-2xl border border-[#e9edf5] p-5 shadow-[0_5px_20px_rgba(15,23,42,0.04)]">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-[12px] font-bold uppercase tracking-wide text-[#8494b5]">Total
                                        Pengunjung</p>

                                    <h2
                                        class="mt-2 text-[30px] sm:text-[32px] font-extrabold tracking-tight text-[#15294e]">
                                        {{ $totalVisitors ?? '0' }}
                                    </h2>

                                    <div class="mt-2 flex items-center gap-1.5 text-xs font-semibold text-[#27ad6c]">
                                        <i class="uil uil-arrow-growth text-sm"></i>

                                        <span> Data Realtime </span>
                                    </div>
                                </div>

                                <div
                                    class="glass-icon w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-[#edf4ff] text-[#155eef] flex items-center justify-center flex-shrink-0">
                                    <i class="uil uil-users-alt text-[23px]"></i>
                                </div>
                            </div>

                            <div class="mt-4 flex items-end justify-between gap-3">
                                <div class="flex items-center gap-1.5 text-[11px] text-[#8a9ab7]">
                                    <i class="uil uil-info-circle"></i>

                                    <span> Data pengunjung website </span>
                                </div>

                                {{-- SVG dekorasi --}}
                                <svg class="mini-line" viewBox="0 0 82 36" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 31C10 29 13 22 22 25C31 28 34 13 43 17C53 21 55 7 64 11C72 15 75 4 81 1"
                                        stroke="#63d5a1" stroke-width="2.5" stroke-linecap="round" />
                                </svg>
                            </div>
                        </div>

                        {{-- =================================================
                            PENGUNJUNG HARI INI
                        ================================================== --}}
                        <div
                            class="stat-card bg-white rounded-2xl border border-[#e9edf5] p-5 shadow-[0_5px_20px_rgba(15,23,42,0.04)]">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-[12px] font-bold uppercase tracking-wide text-[#8494b5]">Pengunjung
                                        Hari Ini</p>

                                    <h2
                                        class="mt-2 text-[30px] sm:text-[32px] font-extrabold tracking-tight text-[#15294e]">
                                        {{ $todayVisitors ?? '0' }}
                                    </h2>

                                    <div class="mt-2 flex items-center gap-1.5 text-xs font-semibold text-[#27ad6c]">
                                        <i class="uil uil-arrow-growth text-sm"></i>

                                        <span> Hari ini </span>
                                    </div>
                                </div>

                                <div
                                    class="glass-icon w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-[#f4eafe] text-[#7b32e2] flex items-center justify-center flex-shrink-0">
                                    <i class="uil uil-calendar-alt text-[23px]"></i>
                                </div>
                            </div>

                            <div class="mt-4 flex items-end justify-between gap-3">
                                <div class="flex items-center gap-1.5 text-[11px] text-[#8a9ab7]">
                                    <i class="uil uil-info-circle"></i>

                                    <span> Kunjungan hari ini </span>
                                </div>

                                <svg class="mini-line" viewBox="0 0 82 36" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 29C10 29 13 20 21 23C29 26 34 16 41 21C49 26 52 8 60 14C67 18 73 8 81 2"
                                        stroke="#c080ff" stroke-width="2.5" stroke-linecap="round" />
                                </svg>
                            </div>
                        </div>

                        {{-- =================================================
                            KLIK WHATSAPP
                        ================================================== --}}
                        <div
                            class="stat-card bg-white rounded-2xl border border-[#e9edf5] p-5 shadow-[0_5px_20px_rgba(15,23,42,0.04)]">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-[12px] font-bold uppercase tracking-wide text-[#8494b5]">Klik
                                        WhatsApp</p>

                                    <h2
                                        class="mt-2 text-[30px] sm:text-[32px] font-extrabold tracking-tight text-[#15294e]">
                                        {{ $whatsappClicks ?? '0' }}
                                    </h2>

                                    <div class="mt-2 flex items-center gap-1.5 text-xs font-semibold text-[#27ad6c]">
                                        <i class="uil uil-arrow-growth text-sm"></i>

                                        <span> Minat Reservasi </span>
                                    </div>
                                </div>

                                <div
                                    class="glass-icon w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-[#e9faef] text-[#18a957] flex items-center justify-center flex-shrink-0">
                                    <i class="uil uil-whatsapp text-[25px]"></i>
                                </div>
                            </div>

                            <div class="mt-4 flex items-end justify-between gap-3">
                                <div class="flex items-center gap-1.5 text-[11px] text-[#8a9ab7]">
                                    <i class="uil uil-info-circle"></i>

                                    <span> Total klik WhatsApp </span>
                                </div>

                                <svg class="mini-line" viewBox="0 0 82 36" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 31C9 28 15 25 22 27C29 29 35 12 43 17C51 22 55 8 63 14C71 20 75 10 81 3"
                                        stroke="#64d3a2" stroke-width="2.5" stroke-linecap="round" />
                                </svg>
                            </div>
                        </div>

                        {{-- =================================================
                            KUNJUNGAN ULANG
                        ================================================== --}}
                        <div
                            class="stat-card bg-white rounded-2xl border border-[#e9edf5] p-5 shadow-[0_5px_20px_rgba(15,23,42,0.04)]">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-[12px] font-bold uppercase tracking-wide text-[#8494b5]">Kunjungan
                                        Ulang</p>

                                    <h2
                                        class="mt-2 text-[30px] sm:text-[32px] font-extrabold tracking-tight text-[#15294e]">
                                        {{ $repeatRate ?? 0 }}%
                                    </h2>

                                    <div class="mt-2 flex items-center gap-1.5 text-xs font-semibold text-[#27ad6c]">
                                        <i class="uil uil-arrow-growth text-sm"></i>

                                        <span> Retensi User </span>
                                    </div>
                                </div>

                                <div
                                    class="glass-icon w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-[#f2eaff] text-[#8139e7] flex items-center justify-center flex-shrink-0">
                                    <i class="uil uil-sync text-[25px]"></i>
                                </div>
                            </div>

                            <div class="mt-4 flex items-end justify-between gap-3">
                                <div class="flex items-center gap-1.5 text-[11px] text-[#8a9ab7]">
                                    <i class="uil uil-info-circle"></i>

                                    <span> Retensi pengunjung </span>
                                </div>

                                <svg class="mini-line" viewBox="0 0 82 36" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 30C9 29 14 20 21 23C29 27 36 15 43 18C51 22 55 9 63 13C70 17 76 8 81 2"
                                        stroke="#bb7cff" stroke-width="2.5" stroke-linecap="round" />
                                </svg>
                            </div>
                        </div>
                    </section>

                    {{-- =====================================================
                        GRAFIK + HALAMAN PALING BANYAK DILIHAT
                    ====================================================== --}}
                    <section class="grid grid-cols-1 xl:grid-cols-[minmax(0,1.65fr)_minmax(330px,1fr)] gap-5 mt-5">
                        {{-- =================================================
                            GRAFIK PENGUNJUNG
                        ================================================== --}}
                        <div
                            class="bg-white rounded-2xl border border-[#e9edf5] shadow-[0_5px_20px_rgba(15,23,42,0.04)] p-5 sm:p-6">
                            <div class="flex items-start justify-between gap-4 mb-5">
                                <div class="min-w-0">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-[#edf4ff] text-[#155eef] flex items-center justify-center flex-shrink-0">
                                            <i class="uil uil-chart-growth text-xl"></i>
                                        </div>

                                        <div>
                                            <h2 class="text-lg sm:text-xl font-extrabold text-[#15294e]">
                                                Grafik Pengunjung Bulanan
                                            </h2>

                                            <p class="mt-0.5 text-xs sm:text-sm text-[#7c8dab]">Tren kunjungan website
                                                dalam tahun ini</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Tahun --}}
                                <div
                                    class="hidden sm:flex items-center px-3 py-2 rounded-xl border border-[#e3e9f2] bg-white text-xs font-semibold text-[#536585]">
                                    <span> Tahun {{ $currentYear }} </span>
                                </div>
                            </div>

                            <div class="relative h-[320px] sm:h-[360px] lg:h-[390px]">
                                <canvas id="visitorsChart"></canvas>
                            </div>

                            <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                                <div class="flex items-center gap-2 text-xs text-[#7384a4]">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#3958f4]">
                                    </span>

                                    <span> Jumlah Pengunjung </span>
                                </div>

                                <div class="flex items-center gap-2 text-xs font-semibold text-[#43896a]">
                                    <span class="flex items-center justify-center w-6 h-6 rounded-lg bg-[#ebfaf2]">
                                        <i class="uil uil-arrow-up-right text-sm"></i>
                                    </span>

                                    <span> Data aktual dari website </span>
                                </div>
                            </div>
                        </div>

                        {{-- =================================================
                            HALAMAN PALING BANYAK DILIHAT
                        ================================================== --}}
                        <div
                            class="bg-white rounded-2xl border border-[#e9edf5] shadow-[0_5px_20px_rgba(15,23,42,0.04)] p-5 sm:p-6">
                            <div class="flex items-center gap-3 mb-5">
                                <div
                                    class="w-10 h-10 rounded-xl bg-[#f3eaff] text-[#7a35dc] flex items-center justify-center flex-shrink-0">
                                    <i class="uil uil-trophy text-xl"></i>
                                </div>

                                <div>
                                    <h2 class="text-lg sm:text-xl font-extrabold text-[#15294e]">
                                        Halaman Paling Banyak Dilihat
                                    </h2>

                                    <p class="mt-0.5 text-xs sm:text-sm text-[#7c8dab]">Daftar halaman yang paling
                                        sering dikunjungi</p>
                                </div>
                            </div>

                            @php

                                $pageRows = collect($popularPages ?? [])
                                    ->take(5)
                                    ->values();

                                $maxPageCount = $pageRows->max('total') ?: 1;

                            @endphp

                            <div class="space-y-5">
                                @forelse ($pageRows as $index => $page)
                                    @php

                                        $pageName = $page['name'] ?? 'Halaman';

                                        $pageCount = (int) ($page['total'] ?? 0);

                                        $barWidth = max(8, ($pageCount / $maxPageCount) * 100);
                                    @endphp

                                    <div>
                                        <div class="flex items-center gap-3">
                                            {{-- NOMOR --}}
                                            <div
                                                class="w-9 h-9 rounded-xl bg-[#edf3ff] text-[#365fe8] font-extrabold text-sm flex items-center justify-center flex-shrink-0">
                                                {{ $index + 1 }}
                                            </div>

                                            {{-- DETAIL --}}
                                            <div class="min-w-0 flex-1">
                                                <div class="flex items-center justify-between gap-3">
                                                    <span class="text-sm font-bold text-[#243456] truncate">
                                                        {{ $pageName }}
                                                    </span>

                                                    <span
                                                        class="text-xs sm:text-sm font-semibold text-[#536585] whitespace-nowrap">
                                                        {{ number_format($pageCount, 0, ',', '.') }}
                                                    </span>
                                                </div>

                                                {{-- BAR --}}
                                                <div class="mt-2 h-2.5 bg-[#e9eef5] rounded-full overflow-hidden">
                                                    <div class="h-full rounded-full bg-gradient-to-r from-[#3157f5] to-[#8d43ed]"
                                                        style="width: {{ $barWidth }}%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @empty
                                    <div class="py-10 text-center text-sm text-[#95a2b8]">
                                        Belum ada data halaman yang dikunjungi.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </section>

                    <div class="h-6"></div>
                </div>
            </div>
        </main>
    </div>

    {{-- =========================================================
        ANIMATION
    ========================================================== --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const section = document.querySelector(".fade-section");

            if (section) {
                section.classList.add("fade-enter");

                requestAnimationFrame(() => {
                    section.classList.add("fade-enter-active");

                    section.classList.remove("fade-enter");
                });
            }
        });
    </script>

    {{-- =========================================================
        CHART
    ========================================================== --}}
    @if (isset($monthlyLabels) && isset($monthlyData))
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const monthlyLabels = @json ($monthlyLabels);

                const monthlyData = @json ($monthlyData);

                const canvasElement = document.getElementById("visitorsChart");

                if (!canvasElement) {
                    return;
                }

                const ctx = canvasElement.getContext("2d");

                const gradient = ctx.createLinearGradient(0, 0, 0, 390);

                gradient.addColorStop(0, "rgba(61, 91, 245, 0.25)");

                gradient.addColorStop(0.65, "rgba(124, 63, 236, 0.10)");

                gradient.addColorStop(1, "rgba(124, 63, 236, 0.00)");

                new Chart(ctx, {
                    type: "line",

                    data: {
                        labels: monthlyLabels,

                        datasets: [{
                            label: "Jumlah Pengunjung",

                            data: monthlyData,

                            borderColor: "#425AF4",

                            backgroundColor: gradient,

                            borderWidth: 3,

                            tension: 0.42,

                            fill: true,

                            pointRadius: 4,

                            pointHoverRadius: 6,

                            pointBackgroundColor: "#ffffff",

                            pointBorderColor: "#425AF4",

                            pointBorderWidth: 2,
                        }, ],
                    },

                    options: {
                        responsive: true,

                        maintainAspectRatio: false,

                        interaction: {
                            intersect: false,

                            mode: "index",
                        },

                        plugins: {
                            legend: {
                                display: false,
                            },

                            tooltip: {
                                backgroundColor: "#15294e",

                                titleColor: "#ffffff",

                                bodyColor: "#ffffff",

                                padding: 12,

                                displayColors: false,

                                cornerRadius: 10,
                            },
                        },

                        scales: {
                            x: {
                                grid: {
                                    display: false,
                                },

                                border: {
                                    display: false,
                                },

                                ticks: {
                                    color: "#7182a4",

                                    font: {
                                        size: 11,
                                    },
                                },
                            },

                            y: {
                                beginAtZero: true,

                                border: {
                                    display: false,
                                },

                                grid: {
                                    color: "#edf1f7",
                                },

                                ticks: {
                                    color: "#7182a4",

                                    font: {
                                        size: 11,
                                    },

                                    precision: 0,
                                },
                            },
                        },
                    },
                });
            });
        </script>
    @endif
</body>

</html>
