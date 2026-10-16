<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Kelola Gallery</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logojossgandos.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>

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
                            <form action="{{ route('gallery.settings.update') }}" method="POST">
                                @csrf
                                @method ('PUT')

                                <div class="p-6">
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                        {{-- KOLOM KIRI --}}
                                        <div class="space-y-5">
                                            {{-- LABEL --}}
                                            <div>
                                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                                    Label
                                                </label>

                                                <input type="text" name="hero_badge"
                                                    value="{{ old('hero_badge', $gallerySetting->hero_badge ?? '') }}"
                                                    placeholder="Contoh: DOKUMENTASI"
                                                    class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                                            </div>

                                            {{-- JUDUL --}}
                                            <div>
                                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                                    Judul
                                                </label>

                                                <input type="text" name="hero_title"
                                                    value="{{ old('hero_title', $gallerySetting->hero_title ?? '') }}"
                                                    placeholder="Contoh: Galeri Kami"
                                                    class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                                            </div>

                                            {{-- DESKRIPSI --}}
                                            <div>
                                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                                    Deskripsi
                                                </label>

                                                <textarea name="hero_description" rows="6" placeholder="Masukkan deskripsi header Gallery..."
                                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none resize-y focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">{{ old('hero_description', $gallerySetting->hero_description ?? '') }}</textarea
                                                >
                                            </div>
                                        </div>

                                        {{-- KOLOM KANAN --}}
                                        <div>
                                            <label
                                                class="block text-sm font-semibold text-slate-700 mb-2"
                                            >
                                                URL Background Hero
                                            </label>

                                            <input
                                                type="url"
                                                name="hero_image"
                                                id="heroImageUrl"
                                                value="{{ old('hero_image', $gallerySetting->hero_image ?? '') }}"
                                                placeholder="https://..."
                                                oninput="previewHeroImage()"
                                                onchange="previewHeroImage()"
                                                class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                            />

                                            {{-- PREVIEW --}}
                                            <div class="mt-4">
                                                <div
                                                    id="heroImagePreview"
                                                    class="relative w-full h-72 rounded-2xl overflow-hidden border border-slate-200 bg-slate-50"
                                                >
                                                    {{-- GAMBAR --}}
                                                    <img
                                                        id="heroImagePreviewImg"
                                                        src="{{ old('hero_image', $gallerySetting->hero_image ?? '') }}"
                                                        alt="Preview Hero"
                                                        class="w-full h-full object-cover
                                                               {{ empty(old('hero_image', $gallerySetting->hero_image ?? '')) ? 'hidden' : '' }}"
                                                    />

                                                    {{-- KOSONG --}}
                                                    <div
                                                        id="heroImagePlaceholder"
                                                        class="{{ !empty(old('hero_image', $gallerySetting->hero_image ?? '')) ? 'hidden' : '' }}
                                                               absolute inset-0 flex flex-col items-center justify-center text-slate-400"
                                                    >
                                                        <i
                                                            data-lucide="image"
                                                            class="w-10 h-10 mb-2"
                                                        >
                                                        </i>

                                                        <span class="text-sm">
                                                            Preview gambar akan
                                                            tampil di sini
                                                        </span>
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
                                                <label
                                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                                >
                                                    Judul
                                                </label>

                                                <input
                                                    type="text"
                                                    name="cta_title"
                                                    value="{{ old('cta_title', $gallerySetting->cta_title ?? '') }}"
                                                    placeholder="Punya momen seru di Resto Joss Gandos?"
                                                    class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                                />
                                            </div>

                                            {{-- LINK --}}
                                            <div>
                                                <label
                                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                                >
                                                    Link Instagram
                                                </label>

                                                <input
                                                    type="url"
                                                    name="cta_button_1_link"
                                                    value="{{ old('cta_button_1_link', $gallerySetting->cta_button_1_link ?? '') }}"
                                                    placeholder="https://www.instagram.com/restojossgandos/"
                                                    class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                                />
                                            </div>

                                            {{-- DESKRIPSI --}}
                                            <div class="lg:col-span-2">
                                                <label
                                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                                >
                                                    Deskripsi
                                                </label>

                                                <textarea
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
                                                <label
                                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                                >
                                                    Judul
                                                </label>

                                                <input
                                                    type="text"
                                                    name="cta_whatsapp_title"
                                                    value="{{ old('cta_whatsapp_title', $gallerySetting->cta_whatsapp_title ?? '') }}"
                                                    placeholder="Butuh bantuan atau ingin reservasi?"
                                                    class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                                />
                                            </div>

                                            {{-- LINK --}}
                                            <div>
                                                <label
                                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                                >
                                                    Link WhatsApp
                                                </label>

                                                <input
                                                    type="text"
                                                    name="cta_button_2_link"
                                                    value="{{ old('cta_button_2_link', $gallerySetting->cta_button_2_link ?? '') }}"
                                                    placeholder="6289699071599 atau https://wa.me/6289699071599"
                                                    class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                                />

                                                <p class="mt-2 text-xs text-slate-500">Bisa diisi nomor WhatsApp atau link WhatsApp.</p>
                                            </div>

                                            {{-- DESKRIPSI --}}
                                            <div class="lg:col-span-2">
                                                <label
                                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                                >
                                                    Deskripsi
                                                </label>

                                                <textarea
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

                                        <div class="space-y-5">
                                            {{-- FOTO --}}
                                            <div>
                                                <div
                                                    class="grid grid-cols-1 lg:grid-cols-[220px_1fr] gap-6 items-start"
                                                >
                                                    {{-- PREVIEW KIRI --}}
                                                    <div>
                                                        <label
                                                            class="block text-sm font-semibold text-slate-700 mb-3"
                                                        >
                                                            Foto
                                                        </label>

                                                        <div
                                                            class="w-[220px] aspect-[4/3] mx-auto lg:mx-0 rounded-xl overflow-hidden border border-slate-200 bg-slate-50 flex items-center justify-center"
                                                        >
                                                            @php
                                                                $frame1Image = $gallerySetting->frame_1_image ?? '';

                                                                if (
                                                                    str_starts_with($frame1Image, 'http://') ||
                                                                    str_starts_with($frame1Image, 'https://')
                                                                ) {
                                                                    $frame1Url = $frame1Image;
                                                                } elseif ($frame1Image) {
                                                                    $frame1Url = asset(
                                                                        'storage/' . ltrim($frame1Image, '/'),
                                                                    );
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

                                                    {{-- UPLOAD + URL KANAN --}}
                                                    <div class="space-y-4">
                                                        {{-- UPLOAD --}}
                                                        <div>
                                                            <label
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

                                                            <p class="mt-1 text-xs text-slate-400">Maksimal 1 MB.</p>

                                                            <p
                                                                id="frame1SizeMessage"
                                                                class="hidden mt-2 text-xs text-red-500"
                                                            >Ukuran file lebih dari 1 MB. Harap kompres gambar terlebih dahulu hingga maksimal 1 MB.</p>
                                                        </div>

                                                        {{-- URL --}}
                                                        <div>
                                                            <label
                                                                class="block text-sm font-semibold text-slate-700 mb-2"
                                                            >
                                                                Atau Gunakan URL
                                                            </label>

                                                            <input
                                                                type="url"
                                                                name="frame_1_image"
                                                                id="frame1Url"
                                                                value="{{ old('frame_1_image', str_starts_with($gallerySetting->frame_1_image ?? '', 'http://') || str_starts_with($gallerySetting->frame_1_image ?? '', 'https://') ? $gallerySetting->frame_1_image : '') }}"
                                                                oninput="
                                                                    previewFrame1Url()
                                                                "
                                                                placeholder="https://contoh.com/foto.jpg"
                                                                class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- DESKRIPSI --}}
                                            <div>
                                                <label
                                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                                >
                                                    Deskripsi
                                                </label>

                                                <textarea
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

                                        <div class="space-y-5">
                                            {{-- FOTO --}}
                                            <div>
                                                <div
                                                    class="grid grid-cols-1 lg:grid-cols-[220px_1fr] gap-6 items-start"
                                                >
                                                    {{-- PREVIEW KIRI --}}
                                                    <div>
                                                        <label
                                                            class="block text-sm font-semibold text-slate-700 mb-3"
                                                        >
                                                            Foto
                                                        </label>

                                                        <div
                                                            class="w-[220px] aspect-[4/3] mx-auto lg:mx-0 rounded-xl overflow-hidden border border-slate-200 bg-slate-50 flex items-center justify-center"
                                                        >
                                                            @php
                                                                $frame2Image = $gallerySetting->frame_2_image ?? '';

                                                                if (
                                                                    str_starts_with($frame2Image, 'http://') ||
                                                                    str_starts_with($frame2Image, 'https://')
                                                                ) {
                                                                    $frame2Url = $frame2Image;
                                                                } elseif ($frame2Image) {
                                                                    $frame2Url = asset(
                                                                        'storage/' . ltrim($frame2Image, '/'),
                                                                    );
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

                                                    {{-- UPLOAD + URL KANAN --}}
                                                    <div class="space-y-4">
                                                        {{-- UPLOAD --}}
                                                        <div>
                                                            <label
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

                                                            <p class="mt-1 text-xs text-slate-400">Maksimal 1 MB.</p>

                                                            <p
                                                                id="frame2SizeMessage"
                                                                class="hidden mt-2 text-xs text-red-500"
                                                            >Ukuran file lebih dari 1 MB. Harap kompres gambar terlebih dahulu hingga maksimal 1 MB.</p>
                                                        </div>

                                                        {{-- URL --}}
                                                        <div>
                                                            <label
                                                                class="block text-sm font-semibold text-slate-700 mb-2"
                                                            >
                                                                Atau Gunakan URL
                                                            </label>

                                                            <input
                                                                type="url"
                                                                name="frame_2_image"
                                                                id="frame2Url"
                                                                value="{{ old('frame_2_image', str_starts_with($gallerySetting->frame_2_image ?? '', 'http://') || str_starts_with($gallerySetting->frame_2_image ?? '', 'https://') ? $gallerySetting->frame_2_image : '') }}"
                                                                oninput="
                                                                    previewFrame2Url()
                                                                "
                                                                placeholder="https://contoh.com/foto.jpg"
                                                                class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- DESKRIPSI --}}
                                            <div>
                                                <label
                                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                                >
                                                    Deskripsi
                                                </label>

                                                <textarea
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

                                                if (
                                                    \Illuminate\Support\Str::startsWith($imagePath, [
                                                        'http://',
                                                        'https://',
                                                    ])
                                                ) {
                                                    $imageUrl = $imagePath;
                                                } elseif (\Illuminate\Support\Str::startsWith($imagePath, 'storage/')) {
                                                    $imageUrl = asset($imagePath);
                                                } elseif (\Illuminate\Support\Str::startsWith($imagePath, 'public/')) {
                                                    $imageUrl = asset(substr($imagePath, 7));
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

                <div class="p-6 space-y-5">
                    {{-- FOTO GALLERY --}}
                    <div>
                        <label class="block text-sm font-medium mb-3">
                            Foto Gallery
                        </label>

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
                                    >
                                        Upload File
                                    </label>
                                    <input
                                        type="file"
                                        name="image_file"
                                        id="addImageFile"
                                        accept=".jpg,.jpeg,.png,.webp"
                                        onchange="handleAddGalleryFile()"
                                        class="block w-full text-sm text-slate-500 border border-slate-200 rounded-xl cursor-pointer bg-white file:mr-3 file:py-2.5 file:px-3 file:border-0 file:bg-slate-100 file:text-slate-700 file:font-medium"
                                    />
                                    <p id="addImageSizeMessage" class="hidden mt-2 text-xs text-red-500">Ukuran file lebih dari 1 MB. Harap kompres gambar terlebih dahulu hingga maksimal 1 MB.</p>
                                </div>

                                {{-- URL --}}
                                <div>
                                    <label
                                        class="block text-sm font-medium mb-2"
                                    >
                                        Atau Gunakan URL
                                    </label>
                                    <input
                                        type="url"
                                        name="image_path"
                                        id="addImageUrl"
                                        oninput="previewAddGalleryUrl()"
                                        placeholder="https://contoh.com/foto.jpg"
                                        class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- JUDUL --}}
                    <div>
                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Judul
                        </label>
                        <input
                            type="text"
                            name="title"
                            required
                            class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                        />
                    </div>

                    {{-- DESKRIPSI --}}
                    <div>
                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Deskripsi
                        </label>
                        <textarea
                            name="description"
                            rows="4"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none resize-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                        ></textarea>
                                            </div>

                                            {{-- KATEGORI --}}
                                            <div>
                                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                                    Kategori
                                                </label>
                                                <select name="category" required
                                                    class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                                                    <option value="momen">Momen</option>
                                                    <option value="facility">Fasilitas</option>
                                                    <option value="event">Event</option>
                                                </select>
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

                                <div class="p-6 space-y-5">
                                    {{-- FOTO GALLERY --}}
                                    <div>
                                        <label class="block text-sm font-medium mb-3">
                                            Foto Gallery
                                        </label>

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
                                                    <label class="block text-sm font-medium mb-2">
                                                        Ganti File
                                                    </label>
                                                    <input type="file" name="image_file" id="updateImageFile"
                                                        accept=".jpg,.jpeg,.png,.webp"
                                                        onchange="handleUpdateGalleryFile()"
                                                        class="block w-full text-sm text-slate-500 border border-slate-200 rounded-xl cursor-pointer bg-white file:mr-3 file:py-2.5 file:px-3 file:border-0 file:bg-slate-100 file:text-slate-700 file:font-medium" />
                                                    <p class="mt-1 text-xs text-slate-400">Maksimal 1 MB.</p>
                                                    <p id="updateImageSizeMessage"
                                                        class="hidden mt-2 text-xs text-red-500">Ukuran file lebih dari
                                                        1 MB. Harap kompres gambar terlebih dahulu hingga maksimal 1 MB.
                                                    </p>
                                                </div>

                                                {{-- URL --}}
                                                <div>
                                                    <label class="block text-sm font-medium mb-2">
                                                        Atau Gunakan URL
                                                    </label>
                                                    <input type="url" name="image_path" id="updateImage"
                                                        oninput="previewUpdateGalleryUrl()"
                                                        placeholder="https://contoh.com/foto.jpg"
                                                        class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- JUDUL --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                                            Judul
                                        </label>
                                        <input type="text" id="updateTitle" name="title" required
                                            class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                                    </div>

                                    {{-- DESKRIPSI --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                                            Deskripsi
                                        </label>
                                        <textarea id="updateDescription" name="description" rows="4"
                                            class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none resize-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"></textarea>
                                    </div>

                                    {{-- KATEGORI --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                                            Kategori
                                        </label>
                                        <select id="updateCategory" name="category" required
                                            class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                                            <option value="momen">Momen</option>
                                            <option value="facility">Fasilitas</option>
                                            <option value="event">Event</option>
                                        </select>
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

                        // Tampilkan preview Hero jika URL sudah tersimpan.
                        previewHeroImage();

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

                        // ========================================
                        // PREVIEW BACKGROUND HERO GALLERY
                        // ========================================

                        function previewHeroImage() {
                            const input = document.getElementById("heroImageUrl");
                            const preview = document.getElementById("heroImagePreview");
                            const image = document.getElementById("heroImagePreviewImg");
                            const placeholder = document.getElementById("heroImagePlaceholder");

                            if (!input || !preview || !image || !placeholder) {
                                return;
                            }

                            const url = input.value.trim();

                            // Kotak preview selalu tetap terlihat.
                            preview.classList.remove("hidden");

                            if (!url) {
                                image.classList.add("hidden");
                                placeholder.classList.remove("hidden");
                                image.src = "";
                                return;
                            }

                            image.onload = function() {
                                image.classList.remove("hidden");
                                placeholder.classList.add("hidden");
                            };

                            image.onerror = function() {
                                image.classList.add("hidden");
                                placeholder.classList.remove("hidden");
                                image.src = "";
                            };

                            image.src = url;
                        }

                        function previewFrame1File() {
                            const input = document.getElementById("frame1Upload");
                            const urlInput = document.getElementById("frame1Url");
                            const image = document.getElementById("frame1PreviewImage");
                            const text = document.getElementById("frame1PreviewText");
                            const message = document.getElementById("frame1SizeMessage");

                            const file = input.files[0];

                            if (!file) return;

                            // Maksimal 1 MB
                            if (file.size > 1024 * 1024) {
                                input.value = "";
                                message.classList.remove("hidden");
                                image.src = "";
                                image.classList.add("hidden");
                                text.classList.remove("hidden");
                                return;
                            }

                            message.classList.add("hidden");
                            urlInput.value = "";

                            const reader = new FileReader();

                            reader.onload = function(event) {
                                image.src = event.target.result;
                                image.classList.remove("hidden");
                                text.classList.add("hidden");
                            };

                            reader.readAsDataURL(file);
                        }

                        function previewFrame1Url() {
                            const input = document.getElementById("frame1Url");
                            const fileInput = document.getElementById("frame1Upload");
                            const image = document.getElementById("frame1PreviewImage");
                            const text = document.getElementById("frame1PreviewText");

                            const url = input.value.trim();

                            if (!url) return;

                            fileInput.value = "";

                            image.onload = function() {
                                image.classList.remove("hidden");
                                text.classList.add("hidden");
                            };

                            image.onerror = function() {
                                image.classList.add("hidden");
                                text.classList.remove("hidden");
                            };

                            image.src = url;
                        }

                        function previewFrame2File() {
                            const input = document.getElementById("frame2Upload");
                            const urlInput = document.getElementById("frame2Url");
                            const image = document.getElementById("frame2PreviewImage");
                            const text = document.getElementById("frame2PreviewText");
                            const message = document.getElementById("frame2SizeMessage");

                            const file = input.files[0];

                            if (!file) return;

                            // Maksimal 1 MB
                            if (file.size > 1024 * 1024) {
                                input.value = "";
                                message.classList.remove("hidden");
                                image.src = "";
                                image.classList.add("hidden");
                                text.classList.remove("hidden");
                                return;
                            }

                            message.classList.add("hidden");
                            urlInput.value = "";

                            const reader = new FileReader();

                            reader.onload = function(event) {
                                image.src = event.target.result;
                                image.classList.remove("hidden");
                                text.classList.add("hidden");
                            };

                            reader.readAsDataURL(file);
                        }

                        function previewFrame2Url() {
                            const input = document.getElementById("frame2Url");
                            const fileInput = document.getElementById("frame2Upload");
                            const image = document.getElementById("frame2PreviewImage");
                            const text = document.getElementById("frame2PreviewText");

                            const url = input.value.trim();

                            if (!url) return;

                            fileInput.value = "";

                            image.onload = function() {
                                image.classList.remove("hidden");
                                text.classList.add("hidden");
                            };

                            image.onerror = function() {
                                image.classList.add("hidden");
                                text.classList.remove("hidden");
                            };

                            image.src = url;
                        }

                        // ========================================
                        // PREVIEW FOTO TAMBAH
                        // ========================================

                        function handleAddGalleryFile() {
                            const fileInput = document.getElementById("addImageFile");
                            const urlInput = document.getElementById("addImageUrl");
                            const image = document.getElementById("addPreviewImage");
                            const text = document.getElementById("addPreviewText");
                            const message = document.getElementById("addImageSizeMessage");
                            const file = fileInput.files[0];

                            if (!file) return;

                            if (file.size > 1024 * 1024) {
                                fileInput.value = "";
                                message.classList.remove("hidden");
                                image.src = "";
                                image.classList.add("hidden");
                                text.classList.remove("hidden");
                                urlInput.disabled = false;
                                return;
                            }

                            message.classList.add("hidden");
                            urlInput.value = "";
                            urlInput.disabled = true;

                            const reader = new FileReader();
                            reader.onload = function(event) {
                                image.src = event.target.result;
                                image.classList.remove("hidden");
                                text.classList.add("hidden");
                            };
                            reader.readAsDataURL(file);
                        }

                        function previewAddGalleryUrl() {
                            const fileInput = document.getElementById("addImageFile");
                            const urlInput = document.getElementById("addImageUrl");
                            const image = document.getElementById("addPreviewImage");
                            const text = document.getElementById("addPreviewText");
                            const url = urlInput.value.trim();
                            const sizeMessage = document.getElementById("addImageSizeMessage");

                            sizeMessage.classList.add("hidden");

                            if (!url) {
                                fileInput.disabled = false;
                                image.src = "";
                                image.classList.add("hidden");
                                text.classList.remove("hidden");
                                return;
                            }

                            fileInput.value = "";
                            fileInput.disabled = true;

                            image.onload = function() {
                                image.classList.remove("hidden");
                                text.classList.add("hidden");
                            };

                            image.onerror = function() {
                                image.classList.add("hidden");
                                text.classList.remove("hidden");
                            };

                            image.src = url;
                        }

                        // ========================================
                        // PREVIEW FOTO UPDATE
                        // ========================================

                        function handleUpdateGalleryFile() {
                            const fileInput = document.getElementById("updateImageFile");
                            const urlInput = document.getElementById("updateImage");
                            const image = document.getElementById("updatePreviewImage");
                            const text = document.getElementById("updatePreviewText");
                            const message = document.getElementById("updateImageSizeMessage");
                            const file = fileInput.files[0];

                            if (!file) return;

                            if (file.size > 1024 * 1024) {
                                fileInput.value = "";
                                message.classList.remove("hidden");
                                urlInput.disabled = false;
                                return;
                            }

                            message.classList.add("hidden");
                            urlInput.value = "";
                            urlInput.disabled = true;

                            const reader = new FileReader();
                            reader.onload = function(event) {
                                image.src = event.target.result;
                                image.classList.remove("hidden");
                                text.classList.add("hidden");
                            };
                            reader.readAsDataURL(file);
                        }

                        function previewUpdateGalleryUrl() {
                            const fileInput = document.getElementById("updateImageFile");
                            const urlInput = document.getElementById("updateImage");
                            const image = document.getElementById("updatePreviewImage");
                            const text = document.getElementById("updatePreviewText");
                            const url = urlInput.value.trim();

                            if (!url) {
                                fileInput.disabled = false;
                                return;
                            }

                            fileInput.value = "";
                            fileInput.disabled = true;

                            image.onload = function() {
                                image.classList.remove("hidden");
                                text.classList.add("hidden");
                            };

                            image.onerror = function() {
                                image.classList.add("hidden");
                                text.classList.remove("hidden");
                            };

                            image.src = url;
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
                            const imageUrlInput = document.getElementById("updateImage");
                            const imageFileInput = document.getElementById("updateImageFile");
                            const previewImage = document.getElementById("updatePreviewImage");
                            const previewText = document.getElementById("updatePreviewText");
                            const sizeMessage = document.getElementById(
                                "updateImageSizeMessage",
                            );

                            form.action = `/dashboard/gallery/${photo.id}`;

                            document.getElementById("updateTitle").value = photo.title || "";
                            document.getElementById("updateDescription").value =
                                photo.description || "";
                            document.getElementById("updateCategory").value =
                                photo.category || "momen";

                            imageFileInput.value = "";
                            imageFileInput.disabled = false;
                            sizeMessage.classList.add("hidden");
                            imageUrlInput.value = "";
                            imageUrlInput.disabled = false;

                            const imagePath = photo.image_path || "";

                            if (imagePath) {
                                let imageUrl = imagePath;

                                if (
                                    !imagePath.startsWith("http://") &&
                                    !imagePath.startsWith("https://")
                                ) {
                                    if (imagePath.startsWith("storage/")) {
                                        imageUrl = "/" + imagePath;
                                    } else {
                                        imageUrl = "/storage/" + imagePath.replace(/^\/+/, "");
                                    }
                                }

                                previewImage.src = imageUrl;
                                previewImage.classList.remove("hidden");
                                previewText.classList.add("hidden");

                                if (
                                    imagePath.startsWith("http://") ||
                                    imagePath.startsWith("https://")
                                ) {
                                    imageUrlInput.value = imagePath;
                                }
                            } else {
                                previewImage.src = "";
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
                    </script>
</body>

</html>
