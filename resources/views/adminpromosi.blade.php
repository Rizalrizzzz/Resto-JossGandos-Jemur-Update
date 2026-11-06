<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Kelola Promosi</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logojossgandos.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css" />

    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        .poster-preview {
            aspect-ratio: 3 / 4;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 overflow-hidden">
    <div class="flex h-screen overflow-hidden">
        {{-- ================= SIDEBAR ================= --}}
        @include ('layouts.sidebar')

        {{-- ================= CONTENT ================= --}}
        <main class="flex-1 min-w-0 min-h-0 overflow-y-auto bg-slate-50 relative">
            {{-- ================= HEADER ================= --}}
            <header
                class="sticky top-0 flex-shrink-0 bg-white border-b border-slate-200 shadow-sm z-20 px-6 py-4 flex items-center justify-between gap-4">
                <div class="flex items-center gap-4 flex-1">
                    <button type="button" onclick="toggleSidebar()"
                        class="md:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-lg">
                        <i class="uil uil-bars text-2xl"></i>
                    </button>

                    <div>
                        <h1 class="text-xl font-bold text-slate-800 tracking-tight">
                            Kelola Promosi
                        </h1>
                    </div>
                </div>

                <button type="button" onclick="openAddModal()"
                    class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg hover:shadow-xl transition-all">
                    <i class="uil uil-plus-circle text-lg"></i>

                    <span>Tambah Promosi</span>
                </button>
            </header>

            {{-- ================= SUCCESS MESSAGE ================= --}}
            @if (session('success'))
                <div id="successMessage" class="px-4 md:px-6 pt-4">
                    <div
                        class="flex items-center justify-between gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-4 py-3 text-sm">
                        <div class="flex items-center gap-2">
                            <i class="uil uil-check-circle text-lg"></i>

                            <span> {{ session('success') }} </span>
                        </div>

                        <button type="button" onclick="closeSuccessMessage()"
                            class="text-emerald-600 hover:text-emerald-800">
                            <i class="uil uil-times text-lg"></i>
                        </button>
                    </div>
                </div>
            @endif

            {{-- ================= ERROR MESSAGE ================= --}}
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

            {{-- ================= TABLE ================= --}}
            <div class="px-4 md:px-6 pt-5 pb-8">
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                    <div class="overflow-x-auto md:overflow-x-hidden">
                        <table class="w-full table-fixed">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th class="w-20 px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">
                                        No
                                    </th>

                                    <th class="w-48 px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">
                                        Poster
                                    </th>

                                    <th
                                        class="w-32 px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">
                                        Status Menu
                                    </th>

                                    <th
                                        class="w-24 px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">
                                        Home
                                    </th>

                                    <th
                                        class="w-56 px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">
                                        Jadwal Home
                                    </th>

                                    <th
                                        class="w-24 px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">
                                        Urutan
                                    </th>

                                    <th
                                        class="w-28 px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @forelse ($promotions as $promotion)
                                    @php
                                        // Gambar promosi hanya menggunakan file yang tersimpan di storage.
                                        $imageUrl = asset('storage/' . $promotion->image_path);
                                    @endphp

                                    <tr class="hover:bg-slate-50 transition">
                                        {{-- NO --}}
                                        <td class="px-6 py-4 text-sm text-slate-500">
                                            {{ $loop->iteration }}
                                        </td>

                                        {{-- POSTER --}}
                                        <td class="px-6 py-4">
                                            <div
                                                class="w-20 poster-preview rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                                                <img src="{{ $imageUrl }}" alt="Poster Promosi"
                                                    class="w-full h-full object-cover"
                                                    onerror="
                                                        this.style.display =
                                                            'none';
                                                        this.parentElement.innerHTML =
                                                            '<div class=&quot;w-full h-full flex items-center justify-center text-slate-400 text-xs text-center px-2&quot;>Gambar tidak tersedia</div>';
                                                    " />
                                            </div>
                                        </td>

                                        {{-- STATUS --}}
                                        @php
                                            $now = now('Asia/Jakarta');

                                            $statusIsActive = $promotion->is_active;

                                            $statusStart = $promotion->home_start_at
                                                ? \Carbon\Carbon::parse(
                                                    $promotion->getRawOriginal('home_start_at'),
                                                    'Asia/Jakarta',
                                                )
                                                : null;

                                            if ($promotion->is_home_popup && $statusStart) {
                                                if ($now->lt($statusStart)) {
                                                    $statusIsActive = false;
                                                } else {
                                                    $statusIsActive = true;
                                                }
                                            }
                                        @endphp

                                        <td class="px-6 py-4 text-center">
                                            @if ($statusIsActive)
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

                                        {{-- HOME --}}
                                        @php
                                            $now = now('Asia/Jakarta');

                                            $homeStart = $promotion->home_start_at
                                                ? \Carbon\Carbon::parse(
                                                    $promotion->getRawOriginal('home_start_at'),
                                                    'Asia/Jakarta',
                                                )
                                                : null;

                                            $homeEnd = $promotion->home_end_at
                                                ? \Carbon\Carbon::parse(
                                                    $promotion->getRawOriginal('home_end_at'),
                                                    'Asia/Jakarta',
                                                )
                                                : null;

                                            $homeIsActive =
                                                $promotion->is_home_popup &&
                                                $homeStart &&
                                                $homeEnd &&
                                                $now->betweenIncluded($homeStart, $homeEnd);
                                        @endphp

                                        <td class="px-6 py-4 text-center">
                                            @if ($homeIsActive)
                                                <span
                                                    class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-600">
                                                    ON
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-500">
                                                    OFF
                                                </span>
                                            @endif
                                        </td>

                                        {{-- JADWAL HOME --}}
                                        <td class="px-6 py-4 text-center text-xs text-slate-600">
                                            @if ($promotion->is_home_popup && $promotion->home_start_at && $promotion->home_end_at)
                                                <div class="font-medium text-slate-700">
                                                    {{ $promotion->home_start_at->format('d/m/Y H:i') }}
                                                </div>

                                                <div class="text-slate-400 my-0.5">
                                                    sampai
                                                </div>

                                                <div class="font-medium text-slate-700">
                                                    {{ $promotion->home_end_at->format('d/m/Y H:i') }}
                                                </div>
                                            @else
                                                <span class="text-slate-400">
                                                    -
                                                </span>
                                            @endif
                                        </td>

                                        {{-- URUTAN --}}
                                        <td class="px-6 py-4 text-center text-sm font-medium text-slate-700">
                                            {{ $promotion->sort_order }}
                                        </td>

                                        {{-- AKSI --}}
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                {{-- EDIT --}}
                                                <button type="button"
                                                    onclick='openUpdateModal(@json($promotion))'
                                                    title="Edit Promosi"
                                                    class="w-9 h-9 flex items-center justify-center rounded-lg text-blue-600 hover:bg-blue-50 transition">
                                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                                </button>

                                                {{-- HAPUS --}}
                                                <form action="{{ route('admin.promotions.destroy', $promotion->id) }}"
                                                    method="POST"
                                                    onsubmit="
                                                        return confirm(
                                                            'Yakin ingin menghapus promosi ini?',
                                                        );
                                                    ">
                                                    @csrf

                                                    @method ('DELETE')

                                                    <button type="submit" title="Hapus Promosi"
                                                        class="w-9 h-9 flex items-center justify-center rounded-lg text-red-600 hover:bg-red-50 transition">
                                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="7" class="px-6 py-16 text-center text-slate-400">
                                            <i data-lucide="megaphone" class="w-10 h-10 mx-auto mb-3"></i>

                                            <div class="text-sm">
                                                Belum ada promosi.
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
        <div class="bg-white w-full max-w-lg max-h-[90vh] rounded-2xl shadow-xl overflow-y-auto">
            {{-- HEADER --}}
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">
                        Tambah Promosi
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">Tambahkan poster promosi baru.</p>
                </div>

                <button type="button" onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- FORM --}}
            <form action="{{ route('admin.promotions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="p-6 space-y-5">
                    {{-- GAMBAR --}}
                    <div>
                        <p class="block text-sm font-medium mb-2">
                            Gambar Promo
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-[180px_1fr] gap-5">
                            {{-- PREVIEW --}}
                            <div
                                class="w-[180px] aspect-[3/4] mx-auto sm:mx-0 rounded-xl overflow-hidden border border-slate-200 bg-slate-50 flex items-center justify-center">
                                <span id="addPreviewText" class="text-xs text-slate-400 text-center px-4">
                                    Preview
                                    Poster
                                </span>

                                <img id="addPreviewImage" src="" alt="Preview Poster"
                                    class="hidden w-full h-full object-cover" />
                            </div>

                            {{-- UPLOAD GAMBAR --}}
                            <div>
                                <label for="addImageFile" class="block text-sm font-medium mb-2">
                                    Upload Foto (JPG/PNG/WebP, maks 2MB)
                                </label>

                                <input type="file" name="image_file" id="addImageFile"
                                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" required
                                    onchange="handleAddFile()"
                                    class="block w-full text-sm text-slate-500 border border-slate-200 rounded-xl cursor-pointer bg-white file:mr-3 file:py-2.5 file:px-3 file:border-0 file:bg-slate-100 file:text-slate-700 file:font-medium" />

                                <p id="addFileSizeMessage" class="hidden mt-2 text-xs text-red-500 font-medium"></p>
                                <p class="text-xs text-slate-400 mt-2">
                                    Pilih foto maksimal 2 MB. Preview berubah setelah file dipilih.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- IKLAN HOME --}}
                    <div class="border border-slate-200 rounded-2xl p-4 bg-slate-50">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold text-slate-700">Tampilkan sebagai Iklan Home</p>

                                <p class="text-xs text-slate-400 mt-1">Promosi akan muncul sebagai popup di halaman
                                    Home sesuai jadwal yang ditentukan.</p>
                            </div>

                            <label class="relative inline-flex items-center cursor-pointer shrink-0">
                                <input type="hidden" name="is_home_popup" value="0" />

                                <input type="checkbox" id="addHomePopup" name="is_home_popup" value="1"
                                    class="sr-only peer" />

                                <div
                                    class="w-12 h-6 bg-slate-200 rounded-full peer-checked:bg-indigo-600 transition-colors duration-200 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-6">
                                </div>
                            </label>
                        </div>

                        {{-- JADWAL --}}
                        <div id="addHomeSchedule" class="hidden grid grid-cols-1 sm:grid-cols-2 gap-4 mt-5">
                            <div>
                                <label for="addHomeStart" class="block text-sm font-medium mb-2">
                                    Mulai Tayang
                                </label>

                                <input type="datetime-local" name="home_start_at" id="addHomeStart"
                                    class="w-full h-11 px-4 border border-slate-200 rounded-xl bg-white outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                            </div>

                            <div>
                                <label for="addHomeEnd" class="block text-sm font-medium mb-2">
                                    Selesai
                                    Tayang
                                </label>

                                <input type="datetime-local" name="home_end_at" id="addHomeEnd"
                                    class="w-full h-11 px-4 border border-slate-200 rounded-xl bg-white outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                            </div>
                        </div>
                    </div>

                    {{-- STATUS + URUTAN --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="addActive" class="block text-sm font-medium mb-2">
                                Status Menu
                            </label>

                            <select id="addActive" name="is_active"
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
                            <label for="addSort" class="block text-sm font-medium mb-2">
                                Urutan
                            </label>

                            <input type="number" id="addSort" name="sort_order" value="0" min="0"
                                class="w-full h-11 px-4 border border-slate-200 rounded-xl" />
                        </div>
                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="flex justify-end gap-3 px-6 py-5 border-t border-slate-100">
                    <button type="button"
                        onclick="
                                                            closeAddModal()
                                                        "
                        class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold">
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
        <div class="bg-white w-full max-w-lg max-h-[90vh] rounded-2xl shadow-xl overflow-y-auto">
            {{-- HEADER --}}
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">
                        Update Promosi
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">Perbarui poster promosi.</p>
                </div>

                <button type="button" onclick="closeUpdateModal()" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- FORM --}}
            <form id="updateForm" method="POST" enctype="multipart/form-data">
                @csrf

                @method ('PUT')

                <div class="p-6 space-y-5">
                    {{-- GAMBAR --}}
                    <div>
                        <p class="block text-sm font-medium mb-2">
                            Gambar Promo
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-[180px_1fr] gap-5">
                            {{-- PREVIEW --}}
                            <div
                                class="w-[180px] aspect-[3/4] mx-auto sm:mx-0 rounded-xl overflow-hidden border border-slate-200 bg-slate-50 flex items-center justify-center">
                                <span id="updatePreviewText" class="hidden text-xs text-slate-400 text-center px-4">
                                    Preview
                                    Poster
                                </span>

                                <img id="updatePreviewImage" src="" alt="Preview Poster"
                                    class="w-full h-full object-cover" />
                            </div>

                            {{-- UPLOAD GAMBAR --}}
                            <div>
                                <label for="updateImageFile" class="block text-sm font-medium mb-2">
                                    Upload Foto (JPG/PNG/WebP, maks 2MB)
                                </label>

                                <input type="file" name="image_file" id="updateImageFile"
                                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                    onchange="handleUpdateFile()"
                                    class="block w-full text-sm text-slate-500 border border-slate-200 rounded-xl cursor-pointer bg-white file:mr-3 file:py-2.5 file:px-3 file:border-0 file:bg-slate-100 file:text-slate-700 file:font-medium" />

                                <p id="updateFileSizeMessage" class="hidden mt-2 text-xs text-red-500 font-medium">
                                </p>
                                <p class="text-xs text-slate-400 mt-2">
                                    Pilih foto maksimal 2 MB. Preview berubah setelah file dipilih.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- IKLAN HOME --}}
                    <div class="border border-slate-200 rounded-2xl p-4 bg-slate-50">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold text-slate-700">Tampilkan sebagai Iklan Home</p>

                                <p class="text-xs text-slate-400 mt-1">Promosi akan muncul sebagai popup di halaman
                                    Home sesuai jadwal yang ditentukan.</p>
                            </div>

                            <label class="relative inline-flex items-center cursor-pointer shrink-0">
                                <input type="hidden" name="is_home_popup" value="0" />

                                <input type="checkbox" id="updateHomePopup" name="is_home_popup" value="1"
                                    class="sr-only peer" />

                                <div
                                    class="w-12 h-6 bg-slate-200 rounded-full peer-checked:bg-indigo-600 transition-colors duration-200 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-6">
                                </div>
                            </label>
                        </div>

                        {{-- JADWAL --}}
                        <div id="updateHomeSchedule" class="hidden grid grid-cols-1 sm:grid-cols-2 gap-4 mt-5">
                            <div>
                                <label for="updateHomeStart" class="block text-sm font-medium mb-2">
                                    Mulai Tayang
                                </label>

                                <input type="datetime-local" name="home_start_at" id="updateHomeStart"
                                    class="w-full h-11 px-4 border border-slate-200 rounded-xl bg-white outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                            </div>

                            <div>
                                <label for="updateHomeEnd" class="block text-sm font-medium mb-2">
                                    Selesai
                                    Tayang
                                </label>

                                <input type="datetime-local" name="home_end_at" id="updateHomeEnd"
                                    class="w-full h-11 px-4 border border-slate-200 rounded-xl bg-white outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                            </div>
                        </div>
                    </div>

                    {{-- STATUS + URUTAN --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="updateActive" class="block text-sm font-medium mb-2">
                                Status Menu
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

                            <p id="updateStatusMenuInfo" class="hidden mt-2 text-xs text-amber-600">
                                *Harap matikan tombol Home terlebih dahulu untuk mengubah Status Promosi Menu.
                            </p>
                        </div>

                        <div>
                            <label for="updateSort" class="block text-sm font-medium mb-2">
                                Urutan
                            </label>

                            <input type="number" id="updateSort" name="sort_order" value="0" min="0"
                                class="w-full h-11 px-4 border border-slate-200 rounded-xl" />
                        </div>
                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="flex justify-end gap-3 px-6 py-5 border-t border-slate-100">
                    <button type="button"
                        onclick="
                                                            closeUpdateModal()
                                                        "
                        class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold">
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
               TAMBAH MODAL
            ====================================================== */

        function openAddModal() {
            const modal =
                document.getElementById(
                    "addModal",
                );

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
               TAMBAH - FILE
            ====================================================== */

        function handleAddFile() {
            const fileInput = document.getElementById("addImageFile");
            const message = document.getElementById("addFileSizeMessage");
            const image = document.getElementById("addPreviewImage");
            const text = document.getElementById("addPreviewText");
            const file = fileInput.files[0];

            if (!file) return;

            message.classList.add("hidden");

            if (file.size > 2 * 1024 * 1024) {
                fileInput.value = "";
                image.src = "";
                image.classList.add("hidden");
                text.classList.remove("hidden");
                message.textContent = "Ukuran foto lebih dari 2 MB. Pilih foto maksimal 2 MB.";
                message.classList.remove("hidden");
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                image.src = event.target.result;
                image.classList.remove("hidden");
                text.classList.add("hidden");
            };
            reader.readAsDataURL(file);
        }

        /* =====================================================
               IKLAN HOME - TAMBAH
            ====================================================== */

        const addHomePopup =
            document.getElementById(
                "addHomePopup",
            );

        const addHomeSchedule =
            document.getElementById(
                "addHomeSchedule",
            );

        const addActive =
            document.getElementById(
                "addActive",
            );

        if (
            addHomePopup &&
            addHomeSchedule &&
            addActive
        ) {
            addHomePopup.addEventListener(
                "change",
                function() {
                    addHomeSchedule.classList.toggle(
                        "hidden",
                        !this.checked,
                    );

                    if (this.checked) {
                        addActive.value = "1";
                        addActive.disabled = true;
                    } else {
                        addActive.disabled = false;
                    }
                },
            );
        }

        /* =====================================================
               UPDATE MODAL
            ====================================================== */

        function openUpdateModal(promotion) {
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

            const previewImage =
                document.getElementById(
                    "updatePreviewImage",
                );

            const previewText =
                document.getElementById(
                    "updatePreviewText",
                );

            const updateActive =
                document.getElementById(
                    "updateActive",
                );

            const updateSort =
                document.getElementById(
                    "updateSort",
                );

            const updateHomePopup =
                document.getElementById(
                    "updateHomePopup",
                );

            const updateHomeSchedule =
                document.getElementById(
                    "updateHomeSchedule",
                );

            const updateHomeStart =
                document.getElementById(
                    "updateHomeStart",
                );

            const updateHomeEnd =
                document.getElementById(
                    "updateHomeEnd",
                );

            /* ACTION FORM */
            form.action = `/dashboard/promotions/${promotion.id}`;

            /* STATUS */
            updateActive.value =
                promotion.is_active ? "1" : "0";

            /* URUTAN */
            updateSort.value =
                promotion.sort_order ?? 0;

            /* IKLAN HOME */
            updateHomePopup.checked =
                promotion.is_home_popup == 1;

            updateHomeSchedule.classList.toggle(
                "hidden",
                !updateHomePopup.checked,
            );

            /* MULAI TAYANG */
            if (promotion.home_start_at) {
                updateHomeStart.value =
                    promotion.home_start_at.substring(
                        0,
                        16,
                    );
            } else {
                updateHomeStart.value = "";
            }

            /* SELESAI TAYANG */
            if (promotion.home_end_at) {
                updateHomeEnd.value =
                    promotion.home_end_at.substring(
                        0,
                        16,
                    );
            } else {
                updateHomeEnd.value = "";
            }
            updateStatusByHomeSchedule();

            /* RESET FILE */
            imageFile.value = "";

            /* GAMBAR LAMA: hanya path file lokal di storage */
            if (promotion.image_path) {
                previewImage.src = `/storage/${promotion.image_path}`;

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

            /* INPUT GAMBAR */
            imageFile.disabled = false;

            /* BUKA MODAL */
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
               IKLAN HOME - UPDATE
            ====================================================== */

        const updateHomePopup =
            document.getElementById(
                "updateHomePopup",
            );

        const updateHomeSchedule =
            document.getElementById(
                "updateHomeSchedule",
            );

        const updateActive =
            document.getElementById(
                "updateActive",
            );

        const updateStatusMenuInfo =
            document.getElementById(
                "updateStatusMenuInfo",
            );

        const updateHomeStart =
            document.getElementById(
                "updateHomeStart",
            );

        const updateHomeEnd =
            document.getElementById(
                "updateHomeEnd",
            );

        function updateStatusByHomeSchedule() {
            if (
                !updateHomePopup ||
                !updateActive
            ) {
                return;
            }

            updateHomeSchedule.classList.toggle(
                "hidden",
                !updateHomePopup.checked,
            );

            if (!updateHomePopup.checked) {
                updateActive.disabled = false;
                updateStatusMenuInfo.classList.add("hidden");
                return;
            }

            if (
                !updateHomeStart.value ||
                !updateHomeEnd.value
            ) {
                updateActive.disabled = false;
                updateStatusMenuInfo.classList.remove("hidden");
                return;
            }

            updateStatusMenuInfo.classList.remove("hidden");

            const now = new Date();
            const start = new Date(
                updateHomeStart.value,
            );

            if (now < start) {
                updateActive.value = "0";
                updateActive.disabled = true;
            } else {
                updateActive.disabled = false;
            }
        }

        if (updateHomePopup) {
            updateHomePopup.addEventListener(
                "change",
                updateStatusByHomeSchedule,
            );
        }

        if (updateHomeStart) {
            updateHomeStart.addEventListener(
                "change",
                updateStatusByHomeSchedule,
            );
        }

        if (updateHomeEnd) {
            updateHomeEnd.addEventListener(
                "change",
                updateStatusByHomeSchedule,
            );
        }

        /* =====================================================
               UPDATE - FILE
            ====================================================== */

        function handleUpdateFile() {
            const fileInput = document.getElementById("updateImageFile");
            const message = document.getElementById("updateFileSizeMessage");
            const image = document.getElementById("updatePreviewImage");
            const text = document.getElementById("updatePreviewText");
            const file = fileInput.files[0];

            if (!file) return;

            message.classList.add("hidden");

            if (file.size > 2 * 1024 * 1024) {
                fileInput.value = "";
                message.textContent = "Ukuran foto lebih dari 2 MB. Pilih foto maksimal 2 MB.";
                message.classList.remove("hidden");
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                image.src = event.target.result;
                image.classList.remove("hidden");
                text.classList.add("hidden");
            };
            reader.readAsDataURL(file);
        }
    </script>

</body>

</html>
