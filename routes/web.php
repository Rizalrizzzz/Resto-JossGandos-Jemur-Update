<?php

use App\Http\Controllers\AboutController;
// Import yang ada
use App\Http\Controllers\AccountAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenuPreviewController;
use App\Http\Controllers\OrderButtonController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ServicePackageController;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\WhatsappClickController;
use App\Http\Controllers\PackageSettingController;
use App\Models\Menu;
// Import yang DIBUTUHKAN untuk Logika Pencatatan Kunjungan
use App\Models\ServicePackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// --- FRONTEND (Publik) ---
Route::get('/gallery', [GalleryController::class, 'publicIndex'])->name('gallery.front');
Route::get('/menu', [MenuController::class, 'publicIndex'])->name('menu.front');
Route::get('/service-packages', function (Request $request) {

    $packages = ServicePackage::where('is_active', true)
        ->orderBy('sort_order', 'asc')
        ->orderByDesc('created_at')
        ->get();

    $packageSettings = \App\Models\PackageSetting::first();

    return view('service-packages', [
    'packages' => $packages,
    'selectedCategory' => $request->query('category'),
    'packageSettings' => $packageSettings,
    ]);

})->name('service-packages.front');

// ---About---
Route::middleware('admin.session')->group(function () {
Route::get('/dashboard/about', [AboutController::class, 'index'])->name('dashboard.about');
Route::post('/dashboard/about/hero', [AboutController::class, 'updateHero'])->name('dashboard.about.hero');
Route::post('/dashboard/about/story', [AboutController::class, 'updateStory'])->name('dashboard.about.story');
Route::post('/dashboard/about/vision', [AboutController::class, 'updateVision'])->name('dashboard.about.vision');
Route::post('/dashboard/about/mission', [AboutController::class, 'storeMission'])->name('dashboard.about.mission.store');
Route::put('/dashboard/about/mission/{id}', [AboutController::class, 'updateMission'])->name('dashboard.about.mission.update');
Route::delete('/dashboard/about/mission/{id}', [AboutController::class, 'destroyMission'])->name('dashboard.about.mission.destroy');
Route::post('/dashboard/about/timeline', [AboutController::class, 'storeTimeline'])->name('dashboard.about.timeline.store');
Route::put('/dashboard/about/timeline/{id}', [AboutController::class, 'updateTimeline'])->name('dashboard.about.timeline.update');
Route::delete('/dashboard/about/timeline/{id}', [AboutController::class, 'destroyTimeline'])->name('dashboard.about.timeline.destroy');
Route::post('/dashboard/about/founder', [AboutController::class, 'updateFounder'])->name('dashboard.about.founder');
Route::post('/dashboard/about/team', [AboutController::class, 'storeTeam'])->name('dashboard.about.team.store');
Route::put('/dashboard/about/team/{id}', [AboutController::class, 'updateTeam'])->name('dashboard.about.team.update');
Route::delete('/dashboard/about/team/{id}', [AboutController::class, 'destroyTeam'])->name('dashboard.about.team.destroy');

});

