<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kelola About - Resto Joss Gandos</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logojossgandos.png') }}">
    @vite (['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css" />
</head>

<body class="bg-slate-50 overflow-hidden">
    <div class="flex h-screen">
        @include ('layouts.sidebar')

        <main class="flex-1 flex flex-col h-screen min-w-0 bg-slate-50">
            {{-- HEADER ABOUT --}}
            <header class="flex-shrink-0 bg-white border-b border-slate-200 shadow-sm px-4 sm:px-6 py-3 sm:py-4 z-20">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
                    {{-- KIRI --}}
                    <div class="flex items-center gap-4 min-w-0">
                        <button type="button" onclick="toggleSidebar()"
                            class="md:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-lg shrink-0">
                            <i class="uil uil-bars text-2xl"></i>
                        </button>

                        <h1 class="text-xl font-bold text-slate-800">
                            Kelola About
                        </h1>
                    </div>

                    {{-- TOMBOL SIMPAN: DI BAWAH JUDUL PADA MOBILE, DI KANAN PADA DESKTOP --}}
                    <button type="button" id="saveAllAboutChanges"
                        class="inline-flex w-full sm:w-auto items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-sm transition">
                        <i class="uil uil-save"></i>
                        Simpan Semua Perubahan
                    </button>
                </div>
            </header>

            {{-- CONTENT ABOUT --}}
            <div class="flex-1 overflow-y-auto p-6 space-y-5">
                {{-- HERO --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
                    <form action="{{ route('dashboard.about.hero') }}" method="POST" enctype="multipart/form-data"
                        class="about-bulk-update-form">
                        @csrf

                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold">Hero Section</h2>
                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl">
                                Simpan
                            </button>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-8">
                            <!-- ================= KIRI ================= -->

                            <div>
                                <!-- Judul -->
                                <div>
                                    <label for="aboutHeroTitle" class="font-medium"> Judul </label>

                                    <input type="text" id="aboutHeroTitle" name="hero_title"
                                        value="{{ old('hero_title', $about->hero_title) }}"
                                        class="w-full mt-2 border rounded-xl p-3" placeholder="Tentang Kami" />
                                </div>

                                <!-- UPLOAD FOTO BACKGROUND HERO -->
                                <div class="mt-6">
                                    <label for="heroImage" class="font-medium block mb-2">
                                        Upload Foto (JPG/PNG/WebP, maks 2MB)
                                    </label>

                                    <input type="file" id="heroImage" name="hero_image"
                                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                        class="w-full border border-slate-200 rounded-xl p-3 bg-white
                                               file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50
                                               file:px-4 file:py-2 file:font-semibold file:text-indigo-700
                                               hover:file:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500" />

                                    <p class="text-xs text-slate-400 mt-2">
                                        Pilih foto maksimal 2 MB. Preview berubah setelah file dipilih.
                                    </p>
                                </div>

                                <!-- PREVIEW -->
                                <div id="heroPreview"
                                    class="mt-4 aspect-[16/9] border-2 border-dashed rounded-2xl overflow-hidden bg-slate-50 flex items-center justify-center">
                                    @if ($about->hero_image)
                                        <img src="{{ asset('storage/' . $about->hero_image) }}"
                                            class="w-full h-full object-contain rounded-xl bg-white"
                                            alt="Preview Background Hero" />
                                    @else
                                        <span class="text-slate-400">Preview Gambar</span>
                                    @endif
                                </div>
                            </div>

                            <!-- ================= KANAN ================= -->

                            <div>
                                <label for="aboutHeroSubtitle" class="font-medium"> Subtitle </label>

                                <textarea id="aboutHeroSubtitle" name="hero_subtitle" class="w-full h-[150px] mt-2 border rounded-xl p-4 resize-none"
                                    placeholder="Perjalanan kami...">{{ old('hero_subtitle', $about->hero_subtitle) }}</textarea
                                >
                            </div>
                        </div>
                    </form>
                </div>

                {{-- CERITA --}}
                <div
                    class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8"
                >
                    <form
                        action="{{ route('dashboard.about.story') }}"
                        method="POST"
                        class="about-bulk-update-form"
                    >
                        @csrf

                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold">Cerita Kami</h2>

                            <button
                                type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl"
                            >
                                Simpan
                            </button>
                        </div>

                        {{-- JUDUL --}}
                        <div>
                            <label for="aboutStoryTitle" class="font-medium"> Judul </label>

                            <input
                                type="text"
                                id="aboutStoryTitle"
                                name="story_title"
                                value="{{ old('story_title', $about->story_title) }}"
                                class="w-full mt-2 border rounded-xl p-3"
                                placeholder="Sejarah Kami"
                            />
                        </div>

                        {{-- ISI CERITA --}}
                        <div class="mt-6">
                            <label for="aboutStoryContent" class="font-medium block">
                                Isi Cerita
                            </label>

                            <textarea
                                id="aboutStoryContent"
                                name="story_content"
                                rows="12"
                                class="w-full mt-2 border rounded-xl p-4 resize-none overflow-y-auto"
                                placeholder="Masukkan cerita resto..."
                                >{{ old('story_content', $about->story_content) }}</textarea
                            >
                        </div>
                    </form>
                </div>

                <div class="grid lg:grid-cols-2 gap-8 mt-2">
                    <div
                        class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8"
                    >
                        <form
                            action="{{ route('dashboard.about.vision') }}"
                            method="POST"
                            class="about-bulk-update-form"
                        >
                            @csrf

                            <div class="flex items-center justify-between mb-5">
                                <h2 class="text-xl font-bold">Visi</h2>

                                <button
                                    type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl"
                                >
                                    Simpan
                                </button>
                            </div>

                            <textarea
                                name="vision"
                                rows="12"
                                class="w-full border rounded-xl p-4 resize-none overflow-y-auto"
                                placeholder="Masukkan visi perusahaan..."
                                >{{ old('vision', $about->vision) }}</textarea
                            >
                        </form>
                    </div>

                    <div
                        class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8"
                    >
                        <div class="flex items-center justify-between mb-5">
                            <h2 class="text-xl font-bold">Misi</h2>

                            <button
                                type="button"
                                onclick="
                                    document
                                        .getElementById('formTambahMisi')
                                        .classList.toggle('hidden')
                                "
                                class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl"
                            >
                                + Tambah Misi
                            </button>
                        </div>

                        {{-- FORM TAMBAH --}}
                        <form
                            id="formTambahMisi"
                            action="{{ route('dashboard.about.mission.store') }}"
                            method="POST"
                            class="hidden mb-4"
                        >
                            @csrf

                            <div class="flex gap-3">
                                <input
                                    type="text"
                                    name="mission"
                                    required
                                    class="flex-1 border rounded-xl p-3"
                                    placeholder="Masukkan misi baru..."
                                />

                                <button
                                    type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-xl"
                                >
                                    Simpan
                                </button>
                            </div>
                        </form>

                        {{-- DAFTAR MISI --}}
                        <div
                            id="missionContainer"
                            class="max-h-[320px] overflow-y-auto pr-2 space-y-3"
                        >
                            @foreach ($missions as $mission)
<div
                                    class="border border-slate-200 rounded-xl p-4 bg-slate-50"
                                >
                                    <div class="flex gap-3 items-center">
                                        {{-- UPDATE --}}
                                        <form
                                            action="{{ route('dashboard.about.mission.update', $mission->id) }}"
                                            method="POST"
                                            class="flex-1 about-bulk-update-form"
                                        >
                                            @csrf
                                            @method ('PUT')

                                            <input
                                                type="text"
                                                name="mission"
                                                value="{{ $mission->mission }}"
                                                class="w-full border rounded-xl p-3 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                                required
                                            />
                                        </form>

                                        {{-- UPDATE --}}
                                        <button
                                            type="button"
                                            onclick="
                                                this.previousElementSibling.submit()
                                            "
                                            class="px-4 py-2 rounded-xl bg-indigo-100 text-indigo-600 hover:bg-indigo-200"
                                        >
                                            Update
                                        </button>

                                        {{-- HAPUS --}}
                                        <form
                                            action="{{ route('dashboard.about.mission.destroy', $mission->id) }}"
                                            method="POST"
                                        >
                                            @csrf
                                            @method ('DELETE')

                                            <button
                                                type="submit"
                                                onclick="
                                                    return confirm(
                                                        'Yakin ingin menghapus misi ini?',
                                                    );
                                                "
                                                class="px-4 py-2 rounded-xl bg-red-100 text-red-600 hover:bg-red-200"
                                            >
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
@endforeach
                        </div>
                    </div>
                </div>

                {{-- TIMELINE --}}
                <div
                    class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8"
                >
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-xl font-bold">
                                Perjalanan Perusahaan
                            </h2>

                            <p class="text-slate-500 text-sm">Kelola sejarah perjalanan Resto Joss Gandos.</p>
                        </div>

                        <button
                            type="button"
                            onclick="
                                document
                                    .getElementById('formTambahTimeline')
                                    .classList.toggle('hidden')
                            "
                            class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-xl"
                        >
                            + Tambah Timeline
                        </button>
                    </div>

                    {{-- FORM TAMBAH TIMELINE --}}
                    <form
                        id="formTambahTimeline"
                        action="{{ route('dashboard.about.timeline.store') }}"
                        method="POST"
                        class="hidden mb-6"
                    >
                        @csrf

                        <div class="grid md:grid-cols-[120px_1fr] gap-4">
                            {{-- TAHUN --}}
                            <div>
                                <label for="aboutTimelineYearNew" class="text-sm font-medium text-slate-600">
                                    Tahun
                                </label>

                                <input
                                    type="text"
                                    id="aboutTimelineYearNew"
                                    name="year"
                                    required
                                    class="w-full mt-2 border rounded-xl p-3"
                                    placeholder="2017"
                                />
                            </div>

                            {{-- JUDUL + DESKRIPSI --}}
                            <div class="space-y-3">
                                <div>
                                    <label for="aboutTimelineTitleNew" class="text-sm font-medium text-slate-600">
                                        Judul
                                    </label>

                                    <input
                                        type="text"
                                        id="aboutTimelineTitleNew"
                                        name="title"
                                        required
                                        class="w-full mt-2 border rounded-xl p-3"
                                        placeholder="Judul perjalanan"
                                    />
                                </div>

                                <div>
                                    <label for="aboutTimelineDescriptionNew" class="text-sm font-medium text-slate-600">
                                        Deskripsi
                                    </label>

                                    <textarea
                                        id="aboutTimelineDescriptionNew"
                                        name="description"
                                        rows="3"
                                        required
                                        class="w-full mt-2 border rounded-xl p-3 resize-none"
                                        placeholder="Deskripsi perjalanan..."
                                    ></textarea>
                            </div>
                        </div>
                </div>

                <div class="flex justify-end gap-3 mt-4">
                    {{-- BATAL --}}
                    <button type="button"
                        onclick="
                                    document
                                        .getElementById('formTambahTimeline')
                                        .classList.add('hidden')
                                "
                        class="px-5 py-2 rounded-xl border border-slate-300 text-slate-600 hover:bg-slate-100">
                        Batal
                    </button>

                    {{-- SIMPAN --}}
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl">
                        Simpan
                    </button>
                </div>
                </form>

                {{-- DAFTAR TIMELINE --}}
                <div class="max-h-[520px] overflow-y-auto pr-2 space-y-4">
                    @foreach ($timelines as $timeline)
                        <div class="border border-slate-200 rounded-xl bg-slate-50 overflow-hidden">
                            {{-- HEADER CARD --}}
                            <div class="flex items-center justify-between px-5 py-4">
                                {{-- TAHUN + JUDUL --}}
                                <div class="flex items-center">
                                    <span class="w-[90px] shrink-0 font-semibold text-indigo-600">
                                        {{ $timeline->year }}
                                    </span>

                                    <span class="font-semibold text-slate-800">
                                        {{ $timeline->title }}
                                    </span>
                                </div>

                                {{-- TOMBOL PANAH --}}
                                <button type="button" onclick="toggleTimeline({{ $timeline->id }})"
                                    class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-slate-200 transition">
                                    <i id="timelineArrow-{{ $timeline->id }}"
                                        class="uil uil-angle-down text-xl text-slate-500 transition-transform duration-200">
                                    </i>
                                </button>
                            </div>

                            {{-- DETAIL TIMELINE --}}
                            <div id="timelineDetail-{{ $timeline->id }}"
                                class="hidden border-t border-slate-200 px-5 py-5">
                                <form action="{{ route('dashboard.about.timeline.update', $timeline->id) }}"
                                    method="POST" class="about-bulk-update-form">
                                    @csrf
                                    @method ('PUT')

                                    {{-- TAHUN + DETAIL --}}
                                    <div class="grid md:grid-cols-[120px_1fr] gap-4">
                                        {{-- TAHUN --}}
                                        <div>
                                            <label for="aboutTimelineYear-{{ $timeline->id }}"
                                                class="text-sm font-medium text-slate-600">
                                                Tahun
                                            </label>

                                            <input type="text" id="aboutTimelineYear-{{ $timeline->id }}"
                                                name="year" value="{{ $timeline->year }}"
                                                class="w-full mt-2 border rounded-xl p-3 font-semibold" required />
                                        </div>

                                        {{-- JUDUL + DESKRIPSI --}}
                                        <div class="space-y-3">
                                            {{-- JUDUL --}}
                                            <div>
                                                <label for="aboutTimelineTitle-{{ $timeline->id }}"
                                                    class="text-sm font-medium text-slate-600">
                                                    Judul
                                                </label>

                                                <input type="text" id="aboutTimelineTitle-{{ $timeline->id }}"
                                                    name="title" value="{{ $timeline->title }}"
                                                    class="w-full mt-2 border rounded-xl p-3" required />
                                            </div>

                                            {{-- DESKRIPSI --}}
                                            <div>
                                                <label for="aboutTimelineDescription-{{ $timeline->id }}"
                                                    class="text-sm font-medium text-slate-600">
                                                    Deskripsi
                                                </label>

                                                <textarea id="aboutTimelineDescription-{{ $timeline->id }}" name="description" rows="3"
                                                    class="w-full mt-2 border rounded-xl p-3 resize-none" required>{{ $timeline->description }}</textarea
                                                    >
                                                </div>
                                            </div>
                                        </div>

                                        {{-- TOMBOL UPDATE + HAPUS --}}
                                        <div
                                            class="flex justify-end gap-2 mt-4"
                                        >
                                            <button
                                                type="submit"
                                                class="px-4 py-2 rounded-xl bg-indigo-100 text-indigo-600 hover:bg-indigo-200"
                                            >
                                                Update
                                            </button>

                                            <button
                                                type="button"
                                                onclick="document.getElementById('delete-timeline-{{ $timeline->id }}').submit()"
                                                class="px-4 py-2 rounded-xl bg-red-100 text-red-600 hover:bg-red-200"
                                            >
                                                Hapus
                                            </button>
                                        </div>
                                    </form>

                                    {{-- FORM HAPUS --}}
                                    <form
                                        id="delete-timeline-{{ $timeline->id }}"
                                        action="{{ route('dashboard.about.timeline.destroy', $timeline->id) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method ('DELETE')
                                    </form>
                                </div>
                            </div>
@endforeach
                    </div>
                </div>

                {{-- ================= PENDIRI RESTO ================= --}}
                <div
                    class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8"
                >
                    <form
                        action="{{ route('dashboard.about.founder') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="about-bulk-update-form"
                    >
                        @csrf

                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold">Pendiri Resto</h2>

                            <button
                                type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl"
                            >
                                Simpan
                            </button>
                        </div>

                        <div class="grid lg:grid-cols-3 gap-8 items-start">
                            {{-- ================= FOTO ================= --}}
                            <div class="lg:col-span-1">
                                <p class="font-medium">
                                    Foto Pendiri
                                </p>

                                <div
                                    id="founderPreview"
                                    class="mt-3 h-[320px] border-2 border-dashed rounded-2xl overflow-hidden bg-slate-50 flex items-center justify-center cursor-pointer hover:border-red-500 transition"
                                >
                                    @if ($about->founder_photo)
<img src="{{ asset('storage/' . $about->founder_photo) }}"
                                            class="w-full h-full object-cover rounded-xl" alt="Preview Foto Pendiri" />
@else
<span class="text-slate-400">Preview Foto</span>
@endif
                                </div>

                                <label for="founderImage" class="block font-medium mt-4 mb-2">
                                    Upload Foto (JPG/PNG/WebP, maks 2MB)
                                </label>

                                <input
                                    id="founderImage"
                                    name="founder_photo"
                                    type="file"
                                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                    class="w-full border border-slate-200 rounded-xl p-3 bg-white
                                           file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50
                                           file:px-4 file:py-2 file:font-semibold file:text-indigo-700
                                           hover:file:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                />
                                <p class="text-xs text-slate-400 mt-2">
                                    Pilih foto maksimal 2 MB. Preview berubah setelah file dipilih.
                                </p>
                            </div>

                            {{-- ================= DATA PENDIRI ================= --}}
                            <div class="lg:col-span-2 space-y-5">
                                {{-- Nama --}}
                                <div>
                                    <label for="aboutFounderName" class="font-medium">
                                        Nama Pendiri
                                    </label>

                                    <input
                                        type="text"
                                        id="aboutFounderName"
                                        name="founder_name"
                                        value="{{ old('founder_name', $about->founder_name) }}"
                                        class="w-full mt-2 border rounded-xl p-3"
                                        placeholder="Dr. Siswanto"
                                        required
                                    />
                                </div>

                                {{-- Jabatan --}}
                                <div>
                                    <label for="aboutFounderPosition" class="font-medium"> Jabatan </label>

                                    <input
                                        type="text"
                                        id="aboutFounderPosition"
                                        name="founder_position"
                                        value="{{ old('founder_position', $about->founder_position) }}"
                                        class="w-full mt-2 border rounded-xl p-3"
                                        placeholder="Founder"
                                        required
                                    />
                                </div>

                                {{-- Deskripsi --}}
                                <div>
                                    <label for="aboutFounderDescription" class="font-medium">
                                        Deskripsi
                                    </label>

                                    <textarea
                                        id="aboutFounderDescription"
                                        name="founder_description"
                                        rows="11"
                                        class="w-full mt-2 border rounded-xl p-4"
                                        placeholder="Masukkan deskripsi pendiri..."
                                        >{{ old('founder_description', $about->founder_description) }}</textarea
                                    >
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- TIM --}}
                {{-- ================= TIM KAMI ================= --}}
                <div
                    class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8"
                >
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-xl font-bold">Tim Kami</h2>

                            <p class="text-slate-500 text-sm">Kelola anggota tim yang tampil pada website.</p>
                        </div>

                        <button
                            type="button"
                            onclick="
                                document
                                    .getElementById('formTambahTeam')
                                    .classList.toggle('hidden')
                            "
                            class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-xl"
                        >
                            + Tambah Tim
                        </button>
                    </div>

                    {{-- ================= FORM TAMBAH ================= --}}
                    <form
                        id="formTambahTeam"
                        action="{{ route('dashboard.about.team.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="hidden mb-6 border border-slate-200 rounded-2xl p-5 bg-slate-50"
                    >
                        @csrf

                        <div class="grid lg:grid-cols-[170px_1fr] gap-6">
                            {{-- FOTO --}}
                            <div>
                                <p class="font-medium"> Foto </p>

                                <div
                                    id="newTeamPreview"
                                    class="mt-2 w-[170px] h-[230px] border-2 border-dashed rounded-2xl overflow-hidden bg-white flex items-center justify-center"
                                >
                                    <span class="text-slate-400 text-sm">
                                        Preview Foto
                                    </span>
                                </div>

                                <label for="newTeamPhoto" class="block font-medium mt-3 mb-2">
                                    Upload Foto (JPG/PNG/WebP, maks 2MB)
                                </label>

                                <input
                                    id="newTeamPhoto"
                                    type="file"
                                    name="photo"
                                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                    class="w-full border border-slate-200 rounded-xl p-3 bg-white
                                           file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50
                                           file:px-4 file:py-2 file:font-semibold file:text-indigo-700
                                           hover:file:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                />
                                <p class="text-xs text-slate-400 mt-2">
                                    Pilih foto maksimal 2 MB. Preview berubah setelah file dipilih.
                                </p>
                            </div>

                            {{-- DATA --}}
                            <div class="space-y-4">
                                <div>
                                    <label for="aboutNewTeamName" class="font-medium"> Nama </label>

                                    <input
                                        type="text"
                                        id="aboutNewTeamName"
                                        name="name"
                                        autocomplete="off"
                                        required
                                        class="w-full mt-2 border rounded-xl p-3"
                                        placeholder="Nama anggota"
                                    />
                                </div>

                                <div>
                                    <label for="aboutNewTeamPosition" class="font-medium"> Jabatan </label>

                                    <input
                                        type="text"
                                        id="aboutNewTeamPosition"
                                        name="position"
                                        required
                                        class="w-full mt-2 border rounded-xl p-3"
                                        placeholder="Jabatan"
                                    />
                                </div>

                                <div>
                                    <label for="aboutNewTeamDescription" class="font-medium">
                                        Deskripsi
                                    </label>

                                    <textarea
                                        id="aboutNewTeamDescription"
                                        name="description"
                                        rows="5"
                                        class="w-full mt-2 border rounded-xl p-3 resize-none"
                                        placeholder="Deskripsi anggota tim..."
                                    ></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- BUTTON TAMBAH --}}
                                    <div class="flex justify-end gap-3 mt-5">
                                        <button type="button"
                                            onclick="
                                    document
                                        .getElementById('formTambahTeam')
                                        .classList.add('hidden')
                                "
                                            class="px-5 py-2 rounded-xl border border-slate-300 text-slate-600 hover:bg-slate-100">
                                            Batal
                                        </button>

                                        <button type="submit"
                                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl">
                                            Simpan
                                        </button>
                                    </div>
                                </form>

                                {{-- ================= SLIDER TIM ================= --}}
                                <div class="relative">
                                    <div class="flex items-start gap-5 overflow-x-auto pb-4 snap-x snap-mandatory">
                                        @foreach ($teams as $team)
                                            <div
                                                class="flex-none self-start w-[300px] border border-slate-200 rounded-2xl bg-slate-50 overflow-hidden snap-start">
                                                {{-- FOTO --}}
                                                <div class="relative">
                                                    <div id="teamPhotoPreviewContainer-{{ $team->id }}"
                                                        class="h-[360px] bg-white flex items-center justify-center">
                                                        @if ($team->photo)
                                                            <img id="teamMainPhoto-{{ $team->id }}"
                                                                src="{{ asset('storage/' . $team->photo) }}"
                                                                alt="{{ $team->name }}"
                                                                class="w-full h-full object-cover" />
                                                        @else
                                                            <span class="text-slate-400">
                                                                Foto
                                                            </span>
                                                        @endif
                                                    </div>

                                                    {{-- PANAH --}}
                                                    <button type="button" onclick="toggleTeam({{ $team->id }})"
                                                        class="absolute bottom-3 right-3 w-10 h-10 bg-white/90 rounded-full shadow flex items-center justify-center hover:bg-white">
                                                        <i id="teamArrow-{{ $team->id }}"
                                                            class="uil uil-angle-down text-xl text-slate-600 transition-transform duration-200">
                                                        </i>
                                                    </button>
                                                </div>

                                                {{-- DETAIL --}}
                                                <div id="teamDetail-{{ $team->id }}"
                                                    class="hidden border-t border-slate-200 p-5">
                                                    <form
                                                        action="{{ route('dashboard.about.team.update', $team->id) }}"
                                                        method="POST" enctype="multipart/form-data"
                                                        class="about-bulk-update-form">
                                                        @csrf
                                                        @method ('PUT')

                                                        {{-- UPLOAD FOTO + PREVIEW --}}
                                                        <div>
                                                            <label for="teamPhotoInput-{{ $team->id }}"
                                                                class="block font-medium mb-2">
                                                                Upload Foto (JPG/PNG/WebP, maks 2MB)
                                                            </label>

                                                            <input type="file"
                                                                id="teamPhotoInput-{{ $team->id }}"
                                                                name="photo"
                                                                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                                                class="w-full border border-slate-200 rounded-xl p-3 bg-white
                                                                       file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50
                                                                       file:px-4 file:py-2 file:font-semibold file:text-indigo-700
                                                                       hover:file:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                                                onchange="previewTeamPhoto({{ $team->id }})" />
                                                            <p class="text-xs text-slate-400 mt-2">
                                                                Pilih foto maksimal 2 MB. Preview berubah setelah file
                                                                dipilih.
                                                            </p>
                                                        </div>

                                                        {{-- NAMA --}}
                                                        <div class="mt-4">
                                                            <label for="aboutTeamName-{{ $team->id }}"
                                                                class="font-medium">
                                                                Nama
                                                            </label>

                                                            <input type="text"
                                                                id="aboutTeamName-{{ $team->id }}" name="name"
                                                                value="{{ $team->name }}" autocomplete="off"
                                                                required class="w-full mt-2 border rounded-xl p-3" />
                                                        </div>

                                                        {{-- JABATAN --}}
                                                        <div class="mt-4">
                                                            <label for="aboutTeamPosition-{{ $team->id }}"
                                                                class="font-medium">
                                                                Jabatan
                                                            </label>

                                                            <input type="text"
                                                                id="aboutTeamPosition-{{ $team->id }}"
                                                                name="position" value="{{ $team->position }}"
                                                                required class="w-full mt-2 border rounded-xl p-3" />
                                                        </div>

                                                        {{-- DESKRIPSI --}}
                                                        <div class="mt-4">
                                                            <label for="aboutTeamDescription-{{ $team->id }}"
                                                                class="font-medium">
                                                                Deskripsi
                                                            </label>

                                                            <textarea id="aboutTeamDescription-{{ $team->id }}" name="description" rows="4"
                                                                class="w-full mt-2 border rounded-xl p-3 resize-none">{{ $team->description }}</textarea>
                                                        </div>

                                                        {{-- BUTTON --}}
                                                        <div class="flex gap-3 mt-5">
                                                            <button type="submit"
                                                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-xl">
                                                                Update
                                                            </button>

                                                            <button type="button"
                                                                onclick="document.getElementById('delete-team-{{ $team->id }}').submit()"
                                                                class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2 rounded-xl">
                                                                Hapus
                                                            </button>
                                                        </div>
                                                    </form>

                                                    {{-- FORM HAPUS --}}
                                                    <form id="delete-team-{{ $team->id }}"
                                                        action="{{ route('dashboard.about.team.destroy', $team->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method ('DELETE')
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <script>
                                const heroInput = document.getElementById("heroImage");
                                const heroPreview = document.getElementById("heroPreview");

                                const founderInput =
                                    document.getElementById("founderImage");
                                const founderPreview =
                                    document.getElementById("founderPreview");

                                // PREVIEW UPLOAD FOTO HERO
                                function loadHeroPreview() {
                                    if (!heroInput || !heroPreview) return;
                                    const file = heroInput.files && heroInput.files[0];
                                    if (!file) return; // Pertahankan preview foto yang sudah tersimpan.

                                    const objectUrl = URL.createObjectURL(file);
                                    heroPreview.innerHTML =
                                        `<img src="${objectUrl}"
                                        class="w-full h-full object-contain rounded-xl bg-white" alt="Preview Background Hero">`;
                                }

                                // PREVIEW UPLOAD FOTO PENDIRI
                                function loadFounderPreview() {
                                    if (!founderInput || !founderPreview) return;
                                    const file = founderInput.files && founderInput.files[0];
                                    if (!file) return; // Pertahankan preview foto yang sudah tersimpan.

                                    const objectUrl = URL.createObjectURL(file);
                                    founderPreview.innerHTML = `<img src="${objectUrl}"
                                        class="w-full h-full object-cover rounded-xl" alt="Preview Foto Pendiri">`;
                                }

                                heroInput?.addEventListener("change", loadHeroPreview);
                                founderInput?.addEventListener("change", loadFounderPreview);

                                // PREVIEW UPLOAD FOTO TIM BARU
                                const newTeamPhotoInput = document.getElementById("newTeamPhoto");
                                const newTeamPreview = document.getElementById("newTeamPreview");
                                newTeamPhotoInput?.addEventListener("change", function() {
                                    const file = this.files && this.files[0];
                                    if (!file || !newTeamPreview) return;
                                    const objectUrl = URL.createObjectURL(file);
                                    newTeamPreview.innerHTML = `<img src="${objectUrl}"
                                        class="w-full h-full object-cover" alt="Preview Foto Tim">`;
                                });

                                // TIMELINE TOGGLE
                                function toggleTimeline(id) {
                                    const detail = document.getElementById(
                                        "timelineDetail-" + id,
                                    );
                                    const arrow = document.getElementById(
                                        "timelineArrow-" + id,
                                    );

                                    if (!detail || !arrow) return;

                                    if (detail.classList.contains("hidden")) {
                                        detail.classList.remove("hidden");
                                        arrow.classList.add("rotate-180");
                                    } else {
                                        detail.classList.add("hidden");
                                        arrow.classList.remove("rotate-180");
                                    }
                                }

                                // TEAM TOGGLE
                                function toggleTeam(id) {
                                    const detail = document.getElementById(
                                        "teamDetail-" + id,
                                    );
                                    const arrow = document.getElementById(
                                        "teamArrow-" + id,
                                    );

                                    if (!detail || !arrow) return;

                                    if (detail.classList.contains("hidden")) {
                                        detail.classList.remove("hidden");
                                        arrow.classList.add("rotate-180");
                                    } else {
                                        detail.classList.add("hidden");
                                        arrow.classList.remove("rotate-180");
                                    }
                                }

                                // PREVIEW UPLOAD FOTO TIM YANG DIEDIT
                                function previewTeamPhoto(id) {
                                    const input = document.getElementById("teamPhotoInput-" + id);
                                    const previewContainer = document.getElementById(
                                        "teamPhotoPreviewContainer-" + id
                                    );
                                    if (!input || !previewContainer) return;

                                    const file = input.files && input.files[0];
                                    if (!file) return;

                                    const objectUrl = URL.createObjectURL(file);
                                    previewContainer.innerHTML = `<img
                                        id="teamMainPhoto-${id}"
                                        src="${objectUrl}"
                                        alt="Preview Foto Tim"
                                        class="w-full h-full object-cover"
                                    >`;
                                }
                            </script>

                            <script>
                                // SIMPAN SEMUA PERUBAHAN ABOUT
                                document.addEventListener("DOMContentLoaded", function() {
                                    const saveAllButton = document.getElementById(
                                        "saveAllAboutChanges",
                                    );

                                    if (!saveAllButton) return;

                                    saveAllButton.addEventListener(
                                        "click",
                                        async function() {
                                            const forms = document.querySelectorAll(
                                                ".about-bulk-update-form",
                                            );

                                            if (forms.length === 0) {
                                                alert(
                                                    "Tidak ada perubahan yang dapat disimpan.",
                                                );
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

                                                    const response = await fetch(
                                                        form.action, {
                                                            method: "POST",
                                                            body: formData,
                                                            headers: {
                                                                "X-Requested-With": "XMLHttpRequest",
                                                            },
                                                        },
                                                    );

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
                                                alert(
                                                    "Terjadi kesalahan saat menyimpan perubahan.",
                                                );
                                            } finally {
                                                saveAllButton.disabled = false;
                                                saveAllButton.innerHTML = originalText;
                                            }
                                        },
                                    );
                                });
                            </script>
        </main>
    </div>
</body>

</html>
