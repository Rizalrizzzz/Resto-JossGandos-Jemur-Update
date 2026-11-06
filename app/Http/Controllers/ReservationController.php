<?php

namespace App\Http\Controllers;

use App\Models\ReservationArea;
use App\Models\ReservationSetting;
use App\Models\ReservationStep;
use App\Models\ReservationTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReservationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN ADMIN RESERVATION
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $setting = ReservationSetting::first();

        $steps = ReservationStep::orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $terms = ReservationTerm::orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $areas = ReservationArea::orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('reservation-admin', compact(
            'setting',
            'steps',
            'terms',
            'areas'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | HALAMAN PUBLIC RESERVATION
    |--------------------------------------------------------------------------
    */

    public function publicIndex()
    {
        $setting = ReservationSetting::first();

        $steps = ReservationStep::orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $terms = ReservationTerm::orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $areas = ReservationArea::orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('reservation', compact(
            'setting',
            'steps',
            'terms',
            'areas'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE SETTINGS
    |--------------------------------------------------------------------------
    |
    | Dipakai oleh:
    | Header
    | Lokasi
    | Social Media
    | CTA
    |
    | Hanya field yang dikirim form yang akan diubah.
    | Data dari form lain tidak akan ikut terhapus.
    |
    */

    public function updateSettings(Request $request)
    {
        $request->validate([
            // HEADER
            'hero_badge' => 'nullable|string|max:100',
            'hero_title' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string',
            'hero_whatsapp_link' => 'nullable|string|max:500',
            'response_time' => 'nullable|string|max:255',
            'hero_image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            // JUDUL SECTION
            'steps_title' => 'nullable|string|max:255',
            'terms_title' => 'nullable|string|max:255',
            'areas_title' => 'nullable|string|max:255',
            'areas_subtitle' => 'nullable|string|max:255',

            // LOKASI & INFORMASI
            'location_name' => 'nullable|string|max:255',
            'location_subtitle' => 'nullable|string|max:255',
            'location_image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'address' => 'nullable|string',
            'location_title' => 'nullable|string|max:255',
            'operating_hours' => 'nullable|string|max:255',
            'whatsapp_number' => 'nullable|string|max:255',

            // SOCIAL MEDIA
            'instagram_link' => 'nullable|string|max:500',
            'facebook_link' => 'nullable|string|max:500',
            'tiktok_link' => 'nullable|string|max:500',
            'whatsapp_link' => 'nullable|string|max:500',

            // CTA
            'cta_badge' => 'nullable|string|max:100',
            'cta_title' => 'nullable|string|max:255',
            'cta_description' => 'nullable|string',
            'cta_background_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'cta_whatsapp_link' => 'nullable|string|max:500',
        ], [
            'hero_image_file.max' => 'Ukuran gambar Header maksimal 2 MB.',
            'location_image_file.max' => 'Ukuran gambar Lokasi & Informasi maksimal 2 MB.',
            'cta_background_file.max' => 'Ukuran gambar CTA maksimal 2 MB.',
            'hero_image_file.mimes' => 'Gambar Header harus berformat JPG, JPEG, PNG, atau WebP.',
            'location_image_file.mimes' => 'Gambar Lokasi & Informasi harus berformat JPG, JPEG, PNG, atau WebP.',
            'cta_background_file.mimes' => 'Gambar CTA harus berformat JPG, JPEG, PNG, atau WebP.',
        ]);

        // Ambil atau buat data pengaturan.
        $setting = ReservationSetting::first();
        if (! $setting) {
            $setting = new ReservationSetting;
        }

        // Hanya ubah isian teks yang dikirim oleh form tersebut.
        $allowedFields = [
            'hero_badge',
            'hero_title',
            'hero_description',
            'hero_whatsapp_link',
            'response_time',
            'steps_title',
            'terms_title',
            'areas_title',
            'areas_subtitle',
            'location_name',
            'location_subtitle',
            'address',
            'location_title',
            'operating_hours',
            'whatsapp_number',
            'instagram_link',
            'facebook_link',
            'tiktok_link',
            'whatsapp_link',
            'cta_badge',
            'cta_title',
            'cta_description',
            'cta_whatsapp_link',
        ];

        foreach ($allowedFields as $field) {
            if ($request->has($field)) {
                $setting->{$field} = $request->input($field);
            }
        }

        // Upload gambar hanya jika admin memilih file baru.
        // Jika tidak memilih file, gambar lama tetap dipakai.
        $imageUploads = [
            'hero_image_file' => ['column' => 'hero_image', 'directory' => 'reservation/hero'],
            'location_image_file' => ['column' => 'location_image', 'directory' => 'reservation/location'],
            'cta_background_file' => ['column' => 'cta_background_image', 'directory' => 'reservation/cta'],
        ];
        $oldImages = [];
        $newlyUploadedPaths = [];

        foreach ($imageUploads as $inputName => $config) {
            if (! $request->hasFile($inputName)) {
                continue;
            }

            $column = $config['column'];
            $oldImages[$column] = $setting->{$column};
            $newPath = $request->file($inputName)->store($config['directory'], 'public');

            if (! $newPath) {
                foreach ($newlyUploadedPaths as $uploadedPath) {
                    Storage::disk('public')->delete($uploadedPath);
                }

                throw new \RuntimeException('Gambar gagal disimpan. Silakan coba kembali.');
            }

            // Simpan path publik untuk gambar Header/Lokasi supaya dapat langsung dipakai
            // oleh halaman Reservation; CTA tetap mengikuti format path lama.
            $setting->{$column} = $inputName === 'cta_background_file'
                ? $newPath
                : Storage::url($newPath);
            $newlyUploadedPaths[] = $newPath;
        }

        try {
            $setting->save();
        } catch (\Throwable $e) {
            foreach ($newlyUploadedPaths as $uploadedPath) {
                Storage::disk('public')->delete($uploadedPath);
            }

            throw $e;
        }

        // Hapus gambar lama setelah perubahan berhasil tersimpan.
        foreach ($oldImages as $column => $oldPath) {
            if ($oldPath !== $setting->{$column}) {
                $this->deleteLocalFile($oldPath);
            }
        }

        return back()->with('success', 'Pengaturan Reservation berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | CARA RESERVASI - TAMBAH
    |--------------------------------------------------------------------------
    */

    
    public function storeStep(Request $request)
    {
        $request->validate([
            'icon_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ], [
            'icon_file.max' => 'Ukuran ikon maksimal 2 MB.',
            'icon_file.mimes' => 'Ikon harus berformat JPG, JPEG, PNG, atau WebP.',
        ]);

        $icon = null;
        $newlyUploadedPath = null;

        if ($request->hasFile('icon_file')) {
            $icon = $request->file('icon_file')->store('reservation/icons', 'public');
            $newlyUploadedPath = $icon;

            if (! $icon) {
                throw new \RuntimeException('Ikon gagal disimpan. Silakan coba kembali.');
            }
        }

        try {
            ReservationStep::create([
                'icon' => $icon,
                'title' => $request->title,
                'description' => $request->description,
                'sort_order' => $request->sort_order ?? 0,
            ]);
        } catch (\Throwable $e) {
            if ($newlyUploadedPath) {
                Storage::disk('public')->delete($newlyUploadedPath);
            }

            throw $e;
        }

        return back()->with('success', 'Cara Reservasi berhasil ditambahkan.');
    }


    /*
    |--------------------------------------------------------------------------
    | CARA RESERVASI - UPDATE
    |--------------------------------------------------------------------------
    */

    public function updateStep(Request $request, int $id)
    {
        $step = ReservationStep::findOrFail($id);

        $request->validate([
            'icon_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ], [
            'icon_file.max' => 'Ukuran ikon maksimal 2 MB.',
            'icon_file.mimes' => 'Ikon harus berformat JPG, JPEG, PNG, atau WebP.',
        ]);

        $oldIcon = $step->icon;
        $icon = $oldIcon;
        $newlyUploadedPath = null;

        if ($request->hasFile('icon_file')) {
            $icon = $request->file('icon_file')->store('reservation/icons', 'public');
            $newlyUploadedPath = $icon;

            if (! $icon) {
                throw new \RuntimeException('Ikon gagal disimpan. Silakan coba kembali.');
            }
        }

        try {
            $step->update([
                'icon' => $icon,
                'title' => $request->title,
                'description' => $request->description,
                'sort_order' => $request->sort_order ?? 0,
            ]);
        } catch (\Throwable $e) {
            if ($newlyUploadedPath) {
                Storage::disk('public')->delete($newlyUploadedPath);
            }

            throw $e;
        }

        if ($oldIcon !== $icon) {
            $this->deleteLocalFile($oldIcon);
        }

        return back()->with('success', 'Cara Reservasi berhasil diperbarui.');
    }


    /*
    |--------------------------------------------------------------------------
    | CARA RESERVASI - HAPUS
    |--------------------------------------------------------------------------
    */

    
public function destroyStep(int $id)
{
    $step = ReservationStep::findOrFail($id);

    // Simpan lokasi ikon sebelum data dihapus.
    $oldIcon = $step->icon;

    // Hapus data dari database terlebih dahulu.
    $deleted = $step->delete();

    // Bersihkan file ikon setelah data berhasil dihapus.
    if ($deleted) {
        $this->deleteLocalFile($oldIcon);
    }

    return back()->with(
        'success',
        'Cara Reservasi berhasil dihapus.'
    );
}


    /*
    |--------------------------------------------------------------------------
    | KETENTUAN RESERVASI - TAMBAH
    |--------------------------------------------------------------------------
    */

    
    public function storeTerm(Request $request)
    {
        $request->validate([
            'icon_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ], [
            'icon_file.max' => 'Ukuran ikon maksimal 2 MB.',
            'icon_file.mimes' => 'Ikon harus berformat JPG, JPEG, PNG, atau WebP.',
        ]);

        $icon = null;
        $newlyUploadedPath = null;

        if ($request->hasFile('icon_file')) {
            $icon = $request->file('icon_file')->store('reservation/icons', 'public');
            $newlyUploadedPath = $icon;

            if (! $icon) {
                throw new \RuntimeException('Ikon gagal disimpan. Silakan coba kembali.');
            }
        }

        try {
            ReservationTerm::create([
                'icon' => $icon,
                'title' => $request->title,
                'description' => $request->description,
                'sort_order' => $request->sort_order ?? 0,
            ]);
        } catch (\Throwable $e) {
            if ($newlyUploadedPath) {
                Storage::disk('public')->delete($newlyUploadedPath);
            }

            throw $e;
        }

        return back()->with('success', 'Ketentuan Reservasi berhasil ditambahkan.');
    }


    /*
    |--------------------------------------------------------------------------
    | KETENTUAN RESERVASI - UPDATE
    |--------------------------------------------------------------------------
    */

    
    public function updateTerm(Request $request, int $id)
    {
        $term = ReservationTerm::findOrFail($id);

        $request->validate([
            'icon_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ], [
            'icon_file.max' => 'Ukuran ikon maksimal 2 MB.',
            'icon_file.mimes' => 'Ikon harus berformat JPG, JPEG, PNG, atau WebP.',
        ]);

        $oldIcon = $term->icon;
        $icon = $oldIcon;
        $newlyUploadedPath = null;

        if ($request->hasFile('icon_file')) {
            $icon = $request->file('icon_file')->store('reservation/icons', 'public');
            $newlyUploadedPath = $icon;

            if (! $icon) {
                throw new \RuntimeException('Ikon gagal disimpan. Silakan coba kembali.');
            }
        }

        try {
            $term->update([
                'icon' => $icon,
                'title' => $request->title,
                'description' => $request->description,
                'sort_order' => $request->sort_order ?? 0,
            ]);
        } catch (\Throwable $e) {
            if ($newlyUploadedPath) {
                Storage::disk('public')->delete($newlyUploadedPath);
            }

            throw $e;
        }

        if ($oldIcon !== $icon) {
            $this->deleteLocalFile($oldIcon);
        }

        return back()->with('success', 'Ketentuan Reservasi berhasil diperbarui.');
    }


    /*
    |--------------------------------------------------------------------------
    | KETENTUAN RESERVASI - HAPUS
    |--------------------------------------------------------------------------
    */

    
public function destroyTerm(int $id)
{
    $term = ReservationTerm::findOrFail($id);

    // Simpan lokasi ikon sebelum data dihapus.
    $oldIcon = $term->icon;

    // Hapus data dari database terlebih dahulu.
    $deleted = $term->delete();

    // Hapus file ikon jika tidak lagi digunakan.
    if ($deleted) {
        $this->deleteLocalFile($oldIcon);
    }

    return back()->with(
        'success',
        'Ketentuan Reservasi berhasil dihapus.'
    );
}


    /*
    |--------------------------------------------------------------------------
    | KENALI AREA RESTO - UPDATE
    |--------------------------------------------------------------------------
    |
    | Sesuai keputusan kita:
    | Tidak ada tambah dari Admin.
    | Area yang sudah ada cukup di-update.
    |
    */

    
    public function updateArea(Request $request, int $id)
    {
        $area = ReservationArea::findOrFail($id);

        $request->validate([
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ], [
            'image_file.max' => 'Ukuran gambar area maksimal 2 MB.',
            'image_file.mimes' => 'Gambar area harus berformat JPG, JPEG, PNG, atau WebP.',
        ]);

        $oldImage = $area->image;
        $newImage = $oldImage;
        $newlyUploadedPath = null;

        if ($request->hasFile('image_file')) {
            $storedImagePath = $request->file('image_file')->store('reservation/areas', 'public');
            $newlyUploadedPath = $storedImagePath;

            if (! $storedImagePath) {
                throw new \RuntimeException('Gambar area gagal disimpan. Silakan coba kembali.');
            }

            // Simpan alamat publik agar src gambar langsung dapat digunakan halaman Reservation.
            $newImage = Storage::url($storedImagePath);
        }

        try {
            $area->update([
                'image' => $newImage,
                'title' => $request->title,
                'description' => $request->description,
                'sort_order' => $request->sort_order ?? $area->sort_order,
            ]);
        } catch (\Throwable $e) {
            if ($newlyUploadedPath) {
                Storage::disk('public')->delete($newlyUploadedPath);
            }

            throw $e;
        }

        if ($oldImage !== $newImage) {
            $this->deleteLocalFile($oldImage);
        }

        return back()->with('success', 'Area resto berhasil diperbarui.');
    }


    /*
    |--------------------------------------------------------------------------
    | KENALI AREA RESTO - HAPUS
    |--------------------------------------------------------------------------
    */

    public function destroyArea(int $id)
    {
        $area = ReservationArea::findOrFail($id);
        $oldImage = $area->image;
        $deleted = $area->delete();

        if ($deleted) {
            $this->deleteLocalFile($oldImage);
        }

        return back()->with('success', 'Area resto berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | TAMBAH AREA
    |--------------------------------------------------------------------------
    |
    | Method tetap disediakan agar route lama tidak error.
    | Namun pada tampilan Admin kita tidak menyediakan tombol tambah.
    |
    */

    public function storeArea(Request $request)
    {
        $request->validate([
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ], [
            'image_file.max' => 'Ukuran gambar area maksimal 2 MB.',
            'image_file.mimes' => 'Gambar area harus berformat JPG, JPEG, PNG, atau WebP.',
        ]);

        $image = null;
        $newlyUploadedPath = null;

        if ($request->hasFile('image_file')) {
            $storedImagePath = $request->file('image_file')->store('reservation/areas', 'public');
            $newlyUploadedPath = $storedImagePath;

            if (! $storedImagePath) {
                throw new \RuntimeException('Gambar area gagal disimpan. Silakan coba kembali.');
            }

            $image = Storage::url($storedImagePath);
        }

        try {
            ReservationArea::create([
                'image' => $image,
                'title' => $request->title,
                'description' => $request->description,
                'sort_order' => $request->sort_order ?? 0,
            ]);
        } catch (\Throwable $e) {
            if ($newlyUploadedPath) {
                Storage::disk('public')->delete($newlyUploadedPath);
            }

            throw $e;
        }

        return back()->with('success', 'Area resto berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER HAPUS FILE LOKAL
    |--------------------------------------------------------------------------
    */

    
    private function normalizeLocalPath(?string $path): ?string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return null;
        }

        // Jika Storage::url() menghasilkan URL absolut, izinkan normalisasi
        // hanya bila host cocok dengan APP_URL atau URL disk public.
        if (preg_match('#^https?://#i', $path)) {
            $urlHost = parse_url($path, PHP_URL_HOST);
            $appHost = parse_url((string) config('app.url'), PHP_URL_HOST);
            $publicDiskHost = parse_url((string) config('filesystems.disks.public.url'), PHP_URL_HOST);
            $knownHosts = array_filter([$appHost, $publicDiskHost]);

            if (! $urlHost || ! in_array(strtolower($urlHost), array_map('strtolower', $knownHosts), true)) {
                return null;
            }

            $path = (string) parse_url($path, PHP_URL_PATH);
        }

        // Ubah URL/path storage menjadi path relatif.
        $path = preg_replace('#^/?storage/#i', '', $path);
        $path = ltrim($path, '/');

        // Cegah path yang tidak aman.
        if (str_contains($path, '..')) {
            return null;
        }

        // Batasi penghapusan hanya pada folder Reservation milik fitur upload.
        $allowedFolders = [
            'reservation/icons/',
            'reservation/cta/',
            'reservation/hero/',
            'reservation/location/',
            'reservation/areas/',
        ];

        foreach ($allowedFolders as $folder) {
            if (str_starts_with($path, $folder)) {
                return $path;
            }
        }

        return null;
    }

    private function deleteLocalFile(?string $path): void
    {
        $localPath = $this->normalizeLocalPath($path);

        if (! $localPath || ! Storage::disk('public')->exists($localPath)) {
            return;
        }

        // Cek apakah file masih digunakan oleh Cara Reservasi.
        $usedBySteps = ReservationStep::query()
            ->get(['icon'])
            ->contains(function ($item) use ($localPath) {
                return $this->normalizeLocalPath($item->icon) === $localPath;
            });

        // Cek apakah file masih digunakan oleh Ketentuan Reservasi.
        $usedByTerms = ReservationTerm::query()
            ->get(['icon'])
            ->contains(function ($item) use ($localPath) {
                return $this->normalizeLocalPath($item->icon) === $localPath;
            });

        // Cek seluruh gambar milik pengaturan Reservation.
        $usedBySettings = ReservationSetting::query()
            ->get(['hero_image', 'location_image', 'cta_background_image'])
            ->contains(function ($item) use ($localPath) {
                return $this->normalizeLocalPath($item->hero_image) === $localPath
                    || $this->normalizeLocalPath($item->location_image) === $localPath
                    || $this->normalizeLocalPath($item->cta_background_image) === $localPath;
            });

        // Cek apakah gambar masih digunakan oleh area resto lainnya.
        $usedByAreas = ReservationArea::query()
            ->get(['image'])
            ->contains(function ($item) use ($localPath) {
                return $this->normalizeLocalPath($item->image) === $localPath;
            });

        // Hapus hanya bila tidak ada data lain yang menggunakan file tersebut.
        if (! $usedBySteps && ! $usedByTerms && ! $usedBySettings && ! $usedByAreas) {
            Storage::disk('public')->delete($localPath);
        }
    }


    
}
