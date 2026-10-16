<!DOCTYPE html>
<html lang="en">
<style>
    .home-scroll {
        scrollbar-width: thin;
    }

    .home-scroll::-webkit-scrollbar {
        width: 8px;
    }
</style>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Kelola Home - Resto Joss Gandos</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logojossgandos.png') }}">

    @vite (['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css" />
</head>

<body class="bg-slate-50 overflow-hidden">
    <div class="flex h-screen">
        {{-- =====================================================
             SIDEBAR
        ====================================================== --}}
        @include ('layouts.sidebar')

        {{-- =====================================================
             CONTENT
        ====================================================== --}}
        <main class="flex-1 flex flex-col h-screen min-w-0 bg-slate-50">
            {{-- =====================================================
                 HEADER HALAMAN
            ====================================================== --}}
            <header class="flex-shrink-0 bg-white border-b border-slate-200 shadow-sm px-6 py-4 z-20">
                <div class="flex items-center justify-between gap-4">
                    {{-- KIRI --}}
                    <div class="flex items-center gap-4 min-w-0">
                        {{-- MOBILE MENU --}}
                        <button type="button" onclick="toggleSidebar()"
                            class="md:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-lg shrink-0">
                            <i class="uil uil-bars text-2xl"></i>
                        </button>

                        <div class="min-w-0">
                            <h1 class="text-xl font-bold text-slate-800">
                                Kelola Home
                            </h1>
                        </div>
                    </div>

                    {{-- KANAN --}}
                    <button type="button" id="saveAllHomeChanges"
                        class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-sm transition shrink-0">
                        <i class="uil uil-save"></i>
                        Simpan Semua Perubahan
                    </button>
                </div>
            </header>

            {{-- =====================================================
                 ISI HOME
            ====================================================== --}}
            <div class="home-scroll flex-1 overflow-y-auto p-6 space-y-6">
                {{-- =================================================
                     1. PENGATURAN VIDEO HEADER
                ================================================== --}}
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-xl font-bold text-slate-800">
                                Pengaturan Video Header
                            </h2>

                            <p class="text-sm text-slate-500 mt-1">Atur video yang digunakan pada bagian header Home.
                            </p>
                        </div>

                        <div
                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-100 text-slate-500 text-xs font-medium">
                            <i class="uil uil-video"></i>

                            Header Home
                        </div>
                    </div>

                    <form action="{{ route('header.update') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6 home-bulk-update-form">
                        @csrf
                        @method ('PUT')

                        {{-- ================= SUMBER VIDEO ================= --}}
                        <div>
                            <label class="block font-semibold text-slate-700 mb-3">
                                Sumber Video
                            </label>

                            <div class="grid sm:grid-cols-3 gap-4">
                                {{-- YOUTUBE --}}
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="source_type" value="youtube" class="peer sr-only"
                                        {{ old('source_type', $header->video_type ?? 'youtube') === 'youtube' ? 'checked' : '' }} />

                                    <div
                                        class="rounded-2xl border border-slate-200 p-5 peer-checked:border-indigo-500 peer-checked:bg-indigo-50/50 hover:border-indigo-300 transition">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-11 h-11 rounded-xl bg-red-50 text-red-600 flex items-center justify-center">
                                                <i class="uil uil-youtube text-2xl"></i>
                                            </div>

                                            <div>
                                                <p class="font-bold text-slate-800">Link YouTube</p>

                                                <p class="text-xs text-slate-500 mt-1">Gunakan video dari YouTube</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                {{-- TIKTOK --}}
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="source_type" value="tiktok" class="peer sr-only"
                                        {{ old('source_type', $header->video_type ?? 'youtube') === 'tiktok' ? 'checked' : '' }} />

                                    <div
                                        class="rounded-2xl border border-slate-200 p-5 peer-checked:border-indigo-500 peer-checked:bg-indigo-50/50 hover:border-indigo-300 transition">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-11 h-11 rounded-xl bg-slate-100 text-slate-800 flex items-center justify-center">
                                                <i class="uil uil-music text-2xl"></i>
                                            </div>

                                            <div>
                                                <p class="font-bold text-slate-800">Link TikTok</p>
                                                <p class="text-xs text-slate-500 mt-1">
                                                    Gunakan video dari TikTok
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                {{-- UPLOAD --}}
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="source_type" value="file" class="peer sr-only"
                                        {{ old('source_type', $header->video_type ?? 'youtube') === 'file' ? 'checked' : '' }} />

                                    <div
                                        class="rounded-2xl border border-slate-200 p-5 peer-checked:border-indigo-500 peer-checked:bg-indigo-50/50 hover:border-indigo-300 transition">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                                                <i class="uil uil-upload text-2xl"></i>
                                            </div>

                                            <div>
                                                <p class="font-bold text-slate-800">Upload File (MP4)</p>

                                                <p class="text-xs text-slate-500 mt-1">Upload video dari komputer</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- ================= YOUTUBE URL ================= --}}
                        <div id="youtubeField">
                            <label for="youtube_url" class="block font-semibold text-slate-700">
                                URL YouTube
                            </label>

                            <p class="text-xs text-slate-500 mt-1 mb-2">Copy paste link lengkap dari browser.</p>

                            <input type="url" id="youtube_url" name="youtube_url"
                                value="{{ old('youtube_url', !empty($header->youtube_id) ? 'https://www.youtube.com/watch?v=' . $header->youtube_id : '') }}"
                                class="w-full border border-slate-200 rounded-xl p-3.5 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                placeholder="https://www.youtube.com/watch?v=xxxxxxxxxxx" />
                        </div>

                        {{-- ================= TIKTOK URL ================= --}}
                        <div id="tiktokField" class="hidden">
                            <label for="tiktok_url" class="block font-semibold text-slate-700">
                                URL TikTok
                            </label>

                            <p class="text-xs text-slate-500 mt-1 mb-2">
                                Copy paste link lengkap dari browser.
                            </p>

                            <input type="url" id="tiktok_url" name="tiktok_url"
                                value="{{ old('tiktok_url', $header->tiktok_url ?? '') }}"
                                class="w-full border border-slate-200 rounded-xl p-3.5 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                placeholder="https://www.tiktok.com/@akun/video/xxxxxxxxxxxx" />
                        </div>

                        {{-- ================= UPLOAD FILE ================= --}}
                        <div id="fileField" class="hidden">
                            <label for="video_file" class="block font-semibold text-slate-700">
                                Upload Video
                            </label>

                            <p class="text-xs text-slate-500 mt-1 mb-2">Format yang didukung: MP4 / MOV, maksimal 20 MB.
                            </p>

                            <div class="flex items-center gap-3 border border-slate-200 rounded-xl p-3 bg-white">

                                <input type="file" id="video_file" name="video_file"
                                    accept="video/mp4,video/quicktime" class="hidden"
                                    onchange="document.getElementById('videoFileName').textContent =
                                    this.files.length ? this.files[0].name : 'Belum ada file dipilih'" />

                                <label for="video_file"
                                    class="shrink-0 cursor-pointer rounded-lg bg-indigo-50 px-4 py-2
                                    text-sm font-semibold text-indigo-700 hover:bg-indigo-100">
                                    <i class="uil uil-upload mr-1"></i>
                                    Pilih Video
                                </label>

                                <span id="videoFileName" class="min-w-0 truncate text-sm text-slate-500">
                                    Belum ada file dipilih
                                </span>

                            </div>
                        </div>

                        {{-- ================= TOMBOL SIMPAN ================= --}}
                        <div class="flex justify-end pt-2">
                            <button type="submit"
                                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-semibold transition">
                                <i class="uil uil-save"></i>

                                Simpan Video Header
                            </button>
                        </div>
                    </form>
                </section>

                {{-- =================================================
     2. HERO HOME
================================================== --}}
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
                    <form action="{{ route('dashboard.home.settings') }}" method="POST"
                        class="home-bulk-update-form">
                        @csrf

                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                            <div>
                                <h2 class="text-xl font-bold text-slate-800">
                                    Hero Section
                                </h2>

                                <p class="text-sm text-slate-500 mt-1">Kelola tulisan utama yang tampil pada header
                                    Home.</p>
                            </div>

                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-medium">
                                <i class="uil uil-save mr-1"></i>

                                {{ $settings ? 'Update' : 'Simpan' }}
                            </button>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-8">
                            {{-- KIRI --}}
                            <div class="space-y-5">
                                {{-- BADGE --}}
                                <div>
                                    <label class="font-medium text-slate-700">
                                        Badge
                                    </label>

                                    <input type="text" name="hero_badge"
                                        value="{{ old('hero_badge', $settings?->hero_badge) }}"
                                        class="w-full mt-2 border border-slate-200 rounded-xl p-3"
                                        placeholder="Est. 2017" />
                                </div>

                                {{-- JUDUL --}}
                                <div>
                                    <label class="font-medium text-slate-700">
                                        Judul
                                    </label>

                                    <input type="text" name="hero_title"
                                        value="{{ old('hero_title', $settings?->hero_title) }}"
                                        class="w-full mt-2 border border-slate-200 rounded-xl p-3"
                                        placeholder="Resto Joss Gandos" />
                                </div>
                            </div>

                            {{-- KANAN --}}
                            <div>
                                <label class="font-medium text-slate-700">
                                    Subtitle
                                </label>

                                <textarea name="hero_subtitle" rows="6" class="w-full mt-2 border border-slate-200 rounded-xl p-4 resize-none"
                                    placeholder="Pelopor No. 1 Resto dan Cafe di Jemursari">{{ old('hero_subtitle', $settings?->hero_subtitle) }}</textarea
                                    >
                                </div>
                            </div>
                        </form>
                    </section>

                    {{-- =================================================
     3. WELCOME
================================================== --}}
                    <section
                        class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8"
                    >
                        <form
                            action="{{ route('dashboard.home.settings') }}"
                            method="POST"
                            class="home-bulk-update-form"
                        >
                            @csrf

                            {{-- ================= HEADER ================= --}}
                            <div
                                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6"
                            >
                                <div>
                                    <h2
                                        class="text-xl font-bold text-slate-800"
                                    >
                                        Welcome Section
                                    </h2>

                                    <p class="text-sm text-slate-500 mt-1">Kelola tulisan sambutan dan foto pada Home.</p>
                                </div>

                                <button
                                    type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-medium transition"
                                >
                                    <i class="uil uil-save mr-1"></i>

                                    {{ $settings ? 'Update' : 'Simpan' }}
                                </button>
                            </div>

                            {{-- ================= BARIS ATAS ================= --}}
                            <div class="grid lg:grid-cols-2 gap-8">
                                {{-- ================= KIRI ================= --}}
                                <div class="space-y-5">
                                    {{-- LABEL --}}
                                    <div>
                                        <label
                                            for="welcome_badge"
                                            class="block font-medium text-slate-700"
                                        >
                                            Label
                                        </label>

                                        <input
                                            type="text"
                                            id="welcome_badge"
                                            name="welcome_badge"
                                            value="{{ old('welcome_badge', $settings?->welcome_badge) }}"
                                            class="w-full mt-2 border border-slate-200 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                            placeholder="Selamat Datang Di"
                                        />
                                    </div>

                                    {{-- JUDUL --}}
                                    <div>
                                        <label
                                            for="welcome_title"
                                            class="block font-medium text-slate-700"
                                        >
                                            Judul
                                        </label>

                                        <input
                                            type="text"
                                            id="welcome_title"
                                            name="welcome_title"
                                            value="{{ old('welcome_title', $settings?->welcome_title) }}"
                                            class="w-full mt-2 border border-slate-200 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                            placeholder="Resto Joss Gandos"
                                        />
                                    </div>

                                    {{-- FOTO --}}
                                    <div>
                                        <label
                                            for="welcome_image"
                                            class="block font-medium text-slate-700"
                                        >
                                            Foto
                                        </label>

                                        <input
                                            type="url"
                                            id="welcome_image"
                                            name="welcome_image"
                                            value="{{ old('welcome_image', $settings?->welcome_image) }}"
                                            class="w-full mt-2 border border-slate-200 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                            placeholder="https://..."
                                        />
                                    </div>
                                </div>

                                {{-- ================= KANAN : PREVIEW ================= --}}
                                <div>
                                    <label
                                        class="block font-medium text-slate-700"
                                    >
                                        Preview Foto
                                    </label>

                                    <div
                                        class="mt-2 w-full max-w-[340px] aspect-square rounded-2xl border border-slate-200 bg-slate-50 overflow-hidden flex items-center justify-center"
                                    >
                                        @if ($settings?->welcome_image)
