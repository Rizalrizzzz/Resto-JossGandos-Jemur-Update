<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Kelola Menu</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logojossgandos.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Unicons untuk Sidebar --}}
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css" />

    {{-- Lucide Icons untuk halaman Menu --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        .scrollbar-stable {
            scrollbar-gutter: stable;
        }

        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">
    <div class="flex h-screen overflow-hidden">
        {{-- SIDEBAR --}}
        @include ('layouts.sidebar')

        {{-- CONTENT --}}
        <main class="flex-1 min-w-0 min-h-0 overflow-y-auto bg-slate-50 relative">
            {{-- HEADER MENU --}}
            <header
                class="sticky top-0 flex-shrink-0 bg-white border-b border-slate-200 shadow-sm z-20 px-6 py-4 flex items-center justify-between gap-4">
                <div class="flex items-center gap-4 flex-1">
                    {{-- GARIS 3 UNTUK HP --}}
                    <button type="button" onclick="toggleSidebar()"
                        class="md:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-lg">
                        <i class="uil uil-bars text-2xl"></i>
                    </button>

                    <div>
                        <h1 class="text-xl font-bold text-slate-800 tracking-tight">
                            Kelola Menu
                        </h1>
                    </div>
                </div>

                {{-- TOMBOL TAMBAH --}}
                <button type="button" onclick="openAddModal()"
                    class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg hover:shadow-xl transition-all">
                    <i class="uil uil-plus-circle text-lg"></i>

                    <span>Tambah Menu</span>
                </button>
            </header>

            {{-- ====================================================== --}}
            {{-- PENGATURAN HALAMAN MENU --}}
            {{-- ====================================================== --}}

            <div class="px-4 md:px-6 pt-5 pb-2">
                <div class="space-y-3">
                    {{-- ================================================== --}}
                    {{-- HERO SECTION --}}
                    {{-- ================================================== --}}

                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                        {{-- HEADER ACCORDION --}}
                        <button type="button"
                            onclick="
                                toggleMenuSetting('heroSetting', 'heroArrow')
                            "
                            class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-slate-50 transition">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                    <i data-lucide="layout-template" class="w-5 h-5"></i>
                                </div>

                                <div>
                                    <h2 class="text-lg font-bold text-slate-800">
                                        Hero Section
                                    </h2>

                                    <p class="text-sm text-slate-500 mt-1">Atur judul, deskripsi, dan gambar utama
                                        halaman Menu.</p>
                                </div>
                            </div>

                            <i id="heroArrow" data-lucide="chevron-down"
                                class="w-5 h-5 text-slate-500 shrink-0 transition-transform duration-200">
                            </i>
                        </button>

                        {{-- ISI --}}
                        <div id="heroSetting" class="hidden border-t border-slate-100">
                            <form action="{{ route('menu.settings.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method ('PUT')

                                <div class="p-6">
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                        {{-- KOLOM KIRI --}}
                                        <div class="space-y-5">
                                            {{-- LABEL --}}
                                            <div>
                                                <label for="menuHeroBadge"
                                                    class="block text-sm font-semibold text-slate-700 mb-2">
                                                    Label
                                                </label>

                                                <input id="menuHeroBadge" type="text" name="hero_badge"
                                                    value="{{ old('hero_badge', $menuSetting->hero_badge ?? 'MENU KAMI') }}"
                                                    placeholder="Contoh: MENU KAMI"
                                                    class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                                            </div>

                                            {{-- JUDUL --}}
                                            <div>
                                                <label for="menuHeroTitle"
                                                    class="block text-sm font-semibold text-slate-700 mb-2">
                                                    Judul
                                                </label>

                                                <input id="menuHeroTitle" type="text" name="hero_title"
                                                    value="{{ old('hero_title', $menuSetting->hero_title ?? 'Cita Rasa Autentik Resto Joss Gandos') }}"
                                                    placeholder="Contoh: Cita Rasa Autentik Resto Joss Gandos"
                                                    class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                                            </div>

                                            {{-- DESKRIPSI --}}
                                            <div>
                                                <label for="menuHeroDescription"
                                                    class="block text-sm font-semibold text-slate-700 mb-2">
                                                    Deskripsi
                                                </label>

                                                <textarea id="menuHeroDescription" name="hero_description" rows="6" placeholder="Masukkan deskripsi hero..."
                                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none resize-y focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">{{ old('hero_description', $menuSetting->hero_description ?? 'Nikmati beragam hidangan pilihan Resto Joss Gandos yang diolah dari bahan berkualitas dengan cita rasa khas yang menggugah selera.') }}</textarea
                                                >
                                            </div>
                                        </div>

                                        {{-- KOLOM KANAN: UPLOAD FOTO HERO --}}
                                        <div>
                                            <label for="heroImageFile" class="block text-sm font-semibold text-slate-700 mb-2">
                                                Upload Foto (JPG/PNG/WebP, maks 2MB)
                                            </label>

                                            <input
                                                type="file"
                                                name="hero_image_file"
                                                id="heroImageFile"
                                                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                                onchange="previewHeroImageFile(this)"
                                                class="block w-full text-sm text-slate-500 border border-slate-200 rounded-xl p-3 bg-white file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-700 file:font-semibold hover:file:bg-indigo-100"
                                            />

                                            <p class="text-xs text-slate-400 mt-2">
                                                Pilih foto maksimal 2 MB. Preview berubah setelah file dipilih.
                                            </p>

                                            {{-- PREVIEW --}}
                                            <div class="mt-4">
                                                <div class="relative w-full h-72 rounded-2xl overflow-hidden border border-slate-200 bg-slate-50">
                                                    <img
                                                        id="heroImagePreview"
                                                        src="{{ !empty($menuSetting->hero_image) ? asset('storage/' . ltrim(preg_replace('#^/?storage/#', '', $menuSetting->hero_image), '/')) : '' }}"
                                                        alt="Preview Hero"
                                                        class="w-full h-full object-cover {{ empty($menuSetting->hero_image) ? 'hidden' : '' }}"
                                                    />

                                                    <div
                                                        id="heroImageEmpty"
                                                        class="{{ !empty($menuSetting->hero_image) ? 'hidden' : '' }} absolute inset-0 flex flex-col items-center justify-center text-slate-400"
                                                    >
                                                        <i data-lucide="image" class="w-10 h-10 mb-2"></i>
                                                        <span class="text-sm">Preview gambar akan tampil di sini</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <p id="heroImageSizeMessage" class="hidden mt-2 text-xs text-red-500">
                                                Ukuran file lebih dari 2 MB. Pilih foto maksimal 2 MB.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- FOOTER --}}
                                <div
                                    class="flex justify-end px-6 py-4 border-t border-slate-100 bg-slate-50"
                                >
                                    <button
                                        type="submit"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-sm transition"
                                    >
                                        <i
                                            data-lucide="save"
                                            class="w-4 h-4"
                                        ></i>

                                        Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- ================================================== --}}
                    {{-- JUDUL SECTION MENU --}}
                    {{-- ================================================== --}}

                    <div
                        class="bg-white border border-slate-200 rounded-2xl overflow-hidden"
                    >
                        {{-- HEADER ACCORDION --}}
                        <button
                            type="button"
                            onclick="
                                toggleMenuSetting(
                                    'sectionTitleSetting',
                                    'sectionTitleArrow',
                                )
                            "
                            class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-slate-50 transition"
                        >
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center shrink-0"
                                >
                                    <i data-lucide="type" class="w-5 h-5"></i>
                                </div>

                                <div>
                                    <h2
                                        class="text-lg font-bold text-slate-800"
                                    >
                                        Judul Section Menu
                                    </h2>

                                    <p class="text-sm text-slate-500 mt-1">Atur judul Promo, Rekomendasi, dan Menu Lainnya.</p>
                                </div>
                            </div>

                            <i
                                id="sectionTitleArrow"
                                data-lucide="chevron-down"
                                class="w-5 h-5 text-slate-500 shrink-0 transition-transform duration-200"
                            >
                            </i>
                        </button>

                        {{-- ISI --}}
                        <div
                            id="sectionTitleSetting"
                            class="hidden border-t border-slate-100"
                        >
                            <form
                                action="{{ route('menu.settings.update') }}"
                                method="POST"
                            >
                                @csrf
                                @method ('PUT')

                                <div class="p-6 space-y-5">
                                    {{-- JUDUL PROMO --}}
                                    <div>
                                        <label for="menuPromoTitle"
                                            class="block text-sm font-semibold text-slate-700 mb-2"
                                        >
                                            Judul Promo
                                        </label>

                                        <input id="menuPromoTitle"
                                            type="text"
                                            name="promo_title"
                                            value="{{ old('promo_title', $menuSetting->promo_title ?? 'Promo Bulan Ini') }}"
                                            placeholder="Contoh: Promo Bulan Ini"
                                            class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                        />
                                    </div>

                                    {{-- JUDUL REKOMENDASI --}}
                                    <div>
                                        <label for="menuRecommendedTitle"
                                            class="block text-sm font-semibold text-slate-700 mb-2"
                                        >
                                            Judul Rekomendasi
                                        </label>

                                        <input id="menuRecommendedTitle"
                                            type="text"
                                            name="recommended_title"
                                            value="{{ old('recommended_title', $menuSetting->recommended_title ?? 'Rekomendasi Spesial Kami') }}"
                                            placeholder="Contoh: Rekomendasi Spesial Kami"
                                            class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                        />
                                    </div>

                                    {{-- JUDUL MENU LAINNYA --}}
                                    <div>
                                        <label for="menuOtherTitle"
                                            class="block text-sm font-semibold text-slate-700 mb-2"
                                        >
                                            Judul Menu Lainnya
                                        </label>

                                        <input id="menuOtherTitle"
                                            type="text"
                                            name="menu_title"
                                            value="{{ old('menu_title', $menuSetting->menu_title ?? 'Menu Lainnya') }}"
                                            placeholder="Contoh: Menu Lainnya"
                                            class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                        />
                                    </div>
                                </div>

                                {{-- FOOTER --}}
                                <div
                                    class="flex justify-end px-6 py-4 border-t border-slate-100 bg-slate-50"
                                >
                                    <button
                                        type="submit"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-sm transition"
                                    >
                                        <i
                                            data-lucide="save"
                                            class="w-4 h-4"
                                        ></i>

                                        Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>


                    {{-- ================================================== --}}
{{-- CTA MENU LENGKAP --}}
{{-- ================================================== --}}

