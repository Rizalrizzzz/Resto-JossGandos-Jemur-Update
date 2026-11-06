<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Kelola Gallery</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logojossgandos.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Unicons untuk Sidebar --}}
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css" />

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        .scrollbar-stable {
            scrollbar-gutter: stable;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 overflow-hidden">
    <div class="flex h-screen overflow-hidden">
        {{-- ========================================================= --}}
        {{-- SIDEBAR --}}
        {{-- ========================================================= --}}

        @include ('layouts.sidebar')

        {{-- ========================================================= --}}
        {{-- CONTENT --}}
        {{-- ========================================================= --}}

        <main class="flex-1 min-w-0 min-h-0 overflow-y-auto bg-slate-50 relative">
            {{-- HEADER --}}
            <header
                class="sticky top-0 flex-shrink-0 bg-white border-b border-slate-200 shadow-sm z-20 px-6 py-4 flex items-center justify-between gap-4">
                <div class="flex items-center gap-4 flex-1">
                    {{-- TOMBOL MENU HP --}}
                    <button type="button" onclick="toggleSidebar()"
                        class="md:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-lg">
                        <i class="uil uil-bars text-2xl"></i>
                    </button>

                    <div>
                        <h1 class="text-xl font-bold text-slate-800 tracking-tight">
                            Kelola Gallery
                        </h1>
                    </div>
                </div>

                {{-- TOMBOL TAMBAH --}}
                <button type="button" onclick="openAddModal()"
                    class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg hover:shadow-xl transition-all">
                    <i class="uil uil-plus-circle text-lg"></i>

                    <span>Tambah Data</span>
                </button>
            </header>

            {{-- NOTIFIKASI HASIL AKSI DAN VALIDASI --}}
            <div class="px-4 md:px-6 pt-4 space-y-3" aria-live="polite">
                @if (session('success'))
                    <div id="gallerySuccessNotification" role="status"
                        class="flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 transition-all duration-300">
                        <i data-lucide="check-circle" class="w-5 h-5 shrink-0 mt-0.5"></i>
                        <div class="font-medium">{{ session('success') }}</div>
                    </div>
                @endif

                @if ($errors->any())
                    <div role="alert"
                        class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        <div class="flex items-start gap-3">
                            <i data-lucide="alert-circle" class="w-5 h-5 shrink-0 mt-0.5"></i>
                            <div>
                                <p class="font-semibold">Data belum berhasil disimpan. Periksa kembali:</p>
                                <ul class="mt-2 list-disc space-y-1 pl-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- ================================================= --}}
            {{-- GALLERY SETTINGS --}}
            {{-- ================================================= --}}

            <div class="px-4 md:px-6 pt-5 pb-2">
                <div class="space-y-3">
                    {{-- ==================================================
                         HEADER SECTION
                    ================================================== --}}

                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                        {{-- HEADER ACCORDION --}}
                        <button type="button"
                            onclick="
                                toggleGallerySetting(
                                    'galleryHeaderSetting',
                                    'galleryHeaderChevron',
                                )
                            "
                            class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-slate-50 transition">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                    <i data-lucide="layout-template" class="w-5 h-5"></i>
                                </div>

                                <div>
                                    <h2 class="text-lg font-bold text-slate-800">
                                        Header Section
                                    </h2>

                                    <p class="text-sm text-slate-500 mt-1">Atur label, judul, deskripsi, dan gambar
                                        utama halaman Gallery.</p>
                                </div>
                            </div>

                            <i id="galleryHeaderChevron" data-lucide="chevron-down"
                                class="w-5 h-5 text-slate-500 shrink-0 transition-transform duration-200">
                            </i>
                        </button>

                        {{-- ISI HEADER --}}
                        <div id="galleryHeaderSetting" class="hidden border-t border-slate-100">
                            <form action="{{ route('gallery.settings.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method ('PUT')
                                <input type="hidden" name="form_context" value="gallery_header">

                                <div class="p-6">
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                        {{-- KOLOM KIRI --}}
                                        <div class="space-y-5">
                                            {{-- LABEL --}}
                                            <div>
                                                <label for="galleryHeroBadge"
                                                    class="block text-sm font-semibold text-slate-700 mb-2">
                                                    Label
                                                </label>

                                                <input type="text" id="galleryHeroBadge" name="hero_badge"
                                                    value="{{ old('hero_badge', $gallerySetting->hero_badge ?? '') }}"
                                                    placeholder="Contoh: DOKUMENTASI"
                                                    class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                                            </div>

                                            {{-- JUDUL --}}
                                            <div>
                                                <label for="galleryHeroTitle"
                                                    class="block text-sm font-semibold text-slate-700 mb-2">
                                                    Judul
                                                </label>

                                                <input type="text" id="galleryHeroTitle" name="hero_title"
                                                    value="{{ old('hero_title', $gallerySetting->hero_title ?? '') }}"
                                                    placeholder="Contoh: Galeri Kami"
                                                    class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                                            </div>

                                            {{-- DESKRIPSI --}}
                                            <div>
                                                <label for="galleryHeroDescription"
                                                    class="block text-sm font-semibold text-slate-700 mb-2">
                                                    Deskripsi
                                                </label>

                                                <textarea id="galleryHeroDescription" name="hero_description" rows="6"
                                                    placeholder="Masukkan deskripsi header Gallery..."
                                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none resize-y focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">{{ old('hero_description', $gallerySetting->hero_description ?? '') }}</textarea
                                                >
                                            </div>
                                        </div>

                                        {{-- KOLOM KANAN --}}
                                        <div>
                                            @php
                                                $heroImagePath = ltrim($gallerySetting->hero_image ?? '', '/');

                                                if (str_starts_with($heroImagePath, 'storage/')) {
                                                    $heroImageUrl = asset($heroImagePath);
                                                } elseif (str_starts_with($heroImagePath, 'public/storage/')) {
                                                    $heroImageUrl = asset(substr($heroImagePath, 7));
                                                } elseif (str_starts_with($heroImagePath, 'public/')) {
                                                    $heroImageUrl = asset('storage/' . substr($heroImagePath, 7));
                                                } elseif ($heroImagePath) {
                                                    $heroImageUrl = asset('storage/' . $heroImagePath);
                                                } else {
                                                    $heroImageUrl = '';
                                                }
                                            @endphp

                                            <label for="heroImageFile" class="block text-sm font-semibold text-slate-700 mb-2">
                                                Background Hero
                                            </label>

                                            <input
                                                type="file"
                                                name="hero_image"
                                                id="heroImageFile"
                                                accept=".jpg,.jpeg,.png,.webp"
                                                onchange="handleHeroImageFile()"
                                                class="block w-full text-sm text-slate-500 border border-slate-200 rounded-xl cursor-pointer bg-white file:mr-3 file:py-2.5 file:px-3 file:border-0 file:bg-slate-100 file:text-slate-700 file:font-medium"
                                            />
                                            <p class="mt-2 text-xs text-slate-500">Pilih foto maksimal 2 MB. Preview berubah setelah file dipilih.</p>
                                            <p id="heroImageSizeMessage" class="hidden mt-2 text-xs text-red-500" role="alert"></p>
                                            @error('hero_image')
<p class="mt-2 text-xs text-red-500">{{ $message }}</p>
@enderror

                                            {{-- PREVIEW --}}
                                            <div class="mt-4">
                                                <div
                                                    id="heroImagePreview"
                                                    class="relative w-full h-72 rounded-2xl overflow-hidden border border-slate-200 bg-slate-50"
                                                >
                                                    <img
                                                        id="heroImagePreviewImg"
                                                        src="{{ $heroImageUrl }}"
                                                        alt="Preview Background Hero"
                                                        class="w-full h-full object-cover {{ $heroImageUrl ? '' : 'hidden' }}"
                                                    />

                                                    <div
                                                        id="heroImagePlaceholder"
                                                        class="{{ $heroImageUrl ? 'hidden' : '' }} absolute inset-0 flex flex-col items-center justify-center text-slate-400"
                                                    >
                                                        <i data-lucide="image" class="w-10 h-10 mb-2"></i>
                                                        <span class="text-sm">Preview gambar akan tampil di sini</span>
                                                    </div>
                                                </div>
                                            </div>
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

                    {{-- ==================================================
                         CTA SECTION
                    ================================================== --}}

                    <div
                        class="bg-white border border-slate-200 rounded-2xl overflow-hidden"
                    >
                        {{-- HEADER ACCORDION --}}
                        <button
                            type="button"
                            onclick="
                                toggleGallerySetting(
                                    'galleryCtaSetting',
                                    'galleryCtaChevron',
                                )
                            "
                            class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-slate-50 transition"
                        >
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center shrink-0"
                                >
                                    <i
                                        data-lucide="megaphone"
                                        class="w-5 h-5"
                                    ></i>
                                </div>

                                <div>
                                    <h2
                                        class="text-lg font-bold text-slate-800"
                                    >
                                        CTA Section
                                    </h2>

                                    <p class="text-sm text-slate-500 mt-1">Atur konten CTA Instagram dan WhatsApp.</p>
                                </div>
                            </div>

                            <i
                                id="galleryCtaChevron"
                                data-lucide="chevron-down"
                                class="w-5 h-5 text-slate-500 shrink-0 transition-transform duration-200"
                            >
                            </i>
                        </button>

                        {{-- ISI CTA --}}
                        <div
                            id="galleryCtaSetting"
                            class="hidden border-t border-slate-100"
                        >
                            <form
                                action="{{ route('gallery.settings.update') }}"
                                method="POST"
                            >
                                @csrf
                                @method ('PUT')
                                <input type="hidden" name="form_context" value="gallery_cta">

                                <div class="p-6 space-y-8">
                                    {{-- INSTAGRAM --}}
                                    <div
                                        class="border border-slate-200 rounded-2xl p-5"
                                    >
                                        <div
                                            class="flex items-center gap-3 mb-5"
                                        >
                                            <div
                                                class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center"
                                            >
                                                <svg
                                                    class="w-6 h-6"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    aria-hidden="true"
                                                >
                                                    <rect x="3" y="3" width="18" height="18" rx="5"></rect>

                                                    <circle cx="12" cy="12" r="4"></circle>

                                                    <circle cx="17.5" cy="6.5" r="1"></circle>
                                                </svg>
                                            </div>

                                            <div>
                                                <h3
                                                    class="font-bold text-slate-800"
                                                >
                                                    CTA Instagram
                                                </h3>

                                                <p class="text-sm text-slate-500">Konten yang tampil pada bagian Instagram.</p>
                                            </div>
                                        </div>

                                        <div
                                            class="grid grid-cols-1 lg:grid-cols-2 gap-5"
                                        >
                                            {{-- JUDUL --}}
                                            <div>
                                                <label for="galleryCtaTitle"
                                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                                >
                                                    Judul
                                                </label>

                                                <input
                                                    type="text"
                                                    id="galleryCtaTitle" name="cta_title"
                                                    value="{{ old('cta_title', $gallerySetting->cta_title ?? '') }}"
                                                    placeholder="Punya momen seru di Resto Joss Gandos?"
                                                    class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                                />
                                            </div>

                                            {{-- LINK --}}
                                            <div>
                                                <label for="galleryCtaInstagramLink"
                                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                                >
                                                    Link Instagram
                                                </label>

                                                <input
                                                    type="url"
                                                    id="galleryCtaInstagramLink"
                                                    name="cta_button_1_link"
                                                    value="{{ old('cta_button_1_link', $gallerySetting->cta_button_1_link ?? '') }}"
                                                    placeholder="https://www.instagram.com/restojossgandos/"
                                                    class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                                />
                                            </div>

                                            {{-- DESKRIPSI --}}
                                            <div class="lg:col-span-2">
                                                <label for="galleryCtaDescription"
                                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                                >
                                                    Deskripsi
                                                </label>

                                                <textarea
                                                    id="galleryCtaDescription"
                                                    name="cta_description"
                                                    rows="3"
                                                    placeholder="Bagikan momen Anda dan tag kami di media sosial!"
                                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none resize-y focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                                    >{{ old('cta_description', $gallerySetting->cta_description ?? '') }}</textarea
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    {{-- WHATSAPP --}}
                                    <div
                                        class="border border-slate-200 rounded-2xl p-5"
                                    >
                                        <div
                                            class="flex items-center gap-3 mb-5"
                                        >
                                            <div
                                                class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center"
                                            >
                                                <svg
                                                    class="w-6 h-6"
                                                    viewBox="0 0 32 32"
                                                    fill="none"
                                                    aria-hidden="true"
                                                >
                                                    <path
                                                        d="M16 3.5C9.1 3.5 3.5 9.1 3.5 16c0 2.3.6 4.5 1.8 6.4L3.5 28.5l6.3-1.7c1.9 1.1 4 1.7 6.2 1.7 6.9 0 12.5-5.6 12.5-12.5S22.9 3.5 16 3.5Z"
                                                        fill="currentColor"
                                                    />

                                                    <path
                                                        d="M11.7 9.3c.3-.1.6.1.8.4l1.3 3c.1.3.1.6-.2.9l-.9.9c.8 1.5 2 2.7 3.5 3.5l.9-.9c.2-.2.6-.3.9-.2l3 1.3c.3.1.5.5.4.8l-.4 1.5c-.1.4-.5.7-.9.7-5.5-.2-9.9-4.6-10.1-10.1 0-.4.3-.8.7-.9l.9-.9Z"
                                                        fill="white"
                                                    />
                                                </svg>
                                            </div>

                                            <div>
                                                <h3
                                                    class="font-bold text-slate-800"
                                                >
                                                    CTA WhatsApp
                                                </h3>

                                                <p class="text-sm text-slate-500">Ganti link atau nomor WhatsApp tujuan.</p>
                                            </div>
                                        </div>

                                        <div
                                            class="grid grid-cols-1 lg:grid-cols-2 gap-5"
                                        >
                                            {{-- JUDUL --}}
                                            <div>
                                                <label for="galleryCtaWhatsappTitle"
                                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                                >
                                                    Judul
                                                </label>

                                                <input
                                                    type="text"
                                                    id="galleryCtaWhatsappTitle" name="cta_whatsapp_title"
                                                    value="{{ old('cta_whatsapp_title', $gallerySetting->cta_whatsapp_title ?? '') }}"
                                                    placeholder="Butuh bantuan atau ingin reservasi?"
                                                    class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                                />
                                            </div>

                                            {{-- LINK --}}
                                            <div>
                                                <label for="galleryCtaWhatsappLink"
                                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                                >
                                                    Link WhatsApp
                                                </label>

                                                <input
                                                    type="text"
                                                    id="galleryCtaWhatsappLink"
                                                    name="cta_button_2_link"
                                                    value="{{ old('cta_button_2_link', $gallerySetting->cta_button_2_link ?? '') }}"
                                                    placeholder="6289699071599 atau https://wa.me/6289699071599"
                                                    class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                                />

                                                <p class="mt-2 text-xs text-slate-500">Bisa diisi nomor WhatsApp atau link WhatsApp.</p>
                                            </div>

                                            {{-- DESKRIPSI --}}
                                            <div class="lg:col-span-2">
                                                <label for="galleryCtaWhatsappDescription"
                                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                                >
                                                    Deskripsi
                                                </label>

                                                <textarea
                                                    id="galleryCtaWhatsappDescription"
                                                    name="cta_whatsapp_description"
                                                    rows="3"
                                                    placeholder="Tim kami siap membantu Anda untuk reservasi dan informasi."
                                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none resize-y focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                                    >{{ old('cta_whatsapp_description', $gallerySetting->cta_whatsapp_description ?? '') }}</textarea
                                                >
                                            </div>
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

                    {{-- ================================================= --}}
                    {{-- ATUR BINGKAI --}}
                    {{-- ================================================= --}}

                    <div
                        class="bg-white border border-slate-200 rounded-2xl overflow-hidden"
                    >
                        {{-- HEADER ACCORDION --}}
                        <button
                            type="button"
                            onclick="
                                toggleGallerySetting(
                                    'galleryFrameSetting',
                                    'galleryFrameChevron',
                                )
                            "
                            class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-slate-50 transition"
                        >
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0"
                                >
                                    <i
                                        data-lucide="panels-top-left"
                                        class="w-5 h-5"
                                    ></i>
                                </div>

                                <div>
                                    <h2
                                        class="text-lg font-bold text-slate-800"
                                    >
                                        Atur Bingkai
                                    </h2>

                                    <p class="text-sm text-slate-500 mt-1">Atur gambar dan deskripsi bingkai Gallery.</p>
                                </div>
                            </div>

                            <i
                                id="galleryFrameChevron"
                                data-lucide="chevron-down"
                                class="w-5 h-5 text-slate-500 shrink-0 transition-transform duration-200"
                            >
                            </i>
                        </button>

                        {{-- ISI --}}
                        <div
                            id="galleryFrameSetting"
                            class="hidden border-t border-slate-100"
                        >
                            <div class="p-6 space-y-6">
                                {{-- ================================================= --}}
                                {{-- BINGKAI 1 --}}
                                {{-- ================================================= --}}

                                <div
                                    class="border border-slate-200 rounded-2xl p-5"
                                >
                                    <div class="mb-5">
                                        <h3 class="font-bold text-slate-800">
                                            Bingkai 1
                                        </h3>

                                        <p class="text-sm text-slate-500 mt-1">Atur gambar dan deskripsi Bingkai 1.</p>
                                    </div>

                                    <form
                                        action="{{ route('gallery.frames.update') }}"
                                        method="POST"
                                        enctype="multipart/form-data"
                                    >
                                        @csrf
                                        @method ('PUT')
                                        <input
                                            type="hidden"
                                            name="frame"
                                            value="1"
                                        />
                                        <input type="hidden" name="form_context" value="gallery_frame_1">

                                        <div class="space-y-5">
                                            {{-- FOTO --}}
                                            <div>
                                                <div
                                                    class="grid grid-cols-1 lg:grid-cols-[220px_1fr] gap-6 items-start"
                                                >
                                                    {{-- PREVIEW KIRI --}}
                                                    <div>
                                                        <p
                                                            class="block text-sm font-semibold text-slate-700 mb-3"
                                                        >
                                                            Foto
                                                        </p>

                                                        <div
                                                            class="w-[220px] aspect-[4/3] mx-auto lg:mx-0 rounded-xl overflow-hidden border border-slate-200 bg-slate-50 flex items-center justify-center"
                                                        >
                                                            @php
                                                                $frame1Image = ltrim(
                                                                    $gallerySetting->frame_1_image ?? '',
                                                                    '/',
                                                                );

                                                                if (str_starts_with($frame1Image, 'storage/')) {
                                                                    $frame1Url = asset($frame1Image);
                                                                } elseif (
                                                                    str_starts_with($frame1Image, 'public/storage/')
                                                                ) {
                                                                    $frame1Url = asset(substr($frame1Image, 7));
                                                                } elseif (str_starts_with($frame1Image, 'public/')) {
                                                                    $frame1Url = asset(
                                                                        'storage/' . substr($frame1Image, 7),
                                                                    );
                                                                } elseif ($frame1Image) {
                                                                    $frame1Url = asset('storage/' . $frame1Image);
                                                                } else {
                                                                    $frame1Url = '';
                                                                }
                                                            @endphp

                                                            <img
                                                                id="frame1PreviewImage"
                                                                src="{{ $frame1Url }}"
                                                                alt="Preview Bingkai 1"
                                                                class="{{ $frame1Url ? '' : 'hidden' }} w-full h-full object-cover"
                                                            />

                                                            <span
                                                                id="frame1PreviewText"
                                                                class="{{ $frame1Url ? 'hidden' : '' }} text-xs text-slate-400 text-center px-4"
                                                            >
                                                                Preview Foto
                                                            </span>
                                                        </div>
                                                    </div>

                                                    {{-- UPLOAD KANAN --}}
                                                    <div class="space-y-4">
                                                        {{-- UPLOAD --}}
                                                        <div>
                                                            <label for="frame1Upload"
                                                                class="block text-sm font-semibold text-slate-700 mb-2"
                                                            >
                                                                Upload Foto
                                                            </label>

                                                            <input
                                                                type="file"
                                                                name="frame_1_upload"
                                                                id="frame1Upload"
                                                                accept=".jpg,.jpeg,.png,.webp"
                                                                onchange="
                                                                    previewFrame1File()
                                                                "
                                                                class="block w-full text-sm text-slate-500 border border-slate-200 rounded-xl cursor-pointer bg-white file:mr-3 file:py-2.5 file:px-3 file:border-0 file:bg-slate-100 file:text-slate-700 file:font-medium"
                                                            />

                                                            <p class="mt-2 text-xs text-slate-500">Pilih foto maksimal 2 MB. Preview berubah setelah file dipilih.</p>
                                                            <p id="frame1SizeMessage" class="hidden mt-2 text-xs text-red-500" role="alert"></p>
                                                            @error('frame_1_upload')
<p class="mt-2 text-xs text-red-500">{{ $message }}</p>
@enderror
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            {{-- DESKRIPSI --}}
                                            <div>
                                                <label
                                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                                 for="galleryFrame1Description">
                                                    Deskripsi
                                                </label>

                                                <textarea id="galleryFrame1Description"
                                                    name="frame_1_description"
                                                    rows="4"
                                                    placeholder="Masukkan deskripsi bingkai..."
                                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none resize-y focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                                    >{{ old('frame_1_description', $gallerySetting->frame_1_description ?? '') }}</textarea
                                                >
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
                                                Update Bingkai 1
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                {{-- ================================================= --}}
                                {{-- BINGKAI 2 --}}
                                {{-- ================================================= --}}

                                <div
                                    class="border border-slate-200 rounded-2xl p-5"
                                >
                                    <div class="mb-5">
                                        <h3 class="font-bold text-slate-800">
                                            Bingkai 2
                                        </h3>

                                        <p class="text-sm text-slate-500 mt-1">Atur gambar dan deskripsi Bingkai 2.</p>
                                    </div>

                                    <form
                                        action="{{ route('gallery.frames.update') }}"
                                        method="POST"
                                        enctype="multipart/form-data"
                                    >
                                        @csrf
                                        @method ('PUT')
                                        <input
                                            type="hidden"
                                            name="frame"
                                            value="2"
                                        />
                                        <input type="hidden" name="form_context" value="gallery_frame_2">

                                        <div class="space-y-5">
                                            {{-- FOTO --}}
                                            <div>
                                                <div
                                                    class="grid grid-cols-1 lg:grid-cols-[220px_1fr] gap-6 items-start"
                                                >
                                                    {{-- PREVIEW KIRI --}}
                                                    <div>
                                                        <p
                                                            class="block text-sm font-semibold text-slate-700 mb-3"
                                                        >
                                                            Foto
                                                        </p>

                                                        <div
                                                            class="w-[220px] aspect-[4/3] mx-auto lg:mx-0 rounded-xl overflow-hidden border border-slate-200 bg-slate-50 flex items-center justify-center"
                                                        >
                                                            @php
                                                                $frame2Image = ltrim(
                                                                    $gallerySetting->frame_2_image ?? '',
                                                                    '/',
                                                                );

                                                                if (str_starts_with($frame2Image, 'storage/')) {
                                                                    $frame2Url = asset($frame2Image);
                                                                } elseif (
                                                                    str_starts_with($frame2Image, 'public/storage/')
                                                                ) {
                                                                    $frame2Url = asset(substr($frame2Image, 7));
                                                                } elseif (str_starts_with($frame2Image, 'public/')) {
                                                                    $frame2Url = asset(
                                                                        'storage/' . substr($frame2Image, 7),
                                                                    );
                                                                } elseif ($frame2Image) {
                                                                    $frame2Url = asset('storage/' . $frame2Image);
                                                                } else {
                                                                    $frame2Url = '';
                                                                }
                                                            @endphp

                                                            <img
                                                                id="frame2PreviewImage"
                                                                src="{{ $frame2Url }}"
                                                                alt="Preview Bingkai 2"
                                                                class="{{ $frame2Url ? '' : 'hidden' }} w-full h-full object-cover"
                                                            />

                                                            <span
                                                                id="frame2PreviewText"
                                                                class="{{ $frame2Url ? 'hidden' : '' }} text-xs text-slate-400 text-center px-4"
                                                            >
                                                                Preview Foto
                                                            </span>
                                                        </div>
                                                    </div>

                                                    {{-- UPLOAD KANAN --}}
                                                    <div class="space-y-4">
                                                        {{-- UPLOAD --}}
                                                        <div>
                                                            <label for="frame2Upload"
                                                                class="block text-sm font-semibold text-slate-700 mb-2"
                                                            >
                                                                Upload Foto
                                                            </label>

                                                            <input
                                                                type="file"
                                                                name="frame_2_upload"
                                                                id="frame2Upload"
                                                                accept=".jpg,.jpeg,.png,.webp"
                                                                onchange="
                                                                    previewFrame2File()
                                                                "
                                                                class="block w-full text-sm text-slate-500 border border-slate-200 rounded-xl cursor-pointer bg-white file:mr-3 file:py-2.5 file:px-3 file:border-0 file:bg-slate-100 file:text-slate-700 file:font-medium"
                                                            />

                                                            <p class="mt-2 text-xs text-slate-500">Pilih foto maksimal 2 MB. Preview berubah setelah file dipilih.</p>
                                                            <p id="frame2SizeMessage" class="hidden mt-2 text-xs text-red-500" role="alert"></p>
                                                            @error('frame_2_upload')
<p class="mt-2 text-xs text-red-500">{{ $message }}</p>
@enderror
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            {{-- DESKRIPSI --}}
                                            <div>
                                                <label
                                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                                 for="galleryFrame2Description">
                                                    Deskripsi
                                                </label>

                                                <textarea id="galleryFrame2Description"
                                                    name="frame_2_description"
                                                    rows="4"
                                                    placeholder="Masukkan deskripsi bingkai..."
                                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none resize-y focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                                    >{{ old('frame_2_description', $gallerySetting->frame_2_description ?? '') }}</textarea
                                                >
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
                                                Update Bingkai 2
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================================================= --}}
            {{-- SEARCH + FILTER --}}
            {{-- ================================================= --}}

            <div class="px-4 md:px-6 pt-4">
                <div
                    class="bg-white border border-slate-200 rounded-2xl p-4 mb-5"
                >
                    <div class="flex flex-col md:flex-row gap-3">
                        {{-- SEARCH --}}
                        <div class="relative flex-1">
                            <i
                                class="uil uil-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"
                            >
                            </i>

                            <input
                                type="text"
                                id="searchGallery"
                                oninput="filterGallery()"
                                placeholder="Cari judul gallery..."
                                class="w-full h-12 pl-11 pr-4 border border-slate-200 rounded-xl outline-none text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                            />
                        </div>

                        {{-- FILTER --}}
                        <div class="relative md:w-64">
                            <select
                                id="categoryFilter"
                                onchange="filterGallery()"
                                class="appearance-none w-full h-12 px-4 pr-10 border border-slate-200 rounded-xl bg-white outline-none text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                            >
                                <option value="all">Semua Kategori</option>

                                <option value="momen">Momen</option>

                                <option value="facility">Fasilitas</option>

                                <option value="event">Event</option>
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

            {{-- ================================================= --}}
            {{-- TABLE --}}
            {{-- ================================================= --}}

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
                                        class="w-24 px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase"
                                    >
                                        Foto
                                    </th>

                                    <th
                                        class="w-48 px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase"
                                    >
                                        Judul
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase"
                                    >
                                        Deskripsi
                                    </th>

                                    <th
                                        class="w-36 px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase"
                                    >
                                        Kategori
                                    </th>

                                    <th
                                        class="w-28 px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase"
                                    >
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody
                                id="galleryTable"
                                class="divide-y divide-slate-100"
                            >
                                @forelse ($photos as $photo)
