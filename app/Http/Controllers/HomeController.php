<?php

namespace App\Http\Controllers;

use App\Models\HeaderSetting;
use App\Models\HomeFeature;
use App\Models\HomeSetting;
use App\Models\Testimonial;
use App\Models\WelcomeFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        if (! session()->has('account_id')) {
            return redirect()
                ->route('login.form')
                ->with('error', 'Session anda telah habis, silakan login ulang.');
        }

        $settings = HomeSetting::first();

        $features = HomeFeature::orderBy('sort_order')->get();

        $welcomeFeatures = WelcomeFeature::orderBy('sort_order')->get();

        $testimonials = Testimonial::orderBy('sort_order')->get();

        $header = HeaderSetting::firstOrNew();

        return view('home-admin', compact(
            'settings',
            'features',
            'welcomeFeatures',
            'testimonials',
            'header'
        ));
    }

    // =========================================================
    // HERO + WELCOME
    // =========================================================
    public function updateSettings(Request $request)
    {
        if (! session()->has('account_id')) {
            return redirect()
                ->route('login.form')
                ->with('error', 'Session anda telah habis, silakan login ulang.');
        }

        $validated = $request->validate([
            // ================= HERO =================
            'hero_badge' => 'nullable|string|max:100',
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:500',

            // ================= WELCOME =================
            'welcome_badge' => 'nullable|string|max:100',
            'welcome_title' => 'nullable|string|max:255',
            'welcome_description' => 'nullable|string',
            'welcome_quote' => 'nullable|string|max:500',
            'welcome_image' => 'nullable|file|image|mimes:jpg,jpeg,png,webp|max:2048',

            // ================= KEUNGGULAN =================
            'feature_badge' => 'nullable|string|max:100',
            'feature_title' => 'nullable|string|max:255',

            // ================= HIDANGAN FAVORIT =================
            'dish_badge' => 'nullable|string|max:100',
            'dish_title' => 'nullable|string|max:255',
            'dish_description' => 'nullable|string',
            'dish_image' => 'nullable|file|image|mimes:jpg,jpeg,png,webp|max:2048',

            // ================= TESTIMONIAL =================
            'testimonial_badge' => 'nullable|string|max:100',
            'testimonial_description' => 'nullable|string|max:500',

            // ================= CTA RESERVATION =================
            'cta_title' => 'nullable|string|max:255',
            'cta_description' => 'nullable|string',
            'cta_button_1_link' => 'nullable|string|max:500',
        ]);

        $settings = HomeSetting::firstOrNew();
        $oldWelcomeImage = $settings->welcome_image;
        $oldDishImage = $settings->dish_image;

        // ================= HERO =================
        if ($request->has('hero_badge')) {
            $settings->hero_badge = $validated['hero_badge'];
        }

        if ($request->has('hero_title')) {
            $settings->hero_title = $validated['hero_title'];
        }

        if ($request->has('hero_subtitle')) {
            $settings->hero_subtitle = $validated['hero_subtitle'];
        }

        // ================= WELCOME =================
        if ($request->has('welcome_badge')) {
            $settings->welcome_badge = $validated['welcome_badge'];
        }

        if ($request->has('welcome_title')) {
            $settings->welcome_title = $validated['welcome_title'];
        }

        if ($request->has('welcome_description')) {
            $settings->welcome_description = $validated['welcome_description'];
        }

        if ($request->has('welcome_quote')) {
            $settings->welcome_quote = $validated['welcome_quote'];
        }

        if ($request->hasFile('welcome_image')) {
            $settings->welcome_image = $request
                ->file('welcome_image')
                ->store('home/welcome', 'public');
        }

        // ================= KEUNGGULAN =================
        if ($request->has('feature_badge')) {
            $settings->feature_badge = $validated['feature_badge'];
        }

        if ($request->has('feature_title')) {
            $settings->feature_title = $validated['feature_title'];
        }

        // ================= HIDANGAN FAVORIT =================
        if ($request->has('dish_badge')) {
            $settings->dish_badge = $validated['dish_badge'];
        }

        if ($request->has('dish_title')) {
            $settings->dish_title = $validated['dish_title'];
        }

        if ($request->has('dish_description')) {
            $settings->dish_description = $validated['dish_description'];
        }

        if ($request->hasFile('dish_image')) {
            $settings->dish_image = $request
                ->file('dish_image')
                ->store('home/dishes', 'public');
        }

        // ================= TESTIMONIAL =================
        if ($request->has('testimonial_badge')) {
            $settings->testimonial_badge = $validated['testimonial_badge'];
        }

        if ($request->has('testimonial_description')) {
            $settings->testimonial_description = $validated['testimonial_description'];
        }

        // ================= CTA RESERVATION =================
        if ($request->has('cta_title')) {
            $settings->cta_title = $validated['cta_title'];
        }

        if ($request->has('cta_description')) {
            $settings->cta_description = $validated['cta_description'];
        }

        if ($request->has('cta_button_1_link')) {
            $settings->cta_button_1_link = $validated['cta_button_1_link'];
        }

        $settings->save();

        // Hapus foto lokal lama hanya setelah record berhasil disimpan.
        // URL eksternal tidak akan dihapus.
        $this->deleteReplacedPublicFile($oldWelcomeImage, $settings->welcome_image);
        $this->deleteReplacedPublicFile($oldDishImage, $settings->dish_image);

        return redirect()
            ->back()
            ->with('success', 'Pengaturan Home berhasil diperbarui.');
    }

    // =========================================================
    // KEUNGGULAN - TAMBAH
    // =========================================================
    public function storeFeature(Request $request)
    {
        if (! session()->has('account_id')) {
            return redirect()
                ->route('login.form')
                ->with('error', 'Session anda telah habis, silakan login ulang.');
        }

        $validated = $request->validate([
            'icon' => 'required|file|mimes:png,jpg,jpeg,webp,svg|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $lastOrder = HomeFeature::max('sort_order') ?? 0;

        // Simpan icon ke storage/app/public/home-features
        $iconPath = $request
            ->file('icon')
            ->store('home-features', 'public');

        HomeFeature::create([
            'icon' => $iconPath,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'is_active' => true,
            'sort_order' => $lastOrder + 1,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Keunggulan berhasil ditambahkan.');
    }

    // =========================================================
    // KEUNGGULAN - UPDATE
    // =========================================================
    public function updateFeature(Request $request, int $id)
    {
        if (! session()->has('account_id')) {
            return redirect()
                ->route('login.form')
                ->with('error', 'Session anda telah habis, silakan login ulang.');
        }

        $validated = $request->validate([
            'icon' => 'nullable|file|mimes:png,jpg,jpeg,webp,svg|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $feature = HomeFeature::findOrFail($id);

        $feature->title = $validated['title'];
        $feature->description = $validated['description'];

        // Simpan icon baru terlebih dahulu; file lama dihapus setelah save berhasil.
        $oldIcon = $feature->icon;
        if ($request->hasFile('icon')) {
            $feature->icon = $request
                ->file('icon')
                ->store('home-features', 'public');
        }

        $feature->save();

        if ($request->hasFile('icon')) {
            $this->deleteReplacedPublicFile($oldIcon, $feature->icon);
        }

        return redirect()
            ->back()
            ->with('success', 'Keunggulan berhasil diperbarui.');
    }

    // =========================================================
    // KEUNGGULAN - HAPUS
    // =========================================================
    public function destroyFeature(int $id)
    {
        if (! session()->has('account_id')) {
            return redirect()
                ->route('login.form')
                ->with('error', 'Session anda telah habis, silakan login ulang.');
        }

        $feature = HomeFeature::findOrFail($id);

        // Hapus file icon dari storage
        if (
            $feature->icon &&
            Storage::disk('public')->exists($feature->icon)
        ) {
            Storage::disk('public')->delete($feature->icon);
        }

        $feature->delete();

        return redirect()
            ->back()
            ->with('success', 'Keunggulan berhasil dihapus.');
    }

    // =========================================================
    // TESTIMONIAL - TAMBAH
    // =========================================================
    public function storeTestimonial(Request $request)
    {
        if (! session()->has('account_id')) {
            return redirect()
                ->route('login.form')
                ->with('error', 'Session anda telah habis, silakan login ulang.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'review' => 'required|string',
        ]);

        $lastOrder = Testimonial::max('sort_order') ?? 0;

        Testimonial::create([
            'name' => $validated['name'],
            'review' => $validated['review'],
            'is_active' => true,
            'sort_order' => $lastOrder + 1,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Testimonial berhasil ditambahkan.');
    }

    // =========================================================
    // TESTIMONIAL - UPDATE
    // =========================================================
    public function updateTestimonial(Request $request, int $id)
    {
        if (! session()->has('account_id')) {
            return redirect()
                ->route('login.form')
                ->with('error', 'Session anda telah habis, silakan login ulang.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'review' => 'required|string',
        ]);

        $testimonial = Testimonial::findOrFail($id);

        $testimonial->name = $validated['name'];
        $testimonial->review = $validated['review'];
        $testimonial->save();

        return redirect()
            ->back()
            ->with('success', 'Testimonial berhasil diperbarui.');
    }

    // =========================================================
    // TESTIMONIAL - HAPUS
    // =========================================================
    public function destroyTestimonial(int $id)
    {
        if (! session()->has('account_id')) {
            return redirect()
                ->route('login.form')
                ->with('error', 'Session anda telah habis, silakan login ulang.');
        }

        $testimonial = Testimonial::findOrFail($id);

        $testimonial->delete();

        return redirect()
            ->back()
            ->with('success', 'Testimonial berhasil dihapus.');
    }

    // =========================================================
    // WELCOME FEATURE - TAMBAH
    // =========================================================
    public function storeWelcomeFeature(Request $request)
    {
        if (! session()->has('account_id')) {
            return redirect()
                ->route('login.form')
                ->with('error', 'Session anda telah habis, silakan login ulang.');
        }

        $validated = $request->validate([
            'icon' => 'nullable|file|mimes:png,jpg,jpeg,webp,svg|max:2048',
            'icon_url' => 'prohibited',
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:255',
        ]);

        $lastOrder = WelcomeFeature::max('sort_order') ?? 0;

        $iconPath = null;

        // Ikon hanya diterima melalui unggahan file lokal.
        if ($request->hasFile('icon')) {
            $iconPath = $request
                ->file('icon')
                ->store('welcome-features', 'public');
        }

        WelcomeFeature::create([
            'icon' => $iconPath,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'is_active' => true,
            'sort_order' => $lastOrder + 1,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Keunggulan Welcome berhasil ditambahkan.');
    }

    // =========================================================
    // WELCOME FEATURE - UPDATE
    // =========================================================
    public function updateWelcomeFeature(Request $request, int $id)
    {
        if (! session()->has('account_id')) {
            return redirect()
                ->route('login.form')
                ->with('error', 'Session anda telah habis, silakan login ulang.');
        }

        $validated = $request->validate([
            'icon' => 'nullable|file|mimes:png,jpg,jpeg,webp,svg|max:2048',
            'icon_url' => 'prohibited',
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:255',
        ]);

        $welcomeFeature = WelcomeFeature::findOrFail($id);
        $oldIcon = $welcomeFeature->icon;

        $welcomeFeature->title = $validated['title'];
        $welcomeFeature->description = $validated['description'];

        // Upload ikon lokal baru; ikon lama dipertahankan jika tidak ada file baru.
        if ($request->hasFile('icon')) {
            $welcomeFeature->icon = $request
                ->file('icon')
                ->store('welcome-features', 'public');
        }

        $welcomeFeature->save();

        if ($oldIcon !== $welcomeFeature->icon) {
            $this->deleteReplacedPublicFile($oldIcon, $welcomeFeature->icon);
        }

        return redirect()
            ->back()
            ->with('success', 'Keunggulan Welcome berhasil diperbarui.');
    }

    // =========================================================
    // WELCOME FEATURE - HAPUS
    // =========================================================
    public function destroyWelcomeFeature(int $id)
    {
        if (! session()->has('account_id')) {
            return redirect()
                ->route('login.form')
                ->with('error', 'Session anda telah habis, silakan login ulang.');
        }

        $welcomeFeature = WelcomeFeature::findOrFail($id);

        // Hapus file icon jika berasal dari upload
        if (
            $welcomeFeature->icon &&
            ! filter_var($welcomeFeature->icon, FILTER_VALIDATE_URL) &&
            Storage::disk('public')->exists($welcomeFeature->icon)
        ) {
            Storage::disk('public')->delete($welcomeFeature->icon);
        }

        $welcomeFeature->delete();

        return redirect()
            ->back()
            ->with('success', 'Keunggulan Welcome berhasil dihapus.');
    }

    /**
     * Hapus file lama hanya jika berupa file lokal yang berbeda dari file baru.
     * URL eksternal tidak pernah dihapus.
     */
    private function deleteReplacedPublicFile(?string $oldPath, ?string $newPath): void
    {
        if (
            empty($oldPath) ||
            $oldPath === $newPath ||
            filter_var($oldPath, FILTER_VALIDATE_URL)
        ) {
            return;
        }

        if (Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }
    }
}