<div
    class="bg-white border border-slate-200 rounded-2xl overflow-hidden"
>
    {{-- HEADER ACCORDION --}}
    <button
        type="button"
        onclick="toggleMenuSetting('ctaSetting', 'ctaArrow')"
        class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-slate-50 transition"
    >
        <div class="flex items-center gap-3">
            <div
                class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0"
            >
                <i
                    data-lucide="book-open"
                    class="w-5 h-5"
                ></i>
            </div>

            <div>
                <h2
                    class="text-lg font-bold text-slate-800"
                >
                    Menu Lengkap
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Atur foto, informasi, dan link Google Drive menu lengkap.
                </p>
            </div>
        </div>

        <i
            id="ctaArrow"
            data-lucide="chevron-down"
            class="w-5 h-5 text-slate-500 shrink-0 transition-transform duration-200"
        ></i>
    </button>

    {{-- ISI --}}
    <div
        id="ctaSetting"
        class="hidden border-t border-slate-100"
    >
        <form
            action="{{ route('menu.settings.update') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            <div class="p-6">
                <div
                    class="grid grid-cols-1 lg:grid-cols-2 gap-6"
                >
                    {{-- KOLOM KIRI --}}
                    <div class="space-y-5">

                        {{-- BADGE --}}
                        <div>
                            <label for="menuCtaBadge"
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >
                                Badge
                            </label>

                            <input id="menuCtaBadge"
                                type="text"
                                name="cta_badge"
                                value="{{ old('cta_badge', $menuSetting->cta_badge ?? '') }}"
                                placeholder="Contoh: MENU LENGKAP"
                                class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                            />
                        </div>

                        {{-- JUDUL --}}
                        <div>
                            <label for="menuCtaTitle"
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >
                                Judul
                            </label>

                            <input id="menuCtaTitle"
                                type="text"
                                name="cta_title"
                                value="{{ old('cta_title', $menuSetting->cta_title ?? '') }}"
                                placeholder="Contoh: Cita Rasa Resto Joss Gandos"
                                class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                            />
                        </div>

                        {{-- DESKRIPSI --}}
                        <div>
                            <label for="menuCtaDescription"
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >
                                Deskripsi
                            </label>

                            <textarea id="menuCtaDescription"
                                name="cta_description"
                                rows="5"
                                placeholder="Masukkan deskripsi menu lengkap..."
                                class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none resize-y focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                            >{{ old('cta_description', $menuSetting->cta_description ?? '') }}</textarea>
                                            </div>

                                            {{-- LINK GOOGLE DRIVE --}}
                                            <div>
                                                <label for="menuCtaLink"
                                                    class="block text-sm font-semibold text-slate-700 mb-2">
                                                    Link Google Drive
                                                </label>

                                                <input id="menuCtaLink" type="url" name="cta_link"
                                                    value="{{ old('cta_link', $menuSetting->cta_link ?? '') }}"
                                                    placeholder="https://drive.google.com/..."
                                                    class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                                            </div>

                                        </div>

                                        {{-- KOLOM KANAN: UPLOAD FOTO MENU LENGKAP --}}
                                        <div>
                                            <label for="ctaImageFile"
                                                class="block text-sm font-semibold text-slate-700 mb-2">
                                                Upload Foto (JPG/PNG/WebP, maks 2MB)
                                            </label>

                                            <input type="file" name="cta_image_file" id="ctaImageFile"
                                                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                                onchange="previewCtaImageFile(this)"
                                                class="block w-full text-sm text-slate-500 border border-slate-200 rounded-xl p-3 bg-white file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-700 file:font-semibold hover:file:bg-indigo-100" />

                                            <p class="text-xs text-slate-400 mt-2">
                                                Pilih foto maksimal 2 MB. Preview berubah setelah file dipilih.
                                            </p>

                                            {{-- PREVIEW --}}
                                            <div class="mt-4">
                                                <div
                                                    class="relative w-full h-72 rounded-2xl overflow-hidden border border-slate-200 bg-slate-50">
                                                    <img id="ctaImagePreview"
                                                        src="{{ !empty($menuSetting->cta_image) ? asset('storage/' . ltrim(preg_replace('#^/?storage/#', '', $menuSetting->cta_image), '/')) : '' }}"
                                                        alt="Preview CTA"
                                                        class="w-full h-full object-cover {{ empty($menuSetting->cta_image) ? 'hidden' : '' }}" />

                                                    <div id="ctaImageEmpty"
                                                        class="{{ !empty($menuSetting->cta_image) ? 'hidden' : '' }} absolute inset-0 flex flex-col items-center justify-center text-slate-400">
                                                        <i data-lucide="image" class="w-10 h-10 mb-2"></i>
                                                        <span class="text-sm">Preview gambar akan tampil di sini</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <p id="ctaImageSizeMessage" class="hidden mt-2 text-xs text-red-500">
                                                Ukuran file lebih dari 2 MB. Pilih foto maksimal 2 MB.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- FOOTER --}}
                                <div class="flex justify-end px-6 py-4 border-t border-slate-100 bg-slate-50">
                                    <button type="submit"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-sm transition">
                                        <i data-lucide="save" class="w-4 h-4"></i>

                                        Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- ================================================== --}}
                    {{-- PAKET & LAYANAN SECTION --}}
                    {{-- ================================================== --}}

                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                        <button type="button"
                            onclick="
                                toggleMenuSetting(
                                    'packageSetting',
                                    'packageArrow',
                                )
                            "
                            class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-slate-50 transition">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center shrink-0">
                                    <i data-lucide="package" class="w-5 h-5"></i>
                                </div>

                                <div>
                                    <h2 class="text-lg font-bold text-slate-800">
                                        Paket & Layanan Section
                                    </h2>

                                    <p class="text-sm text-slate-500 mt-1">Atur judul dan deskripsi bagian paket &
                                        layanan.</p>
                                </div>
                            </div>

                            <i id="packageArrow" data-lucide="chevron-down"
                                class="w-5 h-5 text-slate-500 shrink-0 transition-transform duration-200">
                            </i>
                        </button>

                        <div id="packageSetting" class="hidden border-t border-slate-100">
                            {{-- ================================================== --}}
                            {{-- JUDUL & DESKRIPSI SECTION --}}
                            {{-- ================================================== --}}

                            <div class="p-6 border-b border-slate-100">
                                <form action="{{ route('menu.settings.update') }}" method="POST">
                                    @csrf
                                    @method ('PUT')

                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                                        {{-- JUDUL SECTION --}}
                                        <div>
                                            <label for="packageTitle"
                                                class="block text-sm font-semibold text-slate-700 mb-2">
                                                Judul Section
                                            </label>

                                            <input id="packageTitle" type="text" name="package_title"
                                                value="{{ old('package_title', $menuSetting->package_title ?? 'Paket & Layanan') }}"
                                                placeholder="Contoh: Paket & Layanan"
                                                class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                                        </div>

                                        {{-- DESKRIPSI SECTION --}}
                                        <div>
                                            <label for="packageDescription"
                                                class="block text-sm font-semibold text-slate-700 mb-2">
                                                Deskripsi Section
                                            </label>

                                            <textarea id="packageDescription" name="package_description" rows="3"
                                                placeholder="Masukkan deskripsi section..."
                                                class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none resize-y focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">{{ old('package_description', $menuSetting->package_description ?? '') }}</textarea
                                            >
                                        </div>
                                    </div>

                                    {{-- TOMBOL SIMPAN SECTION --}}
                                    <div class="flex justify-end mt-5">
                                        <button
                                            type="submit"
                                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-sm transition"
                                        >
                                            <i
                                                data-lucide="save"
                                                class="w-4 h-4"
                                            ></i>

                                            Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>

                            {{-- ================================================== --}}
                            {{-- PACKAGE MENU --}}
                            {{-- ================================================== --}}

                            <div class="p-6 border-b border-slate-100">
                                <form
                                    action="{{ route('menu.settings.update') }}"
                                    method="POST"
                                    enctype="multipart/form-data"
                                >
                                    @csrf
                                    @method ('PUT')

                                    <div
                                        class="border border-slate-200 rounded-2xl p-5 bg-white"
                                    >
                                        <div
                                            class="grid grid-cols-1 lg:grid-cols-[180px_1fr] gap-6"
                                        >
                                            {{-- ================= IKON ================= --}}
                                            <div>
                                                <p
                                                    class="block text-sm font-semibold text-slate-700 mb-3"
                                                >
                                                    Ikon
                                                </p>

                                                {{-- PREVIEW --}}
                                                <div
                                                    class="relative w-32 h-32 rounded-2xl border border-slate-200 bg-slate-50 flex items-center justify-center overflow-hidden mb-4"
                                                >
                                                    @if (!empty($menuSetting->package_menu_icon))
