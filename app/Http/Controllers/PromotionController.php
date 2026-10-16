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
     * Menambahkan promosi baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image_path' => 'nullable|string|max:500',
            'image_url' => 'nullable|url|max:500',
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',

            'is_home_popup' => 'nullable|boolean',
            'home_start_at' => 'nullable|date',
            'home_end_at' => 'nullable|date|after_or_equal:home_start_at',
        ]);

        /*
        |--------------------------------------------------------------------------
        | GAMBAR PROMO
        |--------------------------------------------------------------------------
        | Bisa menggunakan:
        | 1. Upload file
        | 2. URL gambar
        |--------------------------------------------------------------------------
        */

        $imagePath = null;

        if ($request->hasFile('image_file')) {

            $imagePath = $request
                ->file('image_file')
                ->store('promotions', 'public');

        } elseif (! empty($validated['image_url'])) {

            $imagePath = $validated['image_url'];

        }

        if (! $imagePath) {
            return back()
                ->withErrors([
                    'image_file' => 'Silakan upload file gambar atau masukkan URL gambar.',
                ])
                ->withInput();
        }

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

        return redirect()
            ->route('admin.promotions.index')
            ->with('success', 'Promosi berhasil ditambahkan.');
    }

    /**
     * Mengubah promosi.
     */
    public function update(Request $request, Promotion $promotion)
    {
        $validated = $request->validate([
            'image_url' => 'nullable|url|max:500',
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',

            'is_home_popup' => 'nullable|boolean',
            'home_start_at' => 'nullable|date',
            'home_end_at' => 'nullable|date|after_or_equal:home_start_at',
        ]);

        // Simpan path gambar lama
        $oldImagePath = $promotion->image_path;

        // Gambar lama tetap digunakan jika tidak ada gambar baru
        $imagePath = $oldImagePath;

        // Jika upload file baru
        if ($request->hasFile('image_file')) {

            // Simpan gambar baru
            $imagePath = $request
                ->file('image_file')
                ->store('promotions', 'public');

            // Hapus gambar lama jika merupakan file lokal
            if (
                $oldImagePath &&
                ! str_starts_with($oldImagePath, 'http://') &&
                ! str_starts_with($oldImagePath, 'https://') &&
                Storage::disk('public')->exists($oldImagePath)
            ) {
                Storage::disk('public')->delete($oldImagePath);
            }

            // Jika menggunakan URL baru
        } elseif (! empty($validated['image_url'])) {

            $imagePath = $validated['image_url'];

            // Hapus gambar lama jika merupakan file lokal
            if (
                $oldImagePath &&
                ! str_starts_with($oldImagePath, 'http://') &&
                ! str_starts_with($oldImagePath, 'https://') &&
                Storage::disk('public')->exists($oldImagePath)
            ) {
                Storage::disk('public')->delete($oldImagePath);
            }
        }

        $promotion->update([
            'image_path' => $imagePath,
            'is_active' => $request->boolean('is_home_popup') && $request->input('home_start_at')
                ? true
                : $request->boolean('is_active'),
            'sort_order' => $validated['sort_order'] ?? 0,

            'is_home_popup' => $request->boolean('is_home_popup'),
            'home_start_at' => $validated['home_start_at'] ?? null,
            'home_end_at' => $validated['home_end_at'] ?? null,
        ]);

        return redirect()
            ->route('admin.promotions.index')
            ->with('success', 'Promosi berhasil diperbarui.');
    }

    /**
     * Menghapus promosi.
     */
    public function destroy(Promotion $promotion)
    {
        // Hapus file gambar jika merupakan file lokal
        if (
            $promotion->image_path &&
            ! str_starts_with($promotion->image_path, 'http://') &&
            ! str_starts_with($promotion->image_path, 'https://') &&
            Storage::disk('public')->exists($promotion->image_path)
        ) {
            Storage::disk('public')->delete($promotion->image_path);
        }

        // Hapus data promosi dari database
        $promotion->delete();

        return redirect()
            ->route('admin.promotions.index')
            ->with('success', 'Promosi berhasil dihapus.');
    }
}