<img
                                                id="welcomeImagePreview"
                                                src="{{ $settings->welcome_image }}"
                                                alt="Preview Welcome"
                                                class="w-full h-full object-cover"
                                            />
@else
<div
                                                id="welcomeImageEmpty"
                                                class="text-center text-slate-400 px-6"
                                            >
                                                <i
                                                    class="uil uil-image text-5xl"
                                                ></i>

                                                <p class="text-sm mt-3">Preview gambar akan muncul di sini</p>
                                            </div>

                                            <img
                                                id="welcomeImagePreview"
                                                src=""
                                                alt="Preview Welcome"
                                                class="hidden w-full h-full object-cover"
                                            />
@endif
                                    </div>
                                </div>
                            </div>

                            {{-- ================= BARIS BAWAH ================= --}}
                            <div class="grid lg:grid-cols-2 gap-8 mt-8">
                                {{-- DESKRIPSI --}}
                                <div>
                                    <label
                                        for="welcome_description"
                                        class="block font-medium text-slate-700"
                                    >
                                        Deskripsi
                                    </label>

                                    <textarea
                                        id="welcome_description"
                                        name="welcome_description"
                                        rows="7"
                                        class="w-full mt-2 border border-slate-200 rounded-xl p-4 resize-none focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        placeholder="Masukkan deskripsi..."
                                        >{{ old('welcome_description', $settings?->welcome_description) }}</textarea
                                    >
                                </div>

                                {{-- KALIMAT PENUTUP --}}
                                <div>
                                    <label
                                        for="welcome_quote"
                                        class="block font-medium text-slate-700"
                                    >
                                        Kalimat Penutup
                                    </label>

                                    <textarea
                                        id="welcome_quote"
                                        name="welcome_quote"
                                        rows="7"
                                        class="w-full mt-2 border border-slate-200 rounded-xl p-4 resize-none focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        placeholder="Selamat menikmati pengalaman bersantap istimewa."
                                        >{{ old('welcome_quote', $settings?->welcome_quote) }}</textarea
                                    >
                                </div>
                            </div>
                        </form>
                    </section>

                    {{-- =================================================
     3.5 KEUNGGULAN WELCOME
================================================== --}}
                    <section
                        class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8"
                    >
                        {{-- HEADER --}}
                        <div
                            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6"
                        >
                            <div>
                                <h2 class="text-xl font-bold text-slate-800">
                                    Keunggulan Welcome
                                </h2>

                                <p class="text-sm text-slate-500 mt-1">Kelola 4 informasi kecil yang tampil di bawah Welcome pada Home.</p>
                            </div>

                            <button
                                type="button"
                                id="toggleWelcomeFeatureButton"
                                class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl font-medium transition"
                            >
                                <i class="uil uil-plus mr-1"></i>
                                Tambah Keunggulan
                            </button>
                        </div>

                        {{-- =================================================
         FORM TAMBAH
    ================================================== --}}
                        <div
                            id="welcomeFeatureAddForm"
                            class="hidden mb-6 rounded-2xl border border-emerald-200 bg-emerald-50/40 p-5"
                        >
                            <form
                                action="{{ route('dashboard.home.welcome-features.store') }}"
                                method="POST"
                                enctype="multipart/form-data"
                            >
                                @csrf

                                <div
                                    class="grid lg:grid-cols-[220px_1fr] gap-6"
                                >
                                    {{-- ================= IKON ================= --}}
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-slate-600 mb-2"
                                        >
                                            Ikon
                                        </label>

                                        {{-- PREVIEW --}}
                                        <div
                                            class="w-[180px] h-[180px] rounded-2xl border-2 border-dashed border-slate-300 bg-white overflow-hidden flex items-center justify-center"
                                        >
                                            <div
                                                id="welcomeFeatureAddIconEmpty"
                                                class="text-center text-slate-400"
                                            >
                                                <i
                                                    class="uil uil-image text-4xl"
                                                ></i>

                                                <p class="text-xs mt-2">Preview Ikon</p>
                                            </div>

                                            <img
                                                id="welcomeFeatureAddIconPreview"
                                                src=""
                                                alt="Preview Ikon"
                                                class="hidden w-full h-full object-contain p-5"
                                            />
                                        </div>

                                        {{-- PILIH SUMBER --}}
                                        <div class="flex gap-2 mt-4">
                                            <button
                                                type="button"
                                                id="welcomeFeatureUploadTab"
                                                onclick="
                                                    setWelcomeFeatureIconSource(
                                                        'upload',
                                                    )
                                                "
                                                class="px-4 py-2.5 rounded-xl bg-indigo-600 text-white font-medium"
                                            >
                                                <i class="uil uil-upload"></i>
                                                Upload Ikon
                                            </button>

                                            <button
                                                type="button"
                                                id="welcomeFeatureUrlTab"
                                                onclick="
                                                    setWelcomeFeatureIconSource(
                                                        'url',
                                                    )
                                                "
                                                class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-600 font-medium"
                                            >
                                                <i class="uil uil-link"></i>
                                                Link Ikon
                                            </button>
                                        </div>

                                        {{-- UPLOAD --}}
                                        <div
                                            id="welcomeFeatureIconUploadBox"
                                            class="mt-3"
                                        >
                                            <input
                                                type="file"
                                                id="welcomeFeatureAddIcon"
                                                name="icon"
                                                accept=".png,.jpg,.jpeg,.webp,.svg"
                                                class="hidden"
                                            />

                                            <label
                                                for="welcomeFeatureAddIcon"
                                                class="inline-flex items-center gap-2 cursor-pointer px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-sm font-medium text-slate-700"
                                            >
                                                <i
                                                    class="uil uil-image-plus"
                                                ></i>
                                                Pilih File Ikon
                                            </label>
                                        </div>

                                        {{-- LINK --}}
                                        <div
                                            id="welcomeFeatureIconUrlBox"
                                            class="hidden mt-3"
                                        >
                                            <input
                                                type="url"
                                                id="welcomeFeatureAddIconUrl"
                                                name="icon_url"
                                                class="w-full border border-slate-200 rounded-xl p-3 bg-white"
                                                placeholder="https://contoh.com/icon.png"
                                            />

                                            <p class="text-xs text-slate-400 mt-2">Masukkan URL langsung ke gambar ikon.</p>
                                        </div>
                                    </div>

                                    {{-- ================= DATA ================= --}}
                                    <div class="space-y-5">
                                        {{-- JUDUL --}}
                                        <div>
                                            <label
                                                for="welcomeFeatureAddTitle"
                                                class="block text-sm font-medium text-slate-600 mb-2"
                                            >
                                                Judul
                                            </label>

                                            <input
                                                type="text"
                                                id="welcomeFeatureAddTitle"
                                                name="title"
                                                required
                                                class="w-full border border-slate-200 rounded-xl p-3 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                                placeholder="Contoh: Cita Rasa"
                                            />
                                        </div>

                                        {{-- DESKRIPSI --}}
                                        <div>
                                            <label
                                                for="welcomeFeatureAddDescription"
                                                class="block text-sm font-medium text-slate-600 mb-2"
                                            >
                                                Deskripsi
                                            </label>

                                            <input
                                                type="text"
                                                id="welcomeFeatureAddDescription"
                                                name="description"
                                                required
                                                class="w-full border border-slate-200 rounded-xl p-3 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                                placeholder="Contoh: Nusantara"
                                            />
                                        </div>

                                        {{-- BUTTON --}}
                                        <div
                                            class="flex justify-end gap-2 pt-2"
                                        >
                                            <button
                                                type="button"
                                                onclick="
                                                    document
                                                        .getElementById(
                                                            'welcomeFeatureAddForm',
                                                        )
                                                        .classList.add('hidden')
                                                "
                                                class="px-5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 font-medium"
                                            >
                                                Batal
                                            </button>

                                            <button
                                                type="submit"
                                                class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-medium"
                                            >
                                                <i
                                                    class="uil uil-save mr-1"
                                                ></i>
                                                Simpan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        {{-- =================================================
         DATA WELCOME FEATURES
    ================================================== --}}
                        @if ($welcomeFeatures->count() > 0)