<img
                                                            id="packageMenuIconPreview"
                                                           src="{{ asset('storage/' . ltrim(preg_replace('#^/?storage/#', '', $menuSetting->package_menu_icon), '/')) }}"
                                                            alt="Preview Ikon Package Menu"
                                                            class="w-full h-full object-contain p-5"
                                                        />
@else
<img
                                                            id="packageMenuIconPreview"
                                                            src=""
                                                            alt="Preview Ikon Package Menu"
                                                            class="hidden w-full h-full object-contain p-5"
                                                        />
@endif
                                                </div>

                                                {{-- UPLOAD --}}
                                                <input
                                                    type="file"
                                                    name="package_menu_icon_file"
                                                    accept=".jpg,.jpeg,.png,.webp,.svg"
                                                    onchange="
                                                        previewPackageMenuIcon(
                                                            this,
                                                        )
                                                    "
                                                    class="block w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-600 file:font-semibold hover:file:bg-indigo-100"
                                                / aria-label="Upload ikon Package Menu">
                                            </div>

                                            {{-- ================= KONTEN ================= --}}
                                            <div class="space-y-4">
                                                {{-- JUDUL --}}
                                                <div>
                                                    <label for="packageMenuTitle"
                                                        class="block text-sm font-semibold text-slate-700 mb-2"
                                                    >
                                                        Judul
                                                    </label>

                                                    <input id="packageMenuTitle"
                                                        type="text"
                                                        name="package_menu_title"
                                                        value="{{ old('package_menu_title', $menuSetting->package_menu_title ?? 'Package Menu') }}"
                                                        placeholder="Package Menu"
                                                        class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                                    />
                                                </div>

                                                {{-- DESKRIPSI --}}
                                                <div>
                                                    <label for="packageMenuDescription"
                                                        class="block text-sm font-semibold text-slate-700 mb-2"
                                                    >
                                                        Deskripsi
                                                    </label>

                                                    <textarea id="packageMenuDescription"
                                                        name="package_menu_description"
                                                        rows="4"
                                                        placeholder="Masukkan deskripsi..."
                                                        class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none resize-y focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                                        >{{ old('package_menu_description', $menuSetting->package_menu_description ?? '') }}</textarea
                                                    >
                                                </div>
                                            </div>
                                        </div>

                                        {{-- UPDATE --}}
                                        <div class="flex justify-end mt-5">
                                            <button
                                                type="submit"
                                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-sm transition"
                                            >
                                                <i
                                                    data-lucide="save"
                                                    class="w-4 h-4"
                                                ></i>

                                                Update
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- ================================================== --}}
                            {{-- BOX PACKAGE --}}
                            {{-- ================================================== --}}

                            <div class="p-6 border-b border-slate-100">
                                <form
                                    action="{{ route('menu.settings.update') }}"
                                    method="POST"
                                    enctype="multipart/form-data"
                                >
                                    @csrf
                                    @method ('PUT')

                                    <div
                                        class="border border-slate-200 rounded-2xl p-5 bg-white"
                                    >
                                        <div
                                            class="grid grid-cols-1 lg:grid-cols-[180px_1fr] gap-6"
                                        >
                                            {{-- ================= IKON ================= --}}
                                            <div>
                                                <p
                                                    class="block text-sm font-semibold text-slate-700 mb-3"
                                                >
                                                    Ikon
                                                </p>

                                                {{-- PREVIEW --}}
                                                <div
                                                    class="relative w-32 h-32 rounded-2xl border border-slate-200 bg-slate-50 flex items-center justify-center overflow-hidden mb-4"
                                                >
                                                    @if (!empty($menuSetting->box_package_icon))
