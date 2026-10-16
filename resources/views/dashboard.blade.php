<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Resto Joss Gandos</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logojossgandos.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css" />

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: "Inter", sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        .custom-scrollbar::-webkit-scrollbar {
            height: 8px;
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
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
                opacity 0.4s ease-out,
                transform 0.4s ease-out;
        }

        .highlighted-row {
            background-color: #fef9c3 !important;
            transition: background 0.3s ease;
        }

        .active-highlight {
            background-color: #fde047 !important;
            transform: scale-[1.01];
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 10;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased overflow-x-hidden">
    <div class="flex h-screen overflow-hidden">
        @include ('layouts.sidebar')

        <div id="overlay"
            class="fixed inset-0 bg-slate-900/50 z-30 hidden md:hidden backdrop-blur-sm transition-opacity"
            onclick="toggleSidebar()"></div>

        <main class="flex-1 flex flex-col h-screen overflow-hidden bg-slate-50 relative">
            <header
                class="flex-shrink-0 bg-white border-b border-slate-200 shadow-sm z-20 px-6 py-4 flex items-center justify-between gap-4">
                <div class="flex items-center gap-4 flex-1">
                    <button onclick="toggleSidebar()"
                        class="md:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-lg">
                        <i class="uil uil-bars text-2xl"></i>
                    </button>

                    <div class="relative w-full max-w-lg hidden sm:block">
                        <i class="uil uil-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                        <input type="text" id="searchInput" placeholder="Cari menu, kategori, atau galeri..."
                            class="w-full pl-11 pr-4 py-2.5 bg-slate-100 border-none rounded-xl text-sm font-medium text-slate-700 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all placeholder:text-slate-400" />
                    </div>
                </div>

                <button onclick="openChooseModal()"
                    class="flex items-center gap-2 bg-green-700 hover:bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                    <i class="uil uil-plus-circle text-lg"></i>
                    <span>Tambah Data</span>
                </button>
            </header>

            <div class="flex-1 overflow-y-auto p-6 scroll-smooth" id="mainScrollContent">
                @if (session('success'))
                    <div id="success-alert"
                        class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3 shadow-sm fade-enter-active">
                        <i class="uil uil-check-circle text-xl"></i>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm">
                        <ul class="list-disc list-inside text-sm font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8 fade-section">
                    {{-- GALERI --}}
                    <div
                        class="bg-white p-5 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-slate-100 flex items-center gap-4 hover:border-indigo-100 transition-colors">
                        <div
                            class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                            <i class="uil uil-image"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Galeri</p>
                            <h3 class="text-2xl font-bold text-slate-800">
                                {{ $galleryCount }}
                            </h3>
                        </div>
                    </div>

                    {{-- MENU --}}
                    <div
                        class="bg-white p-5 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-slate-100 flex items-center gap-4 hover:border-indigo-100 transition-colors">
                        <div
                            class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center text-xl">
                            <i class="uil uil-utensils"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Menu</p>
                            <h3 class="text-2xl font-bold text-slate-800">
                                {{ $menuCount }}
                            </h3>
                        </div>
                    </div>

                    {{-- TESTIMONI --}}
                    <div
                        class="bg-white p-5 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-slate-100 flex items-center gap-4 hover:border-indigo-100 transition-colors">
                        <div
                            class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-xl">
                            <i class="uil uil-comments"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Testimoni</p>
                            <h3 class="text-2xl font-bold text-slate-800">
                                {{ $testimonialCount }}
                            </h3>
                        </div>
                    </div>

                    {{-- PROMO / EVENT --}}
                    <div
                        class="bg-white p-5 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-slate-100 flex items-center gap-4 hover:border-indigo-100 transition-colors">
                        <div
                            class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                            <i class="uil uil-megaphone"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Promo/Event</p>
                            <h3 class="text-2xl font-bold text-slate-800">
                                {{ $eventCount }}
                            </h3>
                        </div>
                    </div>

                    {{-- CATERING PACKAGE --}}
                    <div
                        class="bg-white p-5 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-slate-100 flex items-center gap-4 hover:border-indigo-100 transition-colors">
                        <div
                            class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                            <i class="uil uil-restaurant"></i>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                Catering Package
                            </p>

                            <h3 class="text-2xl font-bold text-slate-800">
                                {{ $servicePackages->where('category', 'catering_package')->count() }}
                            </h3>
                        </div>
                    </div>

                    {{-- WEDDING PACKAGE --}}
                    <div
                        class="bg-white p-5 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-slate-100 flex items-center gap-4 hover:border-indigo-100 transition-colors">
                        <div
                            class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl">
                            <i class="uil uil-heart-alt"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Wedding Package</p>
                            <h3 class="text-2xl font-bold text-slate-800">
                                {{ $weddingPackageCount }}
                            </h3>
                        </div>
                    </div>

                    {{-- PACKAGE MENU --}}
                    <div
                        class="bg-white p-5 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-slate-100 flex items-center gap-4 hover:border-indigo-100 transition-colors">
                        <div
                            class="w-12 h-12 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-xl">
                            <i class="uil uil-box"></i>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                Package Menu
                            </p>

                            <h3 class="text-2xl font-bold text-slate-800">
                                {{ $servicePackages->where('category', 'package_menu')->count() }}
                            </h3>
                        </div>
                    </div>
                </section>

                <div
                    class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 mb-6 fade-section">
                    <div class="bg-slate-200/60 p-1.5 rounded-xl inline-flex flex-wrap">
                        <button id="btn-menu"
                            class="px-5 py-2 rounded-lg text-sm font-semibold transition-all duration-300">
                            Daftar Menu
                        </button>
                        <button id="btn-gallery"
                            class="px-5 py-2 rounded-lg text-sm font-semibold text-slate-500 hover:text-slate-700 transition-all duration-300">
                            Galeri Foto
                        </button>
                        <button id="btn-promotions"
                            class="px-5 py-2 rounded-lg text-sm font-semibold text-slate-500 hover:text-slate-700 transition-all duration-300">
                            Promosi
                        </button>
                        <button id="btn-service-packages"
                            class="px-5 py-2 rounded-lg text-sm font-semibold text-slate-500 hover:text-slate-700 transition-all duration-300">
                            Service Package
                        </button>
                    </div>

                    <div id="filter-wrapper" class="flex flex-wrap items-center gap-2">
                        {{-- FILTER MENU --}}
                        <div id="filter-menu" class="flex items-center gap-2">
                            <select id="menuFilterType"
                                class="bg-white border border-slate-200 text-slate-700 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block px-3 py-2 cursor-pointer shadow-sm outline-none transition-all hover:bg-slate-50">
                                <option value="">Semua Tipe</option>
                                <option value="special">Special</option>
                                <option value="carousel">Carousel</option>
                            </select>

                            <select id="menuSortBy"
                                class="bg-white border border-slate-200 text-slate-700 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block px-3 py-2 cursor-pointer shadow-sm outline-none transition-all hover:bg-slate-50">
                                <option value="latest">Terbaru</option>
                                <option value="oldest">Terlama</option>
                            </select>
                        </div>

                        {{-- FILTER GALLERY --}}
                        <div id="filter-gallery" class="hidden items-center gap-2">
                            <select id="galleryFilterCategory"
                                class="bg-white border border-slate-200 text-slate-700 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block px-3 py-2 cursor-pointer shadow-sm outline-none transition-all hover:bg-slate-50">
                                <option value="">Semua Kategori</option>
                                <option value="momen">Momen</option>
                                <option value="facility">Fasilitas</option>
                                <option value="event">Event</option>
                            </select>

                            <select id="gallerySortBy"
                                class="bg-white border border-slate-200 text-slate-700 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block px-3 py-2 cursor-pointer shadow-sm outline-none transition-all hover:bg-slate-50">
                                <option value="latest">Terbaru</option>
                                <option value="oldest">Terlama</option>
                            </select>
                        </div>

                        {{-- FILTER PROMOTION --}}
                        <div id="filter-promotions" class="hidden items-center gap-2">
                            <select id="promotionFilterStatus"
                                class="bg-white border border-slate-200 text-slate-700 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block px-3 py-2 cursor-pointer shadow-sm outline-none transition-all hover:bg-slate-50">
                                <option value="">Semua Status</option>
                                <option value="active">Aktif</option>
                                <option value="inactive">Nonaktif</option>
                            </select>

                            <select id="promotionSortBy"
                                class="bg-white border border-slate-200 text-slate-700 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block px-3 py-2 cursor-pointer shadow-sm outline-none transition-all hover:bg-slate-50">
                                <option value="latest">Terbaru</option>
                                <option value="oldest">Terlama</option>
                            </select>
                        </div>

                        {{-- FILTER SERVICE PACKAGE --}}
                        <div id="filter-service-packages" class="hidden items-center gap-2">
                            <select id="servicePackageFilterCategory"
                                class="bg-white border border-slate-200 text-slate-700 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block px-3 py-2 cursor-pointer shadow-sm outline-none transition-all hover:bg-slate-50">
                                <option value="">Semua Paket</option>
                                <option value="package_menu">
                                    Catering Package
                                </option>
                                <option value="wedding_package">
                                    Wedding Package
                                </option>
                                <option value="box_package">Box Package</option>
                            </select>

                            <select id="servicePackageSortBy"
                                class="bg-white border border-slate-200 text-slate-700 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block px-3 py-2 cursor-pointer shadow-sm outline-none transition-all hover:bg-slate-50">
                                <option value="latest">Terbaru</option>
                                <option value="oldest">Terlama</option>
                            </select>
                        </div>

                        <button id="globalReset"
                            class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 hover:text-indigo-600 shadow-sm transition-all h-[38px]">
                            <i class="uil uil-redo"></i>
                            <span>Reset</span>
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden fade-section">
                    {{-- =======================================================
                         TABEL MENU
                    ======================================================== --}}
                    <div id="dashboard-menu" data-dashboard-table="menu" class="overflow-x-auto custom-scrollbar">
                        <table class="w-full text-sm text-left text-slate-600">
                            <thead
                                class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200 sticky top-0 z-10">
                                <tr>
                                    <th class="px-6 py-4 font-semibold">
                                        Info Menu
                                    </th>
                                    <th class="px-6 py-4 font-semibold">
                                        Deskripsi
                                    </th>
                                    <th class="px-6 py-4 font-semibold text-center">
                                        Tipe
                                    </th>
                                    <th class="px-6 py-4 font-semibold text-center">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @forelse ($menus as $menu)
                                    <tr class="hover:bg-slate-50/80 transition-colors duration-200 group"
                                        data-type="{{ $menu->type }}"
                                        data-created-at="{{ optional($menu->created_at)->timestamp ?? 0 }}">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4">
                                                @php
                                                    $menuImage = trim($menu->image_path ?? '');

                                                    if (filter_var($menuImage, FILTER_VALIDATE_URL)) {
                                                        $menuImageUrl = $menuImage;
                                                    } elseif (str_starts_with($menuImage, 'public/')) {
                                                        $menuImageUrl = asset(substr($menuImage, 7));
                                                    } elseif (str_starts_with($menuImage, 'img/')) {
                                                        $menuImageUrl = asset($menuImage);
                                                    } else {
                                                        $menuImageUrl = \Illuminate\Support\Facades\Storage::url(
                                                            $menuImage,
                                                        );
                                                    }
                                                @endphp

                                                <img src="{{ $menuImageUrl }}"
                                                    class="w-16 h-16 rounded-xl object-cover shadow-sm border border-slate-100"
                                                    alt="{{ $menu->title }}" />

                                                <span class="font-semibold text-slate-800 text-base">
                                                    {{ $menu->title }}
                                                </span>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <p class="text-slate-500 line-clamp-2 max-w-xs">
                                                {{ $menu->description }}
                                            </p>
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border
                                                {{ $menu->type === 'carousel'
                                                    ? 'bg-purple-50 text-purple-700 border-purple-200'
                                                    : 'bg-orange-50 text-orange-700 border-orange-200' }}">
                                                {{ ucfirst($menu->type) }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('menu.index') }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition">
                                                Kelola
                                                <i class="uil uil-arrow-right"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 text-center text-slate-400">
                                            Belum ada menu.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- =======================================================
                         TABEL GALERI
                    ======================================================== --}}
                    <div id="dashboard-gallery" data-dashboard-table="gallery"
                        class="overflow-x-auto custom-scrollbar hidden">
                        <table class="w-full text-sm text-left text-slate-600">
                            <thead
                                class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200 sticky top-0 z-10">
                                <tr>
                                    <th class="px-6 py-4 font-semibold">
                                        Foto & Judul
                                    </th>
                                    <th class="px-6 py-4 font-semibold text-center">
                                        Kategori
                                    </th>
                                    <th class="px-6 py-4 font-semibold text-center">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @forelse ($photos as $photo)
                                    @php
                                        $galleryCategoryLabel = match ($photo->category) {
                                            'momen' => 'Momen',
                                            'facility' => 'Fasilitas',
                                            'event' => 'Event',
                                            default => ucfirst((string) $photo->category),
                                        };
                                    @endphp

                                    <tr class="hover:bg-slate-50/80 transition-colors duration-200 group"
                                        data-category="{{ $photo->category }}"
                                        data-created-at="{{ optional($photo->created_at)->timestamp ?? 0 }}">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="w-20 h-14 rounded-lg overflow-hidden border border-slate-200 shadow-sm relative group-img">
                                                    @php
                                                        $photoImage = trim($photo->image_path ?? '');

                                                        if (filter_var($photoImage, FILTER_VALIDATE_URL)) {
                                                            $photoImageUrl = $photoImage;
                                                        } elseif (str_starts_with($photoImage, 'public/')) {
                                                            $photoImageUrl = asset(substr($photoImage, 7));
                                                        } elseif (str_starts_with($photoImage, 'img/')) {
                                                            $photoImageUrl = asset($photoImage);
                                                        } else {
                                                            $photoImageUrl = \Illuminate\Support\Facades\Storage::url(
                                                                $photoImage,
                                                            );
                                                        }
                                                    @endphp

                                                    <img src="{{ $photoImageUrl }}"
                                                        class="w-full h-full object-cover"
                                                        alt="{{ $photo->title }}" />
                                                </div>

                                                <span class="font-medium text-slate-700">
                                                    {{ $photo->title }}
                                                </span>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border
                                                {{ $photo->category === 'momen'
                                                    ? 'bg-amber-50 text-amber-700 border-amber-200'
                                                    : ($photo->category === 'facility'
                                                        ? 'bg-blue-50 text-blue-700 border-blue-200'
                                                        : 'bg-green-50 text-green-700 border-green-200') }}">
                                                {{ $galleryCategoryLabel }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('gallery.index') }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition">
                                                Kelola
                                                <i class="uil uil-arrow-right"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-10 text-center text-slate-400">
                                            Belum ada galeri.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- =======================================================
                         TABEL PROMOSI
                    ======================================================== --}}
                    <div id="dashboard-promotions" data-dashboard-table="promotions"
                        class="overflow-x-auto custom-scrollbar hidden">
                        <table class="w-full text-sm text-left text-slate-600">
                            <thead
                                class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200 sticky top-0 z-10">
                                <tr>
                                    <th class="px-6 py-4 font-semibold">
                                        Promosi
                                    </th>
                                    <th class="px-6 py-4 font-semibold text-center">
                                        Status
                                    </th>
                                    <th class="px-6 py-4 font-semibold text-center">
                                        Urutan
                                    </th>
                                    <th class="px-6 py-4 font-semibold text-center">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @forelse ($promotions as $promotion)
                                    <tr class="hover:bg-slate-50/80 transition-colors duration-200 group"
                                        data-status="{{ $promotion->is_active ? 'active' : 'inactive' }}"
                                        data-created-at="{{ optional($promotion->created_at)->timestamp ?? 0 }}">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="w-24 h-14 rounded-lg overflow-hidden border border-slate-200 shadow-sm">
                                                    @php
                                                        $promotionImage = trim($promotion->image_path ?? '');

                                                        if (filter_var($promotionImage, FILTER_VALIDATE_URL)) {
                                                            $promotionImageUrl = $promotionImage;
                                                        } else {
                                                            $promotionImageUrl = \Illuminate\Support\Facades\Storage::url(
                                                                $promotionImage,
                                                            );
                                                        }
                                                    @endphp

                                                    <img src="{{ $promotionImageUrl }}"
                                                        class="w-full h-full object-cover" alt="Promosi" />
                                                </div>

                                                <div>
                                                    <p class="font-semibold text-slate-800">Promosi</p>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border
                                                {{ $promotion->is_active
                                                    ? 'bg-green-50 text-green-700 border-green-200'
                                                    : 'bg-slate-50 text-slate-500 border-slate-200' }}">
                                                {{ $promotion->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <span class="font-medium text-slate-700">
                                                {{ $promotion->sort_order }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('admin.promotions.index') }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-xs font-semibold text-purple-600 bg-purple-50 hover:bg-purple-100 transition">
                                                Kelola
                                                <i class="uil uil-arrow-right"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 text-center text-slate-400">
                                            Belum ada promosi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- =======================================================
                         TABEL SERVICE PACKAGE
                    ======================================================== --}}
                    <div id="dashboard-service-packages" data-dashboard-table="service-packages"
                        class="overflow-x-auto custom-scrollbar hidden">
                        <table class="w-full text-sm text-left text-slate-600">
                            <thead
                                class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200 sticky top-0 z-10">
                                <tr>
                                    <th class="px-6 py-4 font-semibold">
                                        Nama Paket
                                    </th>
                                    <th class="px-6 py-4 font-semibold text-center">
                                        Kategori
                                    </th>
                                    <th class="px-6 py-4 font-semibold text-center">
                                        Harga
                                    </th>
                                    <th class="px-6 py-4 font-semibold text-center">
                                        Kapasitas
                                    </th>
                                    <th class="px-6 py-4 font-semibold text-center">
                                        Status
                                    </th>
                                    <th class="px-6 py-4 font-semibold text-center">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @forelse ($servicePackages as $package)
                                    @php
                                        $servicePackageCategoryLabel = match ($package->category) {
                                            'package_menu' => 'Catering Package',
                                            'wedding_package' => 'Wedding Package',
                                            'box_package' => 'Box Package',
                                            default => ucwords(str_replace('_', ' ', (string) $package->category)),
                                        };
                                    @endphp

                                    <tr class="hover:bg-slate-50/80 transition-colors duration-200 group"
                                        data-category="{{ $package->category }}"
                                        data-created-at="{{ optional($package->created_at)->timestamp ?? 0 }}">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="w-20 h-14 rounded-lg overflow-hidden border border-slate-200 shadow-sm">
                                                    @php
                                                        $packageImage = trim($package->image_path ?? '');

                                                        if (filter_var($packageImage, FILTER_VALIDATE_URL)) {
                                                            $packageImageUrl = $packageImage;
                                                        } elseif (str_starts_with($packageImage, '/storage/')) {
                                                            $packageImageUrl = asset(ltrim($packageImage, '/'));
                                                        } elseif (str_starts_with($packageImage, 'storage/')) {
                                                            $packageImageUrl = asset($packageImage);
                                                        } elseif (str_starts_with($packageImage, 'public/')) {
                                                            $packageImageUrl = asset(substr($packageImage, 7));
                                                        } elseif (str_starts_with($packageImage, 'img/')) {
                                                            $packageImageUrl = asset($packageImage);
                                                        } else {
                                                            $packageImageUrl = \Illuminate\Support\Facades\Storage::url(
                                                                $packageImage,
                                                            );
                                                        }
                                                    @endphp

                                                    <img src="{{ $packageImageUrl }}"
                                                        class="w-full h-full object-cover"
                                                        alt="{{ $package->title }}" />
                                                </div>

                                                <span class="font-semibold text-slate-800">
                                                    {{ $package->title }}
                                                </span>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border
                                                {{ $package->category === 'package_menu'
                                                    ? 'bg-amber-50 text-amber-700 border-amber-200'
                                                    : ($package->category === 'wedding_package'
                                                        ? 'bg-rose-50 text-rose-700 border-rose-200'
                                                        : 'bg-cyan-50 text-cyan-700 border-cyan-200') }}">
                                                {{ $servicePackageCategoryLabel }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 text-center font-medium text-slate-700">
                                            {{ $package->price ?: '-' }}
                                        </td>

                                        <td class="px-6 py-4 text-center text-slate-600">
                                            {{ $package->capacity ?: '-' }}
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border
                                                {{ $package->is_active
                                                    ? 'bg-green-50 text-green-700 border-green-200'
                                                    : 'bg-slate-50 text-slate-500 border-slate-200' }}">
                                                {{ $package->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('service-packages.index') }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition">
                                                Kelola
                                                <i class="uil uil-arrow-right"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-10 text-center text-slate-400">
                                            Belum ada service package.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="h-20"></div>
            </div>
        </main>
    </div>

    <div id="modalChoose" class="fixed inset-0 z-[60] hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeChooseModal()">
        </div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-lg scale-95 opacity-0 modal-content">
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold text-slate-800 mb-6">
                            Mau kelola data apa?
                        </h3>
                        <div class="grid grid-cols-1 gap-4">
                            <button onclick="openHeaderModal()"
                                class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-purple-100 bg-purple-50 text-purple-600 hover:bg-purple-100 hover:border-purple-300 transition-all gap-2 group">
                                <i class="uil uil-video text-3xl group-hover:scale-110 transition-transform"></i>
                                <span class="font-semibold text-sm">Video Header</span>
                            </button>

                            {{-- ORDER NOW --}}
                            <button onclick="openOrderButtonsModal()"
                                class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-green-100 bg-green-50 text-green-600 hover:bg-green-100 hover:border-green-300 transition-all gap-2 group">
                                <i
                                    class="uil uil-shopping-cart-alt text-3xl group-hover:scale-110 transition-transform"></i>
                                <span class="font-semibold text-sm">Order Now</span>
                            </button>
                        </div>

                        <button onclick="closeChooseModal()"
                            class="mt-6 text-slate-400 hover:text-slate-600 text-sm font-medium">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modalHeader" class="fixed inset-0 z-[60] hidden" role="dialog">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeHeaderModal()"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div
                    class="relative w-full max-w-lg transform rounded-2xl bg-white p-6 shadow-2xl transition-all scale-95 opacity-0 modal-content">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-lg font-bold text-slate-800">
                            Pengaturan Video Header
                        </h3>
                        <button onclick="closeHeaderModal()" class="text-slate-400 hover:text-slate-600">
                            <i class="uil uil-times text-xl"></i>
                        </button>
                    </div>

                    @php
                        $h_type = $header->video_type ?? 'youtube';
                        $h_tiktok = $header->tiktok_url ?? '';
                        $h_yt = $header->youtube_id ?? 'b2y8iRP0eXg';
                    @endphp

                    <form action="{{ route('header.update') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-4">
                        @csrf
                        @method ('PUT')

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase mb-3">Sumber
                                Video</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                {{-- YOUTUBE --}}
                                <label
                                    class="flex items-center gap-2 cursor-pointer p-3 border border-slate-200 rounded-lg hover:bg-slate-50">
                                    <input type="radio" name="source_type" value="youtube"
                                        class="w-4 h-4 text-purple-600 focus:ring-purple-500"
                                        {{ $h_type == 'youtube' ? 'checked' : '' }}
                                        onclick="toggleVideoInput('youtube')" />
                                    <span class="text-sm font-medium text-slate-700">Link YouTube</span>
                                </label>

                                {{-- TIKTOK --}}
                                <label
                                    class="flex items-center gap-2 cursor-pointer p-3 border border-slate-200 rounded-lg hover:bg-slate-50">
                                    <input type="radio" name="source_type" value="tiktok"
                                        class="w-4 h-4 text-purple-600 focus:ring-purple-500"
                                        {{ $h_type == 'tiktok' ? 'checked' : '' }}
                                        onclick="toggleVideoInput('tiktok')" />
                                    <span class="text-sm font-medium text-slate-700">Link TikTok</span>
                                </label>

                                {{-- UPLOAD MP4 --}}
                                <label
                                    class="flex items-center gap-2 cursor-pointer p-3 border border-slate-200 rounded-lg hover:bg-slate-50">
                                    <input type="radio" name="source_type" value="file"
                                        class="w-4 h-4 text-purple-600 focus:ring-purple-500"
                                        {{ $h_type == 'file' ? 'checked' : '' }} onclick="toggleVideoInput('file')" />
                                    <span class="text-sm font-medium text-slate-700">Upload File (MP4)</span>
                                </label>
                            </div>
                        </div>

                        <div id="input-youtube" class="{{ $h_type == 'youtube' ? 'block' : 'hidden' }}">
                            <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">URL
                                YouTube</label>
                            <input type="text" name="youtube_url"
                                value="{{ $h_type == 'youtube' ? 'https://www.youtube.com/watch?v=' . $h_yt : '' }}"
                                class="w-full rounded-lg border-slate-300 focus:border-purple-500 focus:ring-purple-500 text-sm p-2.5 bg-slate-50"
                                placeholder="Contoh: https://www.youtube.com/watch?v=b2y8iRP0eXg" />
                            <p class="text-[10px] text-slate-400 mt-1">Copy paste link lengkap dari browser.</p>
                        </div>

                        <div id="input-tiktok" class="{{ $h_type == 'tiktok' ? 'block' : 'hidden' }}">

                            <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">
                                URL TikTok
                            </label>

                            <input type="url" name="tiktok_url" value="{{ old('tiktok_url', $h_tiktok) }}"
                                class="w-full rounded-lg border-slate-300 focus:border-purple-500 focus:ring-purple-500 text-sm p-2.5 bg-slate-50"
                                placeholder="https://www.tiktok.com/@akun/video/..." />

                            <p class="text-[10px] text-slate-400 mt-1">
                                Copy paste link lengkap dari browser.
                            </p>
                        </div>

                        <div id="input-file" class="{{ $h_type == 'file' ? 'block' : 'hidden' }}">
                            <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Upload
                                Video</label>
                            <input type="file" name="video_file" accept="video/mp4"
                                class="w-full text-xs text-slate-500 file:mr-2 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100" />
                            <p class="text-[10px] text-slate-400 mt-1">Format: MP4. Maksimal ukuran: 20MB.</p>
                        </div>

                        <button type="submit"
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2.5 rounded-xl transition-all shadow-md hover:shadow-lg mt-4">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- =========================================================
     MODAL PILIHAN ORDER NOW
========================================================= -->
    <div id="modalOrderButtons" class="fixed inset-0 z-[60] hidden" role="dialog" aria-modal="true">
        <!-- Background -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeOrderButtonsModal()"></div>

        <!-- Modal -->
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div
                    class="relative w-full max-w-md transform rounded-2xl bg-white p-6 shadow-2xl transition-all scale-95 opacity-0 modal-content">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">
                                Order Now
                            </h3>

                            <p class="text-xs text-slate-400 mt-1">Pilih tombol yang ingin dikelola.</p>
                        </div>

                        <button onclick="closeOrderButtonsModal()" class="text-slate-400 hover:text-slate-600">
                            <i class="uil uil-times text-xl"></i>
                        </button>
                    </div>

                    <!-- PILIHAN -->
                    <div class="space-y-3">
                        <!-- GOFOOD -->
                        <button type="button" onclick="openOrderButtonEdit(0)"
                            class="w-full flex items-center gap-4 p-4 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 hover:border-green-300 transition-all text-left">
                            <div
                                class="w-14 h-14 rounded-xl bg-slate-100 flex items-center justify-center overflow-hidden shrink-0">
                                <img
                                    src="{{ filter_var($orderButtons[0]->icon, FILTER_VALIDATE_URL)
                                        ? $orderButtons[0]->icon
                                        : (str_starts_with($orderButtons[0]->icon, 'img/')
                                            ? asset($orderButtons[0]->icon)
                                            : asset('storage/' . ltrim($orderButtons[0]->icon, '/'))) }}" />
                            </div>

                            <div class="flex-1">
                                <p class="font-semibold text-slate-800">
                                    {{ $orderButtons[0]->title }}
                                </p>

                                <p class="text-xs text-slate-400 mt-1">Kelola tombol GoFood</p>
                            </div>

                            <i class="uil uil-angle-right-b text-xl text-slate-400"></i>
                        </button>

                        <!-- GRABFOOD -->
                        <button type="button" onclick="openOrderButtonEdit(1)"
                            class="w-full flex items-center gap-4 p-4 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 hover:border-green-300 transition-all text-left">
                            <div
                                class="w-14 h-14 rounded-xl bg-slate-100 flex items-center justify-center overflow-hidden shrink-0">
                                <img
                                    src="{{ filter_var($orderButtons[1]->icon, FILTER_VALIDATE_URL)
                                        ? $orderButtons[1]->icon
                                        : (str_starts_with($orderButtons[1]->icon, 'img/')
                                            ? asset($orderButtons[1]->icon)
                                            : asset('storage/' . ltrim($orderButtons[1]->icon, '/'))) }}" />
                            </div>

                            <div class="flex-1">
                                <p class="font-semibold text-slate-800">
                                    {{ $orderButtons[1]->title }}
                                </p>

                                <p class="text-xs text-slate-400 mt-1">Kelola tombol GrabFood</p>
                            </div>

                            <i class="uil uil-angle-right-b text-xl text-slate-400"></i>
                        </button>

                        <!-- WHATSAPP -->
                        <button type="button" onclick="openOrderButtonEdit(2)"
                            class="w-full flex items-center gap-4 p-4 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 hover:border-green-300 transition-all text-left">
                            <div
                                class="w-14 h-14 rounded-xl bg-slate-100 flex items-center justify-center overflow-hidden shrink-0">
                                <img
                                    src="{{ filter_var($orderButtons[2]->icon, FILTER_VALIDATE_URL)
                                        ? $orderButtons[2]->icon
                                        : (str_starts_with($orderButtons[2]->icon, 'img/')
                                            ? asset($orderButtons[2]->icon)
                                            : asset('storage/' . ltrim($orderButtons[2]->icon, '/'))) }}" />
                            </div>

                            <div class="flex-1">
                                <p class="font-semibold text-slate-800">
                                    {{ $orderButtons[2]->title }}
                                </p>

                                <p class="text-xs text-slate-400 mt-1">Kelola tombol WhatsApp</p>
                            </div>

                            <i class="uil uil-angle-right-b text-xl text-slate-400"></i>
                        </button>
                    </div>

                    <!-- KEMBALI -->
                    <button onclick="closeOrderButtonsModal()"
                        class="w-full mt-5 py-2.5 text-sm font-medium text-slate-500 hover:text-slate-700">
                        Kembali ke Dashboard
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- =========================================================
     MODAL EDIT ORDER NOW