<div
                                class="h-[420px] overflow-y-auto space-y-4 pr-2"
                            >
                                @foreach ($welcomeFeatures as $welcomeFeature)
<div
                                        class="rounded-2xl border border-slate-200 bg-slate-50 overflow-hidden"
                                    >
                                        {{-- HEADER ITEM --}}
                                        <button
                                            type="button"
                                            onclick="toggleWelcomeFeatureItem({{ $welcomeFeature->id }})"
                                            class="w-full flex items-center gap-4 px-5 py-4 text-left hover:bg-slate-100 transition"
                                        >
                                            {{-- IKON --}}
                                            <div
                                                class="w-12 h-12 rounded-xl bg-white border border-slate-200 overflow-hidden flex items-center justify-center flex-shrink-0"
                                            >
                                                @if ($welcomeFeature->icon)
@if (filter_var($welcomeFeature->icon, FILTER_VALIDATE_URL))
<img
                                                            src="{{ $welcomeFeature->icon }}"
                                                            alt="{{ $welcomeFeature->title }}"
                                                            class="w-full h-full object-contain p-4"
                                                        />
@else
<img
                                                            src="{{ asset('storage/' . $welcomeFeature->icon) }}"
                                                            alt="{{ $welcomeFeature->title }}"
                                                            class="w-full h-full object-contain p-4"
                                                        />
@endif
@else
<i
                                                        class="uil uil-image-slash text-xl text-slate-300"
                                                    ></i>
@endif
                                            </div>

                                            {{-- JUDUL --}}
                                            <div class="flex-1 min-w-0">
                                                <h3
                                                    class="font-semibold text-slate-800 truncate"
                                                >
                                                    {{ $welcomeFeature->title }}
                                                </h3>

                                                <p class="text-xs text-slate-400 mt-1">
                                                    {{ $welcomeFeature->description }}
                                                </p>
                                            </div>

                                            {{-- PANAH --}}
                                            <i
                                                id="welcomeFeatureArrow-{{ $welcomeFeature->id }}"
                                                class="uil uil-angle-down text-xl text-slate-500 transition-transform duration-200"
                                            ></i>
                                        </button>

                                        {{-- DETAIL / UPDATE --}}
                                        <div
                                            id="welcomeFeatureDetail-{{ $welcomeFeature->id }}"
                                            class="hidden border-t border-slate-200 bg-white"
                                        >
                                            <form
                                                action="{{ route('dashboard.home.welcome-features.update', $welcomeFeature->id) }}"
                                                method="POST"
                                                enctype="multipart/form-data"
                                                class="p-5 home-bulk-update-form"
                                            >
                                                @csrf
                                                @method ('PUT')

                                                <div
                                                    class="grid lg:grid-cols-[180px_1fr] gap-6"
                                                >
                                                    {{-- IKON --}}
                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-slate-600 mb-2"
                                                        >
                                                            Ikon
                                                        </label>

                                                        <div
                                                            class="w-[140px] h-[140px] rounded-2xl bg-slate-50 border border-slate-200 overflow-hidden flex items-center justify-center"
                                                        >
                                                            @if ($welcomeFeature->icon)
@if (filter_var($welcomeFeature->icon, FILTER_VALIDATE_URL))
<img
                                                                        id="welcomeUpdatePreview-{{ $welcomeFeature->id }}"
                                                                        src="{{ $welcomeFeature->icon }}"
                                                                        alt="{{ $welcomeFeature->title }}"
                                                                        class="w-full h-full object-contain p-4"
                                                                    />
@else
<img
                                                                        id="welcomeUpdatePreview-{{ $welcomeFeature->id }}"
                                                                        src="{{ asset('storage/' . $welcomeFeature->icon) }}"
                                                                        alt="{{ $welcomeFeature->title }}"
                                                                        class="w-full h-full object-contain p-4"
                                                                    />
@endif
@else
<i
                                                                    class="uil uil-image-slash text-3xl text-slate-300"
                                                                ></i>
@endif
                                                        </div>

                                                        <div
                                                            class="flex gap-2 mt-4"
                                                        >
                                                            <button
                                                                type="button"
                                                                id="welcomeUpdateUploadTab-{{ $welcomeFeature->id }}"
                                                                onclick="setWelcomeUpdateIconSource({{ $welcomeFeature->id }}, 'upload')"
                                                                class="px-4 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-medium"
                                                            >
                                                                <i
                                                                    class="uil uil-upload"
                                                                ></i>
                                                                Upload Ikon
                                                            </button>

                                                            <button
                                                                type="button"
                                                                id="welcomeUpdateUrlTab-{{ $welcomeFeature->id }}"
                                                                onclick="setWelcomeUpdateIconSource({{ $welcomeFeature->id }}, 'url')"
                                                                class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-600 text-sm font-medium"
                                                            >
                                                                <i
                                                                    class="uil uil-link"
                                                                ></i>
                                                                Link Ikon
                                                            </button>
                                                        </div>

                                                        {{-- UPLOAD --}}
                                                        <div
                                                            id="welcomeUpdateIconUploadBox-{{ $welcomeFeature->id }}"
                                                            class="mt-3"
                                                        >
                                                            <input
                                                                type="file"
                                                                id="welcomeUpdateIconFile-{{ $welcomeFeature->id }}"
                                                                name="icon"
                                                                accept=".png,.jpg,.jpeg,.webp,.svg"
                                                                class="hidden"
                                                            />

                                                            <label
                                                                for="welcomeUpdateIconFile-{{ $welcomeFeature->id }}"
                                                                class="inline-flex items-center gap-2 cursor-pointer px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-sm font-medium text-slate-700"
                                                            >
                                                                <i
                                                                    class="uil uil-image-plus"
                                                                ></i>
                                                                Pilih File Ikon
                                                            </label>
                                                        </div>

                                                        {{-- URL --}}
                                                        <div
                                                            id="welcomeUpdateIconUrlBox-{{ $welcomeFeature->id }}"
                                                            class="hidden mt-3"
                                                        >
                                                            <input
                                                                type="url"
                                                                id="welcomeUpdateIconUrl-{{ $welcomeFeature->id }}"
                                                                name="icon_url"
                                                                class="w-full border border-slate-200 rounded-xl p-3 bg-white"
                                                                placeholder="https://contoh.com/icon.png"
                                                            />
                                                        </div>
                                                    </div>

                                                    {{-- DATA --}}
                                                    <div class="space-y-5">
                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium text-slate-600 mb-2"
                                                            >
                                                                Judul
                                                            </label>

                                                            <input
                                                                type="text"
                                                                name="title"
                                                                value="{{ $welcomeFeature->title }}"
                                                                required
                                                                class="w-full border border-slate-200 rounded-xl p-3 bg-white"
                                                            />
                                                        </div>

                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium text-slate-600 mb-2"
                                                            >
                                                                Deskripsi
                                                            </label>

                                                            <input
                                                                type="text"
                                                                name="description"
                                                                value="{{ $welcomeFeature->description }}"
                                                                required
                                                                class="w-full border border-slate-200 rounded-xl p-3 bg-white"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- ACTION --}}
                                                <div
                                                    class="flex justify-end gap-2 mt-5"
                                                >
                                                    <button
                                                        type="button"
                                                        onclick="deleteWelcomeFeature({{ $welcomeFeature->id }})"
                                                        class="inline-flex items-center gap-2 bg-red-100 hover:bg-red-200 text-red-600 px-5 py-2.5 rounded-xl font-medium"
                                                    >
                                                        <i
                                                            class="uil uil-trash-alt"
                                                        ></i>
                                                        Hapus
                                                    </button>

                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center gap-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-600 px-5 py-2.5 rounded-xl font-medium"
                                                    >
                                                        <i
                                                            class="uil uil-edit"
                                                        ></i>
                                                        Update
                                                    </button>
                                                </div>
                                            </form>

                                            {{-- FORM HAPUS --}}
                                            <form
                                                id="deleteWelcomeFeature-{{ $welcomeFeature->id }}"
                                                action="{{ route('dashboard.home.welcome-features.destroy', $welcomeFeature->id) }}"
                                                method="POST"
                                                class="hidden"
                                            >
                                                @csrf
                                                @method ('DELETE')
                                            </form>
                                        </div>
                                    </div>
@endforeach
                            </div>
@else
<div
                                class="border-2 border-dashed border-slate-200 rounded-2xl py-12 text-center"
                            >
                                <i
                                    class="uil uil-star text-4xl text-slate-300"
                                ></i>

                                <p class="mt-3 text-slate-500">Belum ada data Keunggulan Welcome.</p>

                                <p class="text-xs text-slate-400 mt-1">Klik "Tambah Keunggulan" untuk menambahkan data.</p>
                            </div>