<img
                                                            id="boxPackageIconPreview"
                                                            src="{{ asset('storage/' . ltrim(preg_replace('#^/?storage/#', '', $menuSetting->box_package_icon), '/')) }}"
                                                            alt="Preview Ikon Box Package"
                                                            class="w-full h-full object-contain p-5"
                                                        />
@else
<img
                                                            id="boxPackageIconPreview"
                                                            src=""
                                                            alt="Preview Ikon Box Package"
                                                            class="hidden w-full h-full object-contain p-5"
                                                        />
@endif
                                                </div>

                                                {{-- UPLOAD --}}
                                                <input
                                                    type="file"
                                                    name="box_package_icon_file"
                                                    accept=".jpg,.jpeg,.png,.webp,.svg"
                                                    onchange="
                                                        previewBoxPackageIcon(
                                                            this,
                                                        )
                                                    "
                                                    class="block w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-600 file:font-semibold hover:file:bg-indigo-100"
                                                / aria-label="Upload ikon Box Package">

                                            </div>

                                            {{-- ================= KONTEN ================= --}}
                                            <div class="space-y-4">
                                                {{-- JUDUL --}}
                                                <div>
                                                    <label for="boxPackageTitle"
                                                        class="block text-sm font-semibold text-slate-700 mb-2"
                                                    >
                                                        Judul
                                                    </label>

                                                    <input id="boxPackageTitle"
                                                        type="text"
                                                        name="box_package_title"
                                                        value="{{ old('box_package_title', $menuSetting->box_package_title ?? 'Box Package') }}"
                                                        placeholder="Box Package"
                                                        class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                                    />
                                                </div>

                                                {{-- DESKRIPSI --}}
                                                <div>
                                                    <label for="boxPackageDescription"
                                                        class="block text-sm font-semibold text-slate-700 mb-2"
                                                    >
                                                        Deskripsi
                                                    </label>

                                                    <textarea id="boxPackageDescription"
                                                        name="box_package_description"
                                                        rows="4"
                                                        placeholder="Masukkan deskripsi..."
                                                        class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none resize-y focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                                        >{{ old('box_package_description', $menuSetting->box_package_description ?? '') }}</textarea
                                                    >
                                                </div>
                                            </div>
                                        </div>

                                        {{-- UPDATE --}}
                                        <div class="flex justify-end mt-5">
                                            <button
                                                type="submit"
                                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-sm transition"
                                            >
                                                <i
                                                    data-lucide="save"
                                                    class="w-4 h-4"
                                                ></i>

                                                Update
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- ================================================== --}}
                            {{-- WEDDING PACKAGE --}}
                            {{-- ================================================== --}}

                            <div class="p-6">
                                <form
                                    action="{{ route('menu.settings.update') }}"
                                    method="POST"
                                    enctype="multipart/form-data"
                                >
                                    @csrf
                                    @method ('PUT')

                                    <div
                                        class="border border-slate-200 rounded-2xl p-5 bg-white"
                                    >
                                        <div
                                            class="grid grid-cols-1 lg:grid-cols-[180px_1fr] gap-6"
                                        >
                                            {{-- ================= IKON ================= --}}
                                            <div>
                                                <p
                                                    class="block text-sm font-semibold text-slate-700 mb-3"
                                                >
                                                    Ikon
                                                </p>

                                                {{-- PREVIEW --}}
                                                <div
                                                    class="relative w-32 h-32 rounded-2xl border border-slate-200 bg-slate-50 flex items-center justify-center overflow-hidden mb-4"
                                                >
                                                    @if (!empty($menuSetting->wedding_package_icon))
<img
                                                            id="weddingPackageIconPreview"
                                                            src="{{ asset('storage/' . ltrim(preg_replace('#^/?storage/#', '', $menuSetting->wedding_package_icon), '/')) }}"
                                                            alt="Preview Ikon Wedding Package"
                                                            class="w-full h-full object-contain p-5"
                                                        />
@else
<img
                                                            id="weddingPackageIconPreview"
                                                            src=""
                                                            alt="Preview Ikon Wedding Package"
                                                            class="hidden w-full h-full object-contain p-5"
                                                        />
@endif
                                                </div>

                                                {{-- UPLOAD --}}
                                                <input
                                                    type="file"
                                                    name="wedding_package_icon_file"
                                                    accept=".jpg,.jpeg,.png,.webp,.svg"
                                                    onchange="
                                                        previewWeddingPackageIcon(
                                                            this,
                                                        )
                                                    "
                                                    class="block w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-600 file:font-semibold hover:file:bg-indigo-100"
                                                / aria-label="Upload ikon Wedding Package">

                                            </div>

                                            {{-- ================= KONTEN ================= --}}
                                            <div class="space-y-4">
                                                {{-- JUDUL --}}
                                                <div>
                                                    <label for="weddingPackageTitle"
                                                        class="block text-sm font-semibold text-slate-700 mb-2"
                                                    >
                                                        Judul
                                                    </label>

                                                    <input id="weddingPackageTitle"
                                                        type="text"
                                                        name="wedding_package_title"
                                                        value="{{ old('wedding_package_title', $menuSetting->wedding_package_title ?? 'Wedding Package') }}"
                                                        placeholder="Wedding Package"
                                                        class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                                    />
                                                </div>

                                                {{-- DESKRIPSI --}}
                                                <div>
                                                    <label for="weddingPackageDescription"
                                                        class="block text-sm font-semibold text-slate-700 mb-2"
                                                    >
                                                        Deskripsi
                                                    </label>

                                                    <textarea id="weddingPackageDescription"
                                                        name="wedding_package_description"
                                                        rows="4"
                                                        placeholder="Masukkan deskripsi..."
                                                        class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none resize-y focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                                        >{{ old('wedding_package_description', $menuSetting->wedding_package_description ?? '') }}</textarea
                                                    >
                                                </div>
                                            </div>
                                        </div>

                                        {{-- UPDATE --}}
                                        <div class="flex justify-end mt-5">
                                            <button
                                                type="submit"
                                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-sm transition"
                                            >
                                                <i
                                                    data-lucide="save"
                                                    class="w-4 h-4"
                                                ></i>

                                                Update
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SEARCH + FILTER --}}
            <div class="px-4 md:px-6 pt-4">
                <div
                    class="bg-white border border-slate-200 rounded-2xl p-4 mb-5"
                >
                    <div class="flex flex-col md:flex-row gap-3">
                        {{-- SEARCH --}}
                        <div class="relative flex-1">
                            <i
                                data-lucide="search"
                                class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"
                            >
                            </i>

                            <input
                                type="text"
                                id="searchMenu"
                                placeholder="Cari nama menu..."
                                oninput="filterMenus()"
                                class="w-full h-12 pl-12 pr-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                            />
                        </div>

                        {{-- FILTER --}}
                        <div class="relative md:w-64">
                            <select
                                id="categoryFilter"
                                onchange="filterMenus()"
                                class="appearance-none w-full h-12 px-4 pr-10 border border-slate-200 rounded-xl bg-white outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                            >
                                <option value="all">Semua Kategori</option>
                                <option value="makanan">Makanan</option>
                                <option value="minuman">Minuman</option>
                                <option value="snack">Snack</option>
                                <option value="recommended">Rekomendasi</option>
                            </select>

                            <i
                                data-lucide="chevron-down"
                                class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500 pointer-events-none"
                            >
                            </i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="px-4 md:px-6">
                <div
                    class="bg-white border border-slate-200 rounded-2xl overflow-hidden"
                >
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[950px] table-auto">
                            <thead
                                class="bg-slate-50 border-b border-slate-200"
                            >
                                <tr>
                                    <th
                                        class="text-left px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide"
                                    >
                                        Foto
                                    </th>

                                    <th
                                        class="text-left px-4 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide"
                                    >
                                        Nama Menu
                                    </th>

                                    <th
                                        class="text-left px-4 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide"
                                    >
                                        Deskripsi
                                    </th>

                                    <th
                                        class="text-left px-4 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide"
                                    >
                                        Harga
                                    </th>

                                    <th
                                        class="text-left px-4 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide"
                                    >
                                        Kategori
                                    </th>

                                    <th
                                        class="text-center px-4 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide"
                                    >
                                        Rekomendasi
                                    </th>

                                    <th
                                        class="text-center px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide"
                                    >
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody id="menuTable">
                                @forelse ($menus as $menu)