// --- ADMIN AREA (Dilindungi Session) ---
Route::prefix('dashboard')
    ->middleware('admin.session')
    ->group(function () {

    // 1. Dashboard & Statistik
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik');

    // 2. KELOLA HOME
    Route::get('/home', [HomeController::class, 'index'])->name('dashboard.home');

    // 3. UPDATE HOME SETTINGS
    Route::post('/home/settings', [HomeController::class, 'updateSettings'])->name('dashboard.home.settings');

    // 4. TESTIMONIAL
    Route::post('/home/testimonials', [HomeController::class, 'storeTestimonial'])->name('dashboard.home.testimonials.store');
    Route::put('/home/testimonials/{id}', [HomeController::class, 'updateTestimonial'])->name('dashboard.home.testimonials.update');
    Route::delete('/home/testimonials/{id}', [HomeController::class, 'destroyTestimonial'])->name('dashboard.home.testimonials.destroy');

    // CRUD KEUNGGULAN
    Route::post('/home/features', [HomeController::class, 'storeFeature'])->name('dashboard.home.features.store');
    Route::put('/home/features/{id}', [HomeController::class, 'updateFeature'])->name('dashboard.home.features.update');
    Route::delete('/home/features/{id}', [HomeController::class, 'destroyFeature'])->name('dashboard.home.features.destroy');

    // CRUD WELCOME FEATURE
    Route::post('/home/welcome-features', [HomeController::class, 'storeWelcomeFeature'])->name('dashboard.home.welcome-features.store');
    Route::put('/home/welcome-features/{id}', [HomeController::class, 'updateWelcomeFeature'])->name('dashboard.home.welcome-features.update');
    Route::delete('/home/welcome-features/{id}', [HomeController::class, 'destroyWelcomeFeature'])->name('dashboard.home.welcome-features.destroy');

    // 2. HEADER VIDEO SETTING
    // Route ini menangani update video (Youtube/File) dari form dashboard
    Route::put('/header/update', [DashboardController::class, 'updateHeader'])->name('header.update');

    // 2. ORDER NOW
    Route::get('/order-buttons', [OrderButtonController::class, 'index'])->name('order-buttons.index');
    Route::put('/order-buttons/{orderButton}', [OrderButtonController::class, 'update'])->name('order-buttons.update');

    // 3. GALLERY CRUD
    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store');

    // GALLERY SETTINGS
    Route::put('/gallery/settings', [GalleryController::class, 'updateSettings'])->name('gallery.settings.update');

    // UPDATE BINGKAI
    Route::put('/gallery/frames', [GalleryController::class, 'updateFrames'])->name('gallery.frames.update');

    Route::put('/gallery/{id}', [GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/gallery/{id}', [GalleryController::class, 'destroy'])->name('gallery.destroy');

    // 4. MENU CRUD
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::put('/menu/settings', [MenuController::class, 'updateSettings'])->name('menu.settings.update');
    Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');
    Route::put('/menu/{id}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

    // 5. MENU PREVIEW
    Route::get('/menu-preview', [MenuPreviewController::class, 'index'])->name('menu-preview.index');
    Route::post('/menu-preview', [MenuPreviewController::class, 'store'])->name('menu-preview.store');
    Route::put('/menu-preview/{id}', [MenuPreviewController::class, 'update'])->name('menu-preview.update');
    Route::delete('/menu-preview/{id}', [MenuPreviewController::class, 'destroy'])->name('menu-preview.destroy');

    // 5. PROMOSI CRUD
    Route::get('/promotions', [PromotionController::class, 'index'])->name('admin.promotions.index');
    Route::post('/promotions', [PromotionController::class, 'store'])->name('admin.promotions.store');
    Route::put('/promotions/{promotion}', [PromotionController::class, 'update'])->name('admin.promotions.update');
    Route::delete('/promotions/{promotion}', [PromotionController::class, 'destroy'])->name('admin.promotions.destroy');

    // 6. PAKET & LAYANAN CRUD
    Route::get('/service-packages', [ServicePackageController::class, 'index'])->name('service-packages.index');
    Route::post('/service-packages', [ServicePackageController::class, 'store'])->name('service-packages.store');
    Route::put('/service-packages/settings', [PackageSettingController::class,'update'])->name('service-packages.settings.update');
    Route::put('/service-packages/{id}', [ServicePackageController::class, 'update'])->name('service-packages.update');
    Route::delete('/service-packages/{id}', [ServicePackageController::class, 'destroy'])->name('service-packages.destroy');

    // 7. RESERVATION
    Route::get('/reservation', [ReservationController::class, 'index'])
        ->name('reservation.index');

    Route::post('/reservation/settings', [ReservationController::class, 'updateSettings'])
        ->name('reservation.settings.update');

    // CARA RESERVASI
    Route::post('/reservation/steps', [ReservationController::class, 'storeStep'])
        ->name('reservation.steps.store');

    Route::put('/reservation/steps/{id}', [ReservationController::class, 'updateStep'])
        ->name('reservation.steps.update');

    Route::delete('/reservation/steps/{id}', [ReservationController::class, 'destroyStep'])
        ->name('reservation.steps.destroy');

    // KETENTUAN RESERVASI
    Route::post('/reservation/terms', [ReservationController::class, 'storeTerm'])
        ->name('reservation.terms.store');

    Route::put('/reservation/terms/{id}', [ReservationController::class, 'updateTerm'])
        ->name('reservation.terms.update');

    Route::delete('/reservation/terms/{id}', [ReservationController::class, 'destroyTerm'])
        ->name('reservation.terms.destroy');

    // KENALI AREA RESTO
    Route::post('/reservation/areas', [ReservationController::class, 'storeArea'])
        ->name('reservation.areas.store');

    Route::put('/reservation/areas/{id}', [ReservationController::class, 'updateArea'])
        ->name('reservation.areas.update');

    Route::delete('/reservation/areas/{id}', [ReservationController::class, 'destroyArea'])
        ->name('reservation.areas.destroy');

});

// --- AUTENTIKASI ---
// Login
Route::get('/login', [AccountAuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AccountAuthController::class, 'login'])->name('login');

// Logout
Route::post('/logout', [AccountAuthController::class, 'logout'])->name('logout');

// --- PAGE PUBLIK HOME ---

Route::get('/', function (Request $request) {

    // ================= HOME SETTINGS =================
    $settings = \App\Models\HomeSetting::first();

    // ================= KEUNGGULAN =================
    $features = \App\Models\HomeFeature::where('is_active', true)
        ->orderBy('sort_order')
        ->get();

    // ================= WELCOME FEATURES =================
    $welcomeFeatures = \App\Models\WelcomeFeature::where('is_active', true)
        ->orderBy('sort_order')
        ->get();

    // ================= TESTIMONIAL =================
    $testimonials = \App\Models\Testimonial::where('is_active', true)
        ->orderBy('sort_order')
        ->get();

    // ================= HEADER =================
    $header = \App\Models\HeaderSetting::first();

    // ================= PROMO HOME POPUP =================
    $now = now('Asia/Jakarta');

    $homePopup = \App\Models\Promotion::where('is_home_popup', true)
        ->whereNotNull('home_start_at')
        ->whereNotNull('home_end_at')
        ->where('home_start_at', '<=', $now)
        ->where('home_end_at', '>=', $now)
        ->first();

    // ================= MENU =================
    $menus = Menu::orderByDesc('created_at')->get();

    return view('home', compact(
        'settings',
        'features',
        'welcomeFeatures',
        'testimonials',
        'header',
        'menus',
        'homePopup'
    ));
})->name('home');

Route::get('/about', [AboutController::class, 'publicIndex'])->name('about.front');

Route::get('/reservation', [ReservationController::class, 'publicIndex'])
    ->name('reservation.front');

Route::post('/whatsapp-click', [WhatsappClickController::class, 'store'])
        ->name('whatsapp.click');