<tr
                                        class="gallery-row hover:bg-slate-50 transition"
                                        data-title="{{ strtolower($photo->title) }}"
                                        data-category="{{ $photo->category }}"
                                    >
                                        {{-- FOTO --}}
                                        <td class="px-6 py-4">
                                            @php
                                                $imagePath = ltrim($photo->image_path ?? '', '/');

                                                if (\Illuminate\Support\Str::startsWith($imagePath, 'storage/')) {
                                                    $imageUrl = asset($imagePath);
                                                } elseif (
                                                    \Illuminate\Support\Str::startsWith($imagePath, 'public/storage/')
                                                ) {
                                                    $imageUrl = asset(substr($imagePath, 7));
                                                } elseif (\Illuminate\Support\Str::startsWith($imagePath, 'public/')) {
                                                    $imageUrl = asset('storage/' . substr($imagePath, 7));
                                                } else {
                                                    $imageUrl = asset('storage/' . $imagePath);
                                                }
                                            @endphp

                                            <div
                                                class="w-16 h-16 rounded-xl overflow-hidden bg-slate-100 border border-slate-200"
                                            >
                                                @if ($imagePath)
<img
                                                        src="{{ $imageUrl }}"
                                                        alt="{{ $photo->title }}"
                                                        class="w-full h-full object-cover"
                                                        onerror="
                                                            this.style.display =
                                                                'none'
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

                                        {{-- JUDUL --}}
                                        <td class="px-6 py-4 align-top">
                                            <div
                                                class="font-semibold text-slate-800 break-words"
                                            >
                                                {{ $photo->title }}
                                            </div>
                                        </td>

                                        {{-- DESKRIPSI --}}
                                        <td class="px-6 py-4 align-top">
                                            <div
                                                class="text-sm text-slate-500 whitespace-normal break-words"
                                            >
                                                {{ $photo->description ?: '-' }}
                                            </div>
                                        </td>

                                        {{-- KATEGORI --}}
                                        <td class="px-6 py-4 align-top">
                                            @if ($photo->category === 'momen')