<tr
                                        class="menu-row border-b border-slate-100 hover:bg-slate-50 transition"
                                        data-name="{{ strtolower($menu->title) }}"
                                        data-category="{{ $menu->category }}"
                                        data-recommended="{{ $menu->is_recommended ? '1' : '0' }}"
                                    >
                                        {{-- FOTO --}}
                                        <td class="px-6 py-4">
                                            @php
                                                $imagePath = $menu->image_path ?? '';

                                                if (\Illuminate\Support\Str::startsWith($imagePath, 'storage/')) {
                                                    $imageUrl = asset($imagePath);
                                                } else {
                                                    $imageUrl = asset(
                                                        'storage/' .
                                                            ltrim(preg_replace('#^/?storage/#', '', $imagePath), '/'),
                                                    );
                                                }
                                            @endphp

                                            <div
                                                class="w-16 h-16 rounded-xl overflow-hidden border border-slate-200 bg-slate-50"
                                            >
                                                @if ($imagePath)
<img
                                                        src="{{ $imageUrl }}"
                                                        alt="{{ $menu->title }}"
                                                        class="w-full h-full object-cover"
                                                        onerror="
                                                            this.style.display =
                                                                'none';
                                                            this.parentElement.innerHTML =
                                                                '<div class=&quot;w-full h-full flex items-center justify-center text-slate-400 text-xs text-center px-2&quot;>Gambar tidak tersedia</div>';
                                                        "
                                                    />
@else
<div
                                                        class="w-full h-full flex items-center justify-center text-slate-400"
                                                    >
                                                        <i
                                                            data-lucide="image"
                                                            class="w-6 h-6"
                                                        ></i>
                                                    </div>
@endif
                                            </div>
                                        </td>

                                        {{-- NAMA --}}
                                        <td class="px-4 py-4">
                                            <div
                                                class="font-semibold text-slate-800"
                                            >
                                                {{ $menu->title }}
                                            </div>
                                        </td>

                                        {{-- DESKRIPSI --}}
                                        <td class="px-4 py-4 max-w-md">
                                            <div
                                                class="text-sm text-slate-500 leading-6 line-clamp-2"
                                            >
                                                {{ $menu->description }}
                                            </div>
                                        </td>

                                        {{-- HARGA --}}
                                        <td class="px-4 py-4">
                                            <span
                                                class="font-semibold text-slate-700"
                                            >
                                                Rp {{ number_format($menu->price ?? 0, 0, ',', '.') }}
                                            </span>
                                        </td>

                                        {{-- KATEGORI --}}
                                        <td class="px-4 py-4">
                                            @php
                                                $categoryLabel = [
                                                    'makanan' => 'Makanan',
                                                    'minuman' => 'Minuman',
                                                    'snack' => 'Snack',
                                                ];
                                            @endphp

                                            <span
                                                class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-600"
                                            >
                                                {{ $categoryLabel[$menu->category] ?? $menu->category }}
                                            </span>
                                        </td>

                                        {{-- REKOMENDASI --}}
                                        <td class="px-4 py-4 text-center">
                                            @if ($menu->is_recommended)
<span
                                                class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600"
                                            >
                                                <i
                                                    data-lucide="check"
                                                    class="w-4 h-4"
                                                >
                                                </i>
                                            </span>
@else
<span
                                                class="text-slate-300 text-sm"
                                            >
                                                —
                                            </span>
@endif
                                        </td>

                                        {{-- AKSI --}}
                                        <td class="px-6 py-4">
                                            <div
                                                class="flex items-center justify-center gap-2"
                                            >
                                                {{-- UPDATE --}}
                                                <button
                                                    type="button"
                                                    onclick="openUpdateModal({{ $menu->id }})"
                                                    title="Update Menu"
                                                    class="w-9 h-9 flex items-center justify-center rounded-lg text-indigo-600 hover:bg-indigo-50 transition"
                                                >
                                                    <i
                                                        data-lucide="pencil"
                                                        class="w-4.5 h-4.5"
                                                    ></i>
                                                </button>

                                                {{-- HAPUS --}}
                                                <form
                                                    action="{{ route('menu.destroy', $menu->id) }}"
                                                    method="POST"
                                                    onsubmit="
                                                        return confirm(
                                                            'Yakin ingin menghapus menu ini?',
                                                        );
                                                    "
                                                >
                                                    @csrf
                                                    @method ('DELETE')

                                                    <button
                                                        type="submit"
                                                        title="Hapus Menu"
                                                        class="w-9 h-9 flex items-center justify-center rounded-lg text-red-500 hover:bg-red-50 transition"
                                                    >
                                                        <i
                                                            data-lucide="trash-2"
                                                            class="w-4.5 h-4.5"
                                                        >
                                                        </i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    @empty
                                    <tr>
                                        <td
                                            colspan="7"
                                            class="px-6 py-8 text-center text-slate-400"
                                        >
                                            Belum ada menu.
                                        </td>
                                    </tr>
