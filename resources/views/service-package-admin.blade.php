<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Kelola Paket & Layanan</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logojossgandos.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css" />

    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        .poster-preview {
            aspect-ratio: 4 / 3;
        }

        #addCategory {
            font-weight: 600;
        }

        #addPackageDetails.hidden {
            display: none;
        }

        .package-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
            margin-top: 0.45rem;
        }

        .package-meta-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.28rem 0.55rem;
            border-radius: 9999px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 0.75rem;
            line-height: 1rem;
            white-space: nowrap;
        }

        .field-note {
            margin-top: 0.45rem;
            font-size: 0.75rem;
            line-height: 1.1rem;
            color: #64748b;
        }

        .settings-accordion summary {
            list-style: none;
            cursor: pointer;
        }

        .settings-accordion summary::-webkit-details-marker {
            display: none;
        }

        .settings-accordion .settings-chevron {
            transition: transform 0.25s ease;
        }

        .settings-accordion[open] .settings-chevron {
            transform: rotate(180deg);
        }

        .settings-accordion form {
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">
    <div class="flex h-screen">
        {{-- ================= SIDEBAR ================= --}}
        @include ('layouts.sidebar')

        {{-- ================= CONTENT ================= --}}
        <main class="flex-1 min-w-0 min-h-0 overflow-y-auto bg-slate-50 relative">
            {{-- ================= HEADER ================= --}}
            <header
                class="sticky top-0 z-20 flex-shrink-0 bg-white border-b border-slate-200 shadow-sm px-6 py-4 flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <button type="button" onclick="toggleSidebar()"
                        class="md:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-lg">
                        <i class="uil uil-bars text-2xl"></i>
                    </button>

                    <div>
                        <h1 class="text-xl font-bold text-slate-800 tracking-tight">
                            Kelola Paket & Layanan
                        </h1>
                    </div>
                </div>

                {{-- TAMBAH --}}
                <button type="button" onclick="openAddModal()"
                    class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg hover:shadow-xl transition-all">
                    <i class="uil uil-plus-circle text-lg"></i>

                    <span> Tambah Paket </span>
                </button>
            </header>

            {{-- ================= SUCCESS ================= --}}
            @if (session('success'))
                <div id="successMessage" class="px-4 md:px-6 pt-4">
                    <div
                        class="flex items-center justify-between gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-4 py-3 text-sm">
                        <div class="flex items-center gap-2">
                            <i class="uil uil-check-circle text-lg"> </i>

                            <span> {{ session('success') }} </span>
                        </div>

                        <button type="button" onclick="closeSuccessMessage()"
                            class="text-emerald-600 hover:text-emerald-800">
                            <i class="uil uil-times text-lg"></i>
                        </button>
                    </div>
                </div>
            @endif

            {{-- ================= ERROR ================= --}}
            @if ($errors->any())
                <div class="px-4 md:px-6 pt-4">
                    <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3">
                        <div class="font-semibold text-sm mb-1">
                            Terdapat kesalahan:
                        </div>

                        <ul class="list-disc ml-5 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            @endif


            {{-- ================= PENGATURAN PAKET & LAYANAN ================= --}}
            <div class="px-4 md:px-6 pt-5 space-y-4">

                {{-- HEADER SECTION --}}
                <details class="settings-accordion bg-white border border-slate-200 rounded-2xl overflow-hidden">

                    <summary class="flex items-center justify-between gap-4 p-6 hover:bg-slate-50/70 transition-colors">
                        <div class="flex items-center gap-4 min-w-0">
                            <div
                                class="w-14 h-14 shrink-0 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                                <i data-lucide="layout-dashboard" class="w-7 h-7"></i>
                            </div>

                            <div>
                                <h2 class="text-xl font-bold text-slate-800">
                                    Header Section
                                </h2>
                                <p class="text-sm md:text-base text-slate-500 mt-1">
                                    Atur judul dan deskripsi halaman Paket & Layanan.
                                </p>
                            </div>
                        </div>

                        <i data-lucide="chevron-down" class="settings-chevron w-6 h-6 shrink-0 text-slate-500"></i>
                    </summary>

                    <form action="{{ route('service-packages.settings.update') }}" method="POST"
                        class="border-t border-slate-200 p-6 space-y-5">

                        @csrf
                        @method('PUT')

                        <div>
                            <label for="section_title" class="block text-sm font-semibold text-slate-700 mb-2">
                                Judul Section
                            </label>

                            <input type="text" id="section_title" name="section_title"
                                value="{{ old('section_title', $settings?->section_title) }}" required
                                class="w-full h-12 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                        </div>

                        <div>
                            <label for="section_description" class="block text-sm font-semibold text-slate-700 mb-2">
                                Deskripsi Section
                            </label>

                            <textarea id="section_description" name="section_description" rows="3"
                                class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none resize-y focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">{{ old('section_description', $settings?->section_description) }}</textarea>
                        </div>

                        <div class="flex justify-end pt-4 border-t border-slate-100">
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition">
                                <i data-lucide="save" class="w-4 h-4"></i>
                                Update Header Section
                            </button>
                        </div>
                    </form>
                </details>


                {{-- KELOLA CTA --}}
                <details class="settings-accordion bg-white border border-slate-200 rounded-2xl overflow-hidden">

                    <summary class="flex items-center justify-between gap-4 p-6 hover:bg-slate-50/70 transition-colors">
                        <div class="flex items-center gap-4 min-w-0">
                            <div
                                class="w-14 h-14 shrink-0 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center">
                                <i data-lucide="megaphone" class="w-7 h-7"></i>
                            </div>

                            <div>
                                <h2 class="text-xl font-bold text-slate-800">
                                    Kelola CTA
                                </h2>
                                <p class="text-sm md:text-base text-slate-500 mt-1">
                                    Atur judul dan deskripsi CTA di halaman Paket & Layanan.
                                </p>
                            </div>
                        </div>

                        <i data-lucide="chevron-down" class="settings-chevron w-6 h-6 shrink-0 text-slate-500"></i>
                    </summary>

                    <form action="{{ route('service-packages.settings.update') }}" method="POST"
                        class="border-t border-slate-200 p-6 space-y-5">

                        @csrf
                        @method('PUT')

                        <div>
                            <label for="cta_title" class="block text-sm font-semibold text-slate-700 mb-2">
                                Judul CTA
                            </label>

                            <input type="text" id="cta_title" name="cta_title"
                                value="{{ old('cta_title', $settings?->cta_title) }}" required
                                class="w-full h-12 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                        </div>

                        <div>
                            <label for="cta_description" class="block text-sm font-semibold text-slate-700 mb-2">
                                Deskripsi CTA
                            </label>

                            <textarea id="cta_description" name="cta_description" rows="3"
                                class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none resize-y focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">{{ old('cta_description', $settings?->cta_description) }}</textarea>
                        </div>

                        <div class="flex justify-end pt-4 border-t border-slate-100">
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition">
                                <i data-lucide="save" class="w-4 h-4"></i>
                                Update CTA
                            </button>
                        </div>
                    </form>
                </details>

            </div>


            {{-- ================= FILTER ================= --}}
            <div class="px-4 md:px-6 pt-5">
                <div class="bg-white border border-slate-200 rounded-2xl p-4 mb-5">
                    <div class="flex flex-col md:flex-row gap-3">
                        {{-- SEARCH --}}
                        <div class="relative flex-1">
                            <i data-lucide="search"
                                class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400">
                            </i>

                            <input type="text" id="searchPackage" placeholder="Cari nama paket..."
                                oninput="filterPackages()"
                                class="w-full h-12 pl-12 pr-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                        </div>

                        {{-- FILTER KATEGORI --}}
                        <div class="relative md:w-72">
                            <select id="categoryFilter" onchange="filterPackages()"
                                class="appearance-none w-full h-12 px-4 pr-10 border border-slate-200 rounded-xl bg-white outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                                <option value="all">Semua Paket</option>

                                <option value="package_menu">
                                    Package Menu
                                </option>

                                <option value="catering_package">
                                    Catering Package
                                </option>

                                <option value="wedding_package">
                                    Wedding Package
                                </option>
                            </select>

                            <i data-lucide="chevron-down"
                                class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500 pointer-events-none">
                            </i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= TABLE ================= --}}
            <div class="px-4 md:px-6 pt-0 pb-8">
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                    <div class="overflow-x-auto md:overflow-x-hidden">
                        <table class="w-full table-fixed min-w-[980px] md:min-w-0">
                            <colgroup>
                                <col class="w-[8%]" />
                                <col class="w-[13%]" />
                                <col class="w-[10%]" />
                                <col class="w-[11%]" />
                                <col class="w-[20%]" />
                                <col class="w-[12%]" />
                                <col class="w-[9%]" />
                                <col class="w-[7%]" />
                                <col class="w-[10%]" />
                            </colgroup>
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th class="px-3 py-4 text-left text-xs font-semibold text-slate-500 uppercase">
                                        Foto
                                    </th>

                                    <th class="px-3 py-4 text-left text-xs font-semibold text-slate-500 uppercase">
                                        Nama Paket
                                    </th>

                                    <th class="px-3 py-4 text-left text-xs font-semibold text-slate-500 uppercase">
                                        Harga
                                    </th>

                                    <th
                                        class="w-40 px-4 py-4 text-left text-xs font-semibold text-slate-500 uppercase">
                                        Kapasitas / Minimal
                                    </th>

                                    <th class="px-3 py-4 text-left text-xs font-semibold text-slate-500 uppercase">
                                        Deskripsi
                                    </th>

                                    <th
                                        class="w-40 px-4 py-4 text-left text-xs font-semibold text-slate-500 uppercase">
                                        Kategori
                                    </th>

                                    <th class="px-3 py-4 text-center text-xs font-semibold text-slate-500 uppercase">
                                        Status
                                    </th>

                                    <th class="px-3 py-4 text-center text-xs font-semibold text-slate-500 uppercase">
                                        Urutan
                                    </th>

                                    <th class="px-3 py-4 text-center text-xs font-semibold text-slate-500 uppercase">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody id="packageTable" class="divide-y divide-slate-100">
                                @forelse ($packages as $package)
                                    @php
                                        $imagePath = $package->image_path ?? '';

                                        if (\Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://'])) {
                                            $imageUrl = $imagePath;
                                        } elseif (\Illuminate\Support\Str::startsWith($imagePath, 'storage/')) {
                                            $imageUrl = asset($imagePath);
                                        } else {
                                            $imageUrl = asset('storage/' . $imagePath);
                                        }

                                        $categoryLabel = [
                                            'package_menu' => 'Package Menu',

                                            'catering_package' => 'Catering Package',

                                            'wedding_package' => 'Wedding Package',
                                        ];
                                    @endphp

                                    <tr class="package-row hover:bg-slate-50 transition"
                                        data-name="{{ strtolower($package->title) }}"
                                        data-category="{{ $package->category }}">
                                        {{-- FOTO --}}
                                        <td class="px-3 py-4 align-middle">
                                            <div
                                                class="w-16 poster-preview rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                                                @if ($package->image_path)
                                                    <img src="{{ $imageUrl }}" alt="{{ $package->title }}"
                                                        class="w-full h-full object-cover"
                                                        onerror="
                                                            this.style.display =
                                                                'none';
                                                            this.parentElement.innerHTML =
                                                                '<div class=&quot;w-full h-full flex items-center justify-center text-slate-400 text-xs text-center px-2&quot;>Gambar tidak tersedia</div>';
                                                        " />
                                                @else
                                                    <div
                                                        class="w-full h-full flex items-center justify-center text-slate-400">
                                                        <i data-lucide="image" class="w-6 h-6">
                                                        </i>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        {{-- NAMA --}}
                                        <td class="px-3 py-4 align-middle">
                                            <div class="font-semibold text-slate-800 truncate">
                                                {{ $package->title }}
                                            </div>
                                        </td>

                                        {{-- ================= HARGA ================= --}}
                                        <td class="px-3 py-4 align-middle">
                                            @if ($package->price)
                                                <div class="text-sm font-semibold text-slate-800 truncate">
                                                    {{ $package->price }}
                                                </div>
                                            @else
                                                <span class="text-sm text-slate-400">-</span>
                                            @endif
                                        </td>

                                        {{-- ================= KAPASITAS / MINIMAL PEMESANAN ================= --}}
                                        <td class="px-3 py-4 align-middle">
                                            @if ($package->capacity)
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-50 border border-slate-200 text-sm text-slate-600">
                                                    <i class="uil uil-users-alt"></i>
                                                    {{ $package->capacity }}
                                                </span>
                                            @else
                                                <span class="text-sm text-slate-400">-</span>
                                            @endif
                                        </td>

                                        {{-- DESKRIPSI --}}
                                        <td class="px-3 py-4 align-middle">
                                            <div class="text-sm text-slate-500 leading-5 line-clamp-2 break-words">
                                                {{ $package->description }}
                                            </div>
                                        </td>

                                        {{-- KATEGORI --}}
                                        <td class="px-3 py-4 align-middle">
                                            <span
                                                class="inline-flex max-w-full px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-600">
                                                {{ $categoryLabel[$package->category] ?? $package->category }}
                                            </span>
                                        </td>

                                        {{-- STATUS --}}
                                        <td class="px-3 py-4 text-center align-middle">
                                            @if ($package->is_active)
                                                <span
                                                    class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600">
                                                    Aktif
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-500">
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </td>

                                        {{-- URUTAN --}}
                                        <td class="px-3 py-4 text-center align-middle">
                                            <span class="text-sm font-medium text-slate-700">
                                                {{ $package->sort_order }}
                                            </span>
                                        </td>

                                        {{-- AKSI --}}
                                        <td class="px-3 py-4">
                                            <div class="flex items-center justify-center gap-1.5">
                                                {{-- EDIT --}}
                                                <button type="button"
                                                    onclick='openUpdateModal(@json($package))'
                                                    title="Edit Paket"
                                                    class="w-8 h-8 flex items-center justify-center rounded-lg text-blue-600 hover:bg-blue-50 transition">
                                                    <i data-lucide="pencil" class="w-4 h-4">
                                                    </i>
                                                </button>

                                                {{-- HAPUS --}}
                                                <form action="{{ route('service-packages.destroy', $package->id) }}"
                                                    method="POST"
                                                    onsubmit="
                                                        return confirm(
                                                            'Yakin ingin menghapus paket ini?',
                                                        );
                                                    ">
                                                    @csrf
                                                    @method ('DELETE')

                                                    <button type="submit" title="Hapus Paket"
                                                        class="w-8 h-8 flex items-center justify-center rounded-lg text-red-600 hover:bg-red-50 transition">
                                                        <i data-lucide="trash-2" class="w-4 h-4">
                                                        </i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="9" class="px-6 py-16 text-center text-slate-400">
                                            <i data-lucide="package-open" class="w-10 h-10 mx-auto mb-3">
                                            </i>

                                            <div class="text-sm">
                                                Belum ada paket & layanan.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </main>

    </div>

    {{-- =========================================================
         MODAL TAMBAH
    ========================================================== --}}

    <div id="addModal"
        class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm items-center justify-center p-4">
        <div class="bg-white w-full max-w-3xl max-h-[92vh] rounded-2xl shadow-xl overflow-y-auto">
            {{-- HEADER --}}
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">
                        Tambah Paket
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">Tambahkan paket & layanan baru.</p>
                </div>

                <button type="button" onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5">
                    </i>
                </button>
            </div>

            {{-- FORM --}}
            <form action="{{ route('service-packages.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="p-6 space-y-6">
                    {{-- ================= KATEGORI ================= --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Kategori
                        </label>

                        <select name="category" id="addCategory" required
                            onchange="
                                                                updateAddFields()
                                                            "
                            class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                            <option value="" selected disabled>
                                Pilih kategori
                                terlebih dahulu
                            </option>

                            <option value="package_menu">
                                Package Menu
                            </option>

                            <option value="catering_package">
                                Catering Package
                            </option>

                            <option value="wedding_package">
                                Wedding Package
                            </option>
                        </select>
                    </div>

                    <div id="addCategoryHint" class="rounded-xl border border-indigo-100 bg-indigo-50 px-4 py-3">
                        <div class="flex items-start gap-3">
                            <i class="uil uil-info-circle text-indigo-600 text-lg mt-0.5"></i>
                            <div>
                                <p class="text-sm font-semibold text-indigo-800">Pilih kategori terlebih dahulu</p>
                                <p class="text-xs text-indigo-700 mt-1 leading-5">Pilih kategori paket terlebih dahulu.
                                    Kolom detail akan muncul sesuai kategori yang dipilih.</p>
                            </div>
                        </div>
                    </div>

                    <div id="addPackageDetails" class="hidden space-y-6">
                        {{-- ================= GAMBAR ================= --}}
                        <div>
                            <label class="block text-sm font-medium mb-3">
                                Gambar Paket
                            </label>

                            <div class="grid grid-cols-1 sm:grid-cols-[220px_1fr] gap-7 items-start">
                                {{-- PREVIEW POSTER --}}
                                <div
                                    class="w-[220px] aspect-[4/3] mx-auto sm:mx-0 rounded-xl overflow-hidden border border-slate-200 bg-slate-50 flex items-center justify-center">
                                    <span id="addPreviewText" class="text-xs text-slate-400 text-center px-4">
                                        Preview
                                        Poster
                                    </span>

                                    <img id="addPreviewImage" src="" alt="Preview Poster"
                                        class="hidden w-full h-full object-cover" />
                                </div>

                                {{-- SUMBER GAMBAR --}}
                                <div class="space-y-4">
                                    {{-- UPLOAD FILE --}}
                                    <div>
                                        <label class="block text-sm font-medium mb-2">
                                            Upload
                                            File
                                        </label>

                                        <input type="file" name="image_file" id="addImageFile" accept="image/*"
                                            onchange="
                                                                                handleAddFile()
                                                                            "
                                            class="block w-full text-sm text-slate-500 border border-slate-200 rounded-xl cursor-pointer bg-white file:mr-3 file:py-2.5 file:px-3 file:border-0 file:bg-slate-100 file:text-slate-700 file:font-medium" />
                                    </div>

                                    {{-- ATAU URL --}}
                                    <div>
                                        <label class="block text-sm font-medium mb-2">
                                            Atau
                                            Gunakan
                                            URL
                                        </label>

                                        <input type="url" name="image_url" id="addImageUrl"
                                            oninput="
                                                                                handleAddUrl()
                                                                            "
                                            placeholder="https://contoh.com/poster.jpg"
                                            class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />

                                        <p id="addImageMessage" class="hidden mt-2 text-xs text-red-500">Pilih salah
                                            satu: upload file atau gunakan URL gambar.</p>

                                        <p id="addImageSizeMessage" class="hidden mt-2 text-xs text-red-500">
                                            Ukuran file lebih dari 1 MB. Harap kompres gambar terlebih dahulu hingga
                                            maksimal 1 MB.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ================= NAMA ================= --}}
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Nama Paket
                            </label>

                            <input type="text" name="title" required placeholder="Contoh: Package Menu"
                                class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                        </div>

                        {{-- ================= HARGA ================= --}}
                        <div id="addPriceField">
                            <label class="block text-sm font-medium mb-2">
                                Harga
                            </label>

                            <input type="text" name="price" id="addPrice" placeholder="Contoh: 70000/pack"
                                class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />

                            <p class="field-note">Tulis harga sesuai format yang ingin ditampilkan, misalnya 70000/pack
                                atau 50000/pax.</p>
                        </div>

                        {{-- ================= KAPASITAS / MINIMAL PEMESANAN ================= --}}
                        <div id="addCapacityField">
                            <label id="addCapacityLabel" class="block text-sm font-medium mb-2">
                                Kapasitas
                            </label>

                            <input type="text" name="capacity" id="addCapacity" placeholder="Contoh: 1 Orang"
                                class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                        </div>

                        {{-- ================= DESKRIPSI ================= --}}
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Deskripsi
                            </label>

                            <textarea name="description" rows="4" placeholder="Masukkan deskripsi paket..."
                                class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none resize-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"></textarea>
                        </div>

                        {{-- ================= STATUS + URUTAN ================= --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    Status
                                </label>

                                <select name="is_active"
                                    class="w-full h-11 px-4 border border-slate-200 rounded-xl bg-white">
                                    <option value="1">
                                        Aktif
                                    </option>

                                    <option value="0">
                                        Nonaktif
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    Urutan
                                </label>

                                <input type="number" name="sort_order" value="0" min="0"
                                    class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500" />
                            </div>
                        </div>
                    </div>
                </div>
                {{-- FOOTER --}}
                <div class="flex justify-end gap-3 px-6 py-5 border-t border-slate-100">
                    <button type="button"
                        onclick="
                                                            closeAddModal()
                                                        "
                        class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold hover:bg-slate-50">
                        Batal
                    </button>

                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- =========================================================
         MODAL UPDATE
    ========================================================== --}}

    <div id="updateModal"
        class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm items-center justify-center p-4">
        <div class="bg-white w-full max-w-3xl max-h-[92vh] rounded-2xl shadow-xl overflow-y-auto">
            {{-- HEADER --}}
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
                <div>
                    <h2 class="text-lg font-bold">
                        Update Paket
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">Perbarui paket & layanan.</p>
                </div>

                <button type="button" onclick="closeUpdateModal()" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5">
                    </i>
                </button>
            </div>

            {{-- FORM --}}
            <form id="updateForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method ('PUT')

                <div class="p-6 space-y-6">
                    {{-- KATEGORI --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Kategori
                        </label>

                        <select name="category" id="updateCategory" required
                            onchange="
                                                                updateEditFields()
                                                            "
                            class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                            <option value="package_menu">
                                Package Menu
                            </option>

                            <option value="catering_package">
                                Catering Package
                            </option>

                            <option value="wedding_package">
                                Wedding Package
                            </option>
                        </select>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <div class="flex items-start gap-3">
                            <i class="uil uil-info-circle text-slate-500 text-lg mt-0.5"></i>
                            <div>
                                <p class="text-sm font-semibold text-slate-700">Detail mengikuti kategori paket</p>
                                <p class="text-xs text-slate-500 mt-1 leading-5">Harga dan kapasitas akan menyesuaikan
                                    kategori yang dipilih.</p>
                            </div>
                        </div>
                    </div>
                    {{-- ================= GAMBAR ================= --}}
                    <div>
                        <label class="block text-sm font-medium mb-3">
                            Gambar Paket
                        </label>

                        <div class="grid grid-cols-1 sm:grid-cols-[220px_1fr] gap-7 items-start">
                            {{-- PREVIEW --}}
                            <div
                                class="w-[220px] aspect-[4/3] mx-auto sm:mx-0 rounded-xl overflow-hidden border border-slate-200 bg-slate-50 flex items-center justify-center">
                                <span id="updatePreviewText" class="hidden text-xs text-slate-400 text-center px-4">
                                    Preview
                                    Poster
                                </span>

                                <img id="updatePreviewImage" src="" alt="Preview Poster"
                                    class="w-full h-full object-cover" />
                            </div>

                            {{-- SUMBER --}}
                            <div class="space-y-4">
                                {{-- FILE --}}
                                <div>
                                    <label class="block text-sm font-medium mb-2">
                                        Ganti
                                        File
                                    </label>

                                    <input type="file" name="image_file" id="updateImageFile" accept="image/*"
                                        onchange="
                                                                            handleUpdateFile()
                                                                        "
                                        class="block w-full text-sm text-slate-500 border border-slate-200 rounded-xl cursor-pointer bg-white file:mr-3 file:py-2.5 file:px-3 file:border-0 file:bg-slate-100 file:text-slate-700 file:font-medium" />

                                    <p id="updateImageSizeMessage" class="hidden mt-2 text-xs text-red-500">Ukuran
                                        file lebih dari 1 MB. Harap kompres gambar terlebih dahulu hingga maksimal 1 MB.
                                    </p>
                                </div>

                                {{-- URL --}}
                                <div>
                                    <label class="block text-sm font-medium mb-2">
                                        Atau
                                        Gunakan
                                        URL
                                    </label>

                                    <input type="url" name="image_url" id="updateImageUrl"
                                        oninput="
                                                                            handleUpdateUrl()
                                                                        "
                                        placeholder="https://contoh.com/poster.jpg"
                                        class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />

                                    <p id="updateImageMessage" class="hidden mt-2 text-xs text-red-500">Pilih salah
                                        satu: upload file atau gunakan URL gambar.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- NAMA --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Nama Paket
                        </label>

                        <input type="text" name="title" id="updateTitle" required
                            class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500" />
                    </div>

                    {{-- ================= HARGA ================= --}}
                    <div id="updatePriceField">
                        <label class="block text-sm font-medium mb-2">
                            Harga
                        </label>

                        <input type="text" name="price" id="updatePrice" placeholder="Contoh: 70000/pack"
                            class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />

                        <p class="field-note">Tulis harga sesuai format yang ingin ditampilkan.</p>
                    </div>

                    {{-- KAPASITAS / MINIMAL PEMESANAN --}}
                    <div id="updateCapacityField">
                        <label id="updateCapacityLabel" class="block text-sm font-medium mb-2">
                            Kapasitas
                        </label>

                        <input type="text" name="capacity" id="updateCapacity" placeholder="Contoh: 1 Orang"
                            class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500" />
                    </div>

                    {{-- DESKRIPSI --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Deskripsi
                        </label>

                        <textarea name="description" id="updateDescription" rows="4"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none resize-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"></textarea>
                    </div>

                    {{-- STATUS + URUTAN --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Status
                            </label>

                            <select id="updateActive" name="is_active"
                                class="w-full h-11 px-4 border border-slate-200 rounded-xl bg-white">
                                <option value="1">
                                    Aktif
                                </option>

                                <option value="0">
                                    Nonaktif
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Urutan
                            </label>

                            <input type="number" id="updateSort" name="sort_order" min="0"
                                class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none focus:border-indigo-500" />
                        </div>
                    </div>
                </div>
                {{-- FOOTER --}}
                <div class="flex justify-end gap-3 px-6 py-5 border-t border-slate-100">
                    <button type="button"
                        onclick="
                                                            closeUpdateModal()
                                                        "
                        class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold hover:bg-slate-50">
                        Batal
                    </button>

                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- =========================================================
         JAVASCRIPT
    ========================================================== --}}

    <script>
        lucide.createIcons();

        /* =====================================================
                   SUCCESS
                ====================================================== */

        function closeSuccessMessage() {
            const message =
                document.getElementById(
                    "successMessage",
                );

            if (message) {
                message.remove();
            }
        }

        setTimeout(() => {
            closeSuccessMessage();
        }, 3000);

        /* =====================================================
                   FILTER
                ====================================================== */

        function filterPackages() {
            const search = document
                .getElementById("searchPackage")
                .value.toLowerCase()
                .trim();

            const filter =
                document.getElementById(
                    "categoryFilter",
                ).value;

            document
                .querySelectorAll(
                    ".package-row",
                )
                .forEach((row) => {
                    const name =
                        row.dataset.name;

                    const category =
                        row.dataset.category;

                    const matchSearch =
                        name.includes(search);

                    const matchCategory =
                        filter === "all" ||
                        category === filter;

                    row.style.display =
                        matchSearch &&
                        matchCategory ?
                        "" :
                        "none";
                });
        }

        /* =====================================================
                   CATEGORY FIELDS
                ====================================================== */

        function updateAddFields() {
            const category =
                document.getElementById(
                    "addCategory",
                );
            const details =
                document.getElementById(
                    "addPackageDetails",
                );
            const hint =
                document.getElementById(
                    "addCategoryHint",
                );
            const priceField =
                document.getElementById(
                    "addPriceField",
                );
            const capacityField =
                document.getElementById(
                    "addCapacityField",
                );
            const priceInput =
                document.getElementById(
                    "addPrice",
                );
            const capacityInput =
                document.getElementById(
                    "addCapacity",
                );

            if (!category || !details) return;

            const value = category.value;

            if (!value) {
                details.classList.add("hidden");
                hint?.classList.remove(
                    "hidden",
                );
                return;
            }

            details.classList.remove("hidden");
            hint?.classList.add("hidden");

            // Semua kategori memiliki harga.
            priceField.classList.remove(
                "hidden",
            );
            priceInput.required = true;

            // Semua kategori memiliki informasi kapasitas/minimal pemesanan.
            const capacityLabel = document.getElementById("addCapacityLabel");

            capacityField.classList.remove("hidden");
            capacityInput.required = true;

            if (value === "package_menu") {
                capacityLabel.textContent = "Kapasitas";
                capacityInput.placeholder = "Contoh: 1 Orang";
            } else {
                capacityLabel.textContent = "Minimal Pemesanan";
                capacityInput.placeholder = "Contoh: 100 Package";
            }
        }

        function resetAddPackageFields() {
            const fileInput =
                document.getElementById(
                    "addImageFile",
                );
            const urlInput =
                document.getElementById(
                    "addImageUrl",
                );
            const titleInput =
                document.querySelector(
                    '#addModal input[name="title"]',
                );
            const priceInput =
                document.getElementById(
                    "addPrice",
                );
            const capacityInput =
                document.getElementById(
                    "addCapacity",
                );
            const descriptionInput =
                document.querySelector(
                    '#addModal textarea[name="description"]',
                );
            const image =
                document.getElementById(
                    "addPreviewImage",
                );
            const text =
                document.getElementById(
                    "addPreviewText",
                );

            if (fileInput) {
                fileInput.value = "";
                fileInput.disabled = false;
            }
            if (urlInput) {
                urlInput.value = "";
                urlInput.disabled = false;
            }
            if (titleInput)
                titleInput.value = "";
            if (priceInput)
                priceInput.value = "";
            if (capacityInput)
                capacityInput.value = "";
            if (descriptionInput)
                descriptionInput.value = "";
            if (image) image.src = "";
            image?.classList.add("hidden");
            text?.classList.remove("hidden");
        }

        function updateEditFields() {
            const category =
                document.getElementById(
                    "updateCategory",
                );
            const priceField =
                document.getElementById(
                    "updatePriceField",
                );
            const capacityField =
                document.getElementById(
                    "updateCapacityField",
                );
            const priceInput =
                document.getElementById(
                    "updatePrice",
                );
            const capacityInput =
                document.getElementById(
                    "updateCapacity",
                );

            if (!category) return;

            const value = category.value;

            // Semua kategori memiliki harga.
            priceField.classList.remove(
                "hidden",
            );
            priceInput.required = true;

            // Semua kategori memiliki informasi kapasitas/minimal pemesanan.
            const capacityLabel = document.getElementById("updateCapacityLabel");

            capacityField.classList.remove("hidden");
            capacityInput.required = true;

            if (value === "package_menu") {
                capacityLabel.textContent = "Kapasitas";
                capacityInput.placeholder = "Contoh: 1 Orang";
            } else {
                capacityLabel.textContent = "Minimal Pemesanan";
                capacityInput.placeholder = "Contoh: 100 Package";
            }
        }

        /* =====================================================
                   ADD MODAL
                ====================================================== */

        function openAddModal() {
            const modal =
                document.getElementById(
                    "addModal",
                );
            const category =
                document.getElementById(
                    "addCategory",
                );
            const details =
                document.getElementById(
                    "addPackageDetails",
                );
            const hint =
                document.getElementById(
                    "addCategoryHint",
                );

            if (category) category.value = "";
            if (details)
                details.classList.add("hidden");
            if (hint)
                hint.classList.remove("hidden");

            resetAddPackageFields();

            modal.classList.remove("hidden");
            modal.classList.add("flex");
            lucide.createIcons();
        }

        function closeAddModal() {
            const modal =
                document.getElementById(
                    "addModal",
                );

            modal.classList.add("hidden");

            modal.classList.remove("flex");
        }

        /* =====================================================
                   ADD FILE
                ====================================================== */

        function handleAddFile() {
            const fileInput =
                document.getElementById(
                    "addImageFile",
                );
            const urlInput =
                document.getElementById(
                    "addImageUrl",
                );
            const message =
                document.getElementById(
                    "addImageMessage",
                );
            const sizeMessage =
                document.getElementById(
                    "addImageSizeMessage",
                );
            const image =
                document.getElementById(
                    "addPreviewImage",
                );
            const text =
                document.getElementById(
                    "addPreviewText",
                );

            const file = fileInput.files[0];

            if (!file) {
                return;
            }

            // Maksimal 1 MB.
            if (file.size > 1024 * 1024) {
                fileInput.value = "";
                urlInput.disabled = false;

                sizeMessage.classList.remove(
                    "hidden",
                );
                message.classList.add("hidden");

                image.src = "";
                image.classList.add("hidden");
                text.classList.remove("hidden");

                return;
            }

            sizeMessage.classList.add("hidden");

            // File dipilih -> URL dikosongkan.
            urlInput.value = "";
            urlInput.disabled = true;
            message.classList.add("hidden");

            const reader = new FileReader();

            reader.onload = function(event) {
                image.src = event.target.result;
                image.classList.remove(
                    "hidden",
                );
                text.classList.add("hidden");
            };

            reader.readAsDataURL(file);
        }

        function handleAddUrl() {
            const fileInput =
                document.getElementById(
                    "addImageFile",
                );

            const urlInput =
                document.getElementById(
                    "addImageUrl",
                );

            const message =
                document.getElementById(
                    "addImageMessage",
                );

            const image =
                document.getElementById(
                    "addPreviewImage",
                );

            const text =
                document.getElementById(
                    "addPreviewText",
                );

            const url = urlInput.value.trim();

            if (!url) {
                fileInput.disabled = false;

                message.classList.add("hidden");

                image.classList.add("hidden");

                text.classList.remove("hidden");

                image.src = "";

                return;
            }

            // URL dipilih → file dikosongkan
            fileInput.value = "";

            fileInput.disabled = true;

            message.classList.add("hidden");

            image.onload = function() {
                image.classList.remove(
                    "hidden",
                );

                text.classList.add("hidden");
            };

            image.onerror = function() {
                image.classList.add("hidden");

                text.classList.remove("hidden");
            };

            image.src = url;
        }

        /* =====================================================
                   UPDATE MODAL
                ====================================================== */

        function openUpdateModal(packageData) {
            const modal =
                document.getElementById(
                    "updateModal",
                );

            const form =
                document.getElementById(
                    "updateForm",
                );

            const imageFile =
                document.getElementById(
                    "updateImageFile",
                );

            const imageUrl =
                document.getElementById(
                    "updateImageUrl",
                );

            const previewImage =
                document.getElementById(
                    "updatePreviewImage",
                );

            const previewText =
                document.getElementById(
                    "updatePreviewText",
                );

            form.action = `/dashboard/service-packages/${packageData.id}`;

            document.getElementById(
                "updateTitle",
            ).value = packageData.title ?? "";

            document.getElementById(
                    "updateDescription",
                ).value =
                packageData.description ?? "";

            document.getElementById(
                "updatePrice",
            ).value = packageData.price ?? "";

            document.getElementById(
                    "updateCapacity",
                ).value =
                packageData.capacity ?? "";

            document.getElementById(
                    "updateCategory",
                ).value =
                packageData.category ??
                "package_menu";

            document.getElementById(
                    "updateActive",
                ).value = packageData.is_active ?
                "1" :
                "0";

            document.getElementById(
                    "updateSort",
                ).value =
                packageData.sort_order ?? 0;

            updateEditFields();

            imageFile.value = "";

            imageFile.disabled = false;

            imageUrl.value = "";

            imageUrl.disabled = false;

            /*
                    |------------------------------------------------------
                    | GAMBAR LAMA
                    |------------------------------------------------------
                    */

            if (packageData.image_path) {
                const imagePath =
                    packageData.image_path;

                if (
                    imagePath.startsWith(
                        "http://",
                    ) ||
                    imagePath.startsWith(
                        "https://",
                    )
                ) {
                    // Gambar dari URL
                    imageUrl.value = imagePath;
                    previewImage.src =
                        imagePath;
                } else if (
                    imagePath.startsWith(
                        "storage/",
                    )
                ) {
                    // Data lama yang sudah menyimpan "storage/"
                    previewImage.src = `/${imagePath}`;
                } else {
                    // Data baru: service-packages/namafile.jpg
                    previewImage.src = `/storage/${imagePath}`;
                }

                previewImage.classList.remove(
                    "hidden",
                );
                previewText.classList.add(
                    "hidden",
                );
            } else {
                previewImage.src = "";

                previewImage.classList.add(
                    "hidden",
                );

                previewText.classList.remove(
                    "hidden",
                );
            }

            modal.classList.remove("hidden");

            modal.classList.add("flex");

            lucide.createIcons();
        }

        function closeUpdateModal() {
            const modal =
                document.getElementById(
                    "updateModal",
                );

            modal.classList.add("hidden");

            modal.classList.remove("flex");
        }

        /* =====================================================
                   UPDATE FILE
                ====================================================== */

        function handleUpdateFile() {
            const fileInput =
                document.getElementById(
                    "updateImageFile",
                );
            const imageUrl =
                document.getElementById(
                    "updateImageUrl",
                );
            const image =
                document.getElementById(
                    "updatePreviewImage",
                );
            const text =
                document.getElementById(
                    "updatePreviewText",
                );
            const sizeMessage =
                document.getElementById(
                    "updateImageSizeMessage",
                );

            const file = fileInput.files[0];

            if (!file) {
                return;
            }

            // Maksimal 1 MB.
            if (file.size > 1024 * 1024) {
                fileInput.value = "";
                imageUrl.disabled = false;

                sizeMessage.classList.remove(
                    "hidden",
                );

                return;
            }

            sizeMessage.classList.add("hidden");

            // File baru dipilih -> URL dikosongkan.
            imageUrl.value = "";
            imageUrl.disabled = true;

            const reader = new FileReader();

            reader.onload = function(event) {
                image.src = event.target.result;
                image.classList.remove(
                    "hidden",
                );
                text.classList.add("hidden");
            };

            reader.readAsDataURL(file);
        }

        function handleUpdateUrl() {
            const fileInput =
                document.getElementById(
                    "updateImageFile",
                );

            const urlInput =
                document.getElementById(
                    "updateImageUrl",
                );

            const image =
                document.getElementById(
                    "updatePreviewImage",
                );

            const text =
                document.getElementById(
                    "updatePreviewText",
                );

            const url = urlInput.value.trim();

            if (!url) {
                fileInput.disabled = false;

                return;
            }

            fileInput.value = "";

            fileInput.disabled = true;

            image.onload = function() {
                image.classList.remove(
                    "hidden",
                );

                text.classList.add("hidden");
            };

            image.onerror = function() {
                image.classList.add("hidden");

                text.classList.remove("hidden");
            };

            image.src = url;
        }
    </script>

</body>

</html>
