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
            'hero_image' => 'nullable|url|max:2048',
            'response_time' => 'nullable|string|max:255',


            // JUDUL SECTION
            'steps_title' => 'nullable|string|max:255',
            'terms_title' => 'nullable|string|max:255',
            'areas_title' => 'nullable|string|max:255',
            'areas_subtitle' => 'nullable|string|max:255',

            // LOKASI
            'location_name' => 'nullable|string|max:255',
            'location_subtitle' => 'nullable|string|max:255',
            'location_image' => 'nullable|url|max:2048',
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
            'cta_background_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
            'cta_background_url' => 'nullable|string|max:500',
            'cta_whatsapp_link' => 'nullable|string|max:500',
        ]);

        /*
        |--------------------------------------------------------------------------
        | AMBIL ATAU BUAT SETTING
        |--------------------------------------------------------------------------
        */

        $setting = ReservationSetting::first();

        if (! $setting) {
            $setting = new ReservationSetting;
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE HANYA FIELD YANG DIKIRIM
        |--------------------------------------------------------------------------
        */

        $allowedFields = [
            'hero_badge',
            'hero_title',
            'hero_description',
            'hero_whatsapp_link',
            'hero_image',
            'response_time',

            'steps_title',
            'terms_title',
            'areas_title',
            'areas_subtitle',

            'location_name',
            'location_subtitle',
            'location_image',
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

       
        // CTA BACKGROUND IMAGE
        $oldCtaImage = $setting->cta_background_image;
        $newlyUploadedPath = null;

        if ($request->hasFile('cta_background_file')) {
            $newlyUploadedPath = $request->file('cta_background_file')
                ->store('reservation/cta', 'public');

            $setting->cta_background_image = $newlyUploadedPath;

        } elseif ($request->filled('cta_background_url')) {
            $setting->cta_background_image = trim(
                $request->input('cta_background_url')
            );
        }

        // Simpan pengaturan terlebih dahulu.
        try {
            $setting->save();
        } catch (\Throwable $e) {
            // Bersihkan file baru jika penyimpanan gagal.
            if ($newlyUploadedPath) {
                Storage::disk('public')->delete($newlyUploadedPath);
            }

            throw $e;
        }

        // Bersihkan gambar lama setelah penyimpanan berhasil.
        if ($oldCtaImage !== $setting->cta_background_image) {
            $this->deleteLocalFile($oldCtaImage);
        }


        return back()->with(
            'success',
            'Pengaturan Reservation berhasil diperbarui.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CARA RESERVASI - TAMBAH
    |--------------------------------------------------------------------------
    */

    
public function storeStep(Request $request)
{
    $request->validate([
        'icon_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
        'icon_url' => 'nullable|string|max:500',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'sort_order' => 'nullable|integer',
    ], [
        'icon_file.max' => 'Ukuran ikon maksimal 1 MB.',
    ]);

    $icon = null;
    $newlyUploadedPath = null;

    if ($request->hasFile('icon_file')) {
        $icon = $request->file('icon_file')
            ->store('reservation/icons', 'public');

        $newlyUploadedPath = $icon;
    } elseif ($request->filled('icon_url')) {
        $icon = trim($request->input('icon_url'));
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

    return back()->with(
        'success',
        'Cara Reservasi berhasil ditambahkan.'
    );
}


    /*
    |--------------------------------------------------------------------------
    | CARA RESERVASI - UPDATE
    |--------------------------------------------------------------------------
    */

public function updateStep(Request $request, $id)
{
    $step = ReservationStep::findOrFail($id);

    $request->validate([
        'icon_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
        'icon_url' => 'nullable|string|max:500',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'sort_order' => 'nullable|integer',
    ], [
        'icon_file.max' => 'Ukuran ikon maksimal 1 MB.',
    ]);

    $oldIcon = $step->icon;
    $icon = $oldIcon;
    $newlyUploadedPath = null;

    if ($request->hasFile('icon_file')) {
        $icon = $request->file('icon_file')
            ->store('reservation/icons', 'public');

        $newlyUploadedPath = $icon;
    } elseif ($request->filled('icon_url')) {
        $icon = trim($request->input('icon_url'));
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

    return back()->with(
        'success',
        'Cara Reservasi berhasil diperbarui.'
    );
}


    /*
    |--------------------------------------------------------------------------
    | CARA RESERVASI - HAPUS
    |--------------------------------------------------------------------------
    */

    
public function destroyStep($id)
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
        'icon_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
        'icon_url' => 'nullable|string|max:500',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'sort_order' => 'nullable|integer',
    ], [
        'icon_file.max' => 'Ukuran ikon maksimal 1 MB.',
    ]);

    $icon = null;
    $newlyUploadedPath = null;

    if ($request->hasFile('icon_file')) {
        $icon = $request->file('icon_file')
            ->store('reservation/icons', 'public');

        $newlyUploadedPath = $icon;
    } elseif ($request->filled('icon_url')) {
        $icon = trim($request->input('icon_url'));
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

    return back()->with(
        'success',
        'Ketentuan Reservasi berhasil ditambahkan.'
    );
}


    /*
    |--------------------------------------------------------------------------
    | KETENTUAN RESERVASI - UPDATE
    |--------------------------------------------------------------------------
    */

    
public function updateTerm(Request $request, $id)
{
    $term = ReservationTerm::findOrFail($id);

    $request->validate([
        'icon_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
        'icon_url' => 'nullable|string|max:500',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'sort_order' => 'nullable|integer',
    ], [
        'icon_file.max' => 'Ukuran ikon maksimal 1 MB.',
    ]);

    $oldIcon = $term->icon;
    $icon = $oldIcon;
    $newlyUploadedPath = null;

    if ($request->hasFile('icon_file')) {
        $icon = $request->file('icon_file')
            ->store('reservation/icons', 'public');

        $newlyUploadedPath = $icon;
    } elseif ($request->filled('icon_url')) {
        $icon = trim($request->input('icon_url'));
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

    return back()->with(
        'success',
        'Ketentuan Reservasi berhasil diperbarui.'
    );
}


    /*
    |--------------------------------------------------------------------------
    | KETENTUAN RESERVASI - HAPUS
    |--------------------------------------------------------------------------
    */

    
public function destroyTerm($id)
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

    
public function updateArea(Request $request, $id)
{
    $area = ReservationArea::findOrFail($id);

    $request->validate([
        'image' => 'nullable|string|max:500',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'sort_order' => 'nullable|integer',
    ]);

    $data = [
        'title' => $request->title,
        'description' => $request->description,
        'sort_order' => $request->sort_order ?? $area->sort_order,
    ];

    // Ganti gambar hanya jika URL baru diisi.
    if ($request->filled('image')) {
        $data['image'] = trim($request->input('image'));
    }

    $area->update($data);

    return back()->with(
        'success',
        'Area resto berhasil diperbarui.'
    );
}


    /*
    |--------------------------------------------------------------------------
    | KENALI AREA RESTO - HAPUS
    |--------------------------------------------------------------------------
    */

    public function destroyArea($id)
    {
        $area = ReservationArea::findOrFail($id);

        $area->delete();

        return back()->with(
            'success',
            'Area resto berhasil dihapus.'
        );
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
            'image' => 'nullable|string|max:500',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        ReservationArea::create([
            'image' => $request->image,
            'title' => $request->title,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return back()->with(
            'success',
            'Area resto berhasil ditambahkan.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER HAPUS FILE LOKAL
    |--------------------------------------------------------------------------
    */

    
private function normalizeLocalPath(?string $path): ?string
{
    $path = trim((string) $path);

    // URL eksternal tidak perlu dihapus.
    if ($path === '' || preg_match('#^https?://#i', $path)) {
        return null;
    }

    // Ubah URL storage menjadi path relatif.
    $path = preg_replace('#^/?storage/#i', '', $path);
    $path = ltrim($path, '/');

    // Cegah path yang tidak aman.
    if (str_contains($path, '..')) {
        return null;
    }

    // Hanya izinkan folder file Reservation.
    if (
        !str_starts_with($path, 'reservation/icons/') &&
        !str_starts_with($path, 'reservation/cta/')
    ) {
        return null;
    }

    return $path;
}

private function deleteLocalFile(?string $path): void
{
    $localPath = $this->normalizeLocalPath($path);

    if (
        ! $localPath ||
        ! Storage::disk('public')->exists($localPath)
    ) {
        return;
    }

    // Periksa apakah ikon masih digunakan oleh Cara Reservasi.
    $usedBySteps = ReservationStep::query()
        ->get(['icon'])
        ->contains(function ($item) use ($localPath) {
            return $this->normalizeLocalPath($item->icon) === $localPath;
        });

    // Periksa apakah ikon masih digunakan oleh Ketentuan Reservasi.
    $usedByTerms = ReservationTerm::query()
        ->get(['icon'])
        ->contains(function ($item) use ($localPath) {
            return $this->normalizeLocalPath($item->icon) === $localPath;
        });

    // Periksa apakah gambar masih digunakan sebagai background CTA.
    $usedBySettings = ReservationSetting::query()
        ->get(['cta_background_image'])
        ->contains(function ($item) use ($localPath) {
            return $this->normalizeLocalPath(
                $item->cta_background_image
            ) === $localPath;
        });

    // Hapus hanya jika tidak digunakan oleh data mana pun.
    if (! $usedBySteps && ! $usedByTerms && ! $usedBySettings) {
        Storage::disk('public')->delete($localPath);
    }
}


    
}
