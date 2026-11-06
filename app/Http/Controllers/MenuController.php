<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuPreview;
use App\Models\MenuSetting;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    /**
     * Halaman admin menu.
     */
    public function index()
    {
        $menus = Menu::latest()->get();
        $menuSetting = MenuSetting::first();

        return view('menu-admin', compact('menus', 'menuSetting'));
    }

    /**
     * Update pengaturan halaman Menu.
     * Form pengaturan dibuat terpisah, jadi hanya field yang dikirim yang diubah.
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            // Hero: upload file, bukan URL gambar
            'hero_badge' => 'nullable|string|max:100',
            'hero_title' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string',
            'hero_image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            // Judul section menu
            'promo_title' => 'nullable|string|max:255',
            'recommended_title' => 'nullable|string|max:255',
            'menu_title' => 'nullable|string|max:255',

            // Paket & layanan
            'package_title' => 'nullable|string|max:255',
            'package_description' => 'nullable|string',

            // Ikon paket: upload file saja
            'package_menu_icon_file' => 'nullable|mimes:jpg,jpeg,png,webp,svg|max:1024',
            'package_menu_title' => 'nullable|string|max:255',
            'package_menu_description' => 'nullable|string',

            'box_package_icon_file' => 'nullable|mimes:jpg,jpeg,png,webp,svg|max:1024',
            'box_package_title' => 'nullable|string|max:255',
            'box_package_description' => 'nullable|string',

            'wedding_package_icon_file' => 'nullable|mimes:jpg,jpeg,png,webp,svg|max:1024',
            'wedding_package_title' => 'nullable|string|max:255',
            'wedding_package_description' => 'nullable|string',

            // Menu Lengkap: foto upload, link Google Drive tetap berupa URL
            'cta_image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'cta_badge' => 'nullable|string|max:100',
            'cta_title' => 'nullable|string|max:255',
            'cta_description' => 'nullable|string',
            'cta_link' => 'nullable|url|max:2048',
        ], [
            'hero_image_file.image' => 'File Hero harus berupa gambar.',
            'hero_image_file.mimes' => 'Foto Hero harus JPG, JPEG, PNG, atau WebP.',
            'hero_image_file.max' => 'Ukuran foto Hero maksimal 2 MB.',
            'cta_image_file.image' => 'File Menu Lengkap harus berupa gambar.',
            'cta_image_file.mimes' => 'Foto Menu Lengkap harus JPG, JPEG, PNG, atau WebP.',
            'cta_image_file.max' => 'Ukuran foto Menu Lengkap maksimal 2 MB.',
        ]);

        $menuSetting = MenuSetting::first();

        if (! $menuSetting) {
            $menuSetting = new MenuSetting();
        }

        // Simpan nilai gambar lama untuk dibersihkan setelah data baru tersimpan.
        $oldImageValues = [
            $menuSetting->hero_image,
            $menuSetting->cta_image,
        ];

        $oldIconValues = [
            $menuSetting->package_menu_icon,
            $menuSetting->box_package_icon,
            $menuSetting->wedding_package_icon,
        ];

        // Field teks. Gambar tidak dimasukkan ke daftar ini karena sekarang memakai upload.
        $fields = [
            'hero_badge',
            'hero_title',
            'hero_description',

            'promo_title',
            'recommended_title',
            'menu_title',

            'package_title',
            'package_description',

            'package_menu_title',
            'package_menu_description',

            'box_package_title',
            'box_package_description',

            'wedding_package_title',
            'wedding_package_description',

            'cta_badge',
            'cta_title',
            'cta_description',
            'cta_link',
        ];

        foreach ($fields as $field) {
            if ($request->exists($field)) {
                $menuSetting->$field = $request->input($field);
            }
        }

        // Upload gambar Hero Section. Jika tidak memilih file baru, gambar lama tetap dipakai.
        if ($request->hasFile('hero_image_file')) {
            $menuSetting->hero_image = $request->file('hero_image_file')
                ->store('menu-images', 'public');
        }

        // Upload gambar Menu Lengkap. Jika tidak memilih file baru, gambar lama tetap dipakai.
        if ($request->hasFile('cta_image_file')) {
            $menuSetting->cta_image = $request->file('cta_image_file')
                ->store('menu-images', 'public');
        }

        // Upload ikon Package Menu.
        if ($request->hasFile('package_menu_icon_file')) {
            $menuSetting->package_menu_icon = $request->file('package_menu_icon_file')
                ->store('menu-icons', 'public');
        }

        // Upload ikon Box Package.
        if ($request->hasFile('box_package_icon_file')) {
            $menuSetting->box_package_icon = $request->file('box_package_icon_file')
                ->store('menu-icons', 'public');
        }

        // Upload ikon Wedding Package.
        if ($request->hasFile('wedding_package_icon_file')) {
            $menuSetting->wedding_package_icon = $request->file('wedding_package_icon_file')
                ->store('menu-icons', 'public');
        }

        $menuSetting->save();

        // Hapus gambar lama yang sudah tidak digunakan, hanya jika berasal dari menu-images.
        $currentImageValues = [
            $menuSetting->hero_image,
            $menuSetting->cta_image,
        ];

        $normalizeLocalPath = static function ($path) {
            $path = trim((string) $path);

            if ($path === '' || preg_match('#^https?://#i', $path)) {
                return null;
            }

            return ltrim(preg_replace('#^/?storage/#i', '', $path), '/');
        };

        foreach ($oldImageValues as $oldImage) {
            $oldPath = $normalizeLocalPath($oldImage);

            if (! $oldPath || ! Str::startsWith($oldPath, 'menu-images/')) {
                continue;
            }

            $stillUsed = false;

            foreach ($currentImageValues as $currentImage) {
                if ($normalizeLocalPath($currentImage) === $oldPath) {
                    $stillUsed = true;
                    break;
                }
            }

            if (! $stillUsed) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        // Hapus ikon lama yang tidak digunakan, hanya dari folder menu-icons.
        $currentIconValues = [
            $menuSetting->package_menu_icon,
            $menuSetting->box_package_icon,
            $menuSetting->wedding_package_icon,
        ];

        foreach ($oldIconValues as $oldIcon) {
            $oldPath = $normalizeLocalPath($oldIcon);

            if (! $oldPath || ! Str::startsWith($oldPath, 'menu-icons/')) {
                continue;
            }

            $stillUsed = false;

            foreach ($currentIconValues as $currentIcon) {
                if ($normalizeLocalPath($currentIcon) === $oldPath) {
                    $stillUsed = true;
                    break;
                }
            }

            if (! $stillUsed) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        return back()->with('success', 'Pengaturan halaman Menu berhasil diperbarui.');
    }

    /**
     * Halaman publik Menu.
     */
    public function publicIndex()
    {
        $menuSetting = MenuSetting::first();

        $carouselMenus = Menu::where('is_recommended', true)
            ->orderBy('created_at', 'asc')
            ->get();

        $specialMenus = Menu::where('is_recommended', true)
            ->orderBy('created_at', 'asc')
            ->get();

        $menus = Menu::orderBy('created_at', 'asc')
            ->get()
            ->groupBy('category');

        $now = now('Asia/Jakarta');

        $promotions = Promotion::where('is_active', true)
            ->where(function ($query) use ($now) {
                $query->where('is_home_popup', false)
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

    /**
     * Tambah menu menggunakan upload foto.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|in:makanan,minuman,snack',
            'is_recommended' => 'nullable|boolean',
            'image_file' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'image_file.required' => 'Silakan pilih foto menu.',
            'image_file.image' => 'File harus berupa gambar.',
            'image_file.mimes' => 'Foto menu harus JPG, JPEG, PNG, atau WebP.',
            'image_file.max' => 'Ukuran foto menu maksimal 2 MB.',
        ]);

        $imagePath = $request->file('image_file')->store('menus', 'public');

        Menu::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'image_path' => $imagePath,
            'type' => 'special',
            'category' => $request->category,
            'is_recommended' => $request->boolean('is_recommended'),
        ]);

        return back()->with('success', 'Menu berhasil ditambahkan.');
    }

    /**
     * Update menu. Foto lama tetap digunakan jika tidak upload foto baru.
     */
    public function update(Request $request, int $id)
    {
        $menu = Menu::findOrFail($id);
        $oldImagePath = $menu->image_path;
        $normalizedOldImagePath = ltrim(
            preg_replace('#^/?storage/#i', '', trim((string) $oldImagePath)),
            '/'
        );
        $oldImageIsLocal =
            !str_contains($normalizedOldImagePath, '..') &&
            Str::startsWith($normalizedOldImagePath, 'menus/');

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|in:makanan,minuman,snack',
            'is_recommended' => 'nullable|boolean',
            // Jika gambar lama bukan path lokal yang valid, wajib unggah gambar pengganti.
            'image_file' => ($oldImageIsLocal ? 'nullable' : 'required') . '|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'image_file.required' => 'Silakan pilih foto menu dari perangkat.',
            'image_file.image' => 'File harus berupa gambar.',
            'image_file.mimes' => 'Foto menu harus JPG, JPEG, PNG, atau WebP.',
            'image_file.max' => 'Ukuran foto menu maksimal 2 MB.',
        ]);

        $imagePath = $oldImageIsLocal ? $oldImagePath : null;

        if ($request->hasFile('image_file')) {
            $imagePath = $request->file('image_file')->store('menus', 'public');
        }

        $menu->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'image_path' => $imagePath,
            'category' => $request->category,
            'is_recommended' => $request->boolean('is_recommended'),
        ]);

        $normalizeLocalPath = static function ($path) {
            $path = trim((string) $path);

            if ($path === '' || preg_match('#^https?://#i', $path)) {
                return null;
            }

            return ltrim(preg_replace('#^/?storage/#i', '', $path), '/');
        };

        $oldLocalPath = $normalizeLocalPath($oldImagePath);
        $newLocalPath = $normalizeLocalPath($imagePath);

        if (
            $oldLocalPath &&
            $oldLocalPath !== $newLocalPath &&
            Str::startsWith($oldLocalPath, 'menus/')
        ) {
            $stillUsed = Menu::where('id', '!=', $menu->id)
                ->get(['image_path'])
                ->contains(function ($otherMenu) use ($oldLocalPath, $normalizeLocalPath) {
                    return $normalizeLocalPath($otherMenu->image_path) === $oldLocalPath;
                });

            if (! $stillUsed) {
                Storage::disk('public')->delete($oldLocalPath);
            }
        }

        return back()->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Hapus menu beserta foto lokalnya jika sudah tidak dipakai.
     */
    public function destroy(int $id)
    {
        $menu = Menu::findOrFail($id);
        $oldImagePath = $menu->image_path;

        $deleted = $menu->delete();

        if ($deleted && $oldImagePath) {
            $normalizeLocalPath = static function ($path) {
                $path = trim((string) $path);

                if ($path === '' || preg_match('#^https?://#i', $path)) {
                    return null;
                }

                return ltrim(preg_replace('#^/?storage/#i', '', $path), '/');
            };

            $oldLocalPath = $normalizeLocalPath($oldImagePath);

            if (
                $oldLocalPath &&
                Str::startsWith($oldLocalPath, 'menus/') &&
                ! Str::contains($oldLocalPath, '..')
            ) {
                $stillUsed = Menu::get(['image_path'])
                    ->contains(function ($otherMenu) use ($normalizeLocalPath, $oldLocalPath) {
                        return $normalizeLocalPath($otherMenu->image_path) === $oldLocalPath;
                    });

                if (! $stillUsed) {
                    Storage::disk('public')->delete($oldLocalPath);
                }
            }
        }

        return back()->with('success', 'Menu berhasil dihapus.');
    }
}