<span
                                                    class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-orange-50 text-orange-600"
                                                >
                                                    Momen
                                                </span>
@elseif ($photo->category === 'facility')
<span
                                                    class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-600"
                                                >
                                                    Fasilitas
                                                </span>
@else
<span
                                                    class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-purple-50 text-purple-600"
                                                >
                                                    Event
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
                                                    onclick='openUpdateModal(
                                                        @json($photo)
                                                    )'
                                                    class="w-9 h-9 flex items-center justify-center rounded-lg text-blue-600 hover:bg-blue-50 transition"
                                                >
                                                    <i
                                                        data-lucide="pencil"
                                                        class="w-4 h-4"
                                                    >
                                                    </i>
                                                </button>

                                                {{-- HAPUS --}}
                                                <form
                                                    action="{{ route('gallery.destroy', $photo->id) }}"
                                                    method="POST"
                                                    onsubmit="
                                                        return confirm(
                                                            'Hapus gallery ini?',
                                                        );
                                                    "
                                                >
                                                    @csrf
                                                    @method ('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="w-9 h-9 flex items-center justify-center rounded-lg text-red-600 hover:bg-red-50 transition"
                                                    >
                                                        <i
                                                            data-lucide="trash-2"
                                                            class="w-4 h-4"
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
                                            colspan="5"
                                            class="px-6 py-8 text-center text-slate-400"
                                        >
                                            Belum ada gallery.
                                        </td>
                                    </tr>
@endforelse

                                {{-- HASIL SEARCH / FILTER KOSONG --}}
                                <tr id="noGalleryResult" class="hidden">
                                    <td
                                        colspan="5"
                                        class="px-6 py-8 text-center text-slate-500"
                                    >
                                        Tidak ada gallery terkait.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- ============================================================= --}}
    {{-- MODAL TAMBAH --}}
    {{-- ============================================================= --}}

    <div
        id="addModal"
        class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm items-center justify-center p-4"
    >
        <div
            class="bg-white w-full max-w-3xl max-h-[90vh] rounded-2xl shadow-xl overflow-y-auto"
        >
            {{-- HEADER MODAL --}}
            <div
                class="px-6 py-5 border-b border-slate-200 flex items-center justify-between"
            >
                <div>
                    <h2 class="text-lg font-bold text-slate-800">
                        Tambah Gallery
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">Tambahkan foto baru ke gallery.</p>
                </div>

                <button
                    type="button"
                    onclick="closeAddModal()"
                    class="w-9 h-9 rounded-lg hover:bg-slate-100 flex items-center justify-center"
                >
                    <i data-lucide="x" class="w-5 h-5 text-slate-500"></i>
                </button>
            </div>

            {{-- FORM --}}
            <form
                action="{{ route('gallery.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                <input type="hidden" name="form_context" value="gallery_add">

                <div class="p-6 space-y-5">
                    {{-- FOTO GALLERY --}}
                    <div>
                        <p class="block text-sm font-medium mb-3">
                            Foto Gallery
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

                            <div class="space-y-4">
                                {{-- UPLOAD --}}
                                <div>
                                    <label
                                        class="block text-sm font-medium mb-2"
                                     for="addImageFile">
                                        Upload File
                                    </label>
                                    <input
                                        type="file"
                                        name="image_file"
                                        id="addImageFile"
                                        accept=".jpg,.jpeg,.png,.webp"
                                        required
                                        onchange="handleAddGalleryFile()"
                                        class="block w-full text-sm text-slate-500 border border-slate-200 rounded-xl cursor-pointer bg-white file:mr-3 file:py-2.5 file:px-3 file:border-0 file:bg-slate-100 file:text-slate-700 file:font-medium"
                                    />
                                    <p class="mt-2 text-xs text-slate-500">Pilih foto maksimal 2 MB. Preview berubah setelah file dipilih.</p>
                                    <p id="addImageSizeMessage" class="hidden mt-2 text-xs text-red-500" role="alert"></p>
                                    @error('image_file')
