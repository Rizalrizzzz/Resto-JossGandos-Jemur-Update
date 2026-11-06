<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromotionController extends Controller
{
    /**
     * Menampilkan halaman Kelola Promosi.
     */
    public function index()
    {
        $promotions = Promotion::orderBy('sort_order')
            ->orderByDesc('created_at')
            ->get();

        return view('adminpromosi', compact('promotions'));
    }

    /**
     * Menambahkan promosi baru. Gambar wajib diunggah dari perangkat.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image_file' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'is_home_popup' => 'nullable|boolean',
            'home_start_at' => 'nullable|date',
            'home_end_at' => 'nullable|date|after_or_equal:home_start_at',
        ], [
            'image_file.required' => 'Silakan pilih gambar promosi.',
            'image_file.image' => 'File harus berupa gambar.',
            'image_file.mimes' => 'Format gambar harus JPG, PNG, atau WebP.',
            'image_file.max' => 'Ukuran foto maksimal 2 MB. Pilih foto maksimal 2 MB.',
        ]);

        $imagePath = $request->file('image_file')->store('promotions', 'public');

        try {
            Promotion::create([
                'image_path' => $imagePath,
                'is_active' => $request->boolean('is_home_popup')
                    ? true
                    : $request->boolean('is_active'),
                'sort_order' => $validated['sort_order'] ?? 0,
                'is_home_popup' => $request->boolean('is_home_popup'),
                'home_start_at' => $validated['home_start_at'] ?? null,
                'home_end_at' => $validated['home_end_at'] ?? null,
            ]);
        } catch (\Throwable $e) {
            // Hapus file baru jika penyimpanan data gagal.
            Storage::disk('public')->delete($imagePath);
            throw $e;
        }

        return redirect()
            ->route('admin.promotions.index')
            ->with('success', 'Promosi berhasil ditambahkan.');
    }

    /**
     * Mengubah promosi. Gambar lama tetap digunakan jika tidak ada file baru.
     */
    public function update(Request $request, Promotion $promotion)
    {
        $validated = $request->validate([
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'is_home_popup' => 'nullable|boolean',
            'home_start_at' => 'nullable|date',
            'home_end_at' => 'nullable|date|after_or_equal:home_start_at',
        ], [
            'image_file.image' => 'File harus berupa gambar.',
            'image_file.mimes' => 'Format gambar harus JPG, PNG, atau WebP.',
            'image_file.max' => 'Ukuran foto maksimal 2 MB. Pilih foto maksimal 2 MB.',
        ]);

        $oldImagePath = $promotion->image_path;
        $imagePath = $oldImagePath;
        $newImagePath = null;

        // Ganti gambar hanya jika pengguna memilih file baru.
        if ($request->hasFile('image_file')) {
            $newImagePath = $request->file('image_file')->store('promotions', 'public');
            $imagePath = $newImagePath;
        }

        try {
            $promotion->update([
                'image_path' => $imagePath,
                'is_active' => $request->boolean('is_home_popup') && $request->input('home_start_at')
                    ? true
                    : $request->boolean('is_active'),
                'sort_order' => $validated['sort_order'] ?? $promotion->sort_order,
                'is_home_popup' => $request->boolean('is_home_popup'),
                'home_start_at' => $validated['home_start_at'] ?? null,
                'home_end_at' => $validated['home_end_at'] ?? null,
            ]);
        } catch (\Throwable $e) {
            // Hapus file baru jika pembaruan data gagal.
            if ($newImagePath) {
                Storage::disk('public')->delete($newImagePath);
            }
            throw $e;
        }

        // Hapus gambar lama setelah data berhasil diperbarui dan jika tidak dipakai lagi.
        if ($newImagePath && $oldImagePath && $oldImagePath !== $newImagePath) {
            $this->deleteLocalImageIfUnused($oldImagePath);
        }

        return redirect()
            ->route('admin.promotions.index')
            ->with('success', 'Promosi berhasil diperbarui.');
    }

    /**
     * Menghapus promosi.
     */
    public function destroy(Promotion $promotion)
    {
        $oldImagePath = $promotion->image_path;
        $deleted = $promotion->delete();

        // Hapus file hanya jika data berhasil dihapus dan gambar tidak dipakai lagi.
        if ($deleted) {
            $this->deleteLocalImageIfUnused($oldImagePath);
        }

        return redirect()
            ->route('admin.promotions.index')
            ->with('success', 'Promosi berhasil dihapus.');
    }

    /**
     * Hapus gambar lokal jika sudah tidak digunakan promosi lain.
     * URL eksternal dan file di luar folder promotions tidak dihapus.
     */
    private function deleteLocalImageIfUnused(?string $path): void
    {
        $localPath = trim((string) $path);

        if ($localPath === '' || preg_match('#^https?://#i', $localPath)) {
            return;
        }

        $localPath = preg_replace('#^/?storage/#i', '', $localPath);
        $localPath = ltrim($localPath, '/');

        if (
            str_contains($localPath, '..') ||
            !str_starts_with($localPath, 'promotions/') ||
            !Storage::disk('public')->exists($localPath)
        ) {
            return;
        }

        $stillUsed = Promotion::where('image_path', $path)->exists();

        if (!$stillUsed) {
            Storage::disk('public')->delete($localPath);
        }
    }
}
