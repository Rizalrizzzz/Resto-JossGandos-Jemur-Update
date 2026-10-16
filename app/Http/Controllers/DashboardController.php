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
    // Validasi input dari admin
    $validated = $request->validate([
        'source_type' => 'required|in:youtube,tiktok,file',

        'youtube_url' => [
            'nullable',
            'required_if:source_type,youtube',
            'url',
            'max:500',
        ],

        'tiktok_url' => [
            'nullable',
            'required_if:source_type,tiktok',
            'url',
            'max:500',
            function ($attribute, $value, $fail) use ($request) {
                if ($request->input('source_type') !== 'tiktok' || !$value) {
                    return;
                }

                $host = strtolower(
                    parse_url($value, PHP_URL_HOST) ?? ''
                );

                $path = parse_url($value, PHP_URL_PATH) ?? '';

                if (!in_array($host, [
                    'tiktok.com',
                    'www.tiktok.com',
                    'm.tiktok.com',
                ], true)) {
                    $fail('Gunakan link video dari TikTok.');
                    return;
                }

                if (!preg_match('~/@[^/]+/video/\d+~', $path)) {
                    $fail(
                        'Gunakan link lengkap TikTok yang memuat ID video, bukan link pendek.'
                    );
                }
            },
        ],

        'video_file' => [
            'nullable',
            'required_if:source_type,file',
            'file',
            'mimetypes:video/mp4,video/quicktime',
            'max:20480',
        ],
    ]);

    $sourceType = $validated['source_type'];
    $youtubeId = null;

    // Ambil ID dari URL YouTube
    if ($sourceType === 'youtube') {
        $url = $validated['youtube_url'];
        $host = strtolower(parse_url($url, PHP_URL_HOST) ?? '');
        $path = parse_url($url, PHP_URL_PATH) ?? '';

        parse_str(
            parse_url($url, PHP_URL_QUERY) ?? '',
            $query
        );

        if ($host === 'youtu.be') {
            $youtubeId = explode('/', trim($path, '/'))[0] ?? null;
        } else {
            $youtubeId = $query['v'] ?? null;

            if (
                !$youtubeId &&
                preg_match(
                    '~/(?:embed|shorts|live|v)/([A-Za-z0-9_-]{11})(?:/|$)~',
                    $path,
                    $match
                )
            ) {
                $youtubeId = $match[1];
            }
        }

        // Jangan menyimpan URL jika ID video tidak ditemukan
        if (
            !$youtubeId ||
            !preg_match('/^[A-Za-z0-9_-]{11}$/', $youtubeId)
        ) {
            return back()
                ->withErrors([
                    'youtube_url' =>
                        'URL YouTube tidak valid. Masukkan link video YouTube yang lengkap.',
                ])
                ->withInput();
        }

        // Batasi sumber ke domain YouTube
        $allowedYoutubeHosts = [
            'youtube.com',
            'www.youtube.com',
            'm.youtube.com',
            'youtu.be',
            'youtube-nocookie.com',
            'www.youtube-nocookie.com',
        ];

        if (!in_array($host, $allowedYoutubeHosts, true)) {
            return back()
                ->withErrors([
                    'youtube_url' => 'Gunakan link dari YouTube.',
                ])
                ->withInput();
        }
    }

    // Ambil pengaturan header yang sudah tersimpan
    $header = HeaderSetting::firstOrNew();

    // Simpan jenis sumber video
    $header->video_type = $sourceType;

    // Jika sumber YouTube
    if ($sourceType === 'youtube') {
        $header->youtube_id = $youtubeId;
    }

    // Jika sumber TikTok, simpan URL lengkapnya
    if ($sourceType === 'tiktok') {
        $header->tiktok_url = $validated['tiktok_url'];
    }

    // Jika sumber upload file
    if ($sourceType === 'file') {
        // Hapus file lama jika ada file baru yang diunggah
        if ($request->hasFile('video_file')) {
            if (
                $header->video_path &&
                Storage::disk('public')->exists($header->video_path)
            ) {
                Storage::disk('public')->delete($header->video_path);
            }

            $header->video_path = $request
                ->file('video_file')
                ->store('headers', 'public');
        }
    }

    $header->save();

    return back()->with(
        'success',
        'Video Header berhasil diperbarui!'
    );
}

}