<p class="mt-2 text-xs text-red-500">{{ $message }}</p>
@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- JUDUL --}}
                    <div>
                        <label for="addTitle"
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Judul
                        </label>
                        <input
                            type="text"
                            name="title"
                            id="addTitle"
                            required
                            class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                        />
                        @error('title')
<p class="mt-1 text-xs text-red-500">{{ $message }}</p>
@enderror
                    </div>

                    {{-- DESKRIPSI --}}
                    <div>
                        <label for="addDescription"
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Deskripsi
                        </label>
                        <textarea
                            name="description"
                            id="addDescription"
                            rows="4"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none resize-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                        ></textarea>
                                                @error('description')
                                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            {{-- KATEGORI --}}
                                            <div>
                                                <label class="block text-sm font-semibold text-slate-700 mb-2"
                                                    for="addCategory">
                                                    Kategori
                                                </label>
                                                <select name="category" id="addCategory" required
                                                    class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                                                    <option value="momen">Momen</option>
                                                    <option value="facility">Fasilitas</option>
                                                    <option value="event">Event</option>
                                                </select>
                                                @error('category')
                                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- FOOTER --}}
                                        <div
                                            class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end gap-3">
                                            <button type="button" onclick="closeAddModal()"
                                                class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-200 transition">
                                                Batal
                                            </button>
                                            <button type="submit"
                                                class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition">
                                                Simpan
                                            </button>
                                        </div>
                            </form>
                        </div>
                    </div>

                    {{-- ============================================================= --}}
                    {{-- MODAL UPDATE --}}
                    {{-- ============================================================= --}}

                    <div id="updateModal"
                        class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm items-center justify-center p-4">
                        <div class="bg-white w-full max-w-3xl max-h-[90vh] rounded-2xl shadow-xl overflow-y-auto">
                            <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
                                <div>
                                    <h2 class="text-lg font-bold text-slate-800">
                                        Update Gallery
                                    </h2>
                                    <p class="text-sm text-slate-500 mt-1">Perbarui data gallery.</p>
                                </div>

                                <button type="button" onclick="closeUpdateModal()"
                                    class="w-9 h-9 rounded-lg hover:bg-slate-100 flex items-center justify-center">
                                    <i data-lucide="x" class="w-5 h-5 text-slate-500"></i>
                                </button>
                            </div>

                            <form id="updateForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method ('PUT')
                                <input type="hidden" name="form_context" value="gallery_update">
                                <input type="hidden" name="photo_id" id="updatePhotoId"
                                    value="{{ old('photo_id') }}">

                                <div class="p-6 space-y-5">
                                    {{-- FOTO GALLERY --}}
                                    <div>
                                        <p class="block text-sm font-medium mb-3">
                                            Foto Gallery
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
                                                    class="hidden w-full h-full object-cover" />
                                            </div>

                                            <div class="space-y-4">
                                                {{-- UPLOAD --}}
                                                <div>
                                                    <label class="block text-sm font-medium mb-2"
                                                        for="updateImageFile">
                                                        Ganti File
                                                    </label>
                                                    <input type="file" name="image_file" id="updateImageFile"
                                                        accept=".jpg,.jpeg,.png,.webp"
                                                        onchange="handleUpdateGalleryFile()"
                                                        class="block w-full text-sm text-slate-500 border border-slate-200 rounded-xl cursor-pointer bg-white file:mr-3 file:py-2.5 file:px-3 file:border-0 file:bg-slate-100 file:text-slate-700 file:font-medium" />
                                                    <p class="mt-2 text-xs text-slate-500">Pilih foto maksimal 2 MB.
                                                        Preview berubah setelah file dipilih.</p>
                                                    <p id="updateImageSizeMessage"
                                                        class="hidden mt-2 text-xs text-red-500" role="alert"></p>
                                                    @error('image_file')
                                                        <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- JUDUL --}}
                                    <div>
                                        <label for="updateTitle"
                                            class="block text-sm font-semibold text-slate-700 mb-2">
                                            Judul
                                        </label>
                                        <input type="text" id="updateTitle" name="title" required
                                            class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                                        @error('title')
                                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- DESKRIPSI --}}
                                    <div>
                                        <label for="updateDescription"
                                            class="block text-sm font-semibold text-slate-700 mb-2">
                                            Deskripsi
                                        </label>
                                        <textarea id="updateDescription" name="description" rows="4"
                                            class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none resize-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"></textarea>
                                        @error('description')
                                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- KATEGORI --}}
                                    <div>
                                        <label for="updateCategory"
                                            class="block text-sm font-semibold text-slate-700 mb-2">
                                            Kategori
                                        </label>
                                        <select id="updateCategory" name="category" required
                                            class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                                            <option value="momen">Momen</option>
                                            <option value="facility">Fasilitas</option>
                                            <option value="event">Event</option>
                                        </select>
                                        @error('category')
                                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- FOOTER --}}
                                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end gap-3">
                                    <button type="button" onclick="closeUpdateModal()"
                                        class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-200 transition">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition">
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- ============================================================= --}}
                    {{-- JAVASCRIPT --}}
                    {{-- ============================================================= --}}

                    <script>
                        lucide.createIcons();

                        // Notifikasi berhasil hilang otomatis setelah 4 detik.
                        const gallerySuccessNotification = document.getElementById("gallerySuccessNotification");
                        if (gallerySuccessNotification) {
                            window.setTimeout(() => {
                                gallerySuccessNotification.classList.add("opacity-0", "-translate-y-2");
                                window.setTimeout(() => {
                                    gallerySuccessNotification.remove();
                                }, 350);
                            }, 4000);
                        }

                        // ========================================
                        // VALIDASI DAN PREVIEW UPLOAD GAMBAR
                        // ========================================

                        const MAX_GALLERY_IMAGE_SIZE = 2 * 1024 * 1024;
                        const ALLOWED_GALLERY_IMAGE_EXTENSION = /\.(jpe?g|png|webp)$/i;

                        function validateGalleryImageFile(file, input, message) {
                            if (!file || !input || !message) {
                                return false;
                            }

                            if (!ALLOWED_GALLERY_IMAGE_EXTENSION.test(file.name)) {
                                input.value = "";
                                message.textContent = "Format gambar harus JPG, JPEG, PNG, atau WebP.";
                                message.classList.remove("hidden");
                                return false;
                            }

                            if (file.size > MAX_GALLERY_IMAGE_SIZE) {
                                input.value = "";
                                message.textContent = "Ukuran file melebihi 2 MB. Pilih foto maksimal 2 MB.";
                                message.classList.remove("hidden");
                                return false;
                            }

                            message.textContent = "";
                            message.classList.add("hidden");
                            return true;
                        }

                        function showGalleryImagePreview(file, image, placeholder) {
                            if (!file || !image) {
                                return;
                            }

                            const reader = new FileReader();
                            reader.onload = function(event) {
                                image.src = event.target.result;
                                image.classList.remove("hidden");

                                if (placeholder) {
                                    placeholder.classList.add("hidden");
                                }
                            };
                            reader.readAsDataURL(file);
                        }

                        function handleHeroImageFile() {
                            const input = document.getElementById("heroImageFile");
                            const image = document.getElementById("heroImagePreviewImg");
                            const placeholder = document.getElementById("heroImagePlaceholder");
                            const message = document.getElementById("heroImageSizeMessage");
                            const file = input && input.files ? input.files[0] : null;

                            if (!file) {
                                return;
                            }

                            if (!validateGalleryImageFile(file, input, message)) {
                                return;
                            }

                            showGalleryImagePreview(file, image, placeholder);
                        }

                        function previewFrame1File() {
                            const input = document.getElementById("frame1Upload");
                            const image = document.getElementById("frame1PreviewImage");
                            const placeholder = document.getElementById("frame1PreviewText");
                            const message = document.getElementById("frame1SizeMessage");
                            const file = input && input.files ? input.files[0] : null;

                            if (!file) {
                                return;
                            }

                            if (!validateGalleryImageFile(file, input, message)) {
                                return;
                            }

                            showGalleryImagePreview(file, image, placeholder);
                        }

                        function previewFrame2File() {
                            const input = document.getElementById("frame2Upload");
                            const image = document.getElementById("frame2PreviewImage");
                            const placeholder = document.getElementById("frame2PreviewText");
                            const message = document.getElementById("frame2SizeMessage");
                            const file = input && input.files ? input.files[0] : null;

                            if (!file) {
                                return;
                            }

                            if (!validateGalleryImageFile(file, input, message)) {
                                return;
                            }

                            showGalleryImagePreview(file, image, placeholder);
                        }

                        function handleAddGalleryFile() {
                            const input = document.getElementById("addImageFile");
                            const image = document.getElementById("addPreviewImage");
                            const placeholder = document.getElementById("addPreviewText");
                            const message = document.getElementById("addImageSizeMessage");
                            const file = input && input.files ? input.files[0] : null;

                            if (!file) {
                                return;
                            }

                            if (!validateGalleryImageFile(file, input, message)) {
                                return;
                            }

                            showGalleryImagePreview(file, image, placeholder);
                        }

                        function handleUpdateGalleryFile() {
                            const input = document.getElementById("updateImageFile");
                            const image = document.getElementById("updatePreviewImage");
                            const placeholder = document.getElementById("updatePreviewText");
                            const message = document.getElementById("updateImageSizeMessage");
                            const file = input && input.files ? input.files[0] : null;

                            if (!file) {
                                return;
                            }

                            if (!validateGalleryImageFile(file, input, message)) {
                                return;
                            }

                            showGalleryImagePreview(file, image, placeholder);
                        }

                        // ========================================
                        // GALLERY SETTINGS ACCORDION
                        // ========================================

                        function toggleGallerySetting(contentId, chevronId) {
                            const content = document.getElementById(contentId);
                            const chevron = document.getElementById(chevronId);

                            if (!content) {
                                return;
                            }

                            const opening = content.classList.contains("hidden");
                            content.classList.toggle("hidden");

                            if (chevron) {
                                chevron.classList.toggle("rotate-180", opening);
                            }

                            lucide.createIcons();
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | SEARCH + FILTER
                        |--------------------------------------------------------------------------
                        */

                        function filterGallery() {
                            const searchInput = document.getElementById("searchGallery");
                            const categoryInput = document.getElementById("categoryFilter");
                            const noResult = document.getElementById("noGalleryResult");

                            if (!searchInput || !categoryInput || !noResult) {
                                return;
                            }

                            const search = searchInput.value.toLowerCase().trim();

                            const category = categoryInput.value;

                            const rows = document.querySelectorAll(".gallery-row");

                            let visibleCount = 0;

                            rows.forEach((row) => {
                                const title = row.dataset.title || "";
                                const rowCategory = row.dataset.category || "";

                                const matchSearch = title.includes(search);

                                const matchCategory =
                                    category === "all" || rowCategory === category;

                                const showRow = matchSearch && matchCategory;

                                row.style.display = showRow ? "" : "none";

                                if (showRow) {
                                    visibleCount++;
                                }
                            });

                            // Ada data di database, tetapi hasil pencarian/filter kosong
                            if (rows.length > 0 && visibleCount === 0) {
                                noResult.classList.remove("hidden");
                            } else {
                                noResult.classList.add("hidden");
                            }
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | MODAL TAMBAH
                        |--------------------------------------------------------------------------
                        */

                        function openAddModal() {
                            const modal = document.getElementById("addModal");

                            modal.classList.remove("hidden");
                            modal.classList.add("flex");

                            lucide.createIcons();
                        }

                        function closeAddModal() {
                            const modal = document.getElementById("addModal");

                            modal.classList.add("hidden");
                            modal.classList.remove("flex");
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | MODAL UPDATE
                        |--------------------------------------------------------------------------
                        */

                        function openUpdateModal(photo) {
                            const modal = document.getElementById("updateModal");
                            const form = document.getElementById("updateForm");
                            const imageFileInput = document.getElementById("updateImageFile");
                            const previewImage = document.getElementById("updatePreviewImage");
                            const previewText = document.getElementById("updatePreviewText");
                            const sizeMessage = document.getElementById("updateImageSizeMessage");

                            form.action = `/dashboard/gallery/${photo.id}`;
                            document.getElementById("updatePhotoId").value = photo.id;

                            document.getElementById("updateTitle").value = photo.title || "";
                            document.getElementById("updateDescription").value = photo.description || "";
                            document.getElementById("updateCategory").value = photo.category || "momen";

                            imageFileInput.value = "";
                            sizeMessage.textContent = "";
                            sizeMessage.classList.add("hidden");

                            const imagePath = (photo.image_path || "").replace(/^\/+/, "");

                            if (imagePath) {
                                let imageUrl;

                                if (imagePath.startsWith("storage/")) {
                                    imageUrl = "/" + imagePath;
                                } else if (imagePath.startsWith("public/storage/")) {
                                    imageUrl = "/" + imagePath.substring(7);
                                } else if (imagePath.startsWith("public/")) {
                                    imageUrl = "/storage/" + imagePath.substring(7);
                                } else {
                                    imageUrl = "/storage/" + imagePath;
                                }

                                previewImage.src = imageUrl;
                                previewImage.classList.remove("hidden");
                                previewText.classList.add("hidden");
                            } else {
                                previewImage.removeAttribute("src");
                                previewImage.classList.add("hidden");
                                previewText.classList.remove("hidden");
                            }

                            modal.classList.remove("hidden");
                            modal.classList.add("flex");

                            lucide.createIcons();
                        }

                        function closeUpdateModal() {
                            const modal = document.getElementById("updateModal");

                            modal.classList.add("hidden");
                            modal.classList.remove("flex");
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | KLIK AREA GELAP UNTUK CLOSE
                        |--------------------------------------------------------------------------
                        */

                        document
                            .getElementById("addModal")
                            .addEventListener("click", function(event) {
                                if (event.target === this) {
                                    closeAddModal();
                                }
                            });

                        document
                            .getElementById("updateModal")
                            .addEventListener("click", function(event) {
                                if (event.target === this) {
                                    closeUpdateModal();
                                }
                            });

                        // Pulihkan panel/modal yang sesuai saat validasi server gagal.
                        const galleryValidationErrors = @json($errors->keys());
                        const galleryFormContext = @json(old('form_context', ''));
                        const galleryOldInput = @json(old());
                        const galleryPhotosById = @json($photos->keyBy('id'));

                        if (galleryValidationErrors.length > 0) {
                            if (galleryFormContext === "gallery_header") {
                                toggleGallerySetting("galleryHeaderSetting", "galleryHeaderChevron");
                            } else if (galleryFormContext === "gallery_cta") {
                                toggleGallerySetting("galleryCtaSetting", "galleryCtaChevron");
                            } else if (galleryFormContext === "gallery_frame_1" || galleryFormContext === "gallery_frame_2") {
                                toggleGallerySetting("galleryFrameSetting", "galleryFrameChevron");
                            } else if (galleryFormContext === "gallery_add") {
                                openAddModal();
                                document.getElementById("addTitle").value = galleryOldInput.title || "";
                                document.getElementById("addDescription").value = galleryOldInput.description || "";
                                document.getElementById("addCategory").value = galleryOldInput.category || "momen";
                            } else if (galleryFormContext === "gallery_update") {
                                const photoId = galleryOldInput.photo_id;
                                const photo = photoId ? galleryPhotosById[photoId] : null;

                                if (photo) {
                                    openUpdateModal(photo);
                                    document.getElementById("updateTitle").value = galleryOldInput.title || "";
                                    document.getElementById("updateDescription").value = galleryOldInput.description || "";
                                    document.getElementById("updateCategory").value = galleryOldInput.category || "momen";
                                }
                            }
                        }

                        // ========================================
                        // PERTAHANKAN FILTER KATEGORI SETELAH EDIT
                        // ========================================
                        const galleryCategoryFilter = document.getElementById("categoryFilter");
                        const galleryUpdateForm = document.getElementById("updateForm");
                        const savedGalleryCategory = sessionStorage.getItem("galleryCategoryAfterEdit");

                        // Pulihkan kategori setelah halaman kembali dimuat.
                        if (galleryCategoryFilter && savedGalleryCategory) {
                            galleryCategoryFilter.value = savedGalleryCategory;
                            sessionStorage.removeItem("galleryCategoryAfterEdit");
                            filterGallery();
                        }

                        // Simpan kategori yang sedang dipilih sebelum form edit dikirim.
                        if (galleryUpdateForm) {
                            galleryUpdateForm.addEventListener("submit", function() {
                                if (galleryCategoryFilter) {
                                    sessionStorage.setItem(
                                        "galleryCategoryAfterEdit",
                                        galleryCategoryFilter.value
                                    );
                                }
                            });
                        }

                        lucide.createIcons();
                    </script>
</body>

</html>
