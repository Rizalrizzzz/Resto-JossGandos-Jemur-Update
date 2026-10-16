<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuPreview;
use App\Models\MenuSetting;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN ADMIN MENU
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        // Ambil semua menu
        $menus = Menu::latest()->get();

        // Ambil pengaturan halaman menu
        // Karena menu_settings hanya memiliki 1 record,
        // kita gunakan first()
        $menuSetting = MenuSetting::first();

        return view('menu-admin', compact(
            'menus',
            'menuSetting'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE PENGATURAN HALAMAN MENU
    |--------------------------------------------------------------------------
    */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'hero_badge' => 'nullable|string|max:100',
            'hero_title' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string',
            'hero_image' => 'nullable|url|max:2048',

            // JUDUL SECTION MENU
            'promo_title' => 'nullable|string|max:255',
            'recommended_title' => 'nullable|string|max:255',
            'menu_title' => 'nullable|string|max:255',

            // PAKET & LAYANAN
            'package_title' => 'nullable|string|max:255',
            'package_description' => 'nullable|string',

            // PACKAGE MENU
            'package_menu_icon_url' => 'nullable|url|max:2048',
            'package_menu_icon_file' => 'nullable|mimes:jpg,jpeg,png,webp,svg|max:1024',
            'package_menu_title' => 'nullable|string|max:255',
            'package_menu_description' => 'nullable|string',

            // BOX PACKAGE
            'box_package_icon_url' => 'nullable|url|max:2048',
            'box_package_icon_file' => 'nullable|mimes:jpg,jpeg,png,webp,svg|max:1024',
            'box_package_title' => 'nullable|string|max:255',
            'box_package_description' => 'nullable|string',

            // WEDDING PACKAGE
            'wedding_package_icon_url' => 'nullable|url|max:2048',
            'wedding_package_icon_file' => 'nullable|mimes:jpg,jpeg,png,webp,svg|max:1024',
            'wedding_package_title' => 'nullable|string|max:255',
            'wedding_package_description' => 'nullable|string',

            // CTA MENU LENGKAP
            'cta_image' => 'nullable|url|max:2048',
            'cta_badge' => 'nullable|string|max:100',
            'cta_title' => 'nullable|string|max:255',
            'cta_description' => 'nullable|string',
            'cta_link' => 'nullable|url|max:2048',
        ]);

        // Ambil data settings yang sudah ada
        $menuSetting = MenuSetting::first();

        // Jika belum ada, buat record baru
        if (! $menuSetting) {
            $menuSetting = new MenuSetting;
        }

        $oldIconValues = [
            $menuSetting->package_menu_icon,
            $menuSetting->box_package_icon,
            $menuSetting->wedding_package_icon,
        ];

        /*
        |--------------------------------------------------------------------------
        | FIELD TEKS
        |--------------------------------------------------------------------------
        */
        $fields = [
            // HERO
            'hero_badge',
            'hero_title',
            'hero_description',
            'hero_image',

            // JUDUL SECTION MENU
            'promo_title',
            'recommended_title',
            'menu_title',

            // PAKET & LAYANAN
            'package_title',
            'package_description',

            // PACKAGE MENU
            'package_menu_title',
            'package_menu_description',

            // BOX PACKAGE
            'box_package_title',
            'box_package_description',

            // WEDDING PACKAGE
            'wedding_package_title',
            'wedding_package_description',

            
            // CTA MENU LENGKAP
            'cta_image',
            'cta_badge',
            'cta_title',
            'cta_description',
            'cta_link',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                $menuSetting->$field = $request->input($field);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | PACKAGE MENU ICON
        |--------------------------------------------------------------------------
        */

        // Jika upload ikon baru
        if ($request->hasFile('package_menu_icon_file')) {

            $path = $request->file('package_menu_icon_file')
                ->store('menu-icons', 'public');

            $menuSetting->package_menu_icon = $path;

            // Jika tidak upload file tetapi menggunakan URL
        } elseif ($request->filled('package_menu_icon_url')) {

            $menuSetting->package_menu_icon =
                $request->input('package_menu_icon_url');
        }

        /*
        |--------------------------------------------------------------------------
        | BOX PACKAGE ICON
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('box_package_icon_file')) {

            $path = $request->file('box_package_icon_file')
                ->store('menu-icons', 'public');

            $menuSetting->box_package_icon = $path;

        } elseif ($request->filled('box_package_icon_url')) {

            $menuSetting->box_package_icon =
                $request->input('box_package_icon_url');
        }

        /*
        |--------------------------------------------------------------------------
        | WEDDING PACKAGE ICON
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('wedding_package_icon_file')) {

            $path = $request->file('wedding_package_icon_file')
                ->store('menu-icons', 'public');

           $menuSetting->wedding_package_icon = $path;

        } elseif ($request->filled('wedding_package_icon_url')) {

            $menuSetting->wedding_package_icon =
                $request->input('wedding_package_icon_url');
        }

        // Simpan perubahan
        $menuSetting->save();

        // Hapus file ikon lokal lama yang sudah tidak dipakai
$currentIconValues = [
    $menuSetting->package_menu_icon,
    $menuSetting->box_package_icon,
    $menuSetting->wedding_package_icon,
];

foreach ($oldIconValues as $oldIcon) {
    if (
        empty($oldIcon) ||
        \Illuminate\Support\Str::startsWith($oldIcon, ['http://', 'https://'])
    ) {
        continue;
    }

    $oldPath = ltrim(
        preg_replace('#^/?storage/#', '', $oldIcon),
        '/'
    );

    // Hanya proses file ikon di folder menu-icons
    if (!\Illuminate\Support\Str::startsWith($oldPath, 'menu-icons/')) {
        continue;
    }

    $stillUsed = false;

    foreach ($currentIconValues as $currentIcon) {
        if (empty($currentIcon)) {
            continue;
        }

        $currentPath = ltrim(
            preg_replace('#^/?storage/#', '', $currentIcon),
            '/'
        );

        if ($currentPath === $oldPath) {
            $stillUsed = true;
            break;
        }
    }

    if (!$stillUsed) {
        Storage::disk('public')->delete($oldPath);
    }
}

        return back()->with(
            'success',
            'Pengaturan halaman Menu berhasil diperbarui.'
        );



    }

    /*
    |--------------------------------------------------------------------------
    | HALAMAN PUBLIC MENU
    |--------------------------------------------------------------------------
    */
    public function publicIndex()
    {
        // Pengaturan halaman Menu
        $menuSetting = MenuSetting::first();

        // Menu rekomendasi untuk carousel
        $carouselMenus = Menu::where('is_recommended', true)
            ->orderBy('created_at', 'asc')
            ->get();

        // Menu rekomendasi
        $specialMenus = Menu::where('is_recommended', true)
            ->orderBy('created_at', 'asc')
            ->get();

        // Menu berdasarkan kategori
        $menus = Menu::orderBy('created_at', 'asc')
            ->get()
            ->groupBy('category');

        // Promosi yang tampil di Menu
        $now = now('Asia/Jakarta');

        $promotions = Promotion::where('is_active', true)
            ->where(function ($query) use ($now) {

                // Promosi biasa: langsung tampil jika Aktif
                $query->where('is_home_popup', false)

                    // Promosi Home: tampil di Menu mulai dari jadwal tayang
                    ->orWhere(function ($query) use ($now) {
                        $query->where('is_home_popup', true)
                            ->whereNotNull('home_start_at')
                            ->where('home_start_at', '<=', $now);
                    });

            })
            ->orderBy('sort_order', 'asc')
            ->orderByDesc('created_at')
            ->get();

        $menuPreviews = MenuPreview::where('is_active', true)
        ->orderBy('sort_order', 'asc')
        ->orderBy('id', 'asc')
        ->get();

        return view('menu', compact(
            'carouselMenus',
            'specialMenus',
            'menus',
            'promotions',
            'menuSetting',
            'menuPreviews'
        ));

    }

    /*
    |--------------------------------------------------------------------------
    | TAMBAH MENU
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'category' => 'required|in:makanan,minuman,snack',
            'is_recommended' => 'nullable|boolean',

            // Upload maksimal 1 MB
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',

            // Atau gunakan URL
            'image_path' => 'nullable|url|max:2048',
        ], [
            'image_file.max' => 'Ukuran file lebih dari 1 MB. Harap kompres gambar terlebih dahulu hingga maksimal 1 MB.',
        ]);

        // Wajib memilih upload file atau URL
        if (! $request->hasFile('image_file') && ! $request->filled('image_path')) {
            return back()
                ->withErrors([
                    'image_file' => 'Silakan upload foto atau masukkan URL foto.',
                ])
                ->withInput();
        }

        // Tentukan sumber gambar
        if ($request->hasFile('image_file')) {

            $path = $request->file('image_file')
                ->store('menus', 'public');

            $imagePath = $path;

        } else {

            $imagePath = $request->image_path;
        }

        Menu::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'image_path' => $imagePath,
            'type' => 'special',
            'category' => $request->category,
            'is_recommended' => $request->boolean('is_recommended'),
        ]);

        return back()->with(
            'success',
            'Menu berhasil ditambahkan.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE MENU
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
{
    $menu = Menu::findOrFail($id);

    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'nullable|numeric|min:0',
        'category' => 'required|in:makanan,minuman,snack',
        'is_recommended' => 'nullable|boolean',

        // Upload maksimal 1 MB
        'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',

        // Atau gunakan URL
        'image_path' => 'nullable|url|max:2048',
    ], [
        'image_file.max' => 'Ukuran file lebih dari 1 MB. Harap kompres gambar terlebih dahulu hingga maksimal 1 MB.',
    ]);

    // Simpan path foto lama
    $oldImagePath = $menu->image_path;

    // Foto lama tetap digunakan jika tidak memilih foto baru
    $imagePath = $oldImagePath;

    // Jika upload foto baru
    if ($request->hasFile('image_file')) {
        $imagePath = $request->file('image_file')
            ->store('menus', 'public');

    // Jika menggunakan URL foto baru
    } elseif ($request->filled('image_path')) {
        $imagePath = trim($request->input('image_path'));
    }

    // Perbarui data menu terlebih dahulu
    $menu->update([
        'title' => $request->title,
        'description' => $request->description,
        'price' => $request->price,
        'image_path' => $imagePath,
        'category' => $request->category,
        'is_recommended' => $request->boolean('is_recommended'),
    ]);

    // Rapikan path agar format "storage/menus/..." dan
    // "menus/..." bisa dikenali sebagai file yang sama.
    $normalizeLocalPath = function ($path) {
        $path = trim((string) $path);

        // Jangan perlakukan URL sebagai file lokal
        if (
            $path === '' ||
            preg_match('#^https?://#i', $path)
        ) {
            return null;
        }

        $path = preg_replace('#^/?storage/#i', '', $path);

        return ltrim($path, '/');
    };

    $oldLocalPath = $normalizeLocalPath($oldImagePath);
    $newLocalPath = $normalizeLocalPath($imagePath);

    // Hapus foto lama hanya jika path berubah
    // dan file lama berada di folder menus.
    if (
        $oldLocalPath &&
        $oldLocalPath !== $newLocalPath &&
        str_starts_with($oldLocalPath, 'menus/')
    ) {
        // Periksa apakah foto lama masih dipakai menu lain
        $stillUsed = Menu::where('id', '!=', $menu->id)
            ->get(['image_path'])
            ->contains(function ($otherMenu) use (
                $oldLocalPath,
                $normalizeLocalPath
            ) {
                return $normalizeLocalPath(
                    $otherMenu->image_path
                ) === $oldLocalPath;
            });

        // Hapus hanya jika tidak dipakai menu lain
        if (! $stillUsed) {
            Storage::disk('public')->delete($oldLocalPath);
        }
    }

    return back()->with(
        'success',
        'Menu berhasil diperbarui.'
    );
}

    /*
    |--------------------------------------------------------------------------
    | HAPUS MENU
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
{
    $menu = Menu::findOrFail($id);

    // Simpan path foto sebelum data dihapus
    $oldImagePath = $menu->image_path;

    // Hapus data menu terlebih dahulu
    $deleted = $menu->delete();

    // Hanya lanjut jika penghapusan data berhasil
    if ($deleted && $oldImagePath) {

        // Rapikan path foto lokal
        $normalizeLocalPath = function ($path) {
            $path = trim((string) $path);

            // Jangan hapus URL dari CDN
            if (
                $path === '' ||
                preg_match('#^https?://#i', $path)
            ) {
                return null;
            }

            $path = preg_replace(
                '#^/?storage/#i',
                '',
                $path
            );

            return ltrim($path, '/');
        };

        $oldLocalPath = $normalizeLocalPath($oldImagePath);

        // Hanya izinkan penghapusan di folder menus
        if (
            $oldLocalPath &&
            str_starts_with($oldLocalPath, 'menus/') &&
            ! str_contains($oldLocalPath, '..')
        ) {
            // Periksa apakah foto masih digunakan menu lain
            $stillUsed = Menu::get(['image_path'])
                ->contains(function ($otherMenu) use (
                    $normalizeLocalPath,
                    $oldLocalPath
                ) {
                    return $normalizeLocalPath(
                        $otherMenu->image_path
                    ) === $oldLocalPath;
                });

            // Hapus foto jika sudah tidak dipakai
            if (! $stillUsed) {
                Storage::disk('public')->delete($oldLocalPath);
            }
        }
    }

    return back()->with(
        'success',
        'Menu berhasil dihapus.'
    );
}
}
