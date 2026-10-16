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
        $request->validate([
            // HERO
            'hero_badge' => 'nullable|string|max:100',
            'hero_title' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string',
            'hero_image' => 'nullable|url|max:2048',

            // CTA INSTAGRAM
            'cta_title' => 'nullable|string|max:255',
            'cta_description' => 'nullable|string',
            'cta_button_1_link' => 'nullable|url|max:500',

            // CTA WHATSAPP
            'cta_whatsapp_title' => 'nullable|string|max:255',
            'cta_whatsapp_description' => 'nullable|string',
            'cta_button_2_link' => 'nullable|string|max:500',
        ]);

        $gallerySetting = GallerySetting::first();

        if (! $gallerySetting) {
            $gallerySetting = new GallerySetting;
        }

        $gallerySetting->fill(
            $request->except('_token', '_method')
        );

        $gallerySetting->save();

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

            // Hanya 3 kategori
            'category' => 'required|in:momen,facility,event',

            // Upload maksimal 1 MB
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',

            // Alternatif menggunakan URL
            'image_path' => 'nullable|url|max:2048',

        ], [
            'image_file.max' => 'Ukuran file lebih dari 1 MB. Harap kompres gambar terlebih dahulu hingga maksimal 1 MB.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | WAJIB ADA GAMBAR
        |--------------------------------------------------------------------------
        */

        if (
            ! $request->hasFile('image_file') &&
            ! $request->filled('image_path')
        ) {
            return back()
                ->withErrors([
                    'image_file' => 'Silakan upload gambar atau masukkan URL gambar.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN GAMBAR
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image_file')) {

            $path = $request
                ->file('image_file')
                ->store('gallery', 'public');

            // Simpan:
            // gallery/nama-file.jpg
            $imagePath = $path;

        } else {

            // Gunakan URL
            $imagePath = $request->image_path;
        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA
        |--------------------------------------------------------------------------
        */

        Gallery::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'image_path' => $imagePath,
        ]);

        return back()->with(
            'success',
            'Gallery berhasil ditambahkan.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE GALLERY
    |--------------------------------------------------------------------------
    */

   
public function update(Request $request, $id)
{
    $photo = Gallery::findOrFail($id);

    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category' => 'required|in:momen,facility,event',
        'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
        'image_path' => 'nullable|url|max:2048',
    ], [
        'image_file.max' =>
            'Ukuran file lebih dari 1 MB. Harap kompres gambar terlebih dahulu hingga maksimal 1 MB.',
    ]);

    // Simpan alamat foto lama
    $oldImagePath = $photo->image_path;

    // Pertahankan foto lama jika tidak ada pengganti
    $imagePath = $oldImagePath;
    $newlyUploadedPath = null;

    // Jika mengunggah foto baru
    if ($request->hasFile('image_file')) {
        $imagePath = $request->file('image_file')
            ->store('gallery', 'public');

        $newlyUploadedPath = $imagePath;
    }
    // Jika menggunakan URL gambar baru
    elseif ($request->filled('image_path')) {
        $imagePath = trim($request->input('image_path'));
    }

    // Perbarui database terlebih dahulu
    try {
        $photo->update([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'image_path' => $imagePath,
        ]);
    } catch (\Throwable $e) {
        // Bersihkan foto baru jika penyimpanan data gagal
        if ($newlyUploadedPath) {
            Storage::disk('public')->delete($newlyUploadedPath);
        }

        throw $e;
    }

    // Hapus foto lama hanya jika alamatnya berubah
    if (
        $this->normalizeLocalPath($oldImagePath) !==
        $this->normalizeLocalPath($imagePath)
    ) {
        $this->deleteLocalFileIfUnused($oldImagePath);
    }

    return back()->with(
        'success',
        'Gallery berhasil diperbarui.'
    );
}


    
public function updateFrames(Request $request)
{
    $request->validate([
        'frame' => 'required|in:1,2',

        'frame_1_description' => 'nullable|string',
        'frame_1_image' => 'nullable|url|max:2048',
        'frame_1_upload' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',

        'frame_2_description' => 'nullable|string',
        'frame_2_image' => 'nullable|url|max:2048',
        'frame_2_upload' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
    ], [
        'frame_1_upload.max' =>
            'Ukuran file lebih dari 1 MB. Harap kompres gambar terlebih dahulu hingga maksimal 1 MB.',
        'frame_2_upload.max' =>
            'Ukuran file lebih dari 1 MB. Harap kompres gambar terlebih dahulu hingga maksimal 1 MB.',
    ]);

    $gallerySetting = GallerySetting::first();

    if (! $gallerySetting) {
        $gallerySetting = new GallerySetting;
    }

    // Tentukan bingkai yang akan diperbarui
    if ($request->frame == 1) {
        $oldImage = $gallerySetting->frame_1_image;
        $imagePath = $oldImage;
        $description = $request->frame_1_description;
        $uploadField = 'frame_1_upload';
        $urlField = 'frame_1_image';
    } else {
        $oldImage = $gallerySetting->frame_2_image;
        $imagePath = $oldImage;
        $description = $request->frame_2_description;
        $uploadField = 'frame_2_upload';
        $urlField = 'frame_2_image';
    }

    $newlyUploadedPath = null;

    // Jika mengunggah foto baru
    if ($request->hasFile($uploadField)) {
        $imagePath = $request->file($uploadField)
            ->store('gallery/frames', 'public');

        $newlyUploadedPath = $imagePath;
    }
    // Jika menggunakan URL foto baru
    elseif ($request->filled($urlField)) {
        $imagePath = trim($request->input($urlField));
    }

    // Perbarui pengaturan terlebih dahulu
    try {
        if ($request->frame == 1) {
            $gallerySetting->frame_1_description = $description;
            $gallerySetting->frame_1_image = $imagePath;
        } else {
            $gallerySetting->frame_2_description = $description;
            $gallerySetting->frame_2_image = $imagePath;
        }

        $gallerySetting->save();
    } catch (\Throwable $e) {
        // Bersihkan foto baru jika penyimpanan gagal
        if ($newlyUploadedPath) {
            Storage::disk('public')->delete($newlyUploadedPath);
        }

        throw $e;
    }

    // Hapus foto lama jika alamatnya berubah dan tidak digunakan lagi
    if (
        $this->normalizeLocalPath($oldImage) !==
        $this->normalizeLocalPath($imagePath)
    ) {
        $this->deleteLocalFileIfUnused($oldImage);
    }

    return back()->with(
        'success',
        'Bingkai berhasil diperbarui.'
    );
}


    
/**
 * Hapus Gallery.
 */
public function destroy($id)
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

    // Hilangkan awalan storage/ jika ada
    $path = preg_replace('#^/?storage/#i', '', $path);
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
 * Hapus foto jika tidak lagi digunakan galeri atau bingkai.
 */
private function deleteLocalFileIfUnused(?string $path): void
{
    $localPath = $this->normalizeLocalPath($path);

    if (
        !$localPath ||
        !Storage::disk('public')->exists($localPath)
    ) {
        return;
    }

    // Periksa apakah foto masih digunakan data galeri
    $usedByGallery = Gallery::query()
        ->get(['image_path'])
        ->contains(function ($photo) use ($localPath) {
            return $this->normalizeLocalPath($photo->image_path)
                === $localPath;
        });

    // Periksa apakah foto masih digunakan Bingkai 1 atau Bingkai 2
    $usedByFrames = GallerySetting::query()
        ->get(['frame_1_image', 'frame_2_image'])
        ->contains(function ($setting) use ($localPath) {
            return $this->normalizeLocalPath($setting->frame_1_image)
                    === $localPath
                || $this->normalizeLocalPath($setting->frame_2_image)
                    === $localPath;
        });

    // Hapus hanya jika sudah tidak digunakan
    if (!$usedByGallery && !$usedByFrames) {
        Storage::disk('public')->delete($localPath);
    }
}

}
