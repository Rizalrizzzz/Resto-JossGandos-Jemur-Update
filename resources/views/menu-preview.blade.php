<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Kelola Preview Menu</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logojossgandos.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css" />

    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        .menu-preview-image {
            aspect-ratio: 3 / 4;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 overflow-hidden">

    <div class="flex h-screen overflow-hidden">

        {{-- ================= SIDEBAR ================= --}}
        @include('layouts.sidebar')


        {{-- ================= CONTENT ================= --}}
        <main class="flex-1 min-w-0 min-h-0 overflow-y-auto bg-slate-50 relative">

            {{-- ================= HEADER ================= --}}
            <header
                class="sticky top-0 flex-shrink-0 bg-white border-b border-slate-200 shadow-sm z-20 px-6 py-4 flex items-center justify-between gap-4">

                <div class="flex items-center gap-4 flex-1">

                    {{-- MOBILE MENU --}}
                    <button type="button" onclick="toggleSidebar()"
                        class="md:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-lg">
                        <i class="uil uil-bars text-2xl"></i>
                    </button>


                    <div>
                        <h1 class="text-xl font-bold text-slate-800 tracking-tight">
                            Kelola Preview Menu
                        </h1>
                    </div>

                </div>


                {{-- TOMBOL TAMBAH --}}
                <button type="button" onclick="openAddModal()"
                    class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg hover:shadow-xl transition-all">
                    <i class="uil uil-plus-circle text-lg"></i>

                    <span>Tambah Preview</span>
                </button>

            </header>


            {{-- ================= SUCCESS MESSAGE ================= --}}
            @if (session('success'))
                <div id="successMessage" class="px-4 md:px-6 pt-4">

                    <div
                        class="flex items-center justify-between gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-4 py-3 text-sm">

                        <div class="flex items-center gap-2">

                            <i class="uil uil-check-circle text-lg"></i>

                            <span>
                                {{ session('success') }}
                            </span>

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
                                <li>
                                    {{ $error }}
                                </li>
                            @endforeach

                        </ul>

                    </div>

                </div>

            @endif


            {{-- ================= TABLE ================= --}}
            <div class="px-4 md:px-6 pt-5 pb-8">

                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">

                    <div class="overflow-x-auto">

                        <table class="w-full table-fixed">

                            <thead class="bg-slate-50 border-b border-slate-200">

                                <tr>

                                    <th class="w-20 px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">
                                        No
                                    </th>


                                    <th class="w-64 px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">
                                        Preview
                                    </th>


                                    <th
                                        class="w-32 px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">
                                        Status
                                    </th>


                                    <th
                                        class="w-28 px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">
                                        Urutan
                                    </th>


                                    <th
                                        class="w-32 px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">
                                        Aksi
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-slate-100">

                                @forelse ($menuPreviews as $preview)
                                    @php

                                        $imageUrl = \Illuminate\Support\Str::startsWith($preview->image_path, [
                                            'http://',
                                            'https://',
                                        ])
                                            ? $preview->image_path
                                            : asset('storage/' . $preview->image_path);

                                    @endphp


                                    <tr class="hover:bg-slate-50 transition">

                                        {{-- NO --}}
                                        <td class="px-6 py-4 text-sm text-slate-500">

                                            {{ $loop->iteration }}

                                        </td>


                                        {{-- PREVIEW --}}
                                        <td class="px-6 py-4">

                                            <div
                                                class="w-24 menu-preview-image rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                                                <img src="{{ $imageUrl }}" alt="Preview Menu"
                                                    class="w-full h-full object-cover"
                                                    onerror="
                                                    this.style.display = 'none';
                                                    this.parentElement.innerHTML =
                                                    '<div class=&quot;w-full h-full flex items-center justify-center text-slate-400 text-xs text-center px-2&quot;>Gambar tidak tersedia</div>';
                                                " />
                                            </div>

                                        </td>


                                        {{-- STATUS --}}
                                        <td class="px-6 py-4 text-center">

                                            @if ($preview->is_active)
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
                                        <td class="px-6 py-4 text-center text-sm font-medium text-slate-700">

                                            {{ $preview->sort_order }}

                                        </td>


                                        {{-- AKSI --}}
                                        <td class="px-6 py-4">

                                            <div class="flex items-center justify-center gap-2">

                                                {{-- EDIT --}}
                                                <button type="button"
                                                    onclick='openUpdateModal(@json($preview))'
                                                    title="Edit Preview"
                                                    class="w-9 h-9 flex items-center justify-center rounded-lg text-blue-600 hover:bg-blue-50 transition">
                                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                                </button>


                                                {{-- HAPUS --}}
                                                <form action="{{ route('menu-preview.destroy', $preview->id) }}"
                                                    method="POST"
                                                    onsubmit="
                                                        return confirm(
                                                            'Yakin ingin menghapus preview menu ini?'
                                                        );
                                                    ">

                                                    @csrf

                                                    @method('DELETE')

                                                    <button type="submit" title="Hapus Preview"
                                                        class="w-9 h-9 flex items-center justify-center rounded-lg text-red-600 hover:bg-red-50 transition">
                                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="5" class="px-6 py-16 text-center text-slate-400">

                                            <i data-lucide="images" class="w-10 h-10 mx-auto mb-3"></i>

                                            <div class="text-sm">
                                                Belum ada preview menu.
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
                        Tambah Preview Menu
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Tambahkan gambar halaman Menu Lengkap.
                    </p>

                </div>


                <button type="button" onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>

            </div>


            {{-- FORM --}}
            <form action="{{ route('menu-preview.store') }}" method="POST" enctype="multipart/form-data">

                @csrf


                <div class="p-6 space-y-5">

                    {{-- GAMBAR --}}
                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Gambar Preview
                        </label>


                        <div class="grid grid-cols-1 sm:grid-cols-[180px_1fr] gap-5">

                            {{-- PREVIEW --}}
                            <div
                                class="w-[180px] menu-preview-image mx-auto sm:mx-0 rounded-xl overflow-hidden border border-slate-200 bg-slate-50 flex items-center justify-center">

                                <span id="addPreviewText" class="text-xs text-slate-400 text-center px-4">
                                    Preview<br />
                                    Gambar Menu
                                </span>


                                <img id="addPreviewImage" src="" alt="Preview Gambar"
                                    class="hidden w-full h-full object-cover" />

                            </div>


                            {{-- SUMBER GAMBAR --}}
                            <div class="space-y-4">

                                {{-- UPLOAD --}}
                                <div>

                                    <label class="block text-sm font-medium mb-2">
                                        Upload Foto
                                    </label>


                                    <input type="file" name="image_file" id="addImageFile"
                                        accept="image/jpeg,image/png,image/webp" onchange="handleAddFile()"
                                        class="block w-full text-sm text-slate-500 border border-slate-200 rounded-xl cursor-pointer bg-white file:mr-3 file:py-2.5 file:px-3 file:border-0 file:bg-slate-100 file:text-slate-700 file:font-medium" />


                                    {{-- PESAN 1 MB --}}
                                    <p id="addFileSizeMessage" class="hidden mt-2 text-xs text-red-500 font-medium">
                                    </p>

                                </div>


                                {{-- URL --}}
                                <div>

                                    <label class="block text-sm font-medium mb-2">
                                        Atau Gunakan URL
                                    </label>


                                    <input type="url" name="image_url" id="addImageUrl" oninput="handleAddUrl()"
                                        placeholder="https://contoh.com/menu.jpg"
                                        class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />


                                    <p id="addImageMessage" class="hidden mt-2 text-xs text-red-500">
                                        Link gambar tidak dapat dimuat.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- STATUS + URUTAN --}}
                    <div class="grid grid-cols-2 gap-4">

                        {{-- STATUS --}}
                        <div>

                            <label class="block text-sm font-medium mb-2">
                                Status
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


                        {{-- URUTAN --}}
                        <div>

                            <label class="block text-sm font-medium mb-2">
                                Urutan
                            </label>


                            <input type="number" name="sort_order"
                                value="{{ ($menuPreviews->max('sort_order') ?? 0) + 1 }}" min="1"
                                class="w-full h-11 px-4 border border-slate-200 rounded-xl" />

                        </div>

                    </div>

                </div>


                {{-- FOOTER --}}
                <div class="flex justify-end gap-3 px-6 py-5 border-t border-slate-100">

                    <button type="button" onclick="closeAddModal()"
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
                        Update Preview Menu
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Perbarui gambar halaman menu.
                    </p>

                </div>


                <button type="button" onclick="closeUpdateModal()" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>

            </div>


            {{-- FORM --}}
            <form id="updateForm" method="POST" enctype="multipart/form-data">

                @csrf

                @method('PUT')


                <div class="p-6 space-y-5">

                    {{-- GAMBAR --}}
                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Gambar Preview
                        </label>


                        <div class="grid grid-cols-1 sm:grid-cols-[180px_1fr] gap-5">

                            {{-- PREVIEW --}}
                            <div
                                class="w-[180px] menu-preview-image mx-auto sm:mx-0 rounded-xl overflow-hidden border border-slate-200 bg-slate-50 flex items-center justify-center">

                                <span id="updatePreviewText" class="hidden text-xs text-slate-400 text-center px-4">
                                    Preview<br />
                                    Gambar Menu
                                </span>


                                <img id="updatePreviewImage" src="" alt="Preview Gambar"
                                    class="hidden w-full h-full object-cover" />

                            </div>


                            {{-- SUMBER --}}
                            <div class="space-y-4">

                                {{-- FILE --}}
                                <div>

                                    <label class="block text-sm font-medium mb-2">
                                        Ganti Upload Foto
                                    </label>


                                    <input type="file" name="image_file" id="updateImageFile"
                                        accept="image/jpeg,image/png,image/webp" onchange="handleUpdateFile()"
                                        class="block w-full text-sm text-slate-500 border border-slate-200 rounded-xl cursor-pointer bg-white file:mr-3 file:py-2.5 file:px-3 file:border-0 file:bg-slate-100 file:text-slate-700 file:font-medium" />


                                    {{-- PESAN 1 MB --}}
                                    <p id="updateFileSizeMessage"
                                        class="hidden mt-2 text-xs text-red-500 font-medium"></p>

                                </div>


                                {{-- URL --}}
                                <div>

                                    <label class="block text-sm font-medium mb-2">
                                        Atau Gunakan URL
                                    </label>


                                    <input type="url" name="image_url" id="updateImageUrl"
                                        oninput="handleUpdateUrl()" placeholder="https://contoh.com/menu.jpg"
                                        class="w-full h-11 px-4 border border-slate-200 rounded-xl outline-none text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />


                                    <p id="updateImageMessage" class="hidden mt-2 text-xs text-red-500">
                                        Link gambar tidak dapat dimuat.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- STATUS + URUTAN --}}
                    <div class="grid grid-cols-2 gap-4">

                        {{-- STATUS --}}
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


                        {{-- URUTAN --}}
                        <div>

                            <label class="block text-sm font-medium mb-2">
                                Urutan
                            </label>


                            <input type="number" id="updateSort" name="sort_order" value="1" min="1"
                                class="w-full h-11 px-4 border border-slate-200 rounded-xl" />

                        </div>

                    </div>

                </div>


                {{-- FOOTER --}}
                <div class="flex justify-end gap-3 px-6 py-5 border-t border-slate-100">

                    <button type="button" onclick="closeUpdateModal()"
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
                document.getElementById("successMessage");

            if (message) {
                message.remove();
            }

        }


        setTimeout(() => {
            closeSuccessMessage();
        }, 3000);


        /* =====================================================
           SIDEBAR
        ====================================================== */

        function toggleSidebar() {

            const sidebar =
                document.getElementById("sidebar");

            const overlay =
                document.getElementById("sidebar-overlay");

            if (!sidebar) {
                return;
            }


            if (
                sidebar.classList.contains(
                    "-translate-x-full"
                )
            ) {

                sidebar.classList.remove(
                    "-translate-x-full"
                );


                if (overlay) {

                    overlay.classList.remove(
                        "hidden"
                    );

                }

            } else {

                closeSidebar();

            }

        }


        function closeSidebar() {

            const sidebar =
                document.getElementById("sidebar");

            const overlay =
                document.getElementById("sidebar-overlay");

            if (!sidebar) {
                return;
            }


            sidebar.classList.add(
                "-translate-x-full"
            );


            if (overlay) {

                overlay.classList.add(
                    "hidden"
                );

            }

        }


        /* =====================================================
           TAMBAH MODAL
        ====================================================== */

        function openAddModal() {

            const modal =
                document.getElementById("addModal");

            if (!modal) {
                return;
            }


            modal.classList.remove("hidden");

            modal.classList.add("flex");


            lucide.createIcons();

        }


        function closeAddModal() {

            const modal =
                document.getElementById("addModal");

            if (!modal) {
                return;
            }


            modal.classList.add("hidden");

            modal.classList.remove("flex");

        }


        /* =====================================================
           TAMBAH - FILE
        ====================================================== */

        function handleAddFile() {

            const fileInput =
                document.getElementById(
                    "addImageFile"
                );

            const urlInput =
                document.getElementById(
                    "addImageUrl"
                );

            const image =
                document.getElementById(
                    "addPreviewImage"
                );

            const text =
                document.getElementById(
                    "addPreviewText"
                );

            const message =
                document.getElementById(
                    "addFileSizeMessage"
                );

            const urlMessage =
                document.getElementById(
                    "addImageMessage"
                );


            const file =
                fileInput.files[0];


            if (!file) {
                return;
            }


            urlInput.value = "";

            message.classList.add("hidden");

            urlMessage.classList.add("hidden");


            /* CEK 1 MB */

            if (file.size > 1024 * 1024) {

                fileInput.value = "";

                image.src = "";

                image.classList.add("hidden");

                text.classList.remove("hidden");


                message.textContent =
                    "Ukuran foto lebih dari 1 MB. Maksimal ukuran foto adalah 1 MB.";

                message.classList.remove("hidden");

                return;

            }


            const reader =
                new FileReader();


            reader.onload =
                function(event) {

                    image.src =
                        event.target.result;

                    image.classList.remove(
                        "hidden"
                    );

                    text.classList.add(
                        "hidden"
                    );

                };


            reader.readAsDataURL(file);

        }


        /* =====================================================
           TAMBAH - URL
        ====================================================== */

        function handleAddUrl() {

            const fileInput =
                document.getElementById(
                    "addImageFile"
                );

            const urlInput =
                document.getElementById(
                    "addImageUrl"
                );

            const image =
                document.getElementById(
                    "addPreviewImage"
                );

            const text =
                document.getElementById(
                    "addPreviewText"
                );

            const message =
                document.getElementById(
                    "addImageMessage"
                );


            const url =
                urlInput.value.trim();


            if (!url) {

                message.classList.add(
                    "hidden"
                );

                image.classList.add(
                    "hidden"
                );

                text.classList.remove(
                    "hidden"
                );

                image.src = "";

                return;

            }


            fileInput.value = "";

            message.classList.add(
                "hidden"
            );


            image.onload =
                function() {

                    image.classList.remove(
                        "hidden"
                    );

                    text.classList.add(
                        "hidden"
                    );

                    message.classList.add(
                        "hidden"
                    );

                };


            image.onerror =
                function() {

                    image.classList.add(
                        "hidden"
                    );

                    text.classList.remove(
                        "hidden"
                    );

                    message.textContent =
                        "Link gambar tidak dapat dimuat.";

                    message.classList.remove(
                        "hidden"
                    );

                };


            image.src = url;

        }


        /* =====================================================
           UPDATE MODAL
        ====================================================== */

        function openUpdateModal(preview) {

            const modal =
                document.getElementById(
                    "updateModal"
                );

            const form =
                document.getElementById(
                    "updateForm"
                );

            const imageFile =
                document.getElementById(
                    "updateImageFile"
                );

            const imageUrl =
                document.getElementById(
                    "updateImageUrl"
                );

            const previewImage =
                document.getElementById(
                    "updatePreviewImage"
                );

            const previewText =
                document.getElementById(
                    "updatePreviewText"
                );

            const updateActive =
                document.getElementById(
                    "updateActive"
                );

            const updateSort =
                document.getElementById(
                    "updateSort"
                );


            if (
                !modal ||
                !form ||
                !preview
            ) {
                return;
            }


            /* ACTION FORM */

            form.action =
                `/dashboard/menu-preview/${preview.id}`;


            /* STATUS */

            updateActive.value =
                preview.is_active ? "1" : "0";


            /* URUTAN */

            updateSort.value =
                preview.sort_order ?? 1;


            /* RESET */

            imageFile.value = "";

            imageUrl.value = "";

            document
                .getElementById(
                    "updateFileSizeMessage"
                )
                .classList.add("hidden");

            document
                .getElementById(
                    "updateImageMessage"
                )
                .classList.add("hidden");


            /* GAMBAR LAMA */

            if (preview.image_path) {

                if (
                    preview.image_path.startsWith(
                        "http://"
                    ) ||
                    preview.image_path.startsWith(
                        "https://"
                    )
                ) {

                    imageUrl.value =
                        preview.image_path;

                    previewImage.src =
                        preview.image_path;

                } else {

                    previewImage.src =
                        `/storage/${preview.image_path}`;

                }


                previewImage.classList.remove(
                    "hidden"
                );

                previewText.classList.add(
                    "hidden"
                );

            } else {

                previewImage.src = "";

                previewImage.classList.add(
                    "hidden"
                );

                previewText.classList.remove(
                    "hidden"
                );

            }


            /* BUKA MODAL */

            modal.classList.remove(
                "hidden"
            );

            modal.classList.add(
                "flex"
            );


            lucide.createIcons();

        }


        function closeUpdateModal() {

            const modal =
                document.getElementById(
                    "updateModal"
                );

            if (!modal) {
                return;
            }


            modal.classList.add(
                "hidden"
            );

            modal.classList.remove(
                "flex"
            );

        }


        /* =====================================================
           UPDATE - FILE
        ====================================================== */

        function handleUpdateFile() {

            const fileInput =
                document.getElementById(
                    "updateImageFile"
                );

            const urlInput =
                document.getElementById(
                    "updateImageUrl"
                );

            const image =
                document.getElementById(
                    "updatePreviewImage"
                );

            const text =
                document.getElementById(
                    "updatePreviewText"
                );

            const message =
                document.getElementById(
                    "updateFileSizeMessage"
                );

            const urlMessage =
                document.getElementById(
                    "updateImageMessage"
                );


            const file =
                fileInput.files[0];


            if (!file) {
                return;
            }


            urlInput.value = "";

            urlMessage.classList.add(
                "hidden"
            );

            message.classList.add(
                "hidden"
            );


            /* CEK 1 MB */

            if (file.size > 1024 * 1024) {

                fileInput.value = "";

                image.classList.add(
                    "hidden"
                );

                text.classList.remove(
                    "hidden"
                );


                message.textContent =
                    "Ukuran foto lebih dari 1 MB. Maksimal ukuran foto adalah 1 MB.";

                message.classList.remove(
                    "hidden"
                );

                return;

            }


            const reader =
                new FileReader();


            reader.onload =
                function(event) {

                    image.src =
                        event.target.result;

                    image.classList.remove(
                        "hidden"
                    );

                    text.classList.add(
                        "hidden"
                    );

                };


            reader.readAsDataURL(file);

        }


        /* =====================================================
           UPDATE - URL
        ====================================================== */

        function handleUpdateUrl() {

            const fileInput =
                document.getElementById(
                    "updateImageFile"
                );

            const urlInput =
                document.getElementById(
                    "updateImageUrl"
                );

            const image =
                document.getElementById(
                    "updatePreviewImage"
                );

            const text =
                document.getElementById(
                    "updatePreviewText"
                );

            const message =
                document.getElementById(
                    "updateImageMessage"
                );


            const url =
                urlInput.value.trim();


            if (!url) {
                return;
            }


            fileInput.value = "";

            message.classList.add(
                "hidden"
            );


            image.onload =
                function() {

                    image.classList.remove(
                        "hidden"
                    );

                    text.classList.add(
                        "hidden"
                    );

                    message.classList.add(
                        "hidden"
                    );

                };


            image.onerror =
                function() {

                    image.classList.add(
                        "hidden"
                    );

                    text.classList.remove(
                        "hidden"
                    );


                    message.textContent =
                        "Link gambar tidak dapat dimuat.";

                    message.classList.remove(
                        "hidden"
                    );

                };


            image.src = url;

        }


        /* =====================================================
           KLIK LUAR MODAL
        ====================================================== */

        document.addEventListener(
            "click",
            function(event) {

                const addModal =
                    document.getElementById(
                        "addModal"
                    );

                const updateModal =
                    document.getElementById(
                        "updateModal"
                    );


                if (
                    addModal &&
                    event.target === addModal
                ) {
                    closeAddModal();
                }


                if (
                    updateModal &&
                    event.target === updateModal
                ) {
                    closeUpdateModal();
                }

            }
        );
    </script>

</body>

</html>
