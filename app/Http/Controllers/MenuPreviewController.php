<?php

namespace App\Http\Controllers;

use App\Models\MenuPreview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuPreviewController extends Controller
{
    /**
     * Tampilkan daftar preview menu.
     */
    public function index()
    {
        $menuPreviews = MenuPreview::orderBy('sort_order')
            ->orderBy('id')
            ->get();

       return view('menu-preview', compact('menuPreviews'));
    }

    /**
     * Tambah preview menu.
     */
    public function store(Request $request)
    {
        $request->validate([
            // Upload maksimal 1 MB
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',

            // Atau gunakan URL
            'image_url' => 'nullable|url|max:2048',

            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ], [
            'image_file.max' =>
                'Ukuran file lebih dari 1 MB. Harap kompres gambar terlebih dahulu hingga maksimal 1 MB.',
        ]);

        if (
            !$request->hasFile('image_file') &&
            !$request->filled('image_url')
        ) {
            return back()
                ->withErrors([
                    'image_file' => 'Silakan upload gambar atau masukkan URL gambar.',
                ])
                ->withInput();
        }

        /*
        |----------------------------------------------------------------------
        | TENTUKAN SUMBER GAMBAR
        |----------------------------------------------------------------------
        */

        if ($request->hasFile('image_file')) {
            $imagePath = $request->file('image_file')
                ->store('menu-previews', 'public');
        } else {
            $imagePath = $request->image_url;
        }

        MenuPreview::create([
            'image_path' => $imagePath,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with(
            'success',
            'Preview menu berhasil ditambahkan.'
        );
    }

    /**
     * Update preview menu.
     */
    
public function update(Request $request, $id)
{
    $menuPreview = MenuPreview::findOrFail($id);

    $request->validate([
        'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
        'image_url' => 'nullable|url|max:2048',
        'sort_order' => 'nullable|integer|min:0',
        'is_active' => 'nullable|boolean',
    ], [
        'image_file.max' =>
            'Ukuran file lebih dari 1 MB. Harap kompres gambar terlebih dahulu hingga maksimal 1 MB.',
    ]);

    // Simpan alamat gambar lama
    $oldImagePath = $menuPreview->image_path;

    // Jika tidak memilih gambar baru, gunakan gambar lama
    $imagePath = $oldImagePath;
    $newlyUploadedPath = null;

    // Jika mengunggah gambar baru
    if ($request->hasFile('image_file')) {
        $imagePath = $request->file('image_file')
            ->store('menu-previews', 'public');

        $newlyUploadedPath = $imagePath;
    }
    // Jika menggunakan URL gambar baru
    elseif ($request->filled('image_url')) {
        $imagePath = trim($request->input('image_url'));
    }

    // Perbarui data terlebih dahulu
    try {
        $menuPreview->update([
            'image_path' => $imagePath,
            'sort_order' => $request->input('sort_order', 0),
            'is_active' => $request->boolean('is_active'),
        ]);
    } catch (\Throwable $e) {
        // Jika penyimpanan data gagal, hapus file baru yang telanjur diunggah
        if ($newlyUploadedPath) {
            Storage::disk('public')->delete($newlyUploadedPath);
        }

        throw $e;
    }

    // Hapus gambar lama hanya jika alamat gambar berubah
    if (
        $this->normalizeLocalPath($oldImagePath) !==
        $this->normalizeLocalPath($imagePath)
    ) {
        $this->deleteLocalFileIfUnused($oldImagePath);
    }

    return back()->with(
        'success',
        'Preview menu berhasil diperbarui.'
    );
}


    /**
     * Hapus preview menu.
     */
    public function destroy($id)
{
    $menuPreview = MenuPreview::findOrFail($id);

    // Simpan alamat gambar sebelum data dihapus
    $oldImagePath = $menuPreview->image_path;

    // Hapus data preview dari database terlebih dahulu
    $deleted = $menuPreview->delete();

    // Hapus file jika sudah tidak digunakan preview lain
    if ($deleted) {
        $this->deleteLocalFileIfUnused($oldImagePath);
    }

    return back()->with(
        'success',
        'Preview menu berhasil dihapus.'
    );
}

    /**
 * Memeriksa dan menormalkan alamat gambar lokal.
 */
private function normalizeLocalPath(?string $path): ?string
{
    $path = trim((string) $path);

    // URL dari CDN atau website lain tidak diproses sebagai file lokal
    if ($path === '' || preg_match('#^https?://#i', $path)) {
        return null;
    }

    // Hilangkan awalan storage/ jika ada
    $path = preg_replace('#^/?storage/#i', '', $path);
    $path = ltrim($path, '/');

    // Batasi penghapusan hanya untuk folder menu-previews
    if (
        str_contains($path, '..') ||
        !str_starts_with($path, 'menu-previews/')
    ) {
        return null;
    }

    return $path;
}

/**
 * Menghapus gambar lama jika sudah tidak digunakan data lain.
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

    // Periksa apakah gambar masih dipakai preview lain
    $stillUsed = MenuPreview::query()
        ->get(['image_path'])
        ->contains(function ($preview) use ($localPath) {
            return $this->normalizeLocalPath($preview->image_path)
                === $localPath;
        });

    // Hapus file jika sudah tidak digunakan lagi
    if (!$stillUsed) {
        Storage::disk('public')->delete($localPath);
    }
}
}