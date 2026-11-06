<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GallerySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN ADMIN GALLERY
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $photos = Gallery::latest()->get();

        $gallerySetting = GallerySetting::first();

        return view('gallery-admin', compact(
            'photos',
            'gallerySetting'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE PENGATURAN GALLERY
    |--------------------------------------------------------------------------
    */

    public function updateSettings(Request $request)
{
    // Jika gambar Hero lama berupa URL/path tidak valid, wajib unggah gambar lokal pengganti.
    $existingSetting = GallerySetting::first();
    $existingHeroImage = $existingSetting?->hero_image;
    $existingHeroLocalPath = $this->normalizeLocalPath($existingHeroImage);
    $hasValidExistingHeroImage = $existingHeroLocalPath
        && Storage::disk('public')->exists($existingHeroLocalPath);
    $needsHeroUpload = trim((string) $existingHeroImage) !== ''
        && ! $hasValidExistingHeroImage;

    $request->validate([
        'hero_badge' => 'nullable|string|max:100',
        'hero_title' => 'nullable|string|max:255',
        'hero_description' => 'nullable|string',
        'hero_image' => ($needsHeroUpload ? 'required' : 'nullable') . '|image|mimes:jpg,jpeg,png,webp|max:2048',

        'cta_title' => 'nullable|string|max:255',
        'cta_description' => 'nullable|string',
        'cta_button_1_link' => 'nullable|url|max:500',

        'cta_whatsapp_title' => 'nullable|string|max:255',
        'cta_whatsapp_description' => 'nullable|string',
        'cta_button_2_link' => 'nullable|string|max:500',
    ], [
        'hero_image.required' => 'Silakan pilih gambar lokal untuk mengganti Background Hero yang lama.',
        'hero_image.image' => 'Background Hero harus berupa gambar.',
        'hero_image.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WebP.',
        'hero_image.max' => 'Ukuran gambar maksimal 2 MB.',
    ]);

    $gallerySetting = $existingSetting;

    if (!$gallerySetting) {
        $gallerySetting = new GallerySetting;
    }

    // Perbarui hanya field yang dikirim oleh form.
    $textFields = [
        'hero_badge',
        'hero_title',
        'hero_description',
        'cta_title',
        'cta_description',
        'cta_button_1_link',
        'cta_whatsapp_title',
        'cta_whatsapp_description',
        'cta_button_2_link',
    ];

    foreach ($textFields as $field) {
        if ($request->exists($field)) {
            $gallerySetting->{$field} = $request->input($field);
        }
    }

    $oldHeroImage = $gallerySetting->hero_image;
    $newHeroImagePath = null;

    // Upload Hero hanya jika memilih file baru.
    if ($request->hasFile('hero_image')) {
        $newHeroImagePath = $request->file('hero_image')
            ->store('gallery/hero', 'public');

        if (!$newHeroImagePath) {
            return back()->withErrors([
                'hero_image' => 'Gagal menyimpan Background Hero.',
            ])->withInput();
        }

        $gallerySetting->hero_image = $newHeroImagePath;
    }

    try {
        $gallerySetting->save();
    } catch (\Throwable $e) {
        if ($newHeroImagePath) {
            Storage::disk('public')->delete($newHeroImagePath);
        }

        throw $e;
    }

    if ($newHeroImagePath && $oldHeroImage !== $newHeroImagePath) {
        $this->deleteLocalFileIfUnused($oldHeroImage);
    }

    return back()->with(
        'success',
        'Pengaturan Gallery berhasil diperbarui.'
    );
}

    /*
    |--------------------------------------------------------------------------
    | HALAMAN PUBLIC GALLERY
    |--------------------------------------------------------------------------
    */

    public function publicIndex()
    {
        $gallerySetting = GallerySetting::first();

        $photos = Gallery::latest()->get();

        return view('gallery', compact(
            'photos',
            'gallerySetting'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | TAMBAH GALLERY
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category' => 'required|in:momen,facility,event',
        'image_file' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
    ], [
        'image_file.required' => 'Silakan pilih gambar dari perangkat.',
        'image_file.image' => 'File harus berupa gambar.',
        'image_file.mimes' => 'Format harus JPG, JPEG, PNG, atau WebP.',
        'image_file.max' => 'Ukuran gambar maksimal 2 MB.',
    ]);

    $imagePath = $request->file('image_file')
        ->store('gallery', 'public');

    if (!$imagePath) {
        return back()->withErrors([
            'image_file' => 'Gagal menyimpan gambar.',
        ])->withInput();
    }

    try {
        Gallery::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'image_path' => $imagePath,
        ]);
    } catch (\Throwable $e) {
        Storage::disk('public')->delete($imagePath);
        throw $e;
    }

    return back()->with('success', 'Gallery berhasil ditambahkan.');
}

    /*
    |--------------------------------------------------------------------------
    | UPDATE GALLERY
    |--------------------------------------------------------------------------
    */

   
    public function update(Request $request, int $id)
{
    $photo = Gallery::findOrFail($id);
    $oldImagePath = $photo->image_path;
    $oldLocalImagePath = $this->normalizeLocalPath($oldImagePath);
    $hasValidOldImage = $oldLocalImagePath
        && Storage::disk('public')->exists($oldLocalImagePath);

    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category' => 'required|in:momen,facility,event',
        'image_file' => ($hasValidOldImage ? 'nullable' : 'required') . '|image|mimes:jpg,jpeg,png,webp|max:2048',
    ], [
        'image_file.required' => 'Silakan pilih gambar lokal untuk mengganti gambar galeri yang lama.',
        'image_file.image' => 'File harus berupa gambar.',
        'image_file.mimes' => 'Format harus JPG, JPEG, PNG, atau WebP.',
        'image_file.max' => 'Ukuran gambar maksimal 2 MB.',
    ]);

    // Pertahankan hanya gambar lama yang benar-benar tersimpan secara lokal.
    $imagePath = $hasValidOldImage ? $oldLocalImagePath : null;
    $newlyUploadedPath = null;

    // Foto lama tetap digunakan jika tidak memilih file baru.
    if ($request->hasFile('image_file')) {
        $imagePath = $request->file('image_file')
            ->store('gallery', 'public');

        if (!$imagePath) {
            return back()->withErrors([
                'image_file' => 'Gagal menyimpan gambar baru.',
            ])->withInput();
        }

        $newlyUploadedPath = $imagePath;
    }

    try {
        $photo->update([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'image_path' => $imagePath,
        ]);
    } catch (\Throwable $e) {
        if ($newlyUploadedPath) {
            Storage::disk('public')->delete($newlyUploadedPath);
        }

        throw $e;
    }

    if ($oldImagePath !== $imagePath) {
        $this->deleteLocalFileIfUnused($oldImagePath);
    }

    return back()->with('success', 'Gallery berhasil diperbarui.');
}


    
   public function updateFrames(Request $request)
{
    $request->validate([
        'frame' => 'required|in:1,2',
    ]);

    $frame = (string) $request->frame;
    $gallerySetting = GallerySetting::first();

    if ($frame === '1') {
        $imageField = 'frame_1_image';
        $descriptionField = 'frame_1_description';
        $uploadField = 'frame_1_upload';
    } else {
        $imageField = 'frame_2_image';
        $descriptionField = 'frame_2_description';
        $uploadField = 'frame_2_upload';
    }

    $oldImage = $gallerySetting?->{$imageField};
    $oldLocalImagePath = $this->normalizeLocalPath($oldImage);
    $hasValidOldImage = $oldLocalImagePath
        && Storage::disk('public')->exists($oldLocalImagePath);
    $needsFrameUpload = trim((string) $oldImage) !== '' && ! $hasValidOldImage;

    $request->validate([
        'frame_1_description' => 'nullable|string',
        'frame_1_upload' => ($frame === '1' && $needsFrameUpload ? 'required' : 'nullable') . '|image|mimes:jpg,jpeg,png,webp|max:2048',
        'frame_2_description' => 'nullable|string',
        'frame_2_upload' => ($frame === '2' && $needsFrameUpload ? 'required' : 'nullable') . '|image|mimes:jpg,jpeg,png,webp|max:2048',
    ], [
        'frame_1_upload.required' => 'Silakan pilih gambar lokal untuk Bingkai 1.',
        'frame_1_upload.image' => 'File Bingkai 1 harus berupa gambar.',
        'frame_1_upload.mimes' => 'Format Bingkai 1 harus JPG, JPEG, PNG, atau WebP.',
        'frame_1_upload.max' => 'Ukuran Bingkai 1 maksimal 2 MB.',
        'frame_2_upload.required' => 'Silakan pilih gambar lokal untuk Bingkai 2.',
        'frame_2_upload.image' => 'File Bingkai 2 harus berupa gambar.',
        'frame_2_upload.mimes' => 'Format Bingkai 2 harus JPG, JPEG, PNG, atau WebP.',
        'frame_2_upload.max' => 'Ukuran Bingkai 2 maksimal 2 MB.',
    ]);

    if (!$gallerySetting) {
        $gallerySetting = new GallerySetting;
    }

    // Pertahankan hanya gambar lama yang benar-benar tersimpan secara lokal.
    $imagePath = $hasValidOldImage ? $oldLocalImagePath : null;
    $newlyUploadedPath = null;

    if ($request->hasFile($uploadField)) {
        $imagePath = $request->file($uploadField)
            ->store('gallery/frames', 'public');

        if (!$imagePath) {
            return back()->withErrors([
                $uploadField => 'Gagal menyimpan gambar bingkai.',
            ])->withInput();
        }

        $newlyUploadedPath = $imagePath;
    }

    try {
        $gallerySetting->{$imageField} = $imagePath;
        $gallerySetting->{$descriptionField} =
            $request->input($descriptionField);

        $gallerySetting->save();
    } catch (\Throwable $e) {
        if ($newlyUploadedPath) {
            Storage::disk('public')->delete($newlyUploadedPath);
        }

        throw $e;
    }

    if ($oldImage !== $imagePath) {
        $this->deleteLocalFileIfUnused($oldImage);
    }

    return back()->with('success', 'Bingkai berhasil diperbarui.');
}


    
/**
 * Hapus Gallery.
 */
