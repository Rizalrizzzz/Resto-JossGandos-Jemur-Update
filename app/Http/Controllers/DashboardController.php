<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\HeaderSetting;
use App\Models\Menu;
use App\Models\OrderButton;
use App\Models\Promotion;
use App\Models\ServicePackage;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        // =========================================================
        // 1. CEK SESSION ADMIN
        // =========================================================
        if (! session()->has('account_id')) {
            return redirect()
                ->route('login.form')
                ->with(
                    'error',
                    'Session anda telah habis, silakan login ulang.'
                );
        }

        // =========================================================
        // 2. HITUNG DATA CARD OVERVIEW
        // =========================================================

        // Galeri
        $galleryCount = Gallery::count();

        // Menu
        $menuCount = Menu::count();

        // Testimoni
        $testimonialCount = Testimonial::count();

        // Promo / Event
        $eventCount = Promotion::count();

        // Service Package
        // package_menu    = Catering Package
        // wedding_package = Wedding Package
        // box_package     = Box Package
        $cateringPackageCount = ServicePackage::where(
            'category',
            'package_menu'
        )->count();

        $weddingPackageCount = ServicePackage::where(
            'category',
            'wedding_package'
        )->count();

        $boxPackageCount = ServicePackage::where(
            'category',
            'box_package'
        )->count();

        // =========================================================
        // 3. DATA UNTUK TABEL OVERVIEW
        // =========================================================

        // Daftar Menu
        $menus = Menu::latest()->get();

        // Galeri Foto
        $photos = Gallery::latest()->get();

        // Promosi
        $promotions = Promotion::latest()->get();

        // Service Package
        $servicePackages = ServicePackage::latest()->get();

        // =========================================================
        // 4. PENGATURAN HEADER VIDEO
        // =========================================================

        $header = HeaderSetting::firstOrNew();

        // =========================================================
        // 4.5 DATA ORDER NOW
        // =========================================================

        $orderButtons = OrderButton::orderBy('id')->get();

        // =========================================================
        // 5. KIRIM SEMUA DATA KE VIEW DASHBOARD
        // =========================================================

        return response()
            ->view('dashboard', compact(
                'photos',
                'menus',
                'promotions',
                'servicePackages',
                'header',
                'orderButtons',

                // Card utama
                'galleryCount',
                'menuCount',
                'testimonialCount',
                'eventCount',

                // Card Service Package
                'cateringPackageCount',
                'weddingPackageCount',
                'boxPackageCount'
            ))
            ->header(
                'Cache-Control',
                'no-cache, no-store, must-revalidate'
            )
            ->header(
                'Pragma',
                'no-cache'
            )
            ->header(
                'Expires',
                '0'
            );
    }

    /**
     * =============================================================
     * UPDATE VIDEO HEADER
     * =============================================================
     */
   

public function updateHeader(Request $request)
{
    // Hanya menerima sumber video berupa file upload
    $validated = $request->validate([
        'source_type' => 'required|in:file',

        'video_file' => [
            'nullable',
            'file',
            'mimetypes:video/mp4,video/quicktime',
            'max:40960', // Maksimal 40 MB
        ],
    ]);

    // Ambil pengaturan header yang sudah tersimpan
    $header = HeaderSetting::firstOrNew();

    // Simpan path video lama agar dapat dihapus setelah file baru tersimpan
    $oldVideoPath = $header->video_path;

    // Jika belum ada video lama dan tidak mengunggah video baru
    if (
        !$request->hasFile('video_file') &&
        empty($oldVideoPath)
    ) {
        return back()
            ->withErrors([
                'video_file' => 'Silakan upload video header terlebih dahulu.',
            ])
            ->withInput();
    }

    // Jika admin mengunggah video baru
    if ($request->hasFile('video_file')) {
        $newVideoPath = $request
            ->file('video_file')
            ->store('headers', 'public');

        // Pastikan proses penyimpanan menghasilkan path
        if (!$newVideoPath) {
            return back()
                ->withErrors([
                    'video_file' => 'Video gagal disimpan. Silakan coba lagi.',
                ])
                ->withInput();
        }

        $header->video_path = $newVideoPath;
    }

    // Tetapkan sumber video hanya berupa file
    $header->video_type = 'file';

    // Kosongkan referensi sumber video lama
    $header->youtube_id = null;
    $header->tiktok_url = null;

    // Simpan pengaturan header
    $header->save();

    // Hapus video lama setelah pengaturan berhasil disimpan
    if (
        $request->hasFile('video_file') &&
        $oldVideoPath &&
        $oldVideoPath !== $header->video_path &&
        Storage::disk('public')->exists($oldVideoPath)
    ) {
        Storage::disk('public')->delete($oldVideoPath);
    }

    return back()->with(
        'success',
        'Video Header berhasil diperbarui!'
    );
}


}