========================================================= -->
    <div id="modalOrderButtonEdit" class="fixed inset-0 z-[70] hidden" role="dialog" aria-modal="true">
        <!-- Background -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeOrderButtonEdit()"></div>

        <!-- Modal -->
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div
                    class="relative w-full max-w-4xl transform rounded-2xl bg-white shadow-2xl transition-all scale-95 opacity-0 modal-content">
                    <!-- HEADER -->
                    <div class="flex items-center justify-between px-6 py-5 border-b border-slate-200">
                        <div>
                            <h3 id="orderEditTitle" class="text-lg font-bold text-slate-800">
                                Edit Order Now
                            </h3>

                            <p class="text-xs text-slate-400 mt-1">Perbarui gambar, judul, dan link tombol.</p>
                        </div>

                        <button type="button" onclick="closeOrderButtonEdit()"
                            class="text-slate-400 hover:text-slate-600">
                            <i class="uil uil-times text-xl"></i>
                        </button>
                    </div>

                    <!-- CONTENT -->
                    <form id="orderButtonEditForm" method="POST" enctype="multipart/form-data" class="p-6">
                        @csrf
                        @method ('PUT')

                        <div class="grid grid-cols-1 lg:grid-cols-[220px_1fr] gap-6">
                            <!-- KIRI : GAMBAR -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Preview Gambar
                                </label>

                                <!-- PREVIEW KECIL -->
                                <div
                                    class="w-32 h-32 rounded-xl border border-slate-200 bg-slate-50 overflow-hidden flex items-center justify-center">
                                    <img id="orderPreviewImage" src="" alt="Preview"
                                        class="w-full h-full object-contain" />
                                </div>

                                <!-- URL GAMBAR -->
                                <div class="mt-5">
                                    <label class="block text-xs font-semibold text-slate-500 mb-1">
                                        URL Gambar
                                    </label>

                                    <input type="text" id="orderIconUrl" name="icon_url"
                                        placeholder="https://contoh.com/icon.png"
                                        class="w-full rounded-lg border border-slate-300 text-sm p-2.5 bg-white focus:border-green-500 focus:ring-green-500" />
                                </div>

                                <!-- UPLOAD GAMBAR -->
                                <div class="mt-4">
                                    <label class="block text-xs font-semibold text-slate-500 mb-1">
                                        Upload Gambar
                                    </label>

                                    <input type="file" id="orderIconFile" name="icon_file"
                                        accept="image/png,image/jpeg,image/webp"
                                        class="w-full text-xs text-slate-500" />
                                </div>
                            </div>

                            <!-- KANAN : DATA -->
                            <div>
                                <!-- JUDUL -->
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Judul
                                    </label>

                                    <input type="text" id="orderTitleInput" name="title"
                                        class="w-full rounded-xl border border-slate-300 text-sm px-4 py-3 focus:border-green-500 focus:ring-green-500"
                                        placeholder="Contoh: GoFood" />
                                </div>

                                <!-- LINK -->
                                <div class="mt-5">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Link
                                    </label>

                                    <input type="text" id="orderLinkInput" name="link"
                                        class="w-full rounded-xl border border-slate-300 text-sm px-4 py-3 focus:border-green-500 focus:ring-green-500"
                                        placeholder="https://..." />
                                </div>
                            </div>
                        </div>

                        <!-- TOMBOL -->
                        <div class="flex items-center justify-between mt-8 pt-5 border-t border-slate-200">
                            <button type="button" onclick="backToOrderButtonList()"
                                class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-500 hover:text-slate-700 hover:bg-slate-100 transition">
                                Kembali
                            </button>

                            <button type="submit"
                                class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-md hover:shadow-lg transition">
                                <i class="uil uil-save"></i>
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // =========================================================
        // TAB SWITCHER + FILTER OVERVIEW
        // =========================================================

        const tabButtons = {
            menu: document.getElementById("btn-menu"),
            gallery: document.getElementById("btn-gallery"),
            promotions: document.getElementById("btn-promotions"),
            "service-packages": document.getElementById("btn-service-packages"),
        };

        const dashboardTables = {
            menu: document.getElementById("dashboard-menu"),
            gallery: document.getElementById("dashboard-gallery"),
            promotions: document.getElementById("dashboard-promotions"),
            "service-packages": document.getElementById("dashboard-service-packages"),
        };

        const filterGroups = {
            menu: document.getElementById("filter-menu"),
            gallery: document.getElementById("filter-gallery"),
            promotions: document.getElementById("filter-promotions"),
            "service-packages": document.getElementById("filter-service-packages"),
        };

        let activeTab = "menu";

        function setActiveTab(type) {
            activeTab = type;

            Object.entries(tabButtons).forEach(([key, button]) => {
                if (!button) return;

                if (key === type) {
                    button.classList.add("bg-white", "text-indigo-600", "shadow-sm");
                    button.classList.remove("text-slate-500");
                } else {
                    button.classList.remove("bg-white", "text-indigo-600", "shadow-sm");
                    button.classList.add("text-slate-500");
                }
            });

            Object.entries(dashboardTables).forEach(([key, table]) => {
                if (!table) return;

                if (key === type) {
                    table.classList.remove("hidden");
                } else {
                    table.classList.add("hidden");
                }
            });

            Object.entries(filterGroups).forEach(([key, group]) => {
                if (!group) return;

                if (key === type) {
                    group.classList.remove("hidden");
                    group.classList.add("flex");
                } else {
                    group.classList.add("hidden");
                    group.classList.remove("flex");
                }
            });

            clearHighlights();
            filterActiveTable();
        }

        Object.entries(tabButtons).forEach(([key, button]) => {
            if (button) {
                button.addEventListener("click", () => setActiveTab(key));
            }
        });

        // =========================================================
        // MODAL SYSTEM
        // =========================================================

        function toggleModal(modalID, show) {
            const modal = document.getElementById(modalID);

            if (!modal) return;

            const content = modal.querySelector(".modal-content");

            if (show) {
                modal.classList.remove("hidden");
                document.body.style.overflow = "hidden";

                if (content) {
                    setTimeout(() => {
                        content.classList.remove("scale-95", "opacity-0");
                        content.classList.add("scale-100", "opacity-100");
                    }, 10);
                }
            } else {
                if (content) {
                    content.classList.remove("scale-100", "opacity-100");
                    content.classList.add("scale-95", "opacity-0");
                }

                setTimeout(() => {
                    modal.classList.add("hidden");
                    document.body.style.overflow = "";
                }, 200);
            }
        }

        // Modal Choose
        function openChooseModal() {
            toggleModal("modalChoose", true);
        }

        function closeChooseModal() {
            toggleModal("modalChoose", false);
        }

        // Modal Header Video
        function openHeaderModal() {
            closeChooseModal();
            toggleModal("modalHeader", true);
        }

        function closeHeaderModal() {
            toggleModal("modalHeader", false);
        }

        // Modal Order Now
        function openOrderButtonsModal() {
            closeChooseModal();
            toggleModal("modalOrderButtons", true);
        }

        function closeOrderButtonsModal() {
            toggleModal("modalOrderButtons", false);
        }

        // Modal Edit Order Now
        function openOrderButtonEdit(index) {
            const buttons = @json ($orderButtons);

            if (!buttons[index]) return;

            const button = buttons[index];

            // Isi judul popup
            document.getElementById("orderEditTitle").textContent =
                "Edit " + button.title;

            // Isi judul
            document.getElementById("orderTitleInput").value = button.title || "";

            // Isi link
            document.getElementById("orderLinkInput").value = button.link || "";

            // Isi URL gambar jika menggunakan URL
            const iconUrlInput = document.getElementById("orderIconUrl");

            if (
                button.icon &&
                (button.icon.startsWith("http://") ||
                    button.icon.startsWith("https://"))
            ) {
                iconUrlInput.value = button.icon;
            } else {
                iconUrlInput.value = "";
            }

            // Preview gambar
            const preview = document.getElementById("orderPreviewImage");

            function getOrderImageUrl(icon) {
                if (!icon) {
                    return "";
                }

                // URL gambar dari internet
                if (icon.startsWith("http://") || icon.startsWith("https://")) {
                    return icon;
                }

                // Gambar bawaan public/img
                if (icon.startsWith("img/")) {
                    return "{{ asset('') }}" + icon;
                }

                // Jika tersimpan dengan public/
                if (icon.startsWith("public/")) {
                    return "{{ asset('') }}" + icon.substring(7);
                }

                // File dari storage
                if (icon.startsWith("/storage/")) {
                    return "{{ url('/') }}" + icon;
                }

                if (icon.startsWith("storage/")) {
                    return "{{ url('/') }}/" + icon;
                }

                // Default file upload
                return "{{ asset('storage') }}/" + icon;
            }

            preview.src = getOrderImageUrl(button.icon);

            preview.onerror = function() {
                this.src = "";
            };
            // Tentukan form update untuk tombol yang dipilih
            document.getElementById("orderButtonEditForm").action =
                "{{ url('/dashboard/order-buttons') }}/" + button.id;

            // Kosongkan file upload
            document.getElementById("orderIconFile").value = "";

            // Tutup pilihan Order Now
            closeOrderButtonsModal();

            // Buka popup edit
            toggleModal("modalOrderButtonEdit", true);
        }

        function closeOrderButtonEdit() {
            toggleModal("modalOrderButtonEdit", false);
        }

        function backToOrderButtonList() {
            closeOrderButtonEdit();

            setTimeout(() => {
                toggleModal("modalOrderButtons", true);
            }, 250);
        }

        // =========================================================
        // PREVIEW GAMBAR ORDER NOW
        // =========================================================

        const orderIconFile = document.getElementById("orderIconFile");
        const orderIconUrl = document.getElementById("orderIconUrl");
        const orderPreviewImage = document.getElementById("orderPreviewImage");

        // Preview saat upload file
        if (orderIconFile) {
            orderIconFile.addEventListener("change", function() {
                const file = this.files[0];

                if (!file) return;

                const reader = new FileReader();

                reader.onload = function(event) {
                    orderPreviewImage.src = event.target.result;
                };

                reader.readAsDataURL(file);
            });
        }

        // Preview saat memasukkan URL gambar
        if (orderIconUrl) {
            orderIconUrl.addEventListener("input", function() {
                const url = this.value.trim();

                if (!url) return;

                orderPreviewImage.src = url;
            });
        }

        function toggleVideoInput(type) {
            const inputYt = document.getElementById("input-youtube");
            const inputTiktok = document.getElementById("input-tiktok");
            const inputFile = document.getElementById("input-file");

            if (!inputYt || !inputTiktok || !inputFile) return;

            inputYt.classList.toggle("hidden", type !== "youtube");
            inputTiktok.classList.toggle("hidden", type !== "tiktok");
            inputFile.classList.toggle("hidden", type !== "file");
        }

        // =========================================================
        // SEARCH + HIGHLIGHT
        // =========================================================

        const globalReset = document.getElementById("globalReset");
        const searchInput = document.getElementById("searchInput");

        let highlightedRows = [];
        let highlightIndex = -1;

        function clearHighlights() {
            document.querySelectorAll(".highlighted-row").forEach((element) => {
                element.classList.remove("highlighted-row", "active-highlight");
            });

            highlightedRows = [];
            highlightIndex = -1;
        }

        const originalRows = {};
        const emptyRows = {};

        Object.entries(dashboardTables).forEach(([key, table]) => {
            if (!table) return;

            const tbody = table.querySelector("tbody");

            originalRows[key] = Array.from(
                tbody.querySelectorAll("tr[data-created-at]"),
            );

            emptyRows[key] = tbody.querySelector("tr:not([data-created-at])") || null;
        });

        function getTableRows(type) {
            return originalRows[type] ? [...originalRows[type]] : [];
        }

        function searchAcrossTables(term) {
            clearHighlights();

            if (!term) return;

            const normalizedTerm = term.toLowerCase().trim();
            let foundTab = null;

            Object.entries(originalRows).forEach(([key, rows]) => {
                rows.forEach((row) => {
                    if (row.innerText.toLowerCase().includes(normalizedTerm)) {
                        row.classList.add("highlighted-row");
                        highlightedRows.push(row);

                        if (!foundTab) {
                            foundTab = key;
                        }
                    }
                });
            });

            if (foundTab && foundTab !== activeTab) {
                setActiveTab(foundTab);
            }
        }

        if (searchInput) {
            searchInput.addEventListener("input", (event) => {
                searchAcrossTables(event.target.value);
            });
        }

        // =========================================================
        // FILTER + SORT
        // =========================================================

        function sortRows(rows, sortValue) {
            return [...rows].sort((a, b) => {
                const dateA = Number(a.dataset.createdAt || 0);
                const dateB = Number(b.dataset.createdAt || 0);

                return sortValue === "oldest" ? dateA - dateB : dateB - dateA;
            });
        }

        function renderRows(type, rows) {
            const table = dashboardTables[type];

            if (!table) return;

            const tbody = table.querySelector("tbody");
            const emptyRow = emptyRows[type];

            tbody.innerHTML = "";

            rows.forEach((row) => {
                tbody.appendChild(row);
            });

            if (!rows.length && emptyRow) {
                tbody.appendChild(emptyRow);
            }
        }

        function filterMenuTable() {
            const type = (
                document.getElementById("menuFilterType")?.value || ""
            ).toLowerCase();

            const sort = document.getElementById("menuSortBy")?.value || "latest";

            const rows = getTableRows("menu").filter((row) => {
                return !type || (row.dataset.type || "").toLowerCase() === type;
            });

            renderRows("menu", sortRows(rows, sort));
        }

        function filterGalleryTable() {
            const category = (
                document.getElementById("galleryFilterCategory")?.value || ""
            ).toLowerCase();

            const sort = document.getElementById("gallerySortBy")?.value || "latest";

            const rows = getTableRows("gallery").filter((row) => {
                return (
                    !category || (row.dataset.category || "").toLowerCase() === category
                );
            });

            renderRows("gallery", sortRows(rows, sort));
        }

        function filterPromotionsTable() {
            const status = (
                document.getElementById("promotionFilterStatus")?.value || ""
            ).toLowerCase();

            const sort = document.getElementById("promotionSortBy")?.value || "latest";

            const rows = getTableRows("promotions").filter((row) => {
                return !status || (row.dataset.status || "").toLowerCase() === status;
            });

            renderRows("promotions", sortRows(rows, sort));
        }

        function filterServicePackagesTable() {
            const category = (
                document.getElementById("servicePackageFilterCategory")?.value || ""
            ).toLowerCase();

            const sort =
                document.getElementById("servicePackageSortBy")?.value || "latest";

            const rows = getTableRows("service-packages").filter((row) => {
                return (
                    !category || (row.dataset.category || "").toLowerCase() === category
                );
            });

            renderRows("service-packages", sortRows(rows, sort));
        }

        function filterActiveTable() {
            switch (activeTab) {
                case "menu":
                    filterMenuTable();
                    break;
                case "gallery":
                    filterGalleryTable();
                    break;
                case "promotions":
                    filterPromotionsTable();
                    break;
                case "service-packages":
                    filterServicePackagesTable();
                    break;
            }
        }

        [
            "menuFilterType",
            "menuSortBy",
            "galleryFilterCategory",
            "gallerySortBy",
            "promotionFilterStatus",
            "promotionSortBy",
            "servicePackageFilterCategory",
            "servicePackageSortBy",
        ].forEach((id) => {
            const element = document.getElementById(id);

            if (element) {
                element.addEventListener("change", () => {
                    clearHighlights();
                    filterActiveTable();
                });
            }
        });

        if (globalReset) {
            globalReset.addEventListener("click", () => {
                document.getElementById("menuFilterType").value = "";
                document.getElementById("menuSortBy").value = "latest";

                document.getElementById("galleryFilterCategory").value = "";
                document.getElementById("gallerySortBy").value = "latest";

                document.getElementById("promotionFilterStatus").value = "";
                document.getElementById("promotionSortBy").value = "latest";

                document.getElementById("servicePackageFilterCategory").value = "";
                document.getElementById("servicePackageSortBy").value = "latest";

                if (searchInput) {
                    searchInput.value = "";
                }

                clearHighlights();
                filterActiveTable();
            });
        }

        // =========================================================
        // ANIMATION
        // =========================================================

        document.addEventListener("DOMContentLoaded", () => {
            const sections = document.querySelectorAll(".fade-section");

            const observer = new IntersectionObserver(
                (entries, obs) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add("fade-enter-active");
                            entry.target.classList.remove("fade-enter");
                            obs.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.1,
                },
            );

            sections.forEach((section) => {
                section.classList.add("fade-enter");
                observer.observe(section);
            });

            const alert = document.getElementById("success-alert");

            if (alert) {
                setTimeout(() => {
                    alert.style.display = "none";
                }, 3000);
            }

            setActiveTab("menu");
        });
    </script>
</body>

</html>