@endif
                    </section>

                    {{-- =================================================
     4. PENGATURAN SECTION KEUNGGULAN
================================================== --}}
                    <section
                        class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8"
                    >
                        <div
                            class="flex items-center justify-between gap-4 mb-6"
                        >
                            <div>
                                <h2 class="text-xl font-bold text-slate-800">
                                    Pengaturan Section Keunggulan
                                </h2>

                                <p class="text-sm text-slate-500 mt-1">Atur judul section yang tampil pada Home customer.</p>
                            </div>
                        </div>

                        <form
                            action="{{ route('dashboard.home.settings') }}"
                            method="POST"
                            class="home-bulk-update-form"
                        >
                            @csrf

                            <div class="grid lg:grid-cols-2 gap-5">
                                {{-- LABEL --}}
                                <div>
                                    <label
                                        for="feature_badge"
                                        class="block text-sm font-medium text-slate-700 mb-2"
                                    >
                                        Label Section
                                    </label>

                                    <input
                                        type="text"
                                        id="feature_badge"
                                        name="feature_badge"
                                        value="{{ old('feature_badge', $settings?->feature_badge) }}"
                                        class="w-full border border-slate-200 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        placeholder="Kenapa Memilih Kami"
                                    />
                                </div>

                                {{-- JUDUL --}}
                                <div>
                                    <label
                                        for="feature_title"
                                        class="block text-sm font-medium text-slate-700 mb-2"
                                    >
                                        Judul Section
                                    </label>

                                    <input
                                        type="text"
                                        id="feature_title"
                                        name="feature_title"
                                        value="{{ old('feature_title', $settings?->feature_title) }}"
                                        class="w-full border border-slate-200 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        placeholder="Pengalaman Terbaik Untuk Anda"
                                    />
                                </div>
                            </div>

                            <div class="flex justify-end mt-5">
                                <button
                                    type="submit"
                                    class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-medium"
                                >
                                    <i class="uil uil-edit"></i>
                                    Update Judul
                                </button>
                            </div>
                        </form>
                    </section>

                    {{-- =================================================
     5. KEUNGGULAN
================================================== --}}
                    <section
                        class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8"
                    >
                        {{-- HEADER --}}
                        <div
                            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6"
                        >
                            <div>
                                <h2 class="text-xl font-bold text-slate-800">
                                    Keunggulan
                                </h2>

                                <p class="text-sm text-slate-500 mt-1">Kelola daftar keunggulan yang tampil pada Home.</p>
                            </div>

                            <button
                                type="button"
                                onclick="toggleFeatureForm()"
                                class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl font-medium transition"
                            >
                                <i class="uil uil-plus mr-1"></i>
                                Tambah Keunggulan
                            </button>
                        </div>

                        {{-- =================================================
         FORM TAMBAH KEUNGGULAN
    ================================================== --}}
                        <div
                            id="featureAddForm"
                            class="hidden mb-6 rounded-2xl border border-emerald-200 bg-emerald-50/40 p-5"
                        >
                            <form
                                action="{{ route('dashboard.home.features.store') }}"
                                method="POST"
                                enctype="multipart/form-data"
                            >
                                @csrf

                                <div
                                    class="grid lg:grid-cols-[220px_1fr] gap-6"
                                >
                                    {{-- ================= IKON ================= --}}
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-slate-600 mb-2"
                                        >
                                            Ikon
                                        </label>

                                        {{-- PREVIEW --}}
                                        <div
                                            class="w-[180px] h-[180px] rounded-2xl border-2 border-dashed border-slate-300 bg-white overflow-hidden flex items-center justify-center"
                                        >
                                            <div
                                                id="featureAddIconEmpty"
                                                class="text-center text-slate-400"
                                            >
                                                <i
                                                    class="uil uil-image text-4xl"
                                                ></i>

                                                <p class="text-xs mt-2">Preview Ikon</p>
                                            </div>

                                            <img
                                                id="featureAddIconPreview"
                                                src=""
                                                alt="Preview Ikon"
                                                class="hidden w-full h-full object-contain p-5"
                                            />
                                        </div>

                                        {{-- PILIH SUMBER --}}
                                        <div class="flex gap-2 mt-4">
                                            <button
                                                type="button"
                                                id="featureUploadTab"
                                                onclick="
                                                    setFeatureIconSource(
                                                        'upload',
                                                    )
                                                "
                                                class="px-4 py-2.5 rounded-xl bg-indigo-600 text-white font-medium"
                                            >
                                                <i class="uil uil-upload"></i>
                                                Upload Ikon
                                            </button>

                                            <button
                                                type="button"
                                                id="featureUrlTab"
                                                onclick="
                                                    setFeatureIconSource('url')
                                                "
                                                class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-600 font-medium"
                                            >
                                                <i class="uil uil-link"></i>
                                                Link Ikon
                                            </button>
                                        </div>

                                        {{-- UPLOAD --}}
                                        <div
                                            id="featureIconUploadBox"
                                            class="mt-3"
                                        >
                                            <input
                                                type="file"
                                                id="featureAddIcon"
                                                name="icon"
                                                accept=".png,.jpg,.jpeg,.webp,.svg"
                                                class="hidden"
                                            />

                                            <label
                                                for="featureAddIcon"
                                                class="inline-flex items-center gap-2 cursor-pointer px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-sm font-medium text-slate-700"
                                            >
                                                <i
                                                    class="uil uil-image-plus"
                                                ></i>
                                                Pilih File Ikon
                                            </label>
                                        </div>

                                        {{-- LINK --}}
                                        <div
                                            id="featureIconUrlBox"
                                            class="hidden mt-3"
                                        >
                                            <input
                                                type="url"
                                                id="featureAddIconUrl"
                                                name="icon_url"
                                                class="w-full border border-slate-200 rounded-xl p-3 bg-white"
                                                placeholder="https://contoh.com/icon.png"
                                            />

                                            <p class="text-xs text-slate-400 mt-2">Masukkan URL langsung ke gambar ikon.</p>
                                        </div>
                                    </div>
                                    {{-- ================= KONTEN ================= --}}
                                    <div class="space-y-5">
                                        {{-- JUDUL --}}
                                        <div>
                                            <label
                                                for="featureAddTitle"
                                                class="block text-sm font-medium text-slate-600 mb-2"
                                            >
                                                Judul Keunggulan
                                            </label>

                                            <input
                                                type="text"
                                                id="featureAddTitle"
                                                name="title"
                                                required
                                                class="w-full border border-slate-200 rounded-xl p-3 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                                placeholder="Contoh: Hidangan Berkualitas"
                                            />
                                        </div>

                                        {{-- DESKRIPSI --}}
                                        <div>
                                            <label
                                                for="featureAddDescription"
                                                class="block text-sm font-medium text-slate-600 mb-2"
                                            >
                                                Deskripsi
                                            </label>

                                            <textarea
                                                id="featureAddDescription"
                                                name="description"
                                                rows="6"
                                                required
                                                class="w-full border border-slate-200 rounded-xl p-3 bg-white resize-none focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                                placeholder="Masukkan deskripsi keunggulan..."
                                            ></textarea>
                            </div>

                            {{-- BUTTON --}}
                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" onclick="toggleFeatureForm()"
                                    class="px-5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 font-medium">
                                    Batal
                                </button>

                                <button type="submit"
                                    class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-medium">
                                    <i class="uil uil-save mr-1"></i>
                                    Simpan
                                </button>
                            </div>
                        </div>
            </div>
            </form>
    </div>

    {{-- =================================================
         DATA KEUNGGULAN
    ================================================== --}}
    @if ($features->count() > 0)
        <div class="h-[420px] overflow-y-auto space-y-4 pr-2">
            @foreach ($features as $feature)
                <div class="rounded-2xl border border-slate-200 bg-slate-50 overflow-hidden">
                    {{-- ================= HEADER ITEM ================= --}}
                    <button type="button" onclick="toggleFeatureItem({{ $feature->id }})"
                        class="w-full flex items-center gap-4 px-5 py-4 text-left hover:bg-slate-100 transition">
                        {{-- ICON --}}
                        <div
                            class="w-12 h-12 rounded-xl bg-white border border-slate-200 overflow-hidden flex items-center justify-center flex-shrink-0">
                            @if ($feature->icon)
                                @if (filter_var($feature->icon, FILTER_VALIDATE_URL))
                                    <img src="{{ $feature->icon }}" alt="{{ $feature->title }}"
                                        class="w-full h-full object-contain p-2" />
                                @else
                                    <img src="{{ asset('storage/' . $feature->icon) }}" alt="{{ $feature->title }}"
                                        class="w-full h-full object-contain p-2" />
                                @endif
                            @else
                                <i class="uil uil-image-slash text-xl text-slate-300"></i>
                            @endif
                        </div>

                        {{-- JUDUL --}}
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-slate-800 truncate">
                                {{ $feature->title }}
                            </h3>

                            <p class="text-xs text-slate-400 mt-1">Keunggulan Home</p>
                        </div>

                        {{-- PANAH --}}
                        <i id="featureArrow-{{ $feature->id }}"
                            class="uil uil-angle-down text-xl text-slate-500 transition-transform duration-200"></i>
                    </button>

                    {{-- ================= DETAIL ================= --}}
                    <div id="featureDetail-{{ $feature->id }}" class="hidden border-t border-slate-200 bg-white">
                        <form id="feature-update-{{ $feature->id }}"
                            action="{{ route('dashboard.home.features.update', $feature->id) }}" method="POST"
                            enctype="multipart/form-data" class="p-5 home-bulk-update-form">
                            @csrf
                            @method ('PUT')

                            <div class="grid lg:grid-cols-[180px_1fr] gap-6">
                                {{-- ================= IKON ================= --}}
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-2">
                                        Ikon
                                    </label>

                                    {{-- PREVIEW IKON SAAT INI --}}
                                    <div
                                        class="w-[140px] h-[140px] rounded-2xl bg-slate-50 border border-slate-200 overflow-hidden flex items-center justify-center">
                                        @if ($feature->icon)
                                            @if (filter_var($feature->icon, FILTER_VALIDATE_URL))
                                                <img id="featureUpdatePreview-{{ $feature->id }}"
                                                    src="{{ $feature->icon }}" alt="{{ $feature->title }}"
                                                    class="w-full h-full object-contain p-4" />
                                            @else
                                                <img id="featureUpdatePreview-{{ $feature->id }}"
                                                    src="{{ asset('storage/' . $feature->icon) }}"
                                                    alt="{{ $feature->title }}"
                                                    class="w-full h-full object-contain p-4" />
                                            @endif
                                        @else
                                            <div class="text-center text-slate-400">
                                                <i class="uil uil-image-slash text-3xl"></i>

                                                <p class="text-xs mt-2">Belum ada ikon</p>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- PILIH SUMBER IKON --}}
                                    <div class="flex gap-2 mt-4">
                                        {{-- UPLOAD --}}
                                        <button type="button" id="updateUploadTab-{{ $feature->id }}"
                                            onclick="setUpdateIconSource({{ $feature->id }}, 'upload')"
                                            class="px-4 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-medium">
                                            <i class="uil uil-upload"></i>
                                            Upload Ikon
                                        </button>

                                        {{-- LINK --}}
                                        <button type="button" id="updateUrlTab-{{ $feature->id }}"
                                            onclick="setUpdateIconSource({{ $feature->id }}, 'url')"
                                            class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-600 text-sm font-medium">
                                            <i class="uil uil-link"></i>
                                            Link Ikon
                                        </button>
                                    </div>

                                    {{-- ================= UPLOAD ================= --}}
                                    <div id="updateIconUploadBox-{{ $feature->id }}" class="mt-3">
                                        <input type="file" id="updateIconFile-{{ $feature->id }}" name="icon"
                                            accept=".png,.jpg,.jpeg,.webp,.svg" class="hidden" />

                                        <label for="updateIconFile-{{ $feature->id }}"
                                            class="inline-flex items-center gap-2 cursor-pointer px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-sm font-medium text-slate-700">
                                            <i class="uil uil-image-plus"></i>
                                            Pilih File Ikon
                                        </label>
                                    </div>

                                    {{-- ================= LINK ================= --}}
                                    <div id="updateIconUrlBox-{{ $feature->id }}" class="hidden mt-3">
                                        <input type="url" id="updateIconUrl-{{ $feature->id }}" name="icon_url"
                                            class="w-full border border-slate-200 rounded-xl p-3 bg-white"
                                            placeholder="https://contoh.com/icon.png" />

                                        <p class="text-xs text-slate-400 mt-2">Masukkan URL langsung ke gambar ikon.
                                        </p>
                                    </div>
                                </div>

                                {{-- ================= DATA ================= --}}
                                <div class="space-y-5">
                                    {{-- JUDUL --}}
                                    <div>
                                        <label class="block text-sm font-medium text-slate-600 mb-2">
                                            Judul
                                        </label>

                                        <input type="text" name="title" value="{{ $feature->title }}" required
                                            class="w-full border border-slate-200 rounded-xl p-3 bg-white" />
                                    </div>

                                    {{-- DESKRIPSI --}}
                                    <div>
                                        <label class="block text-sm font-medium text-slate-600 mb-2">
                                            Deskripsi
                                        </label>

                                        <textarea name="description" rows="5" required
                                            class="w-full border border-slate-200 rounded-xl p-3 bg-white resize-none">{{ $feature->description }}</textarea
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            {{-- ================= ACTION ================= --}}
                                            <div
                                                class="px-5 pb-5 flex justify-end gap-2"
                                            >
                                                {{-- HAPUS --}}
                                                <form
                                                    action="{{ route('dashboard.home.features.destroy', $feature->id) }}"
                                                    method="POST"
                                                    onsubmit="
                                                        return confirm(
                                                            'Yakin ingin menghapus keunggulan ini?',
                                                        );
                                                    "
                                                >
                                                    @csrf
                                                    @method ('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center gap-2 bg-red-100 hover:bg-red-200 text-red-600 px-5 py-2.5 rounded-xl font-medium"
                                                    >
                                                        <i
                                                            class="uil uil-trash-alt"
                                                        ></i>
                                                        Hapus
                                                    </button>
                                                </form>

                                                {{-- UPDATE --}}
                                                <button
                                                    type="submit"
                                                    form="feature-update-{{ $feature->id }}"
                                                    class="inline-flex items-center gap-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-600 px-5 py-2.5 rounded-xl font-medium"
                                                >
                                                    <i class="uil uil-edit"></i>
                                                    Update
                                                </button>
                                            </div>
                                        </div>
                                    </div>
@endforeach
                            </div>
@else
{{-- ================= EMPTY ================= --}}
                            <div
                                class="border-2 border-dashed border-slate-200 rounded-2xl py-12 text-center"
                            >
                                <i
                                    class="uil uil-star text-4xl text-slate-300"
                                ></i>

                                <p class="mt-3 text-slate-500">Belum ada data keunggulan.</p>

                                <p class="text-xs text-slate-400 mt-1">Klik "Tambah Keunggulan" untuk menambahkan data pertama.</p>
                            </div>

                        @endif
                    </section>

                    {{-- =================================================
     5. HIDANGAN FAVORIT
================================================== --}}
                    <section
                        class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8"
                    >
                        <form
                            action="{{ route('dashboard.home.settings') }}"
                            method="POST"
                            class="home-bulk-update-form"
                        >
                            @csrf

                            {{-- HEADER --}}
                            <div
                                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6"
                            >
                                <div>
                                    <h2
                                        class="text-xl font-bold text-slate-800"
                                    >
                                        Hidangan Favorit
                                    </h2>

                                    <p class="text-sm text-slate-500 mt-1">Atur teks dan gambar hidangan favorit yang tampil pada Home.</p>
                                </div>

                                <button
                                    type="submit"
                                    class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-medium"
                                >
                                    <i class="uil uil-save"></i>
                                    {{ $settings ? 'Update' : 'Simpan' }}
                                </button>
                            </div>

                            {{-- ISI --}}
                            <div class="grid lg:grid-cols-2 gap-8">
                                {{-- ================= KIRI ================= --}}
                                <div class="space-y-5">
                                    {{-- LABEL --}}
                                    <div>
                                        <label
                                            for="dish_badge"
                                            class="block font-medium text-slate-700"
                                        >
                                            Label
                                        </label>

                                        <input
                                            type="text"
                                            id="dish_badge"
                                            name="dish_badge"
                                            value="{{ old('dish_badge', $settings?->dish_badge) }}"
                                            class="w-full mt-2 border border-slate-200 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                            placeholder="Signature"
                                        />
                                    </div>

                                    {{-- JUDUL --}}
                                    <div>
                                        <label
                                            for="dish_title"
                                            class="block font-medium text-slate-700"
                                        >
                                            Judul
                                        </label>

                                        <input
                                            type="text"
                                            id="dish_title"
                                            name="dish_title"
                                            value="{{ old('dish_title', $settings?->dish_title) }}"
                                            class="w-full mt-2 border border-slate-200 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                            placeholder="Hidangan Favorit Pelanggan"
                                        />
                                    </div>

                                    {{-- DESKRIPSI --}}
                                    <div>
                                        <label
                                            for="dish_description"
                                            class="block font-medium text-slate-700"
                                        >
                                            Deskripsi
                                        </label>

                                        <textarea
                                            id="dish_description"
                                            name="dish_description"
                                            rows="8"
                                            class="w-full mt-2 border border-slate-200 rounded-xl p-4 resize-none focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                            placeholder="Masukkan deskripsi hidangan..."
                                            >{{ old('dish_description', $settings?->dish_description) }}</textarea
                                        >
                                    </div>
                                </div>

                                {{-- ================= KANAN : FOTO ================= --}}
                                <div>
                                    <label
                                        for="dish_image"
                                        class="block font-medium text-slate-700"
                                    >
                                        URL Foto
                                    </label>

                                    <input
                                        type="url"
                                        id="dish_image"
                                        name="dish_image"
                                        value="{{ old('dish_image', $settings?->dish_image) }}"
                                        class="w-full mt-2 border border-slate-200 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        placeholder="https://..."
                                    />

                                    <p class="text-xs text-slate-400 mt-2">Masukkan URL langsung ke gambar.</p>

                                    {{-- PREVIEW --}}
                                    <label
                                        class="block font-medium text-slate-700 mt-5"
                                    >
                                        Preview Foto
                                    </label>

                                    <div
                                        class="mt-2 w-full max-w-[420px] h-[310px] rounded-2xl border border-slate-200 bg-slate-50 overflow-hidden flex items-center justify-center"
                                    >
                                        @if ($settings?->dish_image)
<img
                                                id="dishImagePreview"
                                                src="{{ $settings->dish_image }}"
                                                alt="Preview Hidangan Favorit"
                                                class="w-full h-full object-cover"
                                            />
@else
<div
                                                id="dishImageEmpty"
                                                class="text-center text-slate-400 px-6"
                                            >
                                                <i
                                                    class="uil uil-image text-5xl"
                                                ></i>

                                                <p class="text-sm mt-3">Preview gambar akan muncul di sini</p>
                                            </div>

                                            <img
                                                id="dishImagePreview"
                                                src=""
                                                alt="Preview Hidangan Favorit"
                                                class="hidden w-full h-full object-cover"
                                            />
@endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>

                    {{-- =================================================
     6. TESTIMONIAL
================================================== --}}
                    <section
                        class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8"
                    >
                        {{-- ================= PENGATURAN SECTION ================= --}}
                        <form
                            action="{{ route('dashboard.home.settings') }}"
                            method="POST"
                            class="mb-8 home-bulk-update-form"
                        >
                            @csrf

                            <div
                                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-5"
                            >
                                <div>
                                    <h2
                                        class="text-xl font-bold text-slate-800"
                                    >
                                        Pengaturan Section Testimonial
                                    </h2>

                                    <p class="text-sm text-slate-500 mt-1">Atur judul dan deskripsi section testimonial pada Home.</p>
                                </div>

                                <button
                                    type="submit"
                                    class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-medium"
                                >
                                    <i class="uil uil-edit"></i>
                                    Update Judul
                                </button>
                            </div>

                            <div class="grid lg:grid-cols-2 gap-5">
                                {{-- LABEL --}}
                                <div>
                                    <label
                                        for="testimonial_badge"
                                        class="block text-sm font-medium text-slate-700 mb-2"
                                    >
                                        Label Section
                                    </label>

                                    <input
                                        type="text"
                                        id="testimonial_badge"
                                        name="testimonial_badge"
                                        value="{{ old('testimonial_badge', $settings?->testimonial_badge) }}"
                                        class="w-full border border-slate-200 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        placeholder="Ulasan Pelanggan"
                                    />
                                </div>

                                {{-- DESKRIPSI --}}
                                <div>
                                    <label
                                        for="testimonial_description"
                                        class="block text-sm font-medium text-slate-700 mb-2"
                                    >
                                        Deskripsi Section
                                    </label>

                                    <textarea
                                        id="testimonial_description"
                                        name="testimonial_description"
                                        rows="3"
                                        class="w-full border border-slate-200 rounded-xl p-3 resize-none focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        placeholder="Apa kata mereka yang telah merasakan kehangatan dan cita rasa Joss Gandos?"
                                        >{{ old('testimonial_description', $settings?->testimonial_description) }}</textarea
                                    >
                                </div>
                            </div>
                        </form>

                        {{-- ================= DATA TESTIMONIAL ================= --}}
                        <div class="border-t border-slate-200 pt-8">
                            {{-- HEADER DATA --}}
                            <div
                                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6"
                            >
                                <div>
                                    <h3
                                        class="text-lg font-bold text-slate-800"
                                    >
                                        Daftar Testimonial
                                    </h3>

                                    <p class="text-sm text-slate-500 mt-1">Kelola nama dan ulasan pelanggan.</p>
                                </div>

                                <button
                                    type="button"
                                    onclick="toggleTestimonialForm()"
                                    class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl font-medium"
                                >
                                    <i class="uil uil-plus"></i>
                                    Tambah Testimonial
                                </button>
                            </div>

                            {{-- =========================================================
     FORM TAMBAH TESTIMONIAL
========================================================= --}}
                            <div
                                id="testimonialAddForm"
                                class="hidden mb-8 rounded-2xl border border-emerald-200 bg-emerald-50/40 p-5"
                            >
                                <form
                                    action="{{ route('dashboard.home.testimonials.store') }}"
                                    method="POST"
                                >
                                    @csrf

                                    <div class="space-y-5">
                                        {{-- NAMA --}}
                                        <div>
                                            <label
                                                for="testimonialAddName"
                                                class="block text-sm font-medium text-slate-600 mb-2"
                                            >
                                                Nama Pelanggan
                                            </label>

                                            <input
                                                type="text"
                                                id="testimonialAddName"
                                                name="name"
                                                required
                                                class="w-full border border-slate-200 rounded-xl p-3 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                                placeholder="Contoh: Budi Santoso"
                                            />
                                        </div>

                                        {{-- ULASAN --}}
                                        <div>
                                            <label
                                                for="testimonialAddReview"
                                                class="block text-sm font-medium text-slate-600 mb-2"
                                            >
                                                Ulasan Pelanggan
                                            </label>

                                            <textarea
                                                id="testimonialAddReview"
                                                name="review"
                                                rows="6"
                                                required
                                                class="w-full border border-slate-200 rounded-xl p-3 bg-white resize-none focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                                placeholder="Masukkan ulasan pelanggan..."
                                            ></textarea>
                                    </div>

                                    {{-- TOMBOL --}}
                                    <div class="flex justify-end gap-2 pt-2">
                                        <button type="button"
                                            onclick="
                                                    toggleTestimonialForm()
                                                "
                                            class="px-5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 font-medium">
                                            Batal
                                        </button>

                                        <button type="submit"
                                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-medium">
                                            <i class="uil uil-save"></i>
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                        </form>
                    </div>

                    {{-- ================= LIST TESTIMONIAL ================= --}}
                    @if ($testimonials->count() > 0)
                        <div class="max-h-[560px] overflow-y-auto space-y-4 pr-2">
                            @foreach ($testimonials as $testimonial)
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 overflow-hidden">
                                    {{-- ================= HEADER ITEM ================= --}}
                                    <button type="button" onclick="toggleTestimonialItem({{ $testimonial->id }})"
                                        class="w-full flex items-center gap-4 px-5 py-4 text-left hover:bg-slate-100 transition">
                                        {{-- AVATAR OTOMATIS --}}
                                        <div
                                            class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold flex-shrink-0">
                                            {{ strtoupper(substr(trim($testimonial->name), 0, 1)) }}
                                        </div>

                                        {{-- NAMA --}}
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-semibold text-slate-800 truncate">
                                                {{ $testimonial->name }}
                                            </h4>

                                            <p class="text-xs text-slate-400 mt-1">Testimonial Pelanggan</p>
                                        </div>

                                        {{-- PANAH --}}
                                        <i id="testimonialArrow-{{ $testimonial->id }}"
                                            class="uil uil-angle-down text-xl text-slate-500 transition-transform duration-200"></i>
                                    </button>

                                    {{-- ================= DETAIL ================= --}}
                                    <div id="testimonialDetail-{{ $testimonial->id }}"
                                        class="hidden border-t border-slate-200 bg-white p-5">
                                        <form
                                            action="{{ route('dashboard.home.testimonials.update', $testimonial->id) }}"
                                            method="POST" class="home-bulk-update-form">
                                            @csrf
                                            @method ('PUT')

                                            <div class="space-y-5">
                                                {{-- NAMA --}}
                                                <div>
                                                    <label class="block text-sm font-medium text-slate-700 mb-2">
                                                        Nama Pelanggan
                                                    </label>

                                                    <input type="text" name="name"
                                                        value="{{ $testimonial->name }}" required
                                                        class="w-full border border-slate-200 rounded-xl p-3 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                                                </div>

                                                {{-- ULASAN --}}
                                                <div>
                                                    <label class="block text-sm font-medium text-slate-700 mb-2">
                                                        Ulasan Pelanggan
                                                    </label>

                                                    <textarea name="review" rows="5" required
                                                        class="w-full border border-slate-200 rounded-xl p-3 bg-white resize-none focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ $testimonial->review }}</textarea>
                                                </div>

                                                {{-- ACTION --}}
                                                <div class="flex justify-end gap-2 pt-2">
                                                    {{-- HAPUS --}}
                                                    <button type="button"
                                                        onclick="deleteTestimonial({{ $testimonial->id }})"
                                                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-red-100 hover:bg-red-200 text-red-600 font-medium">
                                                        <i class="uil uil-trash-alt"></i>
                                                        Hapus
                                                    </button>

                                                    {{-- UPDATE --}}
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-100 hover:bg-indigo-200 text-indigo-600 font-medium">
                                                        <i class="uil uil-save"></i>
                                                        Update
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                        {{-- FORM HAPUS TERSEMBUNYI --}}
                                        <form id="deleteTestimonial-{{ $testimonial->id }}"
                                            action="{{ route('dashboard.home.testimonials.destroy', $testimonial->id) }}"
                                            method="POST" class="hidden">
                                            @csrf
                                            @method ('DELETE')
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- EMPTY --}}
                        <div class="border-2 border-dashed border-slate-200 rounded-2xl py-12 text-center">
                            <i class="uil uil-comments text-4xl text-slate-300"></i>

                            <p class="mt-3 text-slate-500">Belum ada testimonial.</p>

                            <p class="text-xs text-slate-400 mt-1">Tambahkan testimonial pertama dari tombol di atas.
                            </p>
                        </div>

                    @endif
                </div>
                </section>

                {{-- =================================================
     7. CTA RESERVATION
================================================== --}}
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
                    <form action="{{ route('dashboard.home.settings') }}" method="POST"
                        class="home-bulk-update-form">
                        @csrf

                        {{-- HEADER --}}
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                            <div>
                                <h2 class="text-xl font-bold text-slate-800">
                                    CTA Reservation
                                </h2>

                                <p class="text-sm text-slate-500 mt-1">Kelola kata-kata dan link tombol CTA Reservation
                                    di bagian bawah Home.</p>
                            </div>

                            <button type="submit"
                                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-medium">
                                <i class="uil uil-save"></i>
                                {{ $settings ? 'Update' : 'Simpan' }}
                            </button>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-8">
                            {{-- ================= KIRI ================= --}}
                            <div class="space-y-5">
                                {{-- JUDUL --}}
                                <div>
                                    <label for="cta_title" class="font-medium text-slate-700">
                                        Judul
                                    </label>

                                    <input type="text" id="cta_title" name="cta_title"
                                        value="{{ old('cta_title', $settings?->cta_title) }}"
                                        class="w-full mt-2 border border-slate-200 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        placeholder="Siap Merasakan Pengalaman Kuliner Terbaik?" />
                                </div>

                                {{-- DESKRIPSI --}}
                                <div>
                                    <label for="cta_description" class="font-medium text-slate-700">
                                        Deskripsi
                                    </label>

                                    <textarea id="cta_description" name="cta_description" rows="6"
                                        class="w-full mt-2 border border-slate-200 rounded-xl p-4 resize-none focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        placeholder="Masukkan deskripsi CTA...">{{ old('cta_description', $settings?->cta_description) }}</textarea>
                                </div>
                            </div>

                            {{-- ================= KANAN ================= --}}
                            <div>
                                <label for="cta_button_1_link" class="font-medium text-slate-700">
                                    Link Tombol 1
                                </label>

                                <input type="url" id="cta_button_1_link" name="cta_button_1_link"
                                    value="{{ old('cta_button_1_link', $settings?->cta_button_1_link) }}"
                                    class="w-full mt-2 border border-slate-200 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    placeholder="https://..." />

                                <p class="text-xs text-slate-400 mt-2">Link untuk tombol utama pada CTA.</p>
                            </div>
                        </div>
                    </form>
                </section>
        </div>
        </main>
        </div>

        {{-- =====================================================
         SCRIPT VIDEO HEADER
    ====================================================== --}}
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const youtubeField = document.getElementById("youtubeField");
                const tiktokField = document.getElementById("tiktokField");
                const fileField = document.getElementById("fileField");

                const sourceInputs = document.querySelectorAll(
                    'input[name="source_type"]',
                );

                function toggleVideoSource() {
                    const selected = document.querySelector(
                        'input[name="source_type"]:checked',
                    );

                    if (!selected) return;

                    if (selected.value === "youtube") {
                        youtubeField.classList.remove("hidden");
                        tiktokField.classList.add("hidden");
                        fileField.classList.add("hidden");
                    } else if (selected.value === "tiktok") {
                        youtubeField.classList.add("hidden");
                        tiktokField.classList.remove("hidden");
                        fileField.classList.add("hidden");
                    } else {
                        youtubeField.classList.add("hidden");
                        tiktokField.classList.add("hidden");
                        fileField.classList.remove("hidden");
                    }
                }

                sourceInputs.forEach((input) => {
                    input.addEventListener("change", toggleVideoSource);
                });

                toggleVideoSource();
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const input = document.getElementById("welcome_image");
                const preview = document.getElementById("welcomeImagePreview");
                const empty = document.getElementById("welcomeImageEmpty");

                if (!input || !preview) {
                    return;
                }

                function showPreview(url) {
                    url = url.trim();

                    if (!url) {
                        preview.src = "";
                        preview.classList.add("hidden");

                        if (empty) {
                            empty.classList.remove("hidden");
                        }

                        return;
                    }

                    preview.onload = function() {
                        preview.classList.remove("hidden");

                        if (empty) {
                            empty.classList.add("hidden");
                        }
                    };

                    preview.onerror = function() {
                        preview.classList.add("hidden");

                        if (empty) {
                            empty.classList.remove("hidden");
                            empty.innerHTML = `
                        <i class="uil uil-image-slash text-5xl"></i>
                        <p class="text-sm mt-3">
                            Gambar tidak dapat dimuat
                        </p>
                    `;
                        }
                    };

                    preview.src = url;
                }

                input.addEventListener("input", function() {
                    showPreview(this.value);
                });

                if (input.value.trim()) {
                    showPreview(input.value);
                }
            });
        </script>

        <script>
            function toggleFeatureForm() {
                const form = document.getElementById("featureAddForm");

                if (!form) {
                    return;
                }

                form.classList.toggle("hidden");
            }
        </script>

        <script>
            function setFeatureIconSource(source) {
                const uploadBox = document.getElementById(
                    "featureIconUploadBox",
                );
                const urlBox = document.getElementById("featureIconUrlBox");

                const uploadTab = document.getElementById("featureUploadTab");
                const urlTab = document.getElementById("featureUrlTab");

                const fileInput = document.getElementById("featureAddIcon");
                const urlInput = document.getElementById("featureAddIconUrl");

                if (source === "upload") {
                    uploadBox.classList.remove("hidden");
                    urlBox.classList.add("hidden");

                    uploadTab.classList.remove(
                        "bg-slate-100",
                        "text-slate-600",
                    );
                    uploadTab.classList.add("bg-indigo-600", "text-white");

                    urlTab.classList.remove("bg-indigo-600", "text-white");
                    urlTab.classList.add("bg-slate-100", "text-slate-600");

                    urlInput.value = "";
                } else {
                    uploadBox.classList.add("hidden");
                    urlBox.classList.remove("hidden");

                    urlTab.classList.remove("bg-slate-100", "text-slate-600");
                    urlTab.classList.add("bg-indigo-600", "text-white");

                    uploadTab.classList.remove("bg-indigo-600", "text-white");
                    uploadTab.classList.add("bg-slate-100", "text-slate-600");

                    fileInput.value = "";
                }
            }

            document.addEventListener("DOMContentLoaded", function() {
                const fileInput = document.getElementById("featureAddIcon");
                const urlInput = document.getElementById("featureAddIconUrl");

                const preview = document.getElementById(
                    "featureAddIconPreview",
                );
                const empty = document.getElementById("featureAddIconEmpty");

                function showFeatureIconPreview(src) {
                    if (!src) {
                        preview.src = "";
                        preview.classList.add("hidden");
                        empty.classList.remove("hidden");
                        return;
                    }

                    preview.onload = function() {
                        preview.classList.remove("hidden");
                        empty.classList.add("hidden");
                    };

                    preview.onerror = function() {
                        preview.src = "";
                        preview.classList.add("hidden");
                        empty.classList.remove("hidden");
                    };

                    preview.src = src;
                }

                // PREVIEW UPLOAD
                if (fileInput) {
                    fileInput.addEventListener("change", function() {
                        const file = this.files[0];

                        if (!file) {
                            return;
                        }

                        const reader = new FileReader();

                        reader.onload = function(event) {
                            showFeatureIconPreview(event.target.result);
                        };

                        reader.readAsDataURL(file);
                    });
                }

                // PREVIEW URL
                if (urlInput) {
                    urlInput.addEventListener("input", function() {
                        const url = this.value.trim();

                        if (url) {
                            showFeatureIconPreview(url);
                        }
                    });
                }
            });
        </script>

        <script>
            function toggleFeatureItem(id) {
                const detail = document.getElementById("featureDetail-" + id);

                const arrow = document.getElementById("featureArrow-" + id);

                const form = document.getElementById("feature-update-" + id);

                const preview = document.getElementById(
                    "featureUpdatePreview-" + id,
                );

                if (!detail || !arrow) {
                    return;
                }

                // =====================================================
                // JIKA SEDANG TERBUKA → MAU DITUTUP
                // =====================================================
                if (!detail.classList.contains("hidden")) {
                    // Kembalikan semua input ke data terakhir yang tersimpan
                    if (form) {
                        form.reset();
                    }

                    // Kembalikan preview gambar ke gambar tersimpan
                    if (preview && preview.dataset.originalSrc) {
                        preview.src = preview.dataset.originalSrc;
                    }
                } else {
                    // =================================================
                    // JIKA MAU DIBUKA
                    // Simpan gambar asli sebelum diedit
                    // =================================================
                    if (preview) {
                        preview.dataset.originalSrc = preview.src;
                    }
                }

                detail.classList.toggle("hidden");

                arrow.classList.toggle("rotate-180");
            }
        </script>

        <script>
            function setUpdateIconSource(id, source) {
                const uploadBox = document.getElementById(
                    "updateIconUploadBox-" + id,
                );

                const urlBox = document.getElementById(
                    "updateIconUrlBox-" + id,
                );

                const uploadTab = document.getElementById(
                    "updateUploadTab-" + id,
                );

                const urlTab = document.getElementById("updateUrlTab-" + id);

                const fileInput = document.getElementById(
                    "updateIconFile-" + id,
                );

                const urlInput = document.getElementById("updateIconUrl-" + id);

                if (source === "upload") {
                    uploadBox.classList.remove("hidden");
                    urlBox.classList.add("hidden");

                    uploadTab.classList.remove(
                        "bg-slate-100",
                        "text-slate-600",
                    );

                    uploadTab.classList.add("bg-indigo-600", "text-white");

                    urlTab.classList.remove("bg-indigo-600", "text-white");

                    urlTab.classList.add("bg-slate-100", "text-slate-600");

                    urlInput.value = "";
                } else {
                    uploadBox.classList.add("hidden");
                    urlBox.classList.remove("hidden");

                    urlTab.classList.remove("bg-slate-100", "text-slate-600");

                    urlTab.classList.add("bg-indigo-600", "text-white");

                    uploadTab.classList.remove("bg-indigo-600", "text-white");

                    uploadTab.classList.add("bg-slate-100", "text-slate-600");

                    fileInput.value = "";
                }
            }
        </script>

        <script>
            // =========================================================
            // PREVIEW IKON KEUNGGULAN - UPDATE
            // =========================================================
            document.addEventListener("DOMContentLoaded", function() {
                document
                    .querySelectorAll('[id^="updateIconFile-"]')
                    .forEach(function(input) {
                        const id = input.id.replace("updateIconFile-", "");

                        const preview = document.getElementById(
                            "featureUpdatePreview-" + id,
                        );

                        if (!preview) {
                            return;
                        }

                        input.addEventListener("change", function() {
                            const file = this.files[0];

                            if (!file) {
                                return;
                            }

                            const reader = new FileReader();

                            reader.onload = function(event) {
                                preview.src = event.target.result;
                            };

                            reader.readAsDataURL(file);
                        });
                    });

                // ================= PREVIEW LINK =================

                document
                    .querySelectorAll('[id^="updateIconUrl-"]')
                    .forEach(function(input) {
                        const id = input.id.replace("updateIconUrl-", "");

                        const preview = document.getElementById(
                            "featureUpdatePreview-" + id,
                        );

                        if (!preview) {
                            return;
                        }

                        input.addEventListener("input", function() {
                            const url = this.value.trim();

                            if (!url) {
                                return;
                            }

                            preview.src = url;
                        });
                    });
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const input = document.getElementById("dish_image");
                const preview = document.getElementById("dishImagePreview");
                const empty = document.getElementById("dishImageEmpty");

                if (!input || !preview) {
                    return;
                }

                function showDishPreview(url) {
                    url = url.trim();

                    if (!url) {
                        preview.src = "";
                        preview.classList.add("hidden");

                        if (empty) {
                            empty.classList.remove("hidden");
                        }

                        return;
                    }

                    preview.onload = function() {
                        preview.classList.remove("hidden");

                        if (empty) {
                            empty.classList.add("hidden");
                        }
                    };

                    preview.onerror = function() {
                        preview.classList.add("hidden");

                        if (empty) {
                            empty.classList.remove("hidden");

                            empty.innerHTML = `
                        <i class="uil uil-image-slash text-5xl"></i>
                        <p class="text-sm mt-3">
                            Gambar tidak dapat dimuat
                        </p>
                    `;
                        }
                    };

                    preview.src = url;
                }

                // Saat mengetik URL
                input.addEventListener("input", function() {
                    showDishPreview(this.value);
                });

                // Saat halaman pertama kali dibuka
                if (input.value.trim()) {
                    showDishPreview(input.value);
                }
            });
        </script>

        <script>
            function toggleTestimonialForm() {
                const form = document.getElementById("testimonialAddForm");

                if (!form) {
                    return;
                }

                form.classList.toggle("hidden");
            }

            function toggleTestimonialEdit(id) {
                const form = document.getElementById("testimonialEdit-" + id);

                if (!form) {
                    return;
                }

                form.classList.toggle("hidden");
            }
        </script>

        <script>
            function deleteTestimonial(id) {
                const form = document.getElementById("deleteTestimonial-" + id);

                if (!form) {
                    return;
                }

                const confirmed = confirm(
                    "Yakin ingin menghapus testimonial ini?",
                );

                if (confirmed) {
                    form.submit();
                }
            }
        </script>

        <script>
            function toggleTestimonialItem(id) {
                const detail = document.getElementById(
                    "testimonialDetail-" + id,
                );

                const arrow = document.getElementById("testimonialArrow-" + id);

                if (!detail || !arrow) {
                    return;
                }

                detail.classList.toggle("hidden");
                arrow.classList.toggle("rotate-180");
            }

            function toggleTestimonialEdit(id) {
                const editBox = document.getElementById(
                    "testimonialEdit-" + id,
                );

                if (!editBox) {
                    return;
                }

                editBox.classList.toggle("hidden");
            }
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const button = document.getElementById(
                    "toggleWelcomeFeatureButton",
                );

                const form = document.getElementById("welcomeFeatureAddForm");

                if (!button || !form) {
                    return;
                }

                button.addEventListener("click", function() {
                    form.classList.toggle("hidden");
                });
            });
        </script>

        <script>
            function toggleWelcomeFeatureItem(id) {
                const detail = document.getElementById(
                    "welcomeFeatureDetail-" + id,
                );

                const arrow = document.getElementById(
                    "welcomeFeatureArrow-" + id,
                );

                const form = detail ? detail.querySelector("form") : null;

                const preview = document.getElementById(
                    "welcomeUpdatePreview-" + id,
                );

                if (!detail || !arrow) {
                    return;
                }

                // =====================================================
                // JIKA SEDANG TERBUKA → MAU DITUTUP
                // =====================================================
                if (!detail.classList.contains("hidden")) {
                    // Kembalikan form ke data terakhir tersimpan
                    if (form) {
                        form.reset();
                    }

                    // Kembalikan preview ke gambar yang tersimpan
                    if (preview && preview.dataset.originalSrc) {
                        preview.src = preview.dataset.originalSrc;
                    }
                } else {
                    // =================================================
                    // JIKA MAU DIBUKA
                    // Simpan sumber gambar asli
                    // =================================================
                    if (preview) {
                        preview.dataset.originalSrc = preview.src;
                    }
                }

                detail.classList.toggle("hidden");

                arrow.classList.toggle("rotate-180");
            }

            function setWelcomeFeatureIconSource(source) {
                const uploadBox = document.getElementById(
                    "welcomeFeatureIconUploadBox",
                );

                const urlBox = document.getElementById(
                    "welcomeFeatureIconUrlBox",
                );

                const uploadTab = document.getElementById(
                    "welcomeFeatureUploadTab",
                );

                const urlTab = document.getElementById("welcomeFeatureUrlTab");

                const fileInput = document.getElementById(
                    "welcomeFeatureAddIcon",
                );

                const urlInput = document.getElementById(
                    "welcomeFeatureAddIconUrl",
                );

                if (source === "upload") {
                    uploadBox.classList.remove("hidden");
                    urlBox.classList.add("hidden");

                    uploadTab.classList.remove(
                        "bg-slate-100",
                        "text-slate-600",
                    );

                    uploadTab.classList.add("bg-indigo-600", "text-white");

                    urlTab.classList.remove("bg-indigo-600", "text-white");

                    urlTab.classList.add("bg-slate-100", "text-slate-600");

                    urlInput.value = "";
                } else {
                    uploadBox.classList.add("hidden");
                    urlBox.classList.remove("hidden");

                    urlTab.classList.remove("bg-slate-100", "text-slate-600");

                    urlTab.classList.add("bg-indigo-600", "text-white");

                    uploadTab.classList.remove("bg-indigo-600", "text-white");

                    uploadTab.classList.add("bg-slate-100", "text-slate-600");

                    fileInput.value = "";
                }
            }

            function setWelcomeUpdateIconSource(id, source) {
                const uploadBox = document.getElementById(
                    "welcomeUpdateIconUploadBox-" + id,
                );

                const urlBox = document.getElementById(
                    "welcomeUpdateIconUrlBox-" + id,
                );

                const uploadTab = document.getElementById(
                    "welcomeUpdateUploadTab-" + id,
                );

                const urlTab = document.getElementById(
                    "welcomeUpdateUrlTab-" + id,
                );

                const fileInput = document.getElementById(
                    "welcomeUpdateIconFile-" + id,
                );

                const urlInput = document.getElementById(
                    "welcomeUpdateIconUrl-" + id,
                );

                if (source === "upload") {
                    uploadBox.classList.remove("hidden");
                    urlBox.classList.add("hidden");

                    uploadTab.classList.remove(
                        "bg-slate-100",
                        "text-slate-600",
                    );

                    uploadTab.classList.add("bg-indigo-600", "text-white");

                    urlTab.classList.remove("bg-indigo-600", "text-white");

                    urlTab.classList.add("bg-slate-100", "text-slate-600");

                    urlInput.value = "";
                } else {
                    uploadBox.classList.add("hidden");
                    urlBox.classList.remove("hidden");

                    urlTab.classList.remove("bg-slate-100", "text-slate-600");

                    urlTab.classList.add("bg-indigo-600", "text-white");

                    uploadTab.classList.remove("bg-indigo-600", "text-white");

                    uploadTab.classList.add("bg-slate-100", "text-slate-600");

                    fileInput.value = "";
                }
            }
        </script>

        <script>
            // =========================================================
            // WELCOME FEATURE - PREVIEW SAAT TAMBAH
            // =========================================================
            document.addEventListener("DOMContentLoaded", function() {
                const fileInput = document.getElementById(
                    "welcomeFeatureAddIcon",
                );

                const urlInput = document.getElementById(
                    "welcomeFeatureAddIconUrl",
                );

                const preview = document.getElementById(
                    "welcomeFeatureAddIconPreview",
                );

                const empty = document.getElementById(
                    "welcomeFeatureAddIconEmpty",
                );

                if (!fileInput || !preview || !empty) {
                    return;
                }

                fileInput.addEventListener("change", function() {
                    const file = this.files[0];

                    if (!file) {
                        return;
                    }

                    const reader = new FileReader();

                    reader.onload = function(event) {
                        preview.src = event.target.result;
                        preview.classList.remove("hidden");
                        empty.classList.add("hidden");
                    };

                    reader.readAsDataURL(file);
                });

                if (urlInput) {
                    urlInput.addEventListener("input", function() {
                        const url = this.value.trim();

                        if (!url) {
                            preview.src = "";
                            preview.classList.add("hidden");
                            empty.classList.remove("hidden");
                            return;
                        }

                        preview.onload = function() {
                            preview.classList.remove("hidden");
                            empty.classList.add("hidden");
                        };

                        preview.onerror = function() {
                            preview.classList.add("hidden");
                            empty.classList.remove("hidden");
                        };

                        preview.src = url;
                    });
                }
            });
        </script>

        <script>
            // =========================================================
            // WELCOME FEATURE - PREVIEW SAAT UPDATE
            // =========================================================
            document.addEventListener("DOMContentLoaded", function() {
                document
                    .querySelectorAll('[id^="welcomeUpdateIconFile-"]')
                    .forEach(function(input) {
                        const id = input.id.replace(
                            "welcomeUpdateIconFile-",
                            "",
                        );

                        const preview = document.getElementById(
                            "welcomeUpdatePreview-" + id,
                        );

                        if (!preview) {
                            return;
                        }

                        input.addEventListener("change", function() {
                            const file = this.files[0];

                            if (!file) {
                                return;
                            }

                            const reader = new FileReader();

                            reader.onload = function(event) {
                                preview.src = event.target.result;
                            };

                            reader.readAsDataURL(file);
                        });
                    });

                document
                    .querySelectorAll('[id^="welcomeUpdateIconUrl-"]')
                    .forEach(function(input) {
                        const id = input.id.replace(
                            "welcomeUpdateIconUrl-",
                            "",
                        );

                        const preview = document.getElementById(
                            "welcomeUpdatePreview-" + id,
                        );

                        if (!preview) {
                            return;
                        }

                        input.addEventListener("input", function() {
                            const url = this.value.trim();

                            if (!url) {
                                return;
                            }

                            preview.onload = function() {
                                preview.classList.remove("hidden");
                            };

                            preview.src = url;
                        });
                    });
            });
        </script>

        <script>
            // =========================================================
            // WELCOME FEATURE - HAPUS
            // =========================================================
            function deleteWelcomeFeature(id) {
                const form = document.getElementById(
                    "deleteWelcomeFeature-" + id,
                );

                if (!form) {
                    return;
                }

                const confirmed = confirm(
                    "Yakin ingin menghapus Keunggulan Welcome ini?",
                );

                if (confirmed) {
                    form.submit();
                }
            }
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const saveAllButton =
                    document.getElementById("saveAllHomeChanges");

                if (!saveAllButton) return;

                saveAllButton.addEventListener("click", async function() {
                    const forms = document.querySelectorAll(
                        ".home-bulk-update-form",
                    );

                    if (forms.length === 0) {
                        alert("Tidak ada perubahan yang dapat disimpan.");
                        return;
                    }

                    const originalText = saveAllButton.innerHTML;

                    saveAllButton.disabled = true;
                    saveAllButton.innerHTML = `
                <i class="uil uil-spinner-alt animate-spin"></i>
                Menyimpan...
            `;

                    try {
                        for (const form of forms) {
                            const formData = new FormData(form);

                            const response = await fetch(form.action, {
                                method: "POST",
                                body: formData,
                                headers: {
                                    "X-Requested-With": "XMLHttpRequest",
                                },
                            });

                            if (!response.ok) {
                                throw new Error(
                                    "Gagal menyimpan salah satu perubahan.",
                                );
                            }
                        }

                        alert("Semua perubahan berhasil disimpan.");

                        window.location.reload();
                    } catch (error) {
                        console.error(error);

                        alert("Terjadi kesalahan saat menyimpan perubahan.");
                    } finally {
                        saveAllButton.disabled = false;
                        saveAllButton.innerHTML = originalText;
                    }
                });
            });
        </script>
</body>

</html>
