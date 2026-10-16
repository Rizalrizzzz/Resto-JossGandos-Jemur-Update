<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Kelola Reservation</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logojossgandos.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css" />

    <style>
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

<body class="bg-slate-50 text-slate-800 overflow-hidden">
    <div class="flex h-screen overflow-hidden">
        {{-- =========================================================
         SIDEBAR ADMIN
    ========================================================== --}}
        @include ('layouts.sidebar')

        {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}
        <main class="flex-1 min-w-0 min-h-0 overflow-y-auto bg-slate-50">
            {{-- HEADER ADMIN --}}
            <header class="sticky top-0 z-30 bg-white border-b border-slate-200 shadow-sm px-6 py-4">
                <div class="flex items-center justify-between gap-4">
                    {{-- KIRI --}}
                    <div class="flex items-center gap-4 min-w-0">
                        <button type="button" onclick="toggleSidebar()"
                            class="md:hidden p-2 rounded-lg hover:bg-slate-100 shrink-0">
                            <i class="uil uil-bars text-2xl"></i>
                        </button>

                        <div>
                            <h1 class="text-2xl font-bold text-slate-800">
                                Kelola Reservation
                            </h1>
                        </div>
                    </div>

                    {{-- KANAN --}}
                    <button type="button" id="saveAllReservationChanges"
                        class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-sm transition shrink-0">
                        <i class="uil uil-save"></i>

                        Simpan Semua Perubahan
                    </button>
                </div>
            </header>

            {{-- =====================================================
             CONTENT
        ====================================================== --}}
            <div class="p-4 md:p-6 space-y-6">
                {{-- SUCCESS --}}
                @if (session('success'))
                    <div
                        class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- ERROR --}}
                @if ($errors->any())
                    <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <ul class="list-disc ml-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                @endif

                {{-- =================================================
                 1. HEADER
            ================================================== --}}
                <section class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                    {{-- SECTION HEADER --}}
                    <div class="px-6 py-5 border-b border-slate-200">
                        <div class="flex items-center gap-4">
                            <div>
                                <h2 class="text-xl font-bold">
                                    Header Section
                                </h2>

                                <p class="text-sm text-slate-500 mt-1">Atur badge, judul, deskripsi, tombol WhatsApp,
                                    respon cepat, dan gambar header.</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('reservation.settings.update') }}" method="POST"
                        class="reservation-bulk-update-form">
                        @csrf

                        <div class="p-6">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                {{-- LEFT --}}
                                <div class="space-y-5">
                                    {{-- BADGE --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                                            Badge
                                        </label>

                                        <input type="text" name="hero_badge"
                                            value="{{ old('hero_badge', $setting->hero_badge ?? '') }}"
                                            placeholder="BOOKING & RESERVATION"
                                            class="w-full h-12 px-4 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                                    </div>

                                    {{-- JUDUL --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                                            Judul
                                        </label>

                                        <input type="text" name="hero_title"
                                            value="{{ old('hero_title', $setting->hero_title ?? '') }}"
                                            placeholder="Reservasi Mudah, Momen Spesial Semakin Berkesan"
                                            class="w-full h-12 px-4 rounded-xl border border-slate-200 outline-none focus:border-indigo-500" />
                                    </div>

                                    {{-- DESKRIPSI --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                                            Deskripsi
                                        </label>

                                        <textarea name="hero_description" rows="5"
                                            placeholder="Reservasi lebih cepat dan praktis langsung via WhatsApp. Tim kami siap membantu Anda."
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none resize-y focus:border-indigo-500">{{ old('hero_description', $setting->hero_description ?? '') }}</textarea
                                        >
                                    </div>

                                    {{-- LINK WA --}}
                                    <div>
                                        <label
                                            class="block text-sm font-semibold text-slate-700 mb-2"
                                        >
                                            Link Tombol WhatsApp
                                        </label>

                                        <input
                                            type="text"
                                            name="hero_whatsapp_link"
                                            value="{{ old('hero_whatsapp_link', $setting->hero_whatsapp_link ?? '') }}"
                                            placeholder="https://wa.me/628..."
                                            class="w-full h-12 px-4 rounded-xl border border-slate-200 outline-none focus:border-indigo-500"
                                        />
                                    </div>

                                    {{-- RESPON --}}
                                    <div>
                                        <label
                                            class="block text-sm font-semibold text-slate-700 mb-2"
                                        >
                                            Respon Cepat
                                        </label>

                                        <input
                                            type="text"
                                            name="response_time"
                                            value="{{ old('response_time', $setting->response_time ?? '') }}"
                                            placeholder="Respon cepat setiap hari 10.00 – 22.00 WIB"
                                            class="w-full h-12 px-4 rounded-xl border border-slate-200 outline-none focus:border-indigo-500"
                                        />
                                    </div>
                                </div>

                                {{-- RIGHT IMAGE --}}
                                <div>
                                    <label
                                        class="block text-sm font-semibold text-slate-700 mb-2"
                                    >
                                        URL Gambar Header
                                    </label>

                                    <input
                                        type="url"
                                        name="hero_image"
                                        id="heroImageInput"
                                        value="{{ old('hero_image', $setting->hero_image ?? '') }}"
                                        placeholder="https://contoh.com/reservation.jpg"
                                        class="w-full h-12 px-4 rounded-xl border border-slate-200 outline-none focus:border-indigo-500"
                                    />

                                    {{-- PREVIEW --}}
                                    <div
                                        class="mt-4 h-72 rounded-2xl overflow-hidden border border-slate-200 bg-slate-50"
                                    >
                                        <img
                                            id="heroImagePreview"
                                            src="{{ $setting->hero_image ?? '' }}"
                                            alt="Preview Header"
                                            class="{{ !empty($setting?->hero_image) ? '' : 'hidden' }}
                                               w-full h-full object-cover"
                                        />

                                        <div
                                            id="heroImagePlaceholder"
                                            class="{{ !empty($setting?->hero_image) ? 'hidden' : 'flex' }}
                                               w-full h-full
                                               items-center justify-center
                                               text-slate-400"
                                        >
                                            <div class="text-center">
                                                <i
                                                    class="uil uil-image text-4xl"
                                                ></i>

                                                <p class="mt-2 text-sm">Preview gambar akan tampil di sini</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- SAVE --}}
                        <div
                            class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end"
                        >
                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold"
                            >
                                <i class="uil uil-save text-lg"></i>

                                Simpan Header
                            </button>
                        </div>
                    </form>
                </section>


                  {{-- =================================================
                     2. EDIT JUDUL SECTION
                ================================================== --}}
                <section class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h2 class="text-xl font-bold">
                            Edit Judul
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            Atur judul dan deskripsi section yang tampil pada halaman reservation.
                        </p>
                    </div>

                    <form
                        action="{{ route('reservation.settings.update') }}"
                        method="POST"
                        class="reservation-bulk-update-form"
                    >
                        @csrf

                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                {{-- CARA RESERVASI --}}
                                <div class="p-5 rounded-2xl border border-slate-200 bg-slate-50">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Cara Reservasi
                                    </label>

                                    <input
                                        type="text"
                                        name="steps_title"
                                        value="{{ old('steps_title', $setting->steps_title ?? 'Cara Reservasi') }}"
                                        placeholder="Cara Reservasi"
                                        class="w-full h-12 px-4 rounded-xl border border-slate-200 bg-white outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                    />
                                </div>

                                {{-- KETENTUAN RESERVASI --}}
                                <div class="p-5 rounded-2xl border border-slate-200 bg-slate-50">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Ketentuan Reservasi
                                    </label>

                                    <input
                                        type="text"
                                        name="terms_title"
                                        value="{{ old('terms_title', $setting->terms_title ?? 'Ketentuan Reservasi') }}"
                                        placeholder="Ketentuan Reservasi"
                                        class="w-full h-12 px-4 rounded-xl border border-slate-200 bg-white outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                    />
                                </div>

                                {{-- KENALI AREA RESTO --}}
                                <div class="p-5 rounded-2xl border border-slate-200 bg-slate-50">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Kenali Area Resto
                                    </label>

                                    <input
                                        type="text"
                                        name="areas_title"
                                        value="{{ old('areas_title', $setting->areas_title ?? 'Kenali Area Resto') }}"
                                        placeholder="Kenali Area Resto"
                                        class="w-full h-12 px-4 rounded-xl border border-slate-200 bg-white outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                    />
                                </div>

                                {{-- DESKRIPSI AREA --}}
                                <div class="p-5 rounded-2xl border border-slate-200 bg-slate-50">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Deskripsi Area
                                    </label>

                                    <input
                                        type="text"
                                        name="areas_subtitle"
                                        value="{{ old('areas_subtitle', $setting->areas_subtitle ?? 'Pilih suasana yang sesuai untuk momen Anda.') }}"
                                        placeholder="Pilih suasana yang sesuai untuk momen Anda."
                                        class="w-full h-12 px-4 rounded-xl border border-slate-200 bg-white outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                    />
                                </div>

                                {{-- LOKASI & INFORMASI --}}
                                <div class="md:col-span-2 p-5 rounded-2xl border border-slate-200 bg-slate-50">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Lokasi & Informasi
                                    </label>

                                    <input
                                        type="text"
                                        name="location_title"
                                        value="{{ old('location_title', $setting->location_title ?? 'Lokasi & Informasi') }}"
                                        placeholder="Lokasi & Informasi"
                                        class="w-full h-12 px-4 rounded-xl border border-slate-200 bg-white outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                    />
                                </div>

                            </div>
                        </div>

                        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end">
                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold"
                            >
                                <i class="uil uil-save"></i>
                                Simpan Judul
                            </button>
                        </div>
                    </form>
                </section>

                {{-- =================================================
                 2. CARA RESERVASI
            ================================================== --}}
                <section
                    class="bg-white border border-slate-200 rounded-2xl overflow-hidden"
                >
                    <div class="px-6 py-6">
                        <div
                            class="flex flex-col md:flex-row md:items-center md:justify-between gap-4"
                        >
                            <div>
                                <h2 class="text-2xl font-bold">
                                    Cara Reservasi
                                </h2>

                                <p class="mt-1 text-slate-500">Kelola langkah-langkah cara melakukan reservasi.</p>
                            </div>

                            <button
                                type="button"
                                onclick="toggleBox('addStepForm')"
                                class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl text-sm font-semibold"
                            >
                                <i class="uil uil-plus text-xl"></i>

                                Tambah Cara Reservasi
                            </button>
                        </div>
                    </div>

                    {{-- ADD --}}
                    <div
                        id="addStepForm"
                        class="hidden mx-6 mb-6 p-6 rounded-2xl border border-emerald-200 bg-emerald-50/40"
                    >
                        <form
                            action="{{ route('reservation.steps.store') }}"
                            method="POST"
                            enctype="multipart/form-data"
                        >
                            @csrf

                            <div
                                class="grid grid-cols-1 lg:grid-cols-[260px_1fr] gap-6"
                            >
                                {{-- ICON --}}
                                <div>
                                    <label
                                        class="block text-sm font-semibold text-slate-700 mb-2"
                                    >
                                        Ikon
                                    </label>

                                    <div
                                        id="addStepPreview"
                                        class="h-44 rounded-xl bg-white border border-slate-200 flex items-center justify-center overflow-hidden"
                                    >
                                        <span class="text-sm text-slate-400">
                                            Preview Ikon
                                        </span>
                                    </div>

                                    <input
                                        type="file"
                                        name="icon_file"
                                        id="addStepFile"
                                        accept="image/*"
                                        class="mt-3 block w-full text-sm"
                                    />

                                    <input
                                        type="text"
                                        name="icon_url"
                                        id="addStepUrl"
                                        placeholder="Atau URL ikon"
                                        class="mt-3 w-full h-11 px-4 rounded-xl border border-slate-200 bg-white outline-none"
                                    />

                                    <p class="text-xs text-slate-400 mt-2">Upload file akan diprioritaskan daripada URL.</p>
                                </div>

                                {{-- DATA --}}
                                <div class="space-y-5">
                                    <div>
                                        <label
                                            class="block text-sm font-semibold mb-2"
                                        >
                                            Judul
                                        </label>

                                        <input
                                            type="text"
                                            name="title"
                                            required
                                            placeholder="Klik WhatsApp"
                                            class="w-full h-12 px-4 rounded-xl border border-slate-200 bg-white outline-none"
                                        />
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-semibold mb-2"
                                        >
                                            Deskripsi
                                        </label>

                                        <textarea
                                            name="description"
                                            rows="4"
                                            placeholder="Klik tombol WhatsApp di bawah untuk memulai percakapan."
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white outline-none resize-y"
                                        ></textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold mb-2">
                                            Urutan
                                        </label>

                                        <input type="number" name="sort_order"
                                            value="{{ ($steps->max('sort_order') ?? 0) + 1 }}"
                                            class="w-full h-12 px-4 rounded-xl border border-slate-200 bg-white outline-none" />
                                    </div>

                                    <div class="flex justify-end gap-3">
                                        <button type="button" onclick="toggleBox('addStepForm')"
                                            class="px-5 py-3 rounded-xl bg-white border border-slate-200 font-semibold">
                                            Batal
                                        </button>

                                        <button type="submit"
                                            class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold">
                                            <i class="uil uil-save"></i>
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                            </div>
                    </form>
            </div>

            {{-- LIST --}}
            <div class="px-6 pb-6 space-y-4">
                @forelse ($steps as $step)
                    @php
                        $stepIcon = null;

                        if ($step->icon) {
                            $stepIcon = filter_var($step->icon, FILTER_VALIDATE_URL)
                                ? $step->icon
                                : asset('storage/' . ltrim($step->icon, '/'));
                        }
                    @endphp

                    <div class="rounded-2xl border border-slate-200 overflow-hidden">
                        {{-- CARD HEADER --}}
                        <button type="button" onclick="toggleBox('step{{ $step->id }}')"
                            class="w-full flex items-center gap-4 p-5 text-left bg-slate-50">
                            <div
                                class="w-16 h-16 rounded-xl bg-white border border-slate-200 flex items-center justify-center overflow-hidden flex-shrink-0">
                                @if ($stepIcon)
                                    <img src="{{ $stepIcon }}" alt="{{ $step->title }}"
                                        class="max-w-10 max-h-10 object-contain" />
                                @else
                                    <i class="uil uil-image text-2xl text-slate-400">
                                    </i>
                                @endif
                            </div>

                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-slate-800">
                                    {{ $step->title }}
                                </h3>

                                <p class="text-sm text-slate-400 mt-1">
                                    Langkah {{ $loop->iteration }}
                                </p>
                            </div>

                            <i class="uil uil-angle-down text-xl text-slate-500">
                            </i>
                        </button>

                        {{-- DETAIL --}}
                        <div id="step{{ $step->id }}" class="hidden border-t border-slate-200 bg-white">
                            <form action="{{ route('reservation.steps.update', $step->id) }}" method="POST"
                                enctype="multipart/form-data" class="p-6 reservation-bulk-update-form">
                                @csrf
                                @method ('PUT')

                                <div class="grid grid-cols-1 lg:grid-cols-[260px_1fr] gap-6">
                                    {{-- ICON --}}
                                    <div>
                                        <label class="block text-sm font-semibold mb-2">
                                            Ikon
                                        </label>

                                        <div id="stepPreview{{ $step->id }}"
                                            class="h-44 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center overflow-hidden">
                                            @if ($stepIcon)
                                                <img src="{{ $stepIcon }}" alt="{{ $step->title }}"
                                                    class="max-w-20 max-h-20 object-contain" />
                                            @else
                                                <span class="text-sm text-slate-400">
                                                    Belum ada ikon
                                                </span>
                                            @endif
                                        </div>

                                        <input type="file" name="icon_file" id="stepFile{{ $step->id }}"
                                            accept="image/*" class="mt-3 block w-full text-sm" />

                                        <input type="text" name="icon_url" id="stepUrl{{ $step->id }}"
                                            value="{{ filter_var($step->icon, FILTER_VALIDATE_URL) ? $step->icon : '' }}"
                                            placeholder="Atau URL ikon"
                                            class="mt-3 w-full h-11 px-4 rounded-xl border border-slate-200 outline-none" />
                                    </div>

                                    {{-- DATA --}}
                                    <div class="space-y-5">
                                        <div>
                                            <label class="block text-sm font-semibold mb-2">
                                                Judul
                                            </label>

                                            <input type="text" name="title" value="{{ $step->title }}"
                                                required
                                                class="w-full h-12 px-4 rounded-xl border border-slate-200 outline-none" />
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold mb-2">
                                                Deskripsi
                                            </label>

                                            <textarea name="description" rows="5"
                                                class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none resize-y">{{ $step->description }}</textarea
                                                    >
                                                </div>

                                                <div>
                                                    <label
                                                        class="block text-sm font-semibold mb-2"
                                                    >
                                                        Urutan
                                                    </label>

                                                    <input
                                                        type="number"
                                                        name="sort_order"
                                                        value="{{ $step->sort_order }}"
                                                        class="w-full h-12 px-4 rounded-xl border border-slate-200 outline-none"
                                                    />
                                                </div>

                                                <div
                                                    class="flex justify-end gap-3"
                                                >
                                                    <button
                                                        type="button"
                                                        onclick="deleteItem('deleteStep{{ $step->id }}')"
                                                        class="px-5 py-3 rounded-xl bg-red-50 text-red-600 font-semibold"
                                                    >
                                                        <i
                                                            class="uil uil-trash-alt"
                                                        >
                                                        </i>

                                                        Hapus
                                                    </button>

                                                    <button
                                                        type="submit"
                                                        class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold"
                                                    >
                                                        <i class="uil uil-save">
                                                        </i>

                                                        Update
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <form
                                        id="deleteStep{{ $step->id }}"
                                        action="{{ route('reservation.steps.destroy', $step->id) }}"
                                        method="POST"
                                        class="hidden"
                                    >
                                        @csrf
                                        @method ('DELETE')
                                    </form>
                                </div>
                            </div>

                        @empty
                            <div
                                class="py-10 text-center border border-dashed border-slate-300 rounded-xl text-slate-400"
                            >
                                Belum ada cara reservasi.
                            </div>
@endforelse
                    </div>
                </section>

                {{-- =================================================
                 3. KETENTUAN RESERVASI
            ================================================== --}}
                <section
                    class="bg-white border border-slate-200 rounded-2xl overflow-hidden"
                >
                    <div class="px-6 py-6">
                        <div
                            class="flex flex-col md:flex-row md:items-center md:justify-between gap-4"
                        >
                            <div>
                                <h2 class="text-2xl font-bold">
                                    Ketentuan Reservasi
                                </h2>

                                <p class="mt-1 text-slate-500">Kelola ketentuan yang berlaku saat reservasi.</p>
                            </div>

                            <button
                                type="button"
                                onclick="toggleBox('addTermForm')"
                                class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl text-sm font-semibold"
                            >
                                <i class="uil uil-plus text-xl"></i>

                                Tambah Ketentuan
                            </button>
                        </div>
                    </div>

                    {{-- ADD TERM --}}
                    <div
                        id="addTermForm"
                        class="hidden mx-6 mb-6 p-6 rounded-2xl border border-emerald-200 bg-emerald-50/40"
                    >
                        <form
                            action="{{ route('reservation.terms.store') }}"
                            method="POST"
                            enctype="multipart/form-data"
                        >
                            @csrf

                            <div
                                class="grid grid-cols-1 lg:grid-cols-[260px_1fr] gap-6"
                            >
                                <div>
                                    <label
                                        class="block text-sm font-semibold mb-2"
                                    >
                                        Ikon
                                    </label>

                                    <div
                                        id="addTermPreview"
                                        class="h-44 rounded-xl bg-white border border-slate-200 flex items-center justify-center"
                                    >
                                        <span class="text-sm text-slate-400">
                                            Preview Ikon
                                        </span>
                                    </div>

                                    <input
                                        type="file"
                                        name="icon_file"
                                        id="addTermFile"
                                        accept="image/*"
                                        class="mt-3 block w-full text-sm"
                                    />

                                    <input
                                        type="text"
                                        name="icon_url"
                                        id="addTermUrl"
                                        placeholder="Atau URL ikon"
                                        class="mt-3 w-full h-11 px-4 rounded-xl border border-slate-200 bg-white outline-none"
                                    />
                                </div>

                                <div class="space-y-5">
                                    <div>
                                        <label
                                            class="block text-sm font-semibold mb-2"
                                        >
                                            Judul
                                        </label>

                                        <input
                                            type="text"
                                            name="title"
                                            required
                                            placeholder="Konfirmasi Reservasi"
                                            class="w-full h-12 px-4 rounded-xl border border-slate-200 bg-white outline-none"
                                        />
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-semibold mb-2"
                                        >
                                            Deskripsi
                                        </label>

                                        <textarea
                                            name="description"
                                            rows="5"
                                            placeholder="Reservasi dianggap tersedia setelah mendapatkan konfirmasi dari tim kami."
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white outline-none resize-y"
                                        ></textarea>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold mb-2">
                                                Urutan
                                            </label>

                                            <input type="number" name="sort_order"
                                                value="{{ ($terms->max('sort_order') ?? 0) + 1 }}"
                                                class="w-full h-12 px-4 rounded-xl border border-slate-200 bg-white outline-none" />
                                        </div>

                                        <div class="flex justify-end gap-3">
                                            <button type="button" onclick="toggleBox('addTermForm')"
                                                class="px-5 py-3 rounded-xl border border-slate-200 bg-white font-semibold">
                                                Batal
                                            </button>

                                            <button type="submit"
                                                class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold">
                                                <i class="uil uil-save"></i>
                                                Simpan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        {{-- TERM LIST --}}
                        <div class="px-6 pb-6 space-y-4">
                            @forelse ($terms as $term)
                                @php
                                    $termIcon = null;

                                    if ($term->icon) {
                                        $termIcon = filter_var($term->icon, FILTER_VALIDATE_URL)
                                            ? $term->icon
                                            : asset('storage/' . ltrim($term->icon, '/'));
                                    }
                                @endphp

                                <div class="rounded-2xl border border-slate-200 overflow-hidden">
                                    <button type="button" onclick="toggleBox('term{{ $term->id }}')"
                                        class="w-full flex items-center gap-4 p-5 text-left bg-slate-50">
                                        <div
                                            class="w-16 h-16 rounded-xl bg-white border border-slate-200 flex items-center justify-center overflow-hidden">
                                            @if ($termIcon)
                                                <img src="{{ $termIcon }}" alt="{{ $term->title }}"
                                                    class="max-w-10 max-h-10 object-contain" />
                                            @else
                                                <i class="uil uil-image text-2xl text-slate-400">
                                                </i>
                                            @endif
                                        </div>

                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold">
                                                {{ $term->title }}
                                            </h3>

                                            <p class="text-sm text-slate-400 mt-1">
                                                Ketentuan {{ $loop->iteration }}
                                            </p>
                                        </div>

                                        <i class="uil uil-angle-down text-xl text-slate-500">
                                        </i>
                                    </button>

                                    <div id="term{{ $term->id }}"
                                        class="hidden border-t border-slate-200 bg-white">
                                        <form action="{{ route('reservation.terms.update', $term->id) }}"
                                            method="POST" enctype="multipart/form-data"
                                            class="p-6 reservation-bulk-update-form">
                                            @csrf
                                            @method ('PUT')

                                            <div class="grid grid-cols-1 lg:grid-cols-[260px_1fr] gap-6">
                                                <div>
                                                    <label class="block text-sm font-semibold mb-2">
                                                        Ikon
                                                    </label>

                                                    <div id="termPreview{{ $term->id }}"
                                                        class="h-44 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center overflow-hidden">
                                                        @if ($termIcon)
                                                            <img src="{{ $termIcon }}" alt="{{ $term->title }}"
                                                                class="max-w-20 max-h-20 object-contain" />
                                                        @else
                                                            <span class="text-sm text-slate-400">
                                                                Belum ada ikon
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <input type="file" name="icon_file"
                                                        id="termFile{{ $term->id }}" accept="image/*"
                                                        class="mt-3 block w-full text-sm" />

                                                    <input type="text" name="icon_url"
                                                        id="termUrl{{ $term->id }}"
                                                        value="{{ filter_var($term->icon, FILTER_VALIDATE_URL) ? $term->icon : '' }}"
                                                        placeholder="Atau URL ikon"
                                                        class="mt-3 w-full h-11 px-4 rounded-xl border border-slate-200 outline-none" />
                                                </div>

                                                <div class="space-y-5">
                                                    <div>
                                                        <label class="block text-sm font-semibold mb-2">
                                                            Judul
                                                        </label>

                                                        <input type="text" name="title"
                                                            value="{{ $term->title }}" required
                                                            class="w-full h-12 px-4 rounded-xl border border-slate-200 outline-none" />
                                                    </div>

                                                    <div>
                                                        <label class="block text-sm font-semibold mb-2">
                                                            Deskripsi
                                                        </label>

                                                        <textarea name="description" rows="5"
                                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none resize-y">{{ $term->description }}</textarea>
                                                    </div>

                                                    <div>
                                                        <label class="block text-sm font-semibold mb-2">
                                                            Urutan
                                                        </label>

                                                        <input type="number" name="sort_order"
                                                            value="{{ $term->sort_order }}"
                                                            class="w-full h-12 px-4 rounded-xl border border-slate-200 outline-none" />
                                                    </div>

                                                    <div class="flex justify-end gap-3">
                                                        <button type="button"
                                                            onclick="deleteItem('deleteTerm{{ $term->id }}')"
                                                            class="px-5 py-3 rounded-xl bg-red-50 text-red-600 font-semibold">
                                                            <i class="uil uil-trash-alt">
                                                            </i>

                                                            Hapus
                                                        </button>

                                                        <button type="submit"
                                                            class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold">
                                                            <i class="uil uil-save">
                                                            </i>

                                                            Update
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        <form id="deleteTerm{{ $term->id }}"
                                            action="{{ route('reservation.terms.destroy', $term->id) }}"
                                            method="POST" class="hidden">
                                            @csrf
                                            @method ('DELETE')
                                        </form>
                                    </div>
                                </div>

                            @empty
                                <div
                                    class="py-10 text-center border border-dashed border-slate-300 rounded-xl text-slate-400">
                                    Belum ada ketentuan reservasi.
                                </div>
                            @endforelse
                        </div>
                        </section>

                        {{-- =================================================
     4. KENALI AREA RESTO
================================================== --}}
                        <section class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                            <div class="px-6 py-6">
                                <div>
                                    <h2 class="text-2xl font-bold text-slate-800">
                                        Kenali Area Resto
                                    </h2>

                                    <p class="mt-1 text-slate-500">Kelola 3 area resto yang tampil pada halaman
                                        reservation.</p>
                                </div>
                            </div>

                            <div class="px-6 pb-6 space-y-4">
                                @foreach ($areas->take(3) as $area)
                                    @php
                                        $areaImage = null;

                                        if ($area->image) {
                                            $areaImage = filter_var($area->image, FILTER_VALIDATE_URL)
                                                ? $area->image
                                                : asset('storage/' . ltrim($area->image, '/'));
                                        }
                                    @endphp

                                    {{-- CARD AREA --}}
                                    <div class="border border-slate-200 rounded-2xl overflow-hidden">
                                        {{-- HEADER CARD --}}
                                        <button type="button" onclick="toggleBox('area{{ $area->id }}')"
                                            class="w-full flex items-center gap-4 px-5 py-5 text-left bg-slate-50 hover:bg-slate-100 transition">
                                            {{-- IMAGE --}}
                                            <div
                                                class="w-24 h-16 flex-shrink-0 rounded-xl bg-white border border-slate-200 overflow-hidden flex items-center justify-center">
                                                <img id="areaCardPreview{{ $area->id }}"
                                                    src="{{ $areaImage ?? '' }}" alt="{{ $area->title }}"
                                                    class="{{ $areaImage ? '' : 'hidden' }}
                                   w-full h-full object-cover" />

                                                <span id="areaCardEmpty{{ $area->id }}"
                                                    class="{{ $areaImage ? 'hidden' : 'flex' }}
                                   w-full h-full items-center justify-center
                                   text-xs text-slate-400">
                                                    Preview
                                                </span>
                                            </div>

                                            {{-- TITLE --}}
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-lg font-semibold text-slate-800">
                                                    {{ $area->title }}
                                                </h3>

                                                <p class="text-sm text-slate-400 mt-1">
                                                    Area {{ $loop->iteration }}
                                                </p>
                                            </div>

                                            <i class="uil uil-angle-down text-xl text-slate-500">
                                            </i>
                                        </button>

                                        {{-- DETAIL --}}
                                        <div id="area{{ $area->id }}"
                                            class="hidden border-t border-slate-200 bg-white">
                                            <form action="{{ route('reservation.areas.update', $area->id) }}"
                                                method="POST" class="p-6 reservation-bulk-update-form">
                                                @csrf
                                                @method ('PUT')

                                                <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-6">
                                                    {{-- IMAGE --}}
                                                    <div>
                                                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                                                            URL Gambar
                                                        </label>

                                                        <div
                                                            class="h-48 rounded-xl bg-slate-50 border border-slate-200 overflow-hidden flex items-center justify-center">
                                                            <img id="areaPreview{{ $area->id }}"
                                                                src="{{ $areaImage ?? '' }}"
                                                                alt="{{ $area->title }}"
                                                                class="{{ $areaImage ? '' : 'hidden' }}
                                               w-full h-full object-cover" />

                                                            <div id="areaPlaceholder{{ $area->id }}"
                                                                class="{{ $areaImage ? 'hidden' : 'flex' }}
                                               w-full h-full
                                               items-center justify-center
                                               text-slate-400">
                                                                <div class="text-center">
                                                                    <i class="uil uil-image text-4xl"></i>

                                                                    <p class="mt-2 text-sm">Preview gambar area</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <input type="url" name="image"
                                                            id="areaInput{{ $area->id }}"
                                                            value="{{ filter_var($area->image, FILTER_VALIDATE_URL) ? $area->image : '' }}"
                                                            placeholder="https://contoh.com/area.jpg"
                                                            class="mt-3 w-full h-11 px-4 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                                                    </div>

                                                    {{-- DATA --}}
                                                    <div class="space-y-5">
                                                        {{-- JUDUL --}}
                                                        <div>
                                                            <label
                                                                class="block text-sm font-semibold text-slate-700 mb-2">
                                                                Judul
                                                            </label>

                                                            <input type="text" name="title"
                                                                value="{{ $area->title }}" required
                                                                class="w-full h-12 px-4 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                                                        </div>

                                                        {{-- DESKRIPSI --}}
                                                        <div>
                                                            <label
                                                                class="block text-sm font-semibold text-slate-700 mb-2">
                                                                Deskripsi
                                                            </label>

                                                            <textarea name="description" rows="5"
                                                                class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none resize-y focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">{{ $area->description }}</textarea>
                                                        </div>

                                                        {{-- UPDATE --}}
                                                        <div class="flex justify-end">
                                                            <button type="submit"
                                                                class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold">
                                                                <i class="uil uil-save"></i>

                                                                Update
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>

                        {{-- =================================================
                 5. LOKASI & INFORMASI
                     + SOCIAL MEDIA
            ================================================== --}}
                        <section class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                            <div class="px-6 py-5 border-b border-slate-200">
                                <h2 class="text-xl font-bold">Lokasi & Informasi</h2>

                                <p class="text-sm text-slate-500 mt-1">Atur informasi resto dan seluruh link media
                                    sosial.</p>
                            </div>

                            <form action="{{ route('reservation.settings.update') }}" method="POST"
                                class="reservation-bulk-update-form">
                                @csrf

                                <div class="p-6">
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                        {{-- LEFT --}}
                                        <div class="space-y-5">
                                            <div>
                                                <label class="block text-sm font-semibold mb-2">
                                                    Nama Resto
                                                </label>

                                                <input type="text" name="location_name"
                                                    value="{{ old('location_name', $setting->location_name ?? '') }}"
                                                    placeholder="Resto Joss Gandos - Jemursari"
                                                    class="w-full h-12 px-4 rounded-xl border border-slate-200 outline-none" />
                                            </div>

                                            <div>
                                                <label class="block text-sm font-semibold mb-2">
                                                    Subtitle
                                                </label>

                                                <input type="text" name="location_subtitle"
                                                    value="{{ old('location_subtitle', $setting->location_subtitle ?? '') }}"
                                                    placeholder="Pusat Kuliner & Event Surabaya"
                                                    class="w-full h-12 px-4 rounded-xl border border-slate-200 outline-none" />
                                            </div>

                                            <div>
                                                <label class="block text-sm font-semibold mb-2">
                                                    Alamat
                                                </label>

                                                <textarea name="address" rows="5" placeholder="Jl. Raya Jemursari No.15, Jemur Wonosari..."
                                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none resize-y">{{ old('address', $setting->address ?? '') }}</textarea>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-semibold mb-2">
                                                    Jam Operasional
                                                </label>

                                                <input type="text" name="operating_hours"
                                                    value="{{ old('operating_hours', $setting->operating_hours ?? '') }}"
                                                    placeholder="Senin - Minggu | 10.00 WIB – 22.00 WIB"
                                                    class="w-full h-12 px-4 rounded-xl border border-slate-200 outline-none" />
                                            </div>

                                            <div>
                                                <label class="block text-sm font-semibold mb-2">
                                                    WhatsApp
                                                </label>

                                                <input type="text" name="whatsapp_number"
                                                    value="{{ old('whatsapp_number', $setting->whatsapp_number ?? '') }}"
                                                    placeholder="+62 896-9907-1599"
                                                    class="w-full h-12 px-4 rounded-xl border border-slate-200 outline-none" />
                                            </div>
                                        </div>

                                        {{-- RIGHT --}}
                                        <div>
                                            <label class="block text-sm font-semibold mb-2">
                                                URL Gambar Resto
                                            </label>

                                            <input type="url" name="location_image" id="locationImageInput"
                                                value="{{ old('location_image', $setting->location_image ?? '') }}"
                                                placeholder="https://contoh.com/resto.jpg"
                                                class="w-full h-12 px-4 rounded-xl border border-slate-200 outline-none" />

                                            {{-- PREVIEW --}}
                                            <div
                                                class="mt-4 h-80 rounded-2xl overflow-hidden border border-slate-200 bg-slate-50">
                                                <img id="locationImagePreview"
                                                    src="{{ $setting->location_image ?? '' }}" alt="Preview Resto"
                                                    class="{{ !empty($setting?->location_image) ? '' : 'hidden' }}
                                               w-full h-full object-cover" />

                                                <div id="locationImagePlaceholder"
                                                    class="{{ !empty($setting?->location_image) ? 'hidden' : 'flex' }}
                                               w-full h-full
                                               items-center justify-center
                                               text-slate-400">
                                                    <div class="text-center">
                                                        <i class="uil uil-image text-4xl"></i>

                                                        <p class="mt-2 text-sm">Preview gambar resto</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- SOCIAL MEDIA --}}
                                    <div class="mt-8 pt-8 border-t border-slate-200">
                                        <div class="mb-5">
                                            <h3 class="text-lg font-bold">
                                                Social Media
                                            </h3>

                                            <p class="text-sm text-slate-500 mt-1">Ubah link saja. Tidak perlu mengubah
                                                ikon.</p>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                            {{-- INSTAGRAM --}}
                                            <div>
                                                <label class="block text-sm font-semibold mb-2">
                                                    Instagram
                                                </label>

                                                <input type="text" name="instagram_link"
                                                    value="{{ old('instagram_link', $setting->instagram_link ?? '') }}"
                                                    placeholder="https://instagram.com/..."
                                                    class="w-full h-12 px-4 rounded-xl border border-slate-200 outline-none" />
                                            </div>

                                            {{-- FACEBOOK --}}
                                            <div>
                                                <label class="block text-sm font-semibold mb-2">
                                                    Facebook
                                                </label>

                                                <input type="text" name="facebook_link"
                                                    value="{{ old('facebook_link', $setting->facebook_link ?? '') }}"
                                                    placeholder="https://facebook.com/..."
                                                    class="w-full h-12 px-4 rounded-xl border border-slate-200 outline-none" />
                                            </div>

                                            {{-- TIKTOK --}}
                                            <div>
                                                <label class="block text-sm font-semibold mb-2">
                                                    TikTok
                                                </label>

                                                <input type="text" name="tiktok_link"
                                                    value="{{ old('tiktok_link', $setting->tiktok_link ?? '') }}"
                                                    placeholder="https://tiktok.com/@..."
                                                    class="w-full h-12 px-4 rounded-xl border border-slate-200 outline-none" />
                                            </div>

                                            {{-- WHATSAPP --}}
                                            <div>
                                                <label class="block text-sm font-semibold mb-2">
                                                    WhatsApp Link
                                                </label>

                                                <input type="text" name="whatsapp_link"
                                                    value="{{ old('whatsapp_link', $setting->whatsapp_link ?? '') }}"
                                                    placeholder="https://wa.me/628..."
                                                    class="w-full h-12 px-4 rounded-xl border border-slate-200 outline-none" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end">
                                    <button type="submit"
                                        class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold">
                                        <i class="uil uil-save"></i>

                                        Simpan Lokasi & Social Media
                                    </button>
                                </div>
                            </form>
                        </section>

                        {{-- =================================================
                 6. CTA
            ================================================== --}}
                        <section class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                            <div class="px-6 py-5 border-b border-slate-200">
                                <h2 class="text-xl font-bold">CTA Section</h2>

                                <p class="text-sm text-slate-500 mt-1">Atur badge, judul, deskripsi, dan link WhatsApp
                                    CTA.</p>
                            </div>

                            <form action="{{ route('reservation.settings.update') }}" method="POST"
                                enctype="multipart/form-data" class="reservation-bulk-update-form">
                                @csrf

                                <div class="p-6 space-y-6">
                                    {{-- BADGE + JUDUL --}}
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                        {{-- BADGE --}}
                                        <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                                Badge
                                            </label>

                                            <input type="text" name="cta_badge"
                                                value="{{ old('cta_badge', $setting->cta_badge ?? '') }}"
                                                placeholder="BEST SERVICE"
                                                class="w-full h-12 px-4 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                                        </div>

                                        {{-- JUDUL --}}
                                        <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                                Judul
                                            </label>

                                            <input type="text" name="cta_title"
                                                value="{{ old('cta_title', $setting->cta_title ?? '') }}"
                                                placeholder="Jadikan Momen Anda Lebih Istimewa"
                                                class="w-full h-12 px-4 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                                        </div>
                                    </div>

                                    {{-- DESKRIPSI --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                                            Deskripsi
                                        </label>

                                        <textarea name="cta_description" rows="5" placeholder="Dari ulang tahun hingga gathering kantor..."
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none resize-y focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">{{ old('cta_description', $setting->cta_description ?? '') }}</textarea>
                                    </div>

                                    {{-- LINK WHATSAPP --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                                            Link WhatsApp
                                        </label>

                                        <input type="text" name="cta_whatsapp_link"
                                            value="{{ old('cta_whatsapp_link', $setting->cta_whatsapp_link ?? '') }}"
                                            placeholder="https://wa.me/628..."
                                            class="w-full h-12 px-4 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                                    </div>

                                    {{-- BACKGROUND CTA --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-3">
                                            Background CTA
                                        </label>

                                        <div class="grid grid-cols-1 lg:grid-cols-[320px_1fr] gap-6 items-start">
                                            {{-- PREVIEW --}}
                                            <div>
                                                @php
                                                    $ctaBackground = $setting->cta_background_image ?? '';

                                                    if (
                                                        \Illuminate\Support\Str::startsWith($ctaBackground, [
                                                            'http://',
                                                            'https://',
                                                        ])
                                                    ) {
                                                        $ctaBackgroundUrl = $ctaBackground;
                                                    } elseif (
                                                        \Illuminate\Support\Str::startsWith($ctaBackground, 'storage/')
                                                    ) {
                                                        $ctaBackgroundUrl = asset($ctaBackground);
                                                    } elseif ($ctaBackground) {
                                                        $ctaBackgroundUrl = asset(
                                                            'storage/' . ltrim($ctaBackground, '/'),
                                                        );
                                                    } else {
                                                        $ctaBackgroundUrl = '';
                                                    }
                                                @endphp

                                                <div
                                                    class="w-full h-48 rounded-2xl overflow-hidden border border-slate-200 bg-slate-50 flex items-center justify-center">
                                                    <img id="ctaBackgroundPreview" src="{{ $ctaBackgroundUrl }}"
                                                        alt="Preview Background CTA"
                                                        class="{{ $ctaBackgroundUrl ? '' : 'hidden' }}
                                   w-full h-full object-cover" />

                                                    <div id="ctaBackgroundPlaceholder"
                                                        class="{{ $ctaBackgroundUrl ? 'hidden' : 'flex' }}
                                   w-full h-full items-center justify-center
                                   text-slate-400">
                                                        <div class="text-center">
                                                            <i class="uil uil-image text-4xl"></i>

                                                            <p class="mt-2 text-sm">Preview background CTA</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- UPLOAD + URL --}}
                                            <div class="space-y-5">
                                                {{-- UPLOAD --}}
                                                <div>
                                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                                        Upload Background
                                                    </label>

                                                    <input type="file" name="cta_background_file"
                                                        id="ctaBackgroundFile"
                                                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                                        class="block w-full text-sm text-slate-500 border border-slate-200 rounded-xl cursor-pointer bg-white file:mr-3 file:py-2.5 file:px-3 file:border-0 file:bg-slate-100 file:text-slate-700 file:font-medium" />

                                                    <p class="text-xs text-slate-400 mt-2">Format JPG, JPEG, PNG, atau
                                                        WEBP. Maksimal 1 MB.</p>

                                                    <p id="ctaBackgroundSizeMessage"
                                                        class="hidden mt-2 text-xs text-red-500">Ukuran file lebih dari
                                                        1 MB. Harap kompres gambar terlebih dahulu.</p>
                                                </div>

                                                {{-- URL --}}
                                                <div>
                                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                                        Atau Gunakan URL
                                                    </label>

                                                    <input type="url" name="cta_background_url"
                                                        id="ctaBackgroundUrl"
                                                        value="{{ filter_var($ctaBackground, FILTER_VALIDATE_URL) ? $ctaBackground : '' }}"
                                                        placeholder="https://contoh.com/cta-background.jpg"
                                                        class="w-full h-12 px-4 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- SIMPAN --}}
                                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end">
                                    <button type="submit"
                                        class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold">
                                        <i class="uil uil-save"></i>
                                        Simpan CTA
                                    </button>
                                </div>
                            </form>
                        </section>
                    </div>
        </main>
    </div>

    {{-- =========================================================
     JAVASCRIPT
========================================================== --}}
    <script>
        /* =========================================================
                                                                                                       OPEN / CLOSE BOX
                                                                                                    ========================================================== */

        function toggleBox(id) {
            const box = document.getElementById(id);

            if (!box) {
                return;
            }

            box.classList.toggle("hidden");
        }

        /* =========================================================
           DELETE
        ========================================================== */

        function deleteItem(id) {
            if (!confirm("Yakin ingin menghapus data ini?")) {
                return;
            }

            const form = document.getElementById(id);

            if (form) {
                form.submit();
            }
        }

        /* =========================================================
           HEADER IMAGE PREVIEW
        ========================================================== */

        const heroInput = document.getElementById("heroImageInput");

        const heroPreview = document.getElementById("heroImagePreview");

        const heroPlaceholder = document.getElementById("heroImagePlaceholder");

        if (heroInput && heroPreview && heroPlaceholder) {
            heroInput.addEventListener("input", function() {
                const url = this.value.trim();

                if (!url) {
                    heroPreview.classList.add("hidden");

                    heroPlaceholder.classList.remove("hidden");
                    heroPlaceholder.classList.add("flex");

                    heroPreview.removeAttribute("src");

                    return;
                }

                heroPreview.onload = function() {
                    heroPreview.classList.remove("hidden");

                    heroPlaceholder.classList.add("hidden");
                    heroPlaceholder.classList.remove("flex");
                };

                heroPreview.onerror = function() {
                    heroPreview.classList.add("hidden");

                    heroPlaceholder.classList.remove("hidden");
                    heroPlaceholder.classList.add("flex");
                };

                heroPreview.src = url;
            });
        }

        /* =========================================================
           LOCATION IMAGE PREVIEW
        ========================================================== */

        const locationInput = document.getElementById("locationImageInput");

        const locationPreview = document.getElementById("locationImagePreview");

        const locationPlaceholder = document.getElementById("locationImagePlaceholder");

        if (locationInput && locationPreview && locationPlaceholder) {
            locationInput.addEventListener("input", function() {
                const url = this.value.trim();

                if (!url) {
                    locationPreview.classList.add("hidden");

                    locationPlaceholder.classList.remove("hidden");
                    locationPlaceholder.classList.add("flex");

                    return;
                }

                locationPreview.onload = function() {
                    locationPreview.classList.remove("hidden");

                    locationPlaceholder.classList.add("hidden");
                    locationPlaceholder.classList.remove("flex");
                };

                locationPreview.onerror = function() {
                    locationPreview.classList.add("hidden");

                    locationPlaceholder.classList.remove("hidden");
                    locationPlaceholder.classList.add("flex");
                };

                locationPreview.src = url;
            });
        }

        /* =========================================================
           STEP ICON PREVIEW
        ========================================================== */

        function setupIconPreview(fileId, urlId, previewId) {
            const file = document.getElementById(fileId);

            const url = document.getElementById(urlId);

            const preview = document.getElementById(previewId);

            if (!preview) {
                return;
            }

            if (file) {
                file.addEventListener("change", function() {
                    if (!this.files || !this.files[0]) {
                        return;
                    }

                    const objectUrl = URL.createObjectURL(this.files[0]);

                    preview.innerHTML = "";

                    const img = document.createElement("img");

                    img.src = objectUrl;

                    img.className = "max-w-24 max-h-24 object-contain";

                    preview.appendChild(img);
                });
            }

            if (url) {
                url.addEventListener("input", function() {
                    if (file && file.files && file.files.length > 0) {
                        return;
                    }

                    const value = this.value.trim();

                    if (!value) {
                        return;
                    }

                    const img = document.createElement("img");

                    img.src = value;

                    img.className = "max-w-24 max-h-24 object-contain";

                    img.onload = function() {
                        preview.innerHTML = "";

                        preview.appendChild(img);
                    };
                });
            }
        }

        setupIconPreview("addStepFile", "addStepUrl", "addStepPreview");

        setupIconPreview("addTermFile", "addTermUrl", "addTermPreview");

        @foreach ($steps as $step)

            setupIconPreview(
                "stepFile{{ $step->id }}",
                "stepUrl{{ $step->id }}",
                "stepPreview{{ $step->id }}",
            );
        @endforeach

        @foreach ($terms as $term)

            setupIconPreview(
                "termFile{{ $term->id }}",
                "termUrl{{ $term->id }}",
                "termPreview{{ $term->id }}",
            );
        @endforeach

        /* =========================================================
           AREA IMAGE PREVIEW
        ========================================================== */

        @foreach ($areas as $area)

            const areaInput{{ $area->id }} = document.getElementById(
                "areaInput{{ $area->id }}",
            );

            const areaPreview{{ $area->id }} =
                document.getElementById("areaPreview{{ $area->id }}");


            const areaEmpty{{ $area->id }} = document.getElementById(
                "areaPlaceholder{{ $area->id }}",
            );


            if (areaInput{{ $area->id }}) {
                areaInput{{ $area->id }}.addEventListener(
                    "input",
                    function() {
                        const url = this.value.trim();

                        if (!url) {
                            areaPreview{{ $area->id }}.classList.add(
                                "hidden",
                            );

                            areaEmpty{{ $area->id }}.classList.remove(
                                "hidden",
                            );

                            return;
                        }

                        areaPreview{{ $area->id }}.onload =
                            function() {
                                areaPreview{{ $area->id }}.classList.remove(
                                    "hidden",
                                );

                                areaEmpty{{ $area->id }}.classList.add(
                                    "hidden",
                                );
                            };

                        areaPreview{{ $area->id }}.src = url;
                    },
                );
            }
        @endforeach

        /* =========================================================
               CTA BACKGROUND IMAGE PREVIEW
            ========================================================== */

        const ctaBackgroundFile = document.getElementById("ctaBackgroundFile");

        const ctaBackgroundUrl = document.getElementById("ctaBackgroundUrl");

        const ctaBackgroundPreview = document.getElementById("ctaBackgroundPreview");

        const ctaBackgroundPlaceholder = document.getElementById(
            "ctaBackgroundPlaceholder",
        );

        const ctaBackgroundSizeMessage = document.getElementById(
            "ctaBackgroundSizeMessage",
        );

        if (
            ctaBackgroundFile &&
            ctaBackgroundUrl &&
            ctaBackgroundPreview &&
            ctaBackgroundPlaceholder
        ) {
            // ================= FILE UPLOAD =================
            ctaBackgroundFile.addEventListener("change", function() {
                const file = this.files[0];

                if (!file) {
                    return;
                }

                // Maksimal 1 MB
                if (file.size > 1024 * 1024) {
                    this.value = "";

                    ctaBackgroundUrl.disabled = false;

                    if (ctaBackgroundSizeMessage) {
                        ctaBackgroundSizeMessage.classList.remove("hidden");
                    }

                    return;
                }

                if (ctaBackgroundSizeMessage) {
                    ctaBackgroundSizeMessage.classList.add("hidden");
                }

                // File dipilih → URL dikosongkan
                ctaBackgroundUrl.value = "";
                ctaBackgroundUrl.disabled = true;

                const objectUrl = URL.createObjectURL(file);

                ctaBackgroundPreview.onload = function() {
                    ctaBackgroundPreview.classList.remove("hidden");

                    ctaBackgroundPlaceholder.classList.add("hidden");
                    ctaBackgroundPlaceholder.classList.remove("flex");

                    URL.revokeObjectURL(objectUrl);
                };

                ctaBackgroundPreview.src = objectUrl;
            });

            // ================= URL =================
            ctaBackgroundUrl.addEventListener("input", function() {
                const url = this.value.trim();

                if (!url) {
                    ctaBackgroundFile.disabled = false;

                    if (ctaBackgroundSizeMessage) {
                        ctaBackgroundSizeMessage.classList.add("hidden");
                    }

                    return;
                }

                // URL dipilih → file dikosongkan
                ctaBackgroundFile.value = "";
                ctaBackgroundFile.disabled = true;

                ctaBackgroundPreview.onload = function() {
                    ctaBackgroundPreview.classList.remove("hidden");

                    ctaBackgroundPlaceholder.classList.add("hidden");
                    ctaBackgroundPlaceholder.classList.remove("flex");
                };

                ctaBackgroundPreview.onerror = function() {
                    ctaBackgroundPreview.classList.add("hidden");

                    ctaBackgroundPlaceholder.classList.remove("hidden");
                    ctaBackgroundPlaceholder.classList.add("flex");
                };

                ctaBackgroundPreview.src = url;
            });
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const saveAllButton = document.getElementById(
                "saveAllReservationChanges",
            );

            if (!saveAllButton) {
                return;
            }

            saveAllButton.addEventListener("click", async function() {
                const forms = document.querySelectorAll(
                    ".reservation-bulk-update-form",
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
                                "Accept": "application/json",
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
