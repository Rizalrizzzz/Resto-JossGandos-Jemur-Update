<?php

namespace App\Http\Controllers;

use App\Models\OrderButton;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderButtonController extends Controller
{

    public function update(Request $request, OrderButton $orderButton)
    {
        if (! session()->has('account_id')) {
            return redirect()
                ->route('login.form')
                ->with(
                    'error',
                    'Session anda telah habis, silakan login ulang.'
                );
        }

        // Tidak menerima URL gambar lagi. Gambar hanya dapat diganti lewat Choose File.
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'required|string|max:500',
            'icon_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'icon_file.image' => 'File ikon harus berupa gambar.',
            'icon_file.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WebP.',
            'icon_file.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        $oldIcon = $orderButton->icon;
        $newIconPath = null;

        $orderButton->title = $validated['title'];
        $orderButton->link = $validated['link'];

        // Jika admin memilih file baru, simpan dahulu; gambar lama jangan dihapus dulu.
        if ($request->hasFile('icon_file')) {
            $newIconPath = $request->file('icon_file')->store('order-buttons', 'public');

            if (! $newIconPath) {
                return back()
                    ->withErrors([
                        'icon_file' => 'Gambar gagal disimpan. Silakan coba lagi.',
                    ])
                    ->withInput();
            }

            $orderButton->icon = $newIconPath;
        }
        // Jika tidak memilih file baru, icon lama tetap digunakan.

        try {
            $orderButton->save();
        } catch (\Throwable $e) {
            // Bersihkan file baru jika update database gagal.
            if ($newIconPath) {
                Storage::disk('public')->delete($newIconPath);
            }

            throw $e;
        }

        // Hapus gambar lama setelah perubahan berhasil dan hanya jika tidak dipakai data lain.
        if ($newIconPath && $oldIcon && $oldIcon !== $newIconPath) {
            $this->deleteOldIconIfUnused($oldIcon, $orderButton->id);
        }

        return redirect()
            ->back()
            ->with('success', 'Order Now berhasil diperbarui.');
    }

    /**
     * Normalisasi hanya file upload dalam folder order-buttons.
     * URL eksternal dan file bawaan public/img tidak akan pernah dihapus.
     */
    private function normalizeLocalOrderIcon(?string $value): ?string
    {
        $path = trim((string) $value);

        if ($path === '' || filter_var($path, FILTER_VALIDATE_URL)) {
            return null;
        }

        $path = ltrim($path, '/');

        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, strlen('storage/'));
        } elseif (str_starts_with($path, 'public/')) {
            $path = substr($path, strlen('public/'));
        }

        if (str_contains($path, '..') || ! str_starts_with($path, 'order-buttons/')) {
            return null;
        }

        return $path;
    }

    /** Hapus file lama hanya jika tidak lagi digunakan tombol Order Now lain. */
    private function deleteOldIconIfUnused(string $oldIcon, int $currentId): void
    {
        $localPath = $this->normalizeLocalOrderIcon($oldIcon);

        if (! $localPath || ! Storage::disk('public')->exists($localPath)) {
            return;
        }

        $isStillUsed = OrderButton::query()
            ->where('id', '!=', $currentId)
            ->get(['icon'])
            ->contains(function ($item) use ($localPath) {
                return $this->normalizeLocalOrderIcon($item->icon) === $localPath;
            });

        if (! $isStillUsed) {
            Storage::disk('public')->delete($localPath);
        }
    }
}