public function destroy(int $id)
{
    $photo = Gallery::findOrFail($id);

    // Simpan alamat foto sebelum data dihapus
    $oldImagePath = $photo->image_path;

    // Hapus data galeri dari database terlebih dahulu
    $deleted = $photo->delete();

    // Hapus foto hanya jika sudah tidak digunakan data lain
    if ($deleted) {
        $this->deleteLocalFileIfUnused($oldImagePath);
    }

    return back()->with(
        'success',
        'Gallery berhasil dihapus.'
    );
}

    
/**
 * Memeriksa alamat foto lokal.
 */
private function normalizeLocalPath(?string $path): ?string
{
    $path = trim((string) $path);

    // URL luar, termasuk CDN, tidak diproses sebagai file lokal
    if ($path === '' || preg_match('#^https?://#i', $path)) {
        return null;
    }

    // Rapikan awalan path lama yang mungkin tersimpan di database.
    // Contoh: public/gallery/foto.jpg, public/storage/gallery/foto.jpg,
    // storage/gallery/foto.jpg, atau gallery/foto.jpg.
    $path = ltrim($path, '/');
    $path = preg_replace('#^public/#i', '', $path);
    $path = preg_replace('#^storage/#i', '', $path);
    $path = ltrim($path, '/');

    // Batasi penghapusan pada folder gallery
    if (
        str_contains($path, '..') ||
        !str_starts_with($path, 'gallery/')
    ) {
        return null;
    }

    return $path;
}

    /**
     * Hapus foto jika tidak lagi digunakan Gallery, Hero, atau Bingkai.
     */
    private function deleteLocalFileIfUnused(?string $path): void
    {
        $localPath = $this->normalizeLocalPath($path);

        if (
            ! $localPath ||
            ! Storage::disk('public')->exists($localPath)
        ) {
            return;
        }

        // Periksa apakah foto masih digunakan data Gallery.
        $usedByGallery = Gallery::query()
            ->get(['image_path'])
            ->contains(function ($photo) use ($localPath) {
                return $this->normalizeLocalPath($photo->image_path) === $localPath;
            });

        // Jangan hapus foto yang masih dipakai sebagai Hero atau Bingkai.
        $usedBySettings = GallerySetting::query()
            ->get(['hero_image', 'frame_1_image', 'frame_2_image'])
            ->contains(function ($setting) use ($localPath) {
                return $this->normalizeLocalPath($setting->hero_image) === $localPath
                    || $this->normalizeLocalPath($setting->frame_1_image) === $localPath
                    || $this->normalizeLocalPath($setting->frame_2_image) === $localPath;
            });

        if (! $usedByGallery && ! $usedBySettings) {
            Storage::disk('public')->delete($localPath);
        }
    }

}