@endforelse
                                    {{-- HASIL PENCARIAN / FILTER KOSONG --}}
                                    <tr id="noMenuResult" class="hidden">
                                        <td
                                            colspan="7"
                                            class="px-6 py-8 text-center text-slate-500"
                                        >
                                            Tidak ada menu terkait.
                                        </td>
                                    </tr>
                                    </tbody>
                                    </table>
                                    </div>
                                    </div>
                                    </div>
                                    </main>
                                    </div>

                                    {{-- ====================================================== --}}
                                    {{-- MODAL TAMBAH MENU --}}
                                    {{-- ====================================================== --}}

                                    <div
                                        id="addModal"
                                        class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm items-center justify-center p-4"
                                    >
                                        <div
                                            class="bg-white w-full max-w-3xl max-h-[90vh] rounded-2xl shadow-xl overflow-y-auto"
                                        >
                                            <div
                                                class="flex items-center justify-between px-6 py-5 border-b border-slate-100"
                                            >
                                                <h2 class="text-lg font-bold">
                                                    Tambah Menu
                                                </h2>

                                                <button
                                                    type="button"
                                                    onclick="closeAddModal()"
                                                    class="text-slate-400 hover:text-slate-600"
                                                >
                                                    <i
                                                        data-lucide="x"
                                                        class="w-5 h-5"
                                                    ></i>
                                                </button>
                                            </div>

                                            <form
                                                action="{{ route('menu.store') }}"
                                                method="POST"
                                                enctype="multipart/form-data"
                                            >
                                                @csrf

                                                <div class="p-6 space-y-5">
                                                    {{-- FOTO MENU --}}
                                                    <div>
                                                        <p
                                                            class="block text-sm font-medium mb-3"
                                                        >
                                                            Foto Menu
                                                        </p>

                                                        <div
                                                            class="grid grid-cols-1 sm:grid-cols-[220px_1fr] gap-7 items-start"
                                                        >
                                                            {{-- PREVIEW SELALU TERSEDIA --}}
                                                            <div
                                                                class="w-[220px] aspect-[4/3] mx-auto sm:mx-0 rounded-xl overflow-hidden border border-slate-200 bg-slate-50 flex items-center justify-center"
                                                            >
                                                                <span
                                                                    id="addPreviewText"
                                                                    class="text-xs text-slate-400 text-center px-4"
                                                                >
                                                                    Preview Foto
                                                                </span>
                                                                <img
                                                                    id="addPreviewImage"
                                                                    src=""
                                                                    alt="Preview Foto"
                                                                    class="hidden w-full h-full object-cover"
                                                                />
                                                            </div>

                                                            <div
                                                                class="space-y-4"
                                                            >
                                                                <div>
                                                                    <label for="addImageFile"
                                                                        class="block text-sm font-medium mb-2"
                                                                    >
                                                                        Upload Foto (JPG/PNG/WebP, maks 2MB)
                                                                    </label>
                                                                    <input
                                                                        type="file"
                                                                        name="image_file"
                                                                        id="addImageFile"
                                                                        accept=".jpg,.jpeg,.png,.webp"
                                                                        required
                                                                        onchange="
                                                                            handleAddMenuFile()
                                                                        "
                                                                        class="block w-full text-sm text-slate-500 border border-slate-200 rounded-xl cursor-pointer bg-white file:mr-3 file:py-2.5 file:px-3 file:border-0 file:bg-slate-100 file:text-slate-700 file:font-medium"
                                                                    />
                                                                    <p id="addImageSizeMessage" class="hidden mt-2 text-xs text-red-500">
                                                                        Ukuran file lebih dari 2 MB. Pilih foto maksimal 2 MB.
                                                                    </p>
                                                                    <p class="text-xs text-slate-400 mt-2">
                                                                        Pilih foto maksimal 2 MB. Preview berubah setelah file dipilih.
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- NAMA --}}
                                                    <div>
                                                        <label for="addMenuTitle"
                                                            class="block text-sm font-medium mb-2"
                                                        >
                                                            Nama Menu
                                                        </label>

                                                        <input id="addMenuTitle"
                                                            type="text"
                                                            name="title"
                                                            required
                                                            placeholder="Contoh: Bebek Goreng"
                                                            class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500"
                                                        />
                                                    </div>

                                                    {{-- DESKRIPSI --}}
                                                    <div>
                                                        <label for="addMenuDescription"
                                                            class="block text-sm font-medium mb-2"
                                                        >
                                                            Deskripsi
                                                        </label>

                                                        <textarea id="addMenuDescription"
                                                            name="description"
                                                            rows="4"
                                                            placeholder="Masukkan deskripsi menu..."
                                                            class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none resize-none focus:border-indigo-500"
                                                        ></textarea>
                                        </div>

                                        {{-- REKOMENDASI --}}
                                        <div class="flex items-center justify-between py-1">
                                            <div>
                                                <p class="text-sm font-medium text-slate-700">Menu Rekomendasi</p>

                                                <p class="text-xs text-slate-400 mt-1">Tampilkan menu ini sebagai
                                                    rekomendasi.</p>
                                            </div>

                                            <label for="addRecommended"
                                                class="relative inline-flex items-center cursor-pointer">
                                                <input type="hidden" name="is_recommended" value="0" />

                                                <input type="checkbox" name="is_recommended" value="1"
                                                    id="addRecommended"
                                                    aria-label="Tampilkan sebagai menu rekomendasi"
                                                    class="sr-only peer" />

                                                <div
                                                    class="w-12 h-6 bg-slate-200 rounded-full peer-checked:bg-indigo-600 transition-colors duration-200 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-6">
                                                </div>
                                            </label>
                                        </div>

                                        {{-- HARGA --}}
                                        <div>
                                            <label for="addPrice" class="block text-sm font-medium mb-2">
                                                Harga
                                            </label>

                                            <div class="relative">
                                                <span
                                                    class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-slate-500">
                                                    Rp
                                                </span>

                                                <input type="number" name="price" id="addPrice" required
                                                    min="0" step="100" placeholder="38000"
                                                    class="w-full h-11 pl-12 pr-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                                            </div>
                                        </div>

                                        {{-- KATEGORI --}}
                                        <div>
                                            <label for="addCategory" class="block text-sm font-medium mb-2">
                                                Kategori
                                            </label>

                                            <select id="addCategory" name="category" required
                                                class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none">
                                                <option value="makanan">
                                                    Makanan
                                                </option>
                                                <option value="minuman">
                                                    Minuman
                                                </option>
                                                <option value="snack">
                                                    Snack
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="flex justify-end gap-3 px-6 py-5 border-t border-slate-100">
                                        <button type="button"
                                            onclick="
                                                            closeAddModal()
                                                        "
                                            class="px-5 py-2.5 rounded-xl border border-slate-200">
                                            Batal
                                        </button>

                                        <button type="submit"
                                            class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white">
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- ====================================================== --}}
                        {{-- MODAL UPDATE --}}
                        {{-- ====================================================== --}}

                        <div id="updateModal"
                            class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm items-center justify-center p-4">
                            <div class="bg-white w-full max-w-3xl max-h-[90vh] rounded-2xl shadow-xl overflow-y-auto">
                                <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
                                    <h2 class="text-lg font-bold">
                                        Update Menu
                                    </h2>

                                    <button type="button" onclick="closeUpdateModal()"
                                        class="text-slate-400 hover:text-slate-600">
                                        <i data-lucide="x" class="w-5 h-5"></i>
                                    </button>
                                </div>

                                <form id="updateForm" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method ('PUT')

                                    <div class="p-6 space-y-5">
                                        {{-- FOTO MENU --}}
                                        <div>
                                            <p class="block text-sm font-medium mb-3">
                                                Foto Menu
                                            </p>

                                            <div class="grid grid-cols-1 sm:grid-cols-[220px_1fr] gap-7 items-start">
                                                {{-- PREVIEW SELALU TERSEDIA --}}
                                                <div
                                                    class="w-[220px] aspect-[4/3] mx-auto sm:mx-0 rounded-xl overflow-hidden border border-slate-200 bg-slate-50 flex items-center justify-center">
                                                    <span id="updatePreviewText"
                                                        class="hidden text-xs text-slate-400 text-center px-4">
                                                        Preview Foto
                                                    </span>
                                                    <img id="updatePreviewImage" src="" alt="Preview Foto"
                                                        class="w-full h-full object-cover" />
                                                </div>

                                                <div class="space-y-4">
                                                    <div>
                                                        <label for="updateImageFile"
                                                            class="block text-sm font-medium mb-2">
                                                            Upload Foto (JPG/PNG/WebP, maks 2MB)
                                                        </label>
                                                        <input type="file" name="image_file" id="updateImageFile"
                                                            accept=".jpg,.jpeg,.png,.webp"
                                                            onchange="
                                                                            handleUpdateMenuFile()
                                                                        "
                                                            class="block w-full text-sm text-slate-500 border border-slate-200 rounded-xl cursor-pointer bg-white file:mr-3 file:py-2.5 file:px-3 file:border-0 file:bg-slate-100 file:text-slate-700 file:font-medium" />
                                                        <p id="updateImageSizeMessage"
                                                            class="hidden mt-2 text-xs text-red-500">
                                                            Ukuran file lebih dari 2 MB. Pilih foto maksimal 2 MB.
                                                        </p>
                                                        <p class="text-xs text-slate-400 mt-2">
                                                            Pilih foto maksimal 2 MB. Preview berubah setelah file
                                                            dipilih.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- NAMA --}}
                                        <div>
                                            <label for="updateTitle" class="block text-sm font-medium mb-2">
                                                Nama Menu
                                            </label>

                                            <input type="text" name="title" id="updateTitle" required
                                                class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500" />
                                        </div>

                                        {{-- DESKRIPSI --}}
                                        <div>
                                            <label for="updateDescription" class="block text-sm font-medium mb-2">
                                                Deskripsi
                                            </label>

                                            <textarea name="description" id="updateDescription" rows="6"
                                                class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none resize-y focus:border-indigo-500"></textarea>
                                        </div>

                                        {{-- REKOMENDASI --}}
                                        <div class="flex items-center justify-between py-1">
                                            <div>
                                                <p class="text-sm font-medium text-slate-700">Menu Rekomendasi</p>

                                                <p class="text-xs text-slate-400 mt-1">Tampilkan menu ini sebagai
                                                    rekomendasi.</p>
                                            </div>

                                            <label for="updateRecommended"
                                                class="relative inline-flex items-center cursor-pointer">
                                                <input type="hidden" name="is_recommended" value="0" />

                                                <input type="checkbox" name="is_recommended" value="1"
                                                    aria-label="Tampilkan sebagai menu rekomendasi"
                                                    id="updateRecommended" class="sr-only peer" />

                                                <div
                                                    class="w-12 h-6 bg-slate-200 rounded-full peer-checked:bg-indigo-600 transition-colors duration-200 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-6">
                                                </div>
                                            </label>
                                        </div>

                                        {{-- HARGA --}}
                                        <div>
                                            <label for="updatePrice" class="block text-sm font-medium mb-2">
                                                Harga
                                            </label>

                                            <div class="relative">
                                                <span
                                                    class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-slate-500">
                                                    Rp
                                                </span>

                                                <input type="number" name="price" id="updatePrice" required
                                                    min="0" step="100" placeholder="38000"
                                                    class="w-full h-11 pl-12 pr-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                                            </div>
                                        </div>

                                        {{-- KATEGORI --}}
                                        <div>
                                            <label for="updateCategory" class="block text-sm font-medium mb-2">
                                                Kategori
                                            </label>

                                            <select name="category" id="updateCategory" required
                                                class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none">
                                                <option value="makanan">
                                                    Makanan
                                                </option>
                                                <option value="minuman">
                                                    Minuman
                                                </option>
                                                <option value="snack">
                                                    Snack
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="flex justify-end gap-3 px-6 py-5 border-t border-slate-100">
                                        <button type="button"
                                            onclick="
                                                            closeUpdateModal()
                                                        "
                                            class="px-5 py-2.5 rounded-xl border border-slate-200">
                                            Batal
                                        </button>

                                        <button type="submit"
                                            class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white">
                                            Update
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- JAVASCRIPT --}}
                        <script>
                            lucide.createIcons();

                            /* ==============================
                               SEARCH + FILTER
                            ============================== */

                            function filterMenus() {
                                const searchInput = document.getElementById("searchMenu");
                                const categoryInput = document.getElementById("categoryFilter");

                                const tableBody = document.getElementById("menuTable");
                                const noResult = document.getElementById("noMenuResult");

                                if (!searchInput || !categoryInput || !tableBody || !noResult) {
                                    return;
                                }

                                const search = searchInput.value.toLowerCase().trim();

                                const filter = categoryInput.value;

                                const rows = tableBody.querySelectorAll(".menu-row");

                                let visibleCount = 0;

                                rows.forEach((row) => {
                                    const name = row.dataset.name || "";
                                    const category = row.dataset.category || "";
                                    const recommended = row.dataset.recommended || "0";

                                    const matchSearch = name.includes(search);

                                    let matchFilter = true;

                                    if (filter !== "all") {
                                        if (filter === "recommended") {
                                            matchFilter = recommended === "1";
                                        } else {
                                            matchFilter = category === filter;
                                        }
                                    }

                                    const showRow = matchSearch && matchFilter;

                                    row.style.display = showRow ? "" : "none";

                                    if (showRow) {
                                        visibleCount++;
                                    }
                                });

                                /*
                                |--------------------------------------------------------------------------
                                | TIDAK ADA HASIL
                                |--------------------------------------------------------------------------
                                |
                                | Kalau database punya menu tetapi hasil pencarian/filter = 0,
                                | tampilkan satu baris pesan di dalam tabel.
                                |
                                */
                                if (rows.length > 0 && visibleCount === 0) {
                                    noResult.classList.remove("hidden");
                                } else {
                                    noResult.classList.add("hidden");
                                }

                                lucide.createIcons();
                            }

                            // Simpan kategori yang sedang dipilih saat form edit menu dikirim.
                            const updateMenuForm = document.getElementById("updateForm");
                            const menuCategoryFilter = document.getElementById("categoryFilter");

                            if (updateMenuForm && menuCategoryFilter) {
                                updateMenuForm.addEventListener("submit", function() {
                                    sessionStorage.setItem(
                                        "menuCategoryFilterAfterUpdate",
                                        menuCategoryFilter.value
                                    );
                                });
                            }

                            // Kembalikan kategori setelah halaman selesai di-refresh/redirect.
                            const savedMenuCategoryFilter = sessionStorage.getItem(
                                "menuCategoryFilterAfterUpdate"
                            );

                            if (savedMenuCategoryFilter && menuCategoryFilter) {
                                menuCategoryFilter.value = savedMenuCategoryFilter;
                                sessionStorage.removeItem("menuCategoryFilterAfterUpdate");
                                filterMenus();
                            }

                            /* ==============================
                               TAMBAH
                            ============================== */

                            function openAddModal() {
                                const modal = document.getElementById("addModal");

                                modal.classList.remove("hidden");
                                modal.classList.add("flex");
                            }

                            function closeAddModal() {
                                const modal = document.getElementById("addModal");

                                modal.classList.add("hidden");
                                modal.classList.remove("flex");
                            }

                            /* ==============================
                               PREVIEW TAMBAH
                            ============================== */

                            function handleAddMenuFile() {
                                const fileInput = document.getElementById("addImageFile");
                                const image = document.getElementById("addPreviewImage");
                                const text = document.getElementById("addPreviewText");
                                const message = document.getElementById("addImageSizeMessage");
                                const file = fileInput.files[0];

                                if (!file) return;

                                if (file.size > 2 * 1024 * 1024) {
                                    fileInput.value = "";
                                    message.classList.remove("hidden");
                                    image.src = "";
                                    image.classList.add("hidden");
                                    text.classList.remove("hidden");
                                    return;
                                }

                                message.classList.add("hidden");

                                const reader = new FileReader();
                                reader.onload = function(event) {
                                    image.src = event.target.result;
                                    image.classList.remove("hidden");
                                    text.classList.add("hidden");
                                };
                                reader.readAsDataURL(file);
                            }

                            /* ==============================
                               UPDATE
                            ============================== */

                            function openUpdateModal(menuId) {
                                const modal = document.getElementById("updateModal");

                                const form = document.getElementById("updateForm");

                                if (!modal || !form) {
                                    return;
                                }

                                const menus = @json ($menus);

                                const menu = menus.find((item) => Number(item.id) === Number(menuId));

                                if (!menu) {
                                    return;
                                }

                                form.action = `/dashboard/menu/${menu.id}`;

                                document.getElementById("updateTitle").value = menu.title ?? "";

                                document.getElementById("updateDescription").value = menu.description ?? "";

                                document.getElementById("updatePrice").value =
                                    menu.price != null ? Math.round(Number(menu.price)) : "";

                                document.getElementById("updateCategory").value =
                                    menu.category ?? "makanan";

                                document.getElementById("updateRecommended").checked =
                                    menu.is_recommended == 1;

                                const updateImageFile = document.getElementById("updateImageFile");
                                const updatePreviewImage = document.getElementById("updatePreviewImage");
                                const updatePreviewText = document.getElementById("updatePreviewText");
                                const updateImageSizeMessage = document.getElementById(
                                    "updateImageSizeMessage",
                                );

                                updateImageFile.value = "";
                                updateImageSizeMessage.classList.add("hidden");

                                if (menu.image_path) {
                                    const imagePath = String(menu.image_path);

                                    const cleanPath = imagePath
                                        .replace(/^\/?storage\//, "")
                                        .replace(/^public\/storage\//, "")
                                        .replace(/^public\//, "")
                                        .replace(/^\/+/, "");
                                    updatePreviewImage.src = "/storage/" + cleanPath;

                                    updatePreviewImage.classList.remove("hidden");
                                    updatePreviewText.classList.add("hidden");
                                } else {
                                    updatePreviewImage.src = "";
                                    updatePreviewImage.classList.add("hidden");
                                    updatePreviewText.classList.remove("hidden");
                                }

                                modal.classList.remove("hidden");
                                modal.classList.add("flex");
                            }

                            function closeUpdateModal() {
                                const modal = document.getElementById("updateModal");

                                modal.classList.add("hidden");
                                modal.classList.remove("flex");
                            }

                            function handleUpdateMenuFile() {
                                const fileInput = document.getElementById("updateImageFile");
                                const image = document.getElementById("updatePreviewImage");
                                const text = document.getElementById("updatePreviewText");
                                const message = document.getElementById("updateImageSizeMessage");
                                const file = fileInput.files[0];

                                if (!file) return;

                                if (file.size > 2 * 1024 * 1024) {
                                    fileInput.value = "";
                                    message.classList.remove("hidden");
                                    return;
                                }

                                message.classList.add("hidden");

                                const reader = new FileReader();
                                reader.onload = function(event) {
                                    image.src = event.target.result;
                                    image.classList.remove("hidden");
                                    text.classList.add("hidden");
                                };
                                reader.readAsDataURL(file);
                            }

                            /* ==================================================
                               PREVIEW IKON PAKET & LAYANAN
                               ================================================== */

                            function previewIconFile(input, previewId) {
                                const preview = document.getElementById(previewId);

                                if (!preview) {
                                    return;
                                }

                                if (!input.files || !input.files[0]) {
                                    return;
                                }

                                const file = input.files[0];

                                const reader = new FileReader();

                                reader.onload = function(event) {
                                    preview.src = event.target.result;
                                    preview.classList.remove("hidden");
                                };

                                reader.readAsDataURL(file);
                            }

                            /* ==================================================
                               PACKAGE MENU
                               ================================================== */

                            function previewPackageMenuIcon(input) {
                                previewIconFile(input, "packageMenuIconPreview");
                            }


                            /* ==================================================
                               BOX PACKAGE
                               ================================================== */

                            function previewBoxPackageIcon(input) {
                                previewIconFile(input, "boxPackageIconPreview");
                            }

                            /* ==================================================
                               WEDDING PACKAGE
                               ================================================== */

                            function previewWeddingPackageIcon(input) {
                                previewIconFile(input, "weddingPackageIconPreview");
                            }


                            function previewHeroImageFile(input) {
                                const image = document.getElementById("heroImagePreview");
                                const empty = document.getElementById("heroImageEmpty");
                                const message = document.getElementById("heroImageSizeMessage");
                                const file = input.files && input.files[0];

                                if (!image || !empty || !message || !file) return;

                                if (file.size > 2 * 1024 * 1024) {
                                    input.value = "";
                                    message.classList.remove("hidden");
                                    return;
                                }

                                message.classList.add("hidden");
                                const reader = new FileReader();
                                reader.onload = function(event) {
                                    image.src = event.target.result;
                                    image.classList.remove("hidden");
                                    empty.classList.add("hidden");
                                };
                                reader.readAsDataURL(file);
                            }

                            function toggleMenuSetting(contentId, arrowId) {
                                const content = document.getElementById(contentId);
                                const arrow = document.getElementById(arrowId);

                                if (!content || !arrow) {
                                    return;
                                }

                                const isClosed = content.classList.contains("hidden");

                                // Tutup semua section terlebih dahulu
                                const sections = [
                                    ["heroSetting", "heroArrow"],
                                    ["sectionTitleSetting", "sectionTitleArrow"],
                                    ["ctaSetting", "ctaArrow"],
                                    ["packageSetting", "packageArrow"],
                                ];

                                sections.forEach(([sectionId, sectionArrowId]) => {
                                    const section = document.getElementById(sectionId);
                                    const sectionArrow = document.getElementById(sectionArrowId);

                                    if (section) {
                                        section.classList.add("hidden");
                                    }

                                    if (sectionArrow) {
                                        sectionArrow.setAttribute("data-lucide", "chevron-down");
                                        sectionArrow.classList.remove("rotate-180");
                                    }
                                });

                                // Kalau sebelumnya tertutup, buka section yang diklik
                                if (isClosed) {
                                    content.classList.remove("hidden");

                                    arrow.setAttribute("data-lucide", "chevron-up");
                                    arrow.classList.add("rotate-180");
                                }

                                lucide.createIcons();
                            }

                            function previewCtaImageFile(input) {
                                const image = document.getElementById("ctaImagePreview");
                                const empty = document.getElementById("ctaImageEmpty");
                                const message = document.getElementById("ctaImageSizeMessage");
                                const file = input.files && input.files[0];

                                if (!image || !empty || !message || !file) return;

                                if (file.size > 2 * 1024 * 1024) {
                                    input.value = "";
                                    message.classList.remove("hidden");
                                    return;
                                }

                                message.classList.add("hidden");
                                const reader = new FileReader();
                                reader.onload = function(event) {
                                    image.src = event.target.result;
                                    image.classList.remove("hidden");
                                    empty.classList.add("hidden");
                                };
                                reader.readAsDataURL(file);
                            }
                        </script>
</body>

</html>
