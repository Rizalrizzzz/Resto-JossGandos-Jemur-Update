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
     * Tambah preview menu. Gambar wajib diunggah dari perangkat.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image_file' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ], [
            'image_file.required' => 'Silakan pilih gambar preview menu.',
            'image_file.image' => 'File yang dipilih harus berupa gambar.',
            'image_file.mimes' => 'Format gambar harus JPG, PNG, atau WebP.',
            'image_file.max' => 'Ukuran foto maksimal 2 MB. Silakan kompres gambar terlebih dahulu.',
        ]);

        $imagePath = $request->file('image_file')->store('menu-previews', 'public');

        try {
            MenuPreview::create([
                'image_path' => $imagePath,
                'sort_order' => $validated['sort_order'] ?? 1,
                'is_active' => $request->boolean('is_active', true),
            ]);
        } catch (\Throwable $e) {
            // Bersihkan file baru jika penyimpanan ke database gagal.
            Storage::disk('public')->delete($imagePath);
            throw $e;
        }

        return back()->with('success', 'Preview menu berhasil ditambahkan.');
    }

    /**
     * Update preview. Gambar lokal lama dipertahankan jika valid dan tidak ada file baru.
     */
    public function update(Request $request, int $id)
    {
        $menuPreview = MenuPreview::findOrFail($id);
        $oldImagePath = $menuPreview->image_path;
        $oldLocalPath = $this->normalizeLocalPath($oldImagePath);

        $validated = $request->validate([
            // Jika gambar lama bukan path lokal yang valid, gambar baru wajib diunggah.
            'image_file' => ($oldLocalPath ? 'nullable' : 'required') . '|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
        ], [
            'image_file.required' => 'Silakan pilih gambar lokal pengganti.',
            'image_file.image' => 'File yang dipilih harus berupa gambar.',
            'image_file.mimes' => 'Format gambar harus JPG, PNG, atau WebP.',
            'image_file.max' => 'Ukuran foto maksimal 2 MB. Silakan kompres gambar terlebih dahulu.',
        ]);

        // Gunakan hanya path lokal yang valid sebagai nilai awal.
        $imagePath = $oldLocalPath;
        $newlyUploadedPath = null;

        if ($request->hasFile('image_file')) {
            $newlyUploadedPath = $request->file('image_file')->store('menu-previews', 'public');
            $imagePath = $newlyUploadedPath;
        }

        try {
            $menuPreview->update([
                'image_path' => $imagePath,
                'sort_order' => $validated['sort_order'] ?? $menuPreview->sort_order,
                'is_active' => $request->boolean('is_active'),
            ]);
        } catch (\Throwable $e) {
            // Jangan tinggalkan file baru jika update database gagal.
            if ($newlyUploadedPath) {
                Storage::disk('public')->delete($newlyUploadedPath);
            }
            throw $e;
        }

        // Hapus gambar lama hanya jika diganti dan tidak dipakai lagi.
        if ($newlyUploadedPath && $this->normalizeLocalPath($oldImagePath) !== $this->normalizeLocalPath($imagePath)) {
            $this->deleteLocalFileIfUnused($oldImagePath);
        }

        return back()->with('success', 'Preview menu berhasil diperbarui.');
    }

    /**
     * Hapus preview menu.
     */
    public function destroy(int $id)
    {
        $menuPreview = MenuPreview::findOrFail($id);
        $oldImagePath = $menuPreview->image_path;

        $deleted = $menuPreview->delete();

        if ($deleted) {
            $this->deleteLocalFileIfUnused($oldImagePath);
        }

        return back()->with('success', 'Preview menu berhasil dihapus.');
    }

    /**
     * Normalisasi lokasi gambar lokal dan batasi ke folder menu-previews.
     */
    private function normalizeLocalPath(?string $path): ?string
    {
        $path = trim((string) $path);

        // URL eksternal bukan file lokal.
        if ($path === '' || preg_match('#^(?:https?:)?//#i', $path) || preg_match('#^(?:data|blob):#i', $path)) {
            return null;
        }

        $path = preg_replace('#^/?storage/#i', '', $path);
        $path = ltrim($path, '/');

        if (str_contains($path, '..') || !str_starts_with($path, 'menu-previews/')) {
            return null;
        }

        return $path;
    }

    /**
     * Hapus gambar dari penyimpanan hanya jika tidak digunakan preview lain.
     */
    private function deleteLocalFileIfUnused(?string $path): void
    {
        $localPath = $this->normalizeLocalPath($path);

        if (!$localPath || !Storage::disk('public')->exists($localPath)) {
            return;
        }

        $stillUsed = MenuPreview::query()
            ->get(['image_path'])
            ->contains(function ($preview) use ($localPath) {
                return $this->normalizeLocalPath($preview->image_path) === $localPath;
            });

        if (!$stillUsed) {
            Storage::disk('public')->delete($localPath);
        }
    }
}
