<?php

namespace App\Http\Controllers;

use App\Models\ServicePackage;
use App\Models\PackageSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServicePackageController extends Controller
{
    /**
     * Menampilkan halaman admin Paket & Layanan.
     */
    public function index()
    {
        $packages = ServicePackage::orderBy('sort_order')
            ->orderByDesc('created_at')
            ->get();

        $settings = PackageSetting::first();

        return view('service-package-admin', compact(
        'packages',
        'settings'));
    }

    /**
     * Menambahkan paket.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',

            // Harga berupa teks bebas, contoh: 70000/pack
            'price' => 'nullable|string|max:100',

            // Hanya Package Menu yang menggunakan kapasitas
            'capacity' => 'nullable|string|max:100',

            'description' => 'nullable|string',

            // Hanya 3 kategori yang digunakan
            'category' => 'required|in:package_menu,catering_package,wedding_package',

            'sort_order' => 'nullable|integer|min:0',

            'is_active' => 'nullable|boolean',

            // Maksimal 1 MB
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',

            'image_url' => 'nullable|url|max:500',
        ], [
            'image_file.max' => 'Ukuran file lebih dari 1 MB. Harap kompres gambar terlebih dahulu hingga maksimal 1 MB.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | CEK GAMBAR
        |--------------------------------------------------------------------------
        */

        if (
            ! $request->hasFile('image_file') &&
            ! $request->filled('image_url')
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
                ->store('service-packages', 'public');

            /*
             * Simpan:
             * service-packages/nama-file.jpg
             */
            $imagePath = $path;

        } else {

            $imagePath = $request->input('image_url');
        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA
        |--------------------------------------------------------------------------
        */

        ServicePackage::create([
            'title' => $request->title,

            'price' => $request->price,

            'capacity' => $request->capacity,

            'description' => $request->description,

            'image_path' => $imagePath,

            'category' => $request->category,

            'sort_order' => $request->sort_order ?? 0,

            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with(
            'success',
            'Paket berhasil ditambahkan.'
        );
    }

    /**
     * Mengubah paket.
     */
    
public function update(Request $request, $id)
{
    $package = ServicePackage::findOrFail($id);

    $request->validate([
        'title' => 'required|string|max:255',
        'price' => 'nullable|string|max:100',
        'capacity' => 'nullable|string|max:100',
        'description' => 'nullable|string',
        'category' => 'required|in:package_menu,catering_package,wedding_package',
        'sort_order' => 'nullable|integer|min:0',
        'is_active' => 'nullable|boolean',
        'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
        'image_url' => 'nullable|url|max:500',
    ], [
        'image_file.max' =>
            'Ukuran file lebih dari 1 MB. Harap kompres gambar terlebih dahulu hingga maksimal 1 MB.',
    ]);

    // Simpan alamat gambar lama
    $oldImagePath = $package->image_path;

    // Gunakan gambar lama jika tidak ada gambar pengganti
    $imagePath = $oldImagePath;
    $newlyUploadedPath = null;

    // Jika mengunggah gambar baru
    if ($request->hasFile('image_file')) {
        $imagePath = $request->file('image_file')
            ->store('service-packages', 'public');

        $newlyUploadedPath = $imagePath;
    }
    // Jika menggunakan URL gambar baru
    elseif ($request->filled('image_url')) {
        $imagePath = trim($request->input('image_url'));
    }

    // Perbarui database terlebih dahulu
    try {
        $package->update([
            'title' => $request->title,
            'price' => $request->price,
            'capacity' => $request->capacity,
            'description' => $request->description,
            'image_path' => $imagePath,
            'category' => $request->category,
            'sort_order' => $request->input('sort_order') ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);
    } catch (\Throwable $e) {
        // Bersihkan gambar baru jika penyimpanan data gagal
        if ($newlyUploadedPath) {
            Storage::disk('public')->delete($newlyUploadedPath);
        }

        throw $e;
    }

    // Bersihkan gambar lama jika alamatnya berubah
    if (
        $this->normalizeLocalPath($oldImagePath) !==
        $this->normalizeLocalPath($imagePath)
    ) {
        $this->deleteLocalFileIfUnused($oldImagePath);
    }

    return back()->with(
        'success',
        'Paket berhasil diperbarui.'
    );
}


    
/**
 * Menghapus paket.
 */
public function destroy($id)
{
    $package = ServicePackage::findOrFail($id);

    // Simpan alamat foto sebelum data dihapus
    $oldImagePath = $package->image_path;

    // Hapus data paket dari database terlebih dahulu
    $deleted = $package->delete();

    // Hapus foto jika sudah tidak digunakan paket lain
    if ($deleted) {
        $this->deleteLocalFileIfUnused($oldImagePath);
    }

    return back()->with(
        'success',
        'Paket berhasil dihapus.'
    );
}



    /**
 * Memeriksa dan menormalkan alamat gambar lokal.
 */
private function normalizeLocalPath(?string $path): ?string
{
    $path = trim((string) $path);

    // URL eksternal tidak diproses sebagai file lokal
    if ($path === '' || preg_match('#^https?://#i', $path)) {
        return null;
    }

    // Hilangkan awalan storage/ jika ada
    $path = preg_replace('#^/?storage/#i', '', $path);
    $path = ltrim($path, '/');

    // Batasi penghapusan hanya untuk folder service-packages
    if (
        str_contains($path, '..') ||
        !str_starts_with($path, 'service-packages/')
    ) {
        return null;
    }

    return $path;
}

/**
 * Menghapus foto jika sudah tidak digunakan paket lain.
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

    // Periksa apakah foto masih digunakan paket lain
    $stillUsed = ServicePackage::query()
        ->get(['image_path'])
        ->contains(function ($package) use ($localPath) {
            return $this->normalizeLocalPath($package->image_path)
                === $localPath;
        });

    // Hapus foto hanya jika sudah tidak digunakan
    if (!$stillUsed) {
        Storage::disk('public')->delete($localPath);
    }
}
}
