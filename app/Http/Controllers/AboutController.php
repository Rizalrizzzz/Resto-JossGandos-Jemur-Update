<?php

namespace App\Http\Controllers;

use App\Models\AboutMission;
use App\Models\AboutSetting;
use App\Models\AboutTeam;
use App\Models\AboutTimeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function index()
    {
        $about = AboutSetting::first();

        if (! $about) {
            $about = AboutSetting::create([
                'hero_title' => '',
                'hero_subtitle' => '',
                'hero_image' => '',
                'story_title' => '',
                'story_content' => '',
                'vision' => '',
                'founder_name' => '',
                'founder_position' => '',
                'founder_photo' => '',
                'founder_description' => '',
            ]);
        }

        $missions = AboutMission::orderBy('sort_order')->get();
        $timelines = AboutTimeline::orderByRaw("CAST(SUBSTRING_INDEX(year, '-', 1) AS UNSIGNED) ASC")->get();
        $teams = AboutTeam::orderBy('sort_order')->get();

        return view('about-admin', compact(
            'about',
            'missions',
            'timelines',
            'teams'
        ));
    }

    /**
     * Delete a previous image only when it is a locally stored file.
     * Existing external URLs are left untouched.
     */
    private function deleteStoredImage(?string $path): void
    {
        if (! $path || filter_var($path, FILTER_VALIDATE_URL)) {
            return;
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function updateHero(Request $request)
    {
        $validated = $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'nullable|string',
            'hero_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $about = AboutSetting::first() ?? new AboutSetting();
        $oldImagePath = $about->hero_image;

        $about->hero_title = $validated['hero_title'];
        $about->hero_subtitle = $validated['hero_subtitle'] ?? null;

        if ($request->hasFile('hero_image')) {
            $newImagePath = $request->file('hero_image')->store('about', 'public');

            if (! $newImagePath) {
                return back()
                    ->withErrors(['hero_image' => 'Foto Hero gagal disimpan. Silakan coba lagi.'])
                    ->withInput();
            }

            $about->hero_image = $newImagePath;
        }

        $about->save();

        // Hapus foto lama setelah foto baru tersimpan dan database berhasil diperbarui.
        if ($request->hasFile('hero_image') && $oldImagePath !== $about->hero_image) {
            $this->deleteStoredImage($oldImagePath);
        }

        return back()->with('success', 'Hero berhasil diperbarui.');
    }

    public function updateStory(Request $request)
    {
        $request->validate([
            'story_title' => 'required',
            'story_content' => 'required',
        ]);

        $about = AboutSetting::first();
        $about->story_title = $request->story_title;
        $about->story_content = $request->story_content;
        $about->save();

        return back()->with('success', 'Cerita Kami berhasil diperbarui.');
    }

    public function updateVision(Request $request)
    {
        $request->validate([
            'vision' => 'required',
        ]);

        $about = AboutSetting::first();
        $about->vision = $request->vision;
        $about->save();

        return back()->with('success', 'Visi berhasil diperbarui.');
    }

    public function storeMission(Request $request)
    {
        $request->validate([
            'mission' => 'required',
        ]);

        AboutMission::create([
            'mission' => $request->mission,
            'sort_order' => AboutMission::max('sort_order') + 1,
        ]);

        return back()->with('success', 'Misi berhasil ditambahkan.');
    }

    public function updateMission(Request $request, int $id)
    {
        $request->validate([
            'mission' => 'required',
        ]);

        $mission = AboutMission::findOrFail($id);
        $mission->mission = $request->mission;
        $mission->save();

        return back()->with('success', 'Misi berhasil diperbarui.');
    }

    public function destroyMission(int $id)
    {
        $mission = AboutMission::findOrFail($id);
        $mission->delete();

        return back()->with('success', 'Misi berhasil dihapus.');
    }

    public function storeTimeline(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        AboutTimeline::create([
            'year' => $request->year,
            'title' => $request->title,
            'description' => $request->description,
            'sort_order' => (AboutTimeline::max('sort_order') ?? 0) + 1,
        ]);

        return back()->with('success', 'Timeline berhasil ditambahkan.');
    }

    public function updateTimeline(Request $request, int $id)
    {
        $request->validate([
            'year' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        $timeline = AboutTimeline::findOrFail($id);
        $timeline->year = $request->year;
        $timeline->title = $request->title;
        $timeline->description = $request->description;
        $timeline->save();

        return back()->with('success', 'Timeline berhasil diperbarui.');
    }

    public function destroyTimeline(int $id)
    {
        $timeline = AboutTimeline::findOrFail($id);
        $timeline->delete();

        return back()->with('success', 'Timeline berhasil dihapus.');
    }

    public function updateFounder(Request $request)
    {
        $validated = $request->validate([
            'founder_name' => 'required|string|max:255',
            'founder_position' => 'required|string|max:255',
            'founder_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'founder_description' => 'nullable|string',
        ]);

        $about = AboutSetting::first() ?? new AboutSetting();
        $oldImagePath = $about->founder_photo;

        $about->founder_name = $validated['founder_name'];
        $about->founder_position = $validated['founder_position'];
        $about->founder_description = $validated['founder_description'] ?? null;

        if ($request->hasFile('founder_photo')) {
            $newImagePath = $request->file('founder_photo')->store('about', 'public');

            if (! $newImagePath) {
                return back()
                    ->withErrors(['founder_photo' => 'Foto Pendiri gagal disimpan. Silakan coba lagi.'])
                    ->withInput();
            }

            $about->founder_photo = $newImagePath;
        }

        $about->save();

        if ($request->hasFile('founder_photo') && $oldImagePath !== $about->founder_photo) {
            $this->deleteStoredImage($oldImagePath);
        }

        return back()->with('success', 'Data Pendiri Resto berhasil diperbarui.');
    }

    public function storeTeam(Request $request)
    {
        $validated = $request->validate([
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('about/team', 'public');

            if (! $photoPath) {
                return back()
                    ->withErrors(['photo' => 'Foto anggota tim gagal disimpan. Silakan coba lagi.'])
                    ->withInput();
            }
        }

        AboutTeam::create([
            'photo' => $photoPath,
            'name' => $validated['name'],
            'position' => $validated['position'],
            'description' => $validated['description'] ?? null,
            'sort_order' => (AboutTeam::max('sort_order') ?? 0) + 1,
        ]);

        return back()->with('success', 'Tim berhasil ditambahkan.');
    }

    public function updateTeam(Request $request, int $id)
    {
        $validated = $request->validate([
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $team = AboutTeam::findOrFail($id);
        $oldImagePath = $team->photo;

        $team->name = $validated['name'];
        $team->position = $validated['position'];
        $team->description = $validated['description'] ?? null;

        if ($request->hasFile('photo')) {
            $newImagePath = $request->file('photo')->store('about/team', 'public');

            if (! $newImagePath) {
                return back()
                    ->withErrors(['photo' => 'Foto anggota tim gagal disimpan. Silakan coba lagi.'])
                    ->withInput();
            }

            $team->photo = $newImagePath;
        }

        $team->save();

        // Foto lama dihapus hanya ketika foto baru berhasil tersimpan.
        if ($request->hasFile('photo') && $oldImagePath !== $team->photo) {
            $this->deleteStoredImage($oldImagePath);
        }

        return back()->with('success', 'Data tim berhasil diperbarui.');
    }

    public function destroyTeam(int $id)
    {
        $team = AboutTeam::findOrFail($id);
        $oldImagePath = $team->photo;
        $team->delete();

        // Bersihkan foto lokal saat data anggota tim dihapus.
        $this->deleteStoredImage($oldImagePath);

        return back()->with('success', 'Data tim berhasil dihapus.');
    }

    public function publicIndex()
    {
        $about = AboutSetting::first();
        $missions = AboutMission::orderBy('sort_order')->get();

        $timelines = AboutTimeline::orderByRaw(
            "CAST(SUBSTRING_INDEX(year, '-', 1) AS UNSIGNED) ASC"
        )->get();

        $teams = AboutTeam::orderBy('sort_order')->get();

        return view('about', compact(
            'about',
            'missions',
            'timelines',
            'teams'
        ));
    }
}
