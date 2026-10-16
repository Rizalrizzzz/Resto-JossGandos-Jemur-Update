<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StatistikController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | 1. CEK SESSION ADMIN
        |--------------------------------------------------------------------------
        */

        if (! session()->has('account_id')) {
            return redirect()
                ->route('login.form')
                ->with(
                    'error',
                    'Session anda telah habis, silakan login ulang.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | TAHUN BERJALAN
        |--------------------------------------------------------------------------
        | Semua statistik tahunan menggunakan tahun ini.
        |--------------------------------------------------------------------------
        */

        $currentYear = Carbon::now()->year;

        /*
        |--------------------------------------------------------------------------
        | 2. TOTAL PENGUNJUNG
        |--------------------------------------------------------------------------
        | Total unik berdasarkan session_id.
        | Ini tetap keseluruhan data pengunjung.
        |--------------------------------------------------------------------------
        */

        $totalVisitors = Visit::whereYear('created_at', $currentYear)
            ->whereNotNull('session_id')
            ->distinct('session_id')
            ->count('session_id');

        /*
        |--------------------------------------------------------------------------
        | 3. PENGUNJUNG HARI INI
        |--------------------------------------------------------------------------
        | Pengunjung unik pada hari ini.
        |--------------------------------------------------------------------------
        */

        $todayVisitors = Visit::whereDate(
            'created_at',
            Carbon::today()
        )
            ->whereNotNull('session_id')
            ->distinct('session_id')
            ->count('session_id');

        /*
        |--------------------------------------------------------------------------
        | 4. KUNJUNGAN ULANG
        |--------------------------------------------------------------------------
        | Session yang datang pada lebih dari satu tanggal berbeda.
        |--------------------------------------------------------------------------
        */

        $returningVisitors = DB::table('visits')
            ->select('session_id')
            ->whereNotNull('session_id')
            ->whereYear('created_at', $currentYear)
            ->groupBy('session_id')
            ->having(
                DB::raw('COUNT(DISTINCT DATE(created_at))'),
                '>',
                1
            )
            ->get()
            ->count();

        $repeatRate = $totalVisitors > 0
            ? round(
                ($returningVisitors / $totalVisitors) * 100
            )
            : 0;

        /*
        |--------------------------------------------------------------------------
        | 5. DURASI RATA-RATA
        |--------------------------------------------------------------------------
        */

        $visitsWithDuration = Visit::whereNotNull('last_activity')
            ->whereYear('created_at', $currentYear)
            ->get();

        $avgSeconds = $visitsWithDuration->avg(
            function ($visit) {

                if (
                    empty($visit->created_at) ||
                    empty($visit->last_activity)
                ) {
                    return 0;
                }

                $start = Carbon::parse(
                    $visit->created_at
                );

                $end = Carbon::parse(
                    $visit->last_activity
                );

                return max(
                    0,
                    $end->diffInSeconds($start)
                );
            }
        );

        $avgDuration = '0m 0s';

        if ($avgSeconds) {

            $minutes = floor(
                $avgSeconds / 60
            );

            $seconds = round(
                $avgSeconds % 60
            );

            if ($seconds >= 60) {
                $minutes++;
                $seconds = 0;
            }

            $avgDuration = "{$minutes}m {$seconds}s";
        }

        /*
        |--------------------------------------------------------------------------
        | 6. GRAFIK PENGUNJUNG BULANAN
        |--------------------------------------------------------------------------
        | HANYA tahun berjalan.
        |
        | Ketika tahun berubah:
        | 2026 -> memakai data 2026
        | 2027 -> memakai data 2027
        |
        | Jika belum ada data di tahun baru,
        | seluruh bulan otomatis bernilai 0.
        |--------------------------------------------------------------------------
        */

        $monthlyLabels = [];
        $monthlyData = [];

        for ($month = 1; $month <= 12; $month++) {

            $date = Carbon::create(
                $currentYear,
                $month,
                1
            );

            $monthlyLabels[] = $date->translatedFormat(
                'M'
            );

            $visitorsThisMonth = Visit::whereYear(
                'created_at',
                $currentYear
            )
                ->whereMonth(
                    'created_at',
                    $month
                )
                ->whereNotNull('session_id')
                ->distinct('session_id')
                ->count('session_id');

            $monthlyData[] = $visitorsThisMonth;
        }

        /*
        |--------------------------------------------------------------------------
        | 7. HALAMAN PALING BANYAK DILIHAT
        |--------------------------------------------------------------------------
        | Hanya tahun berjalan.
        |
        | Lima halaman utama tetap ditampilkan:
        | Home
        | About
        | Menu
        | Gallery
        | Reservation
        |
        | Jika belum ada kunjungan -> 0.
        |--------------------------------------------------------------------------
        */

        $pageVisitData = Visit::select(
            'url',
            DB::raw('COUNT(*) as total_views')
        )
            ->whereNotNull('url')
            ->where('url', '!=', '')
            ->whereYear('created_at', $currentYear)
            ->groupBy('url')
            ->get()
            ->map(function ($visit) {

                $path = parse_url(
                    $visit->url,
                    PHP_URL_PATH
                );

                $path = $path ?: '/';

                switch ($path) {

                    case '/':
                    case '/public':
                        $name = 'Home';
                        break;

                    case '/about':
                        $name = 'About';
                        break;

                    case '/menu':
                        $name = 'Menu';
                        break;

                    case '/gallery':
                        $name = 'Gallery';
                        break;

                    case '/reservation':
                        $name = 'Reservation';
                        break;

                    default:

                        $cleanName = trim(
                            $path,
                            '/'
                        );

                        $name = $cleanName === ''
                            ? 'Home'
                            : ucwords(
                                str_replace(
                                    ['-', '_'],
                                    ' ',
                                    $cleanName
                                )
                            );

                        break;
                }

                return [
                    'name' => $name,
                    'total' => (int) $visit->total_views,
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | GABUNGKAN URL YANG MEMILIKI NAMA HALAMAN SAMA
        |--------------------------------------------------------------------------
        | Contoh:
        | /menu
        | /menu?category=makanan
        |
        | Tetap dihitung sebagai "Menu".
        |--------------------------------------------------------------------------
        */

        $pageVisitData = $pageVisitData
            ->groupBy('name')
            ->map(function ($rows, $name) {

                return [
                    'name' => $name,
                    'total' => $rows->sum('total'),
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | HALAMAN DEFAULT
        |--------------------------------------------------------------------------
        | Selalu tampil walaupun belum ada data.
        |--------------------------------------------------------------------------
        */

        $defaultPages = collect([
            'Home',
            'About',
            'Menu',
            'Gallery',
            'Reservation',
        ]);

        /*
        |--------------------------------------------------------------------------
        | GABUNGKAN DATA AKTUAL DENGAN HALAMAN DEFAULT
        |--------------------------------------------------------------------------
        */

        $popularPages = $defaultPages
            ->map(function ($name) use ($pageVisitData) {

                return [
                    'name' => $name,

                    'total' => (int) (
                        $pageVisitData
                            ->get($name)['total'] ?? 0
                    ),
                ];
            })
            ->sortByDesc('total')
            ->values();

        /*
        |--------------------------------------------------------------------------
        | 8. KLIK WHATSAPP
        |--------------------------------------------------------------------------
        | Mengambil data dari tabel whatsapp_clicks.
        |--------------------------------------------------------------------------
        */

        $whatsappClicks = 0;

        if (Schema::hasTable('whatsapp_clicks')) {
            $whatsappClicks = DB::table('whatsapp_clicks')
                ->whereYear('created_at', $currentYear)
                ->count();
        }       

        /*
        |--------------------------------------------------------------------------
        | 9. DATA UNTUK VIEW
        |--------------------------------------------------------------------------
        */

        $data = [
            'currentYear' => $currentYear,

            /*
            |--------------------------------------------------------------------------
            | KARTU STATISTIK
            |--------------------------------------------------------------------------
            */

            'totalVisitors' => number_format(
                $totalVisitors,
                0,
                ',',
                '.'
            ),

            'todayVisitors' => number_format(
                $todayVisitors,
                0,
                ',',
                '.'
            ),

            'whatsappClicks' => number_format(
                $whatsappClicks,
                0,
                ',',
                '.'
            ),

            'repeatRate' => $repeatRate,

            /*
            |--------------------------------------------------------------------------
            | DURASI
            |--------------------------------------------------------------------------
            */

            'avgDuration' => $avgDuration,

            /*
            |--------------------------------------------------------------------------
            | GRAFIK
            |--------------------------------------------------------------------------
            */

            'monthlyLabels' => $monthlyLabels,

            'monthlyData' => $monthlyData,

            /*
            |--------------------------------------------------------------------------
            | HALAMAN TERPOPULER
            |--------------------------------------------------------------------------
            */

            'popularPages' => $popularPages,
        ];

        /*
        |--------------------------------------------------------------------------
        | 10. RESPONSE TANPA CACHE
        |--------------------------------------------------------------------------
        | Supaya halaman selalu membaca data terbaru.
        |--------------------------------------------------------------------------
        */

        return response()
            ->view(
                'statistik',
                $data
            )
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
}
