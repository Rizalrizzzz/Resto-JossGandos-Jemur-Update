<?php

namespace App\Http\Controllers;

use App\Models\AboutMission;
use App\Models\AboutSetting;
use App\Models\AboutTeam;
use App\Models\AboutTimeline;
use Illuminate\Http\Request;

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

    public function updateHero(Request $request)
    {
        $request->validate([
            'hero_title' => 'required',
            'hero_subtitle' => 'nullable',
            'hero_image' => 'nullable',
        ]);

        $about = AboutSetting::first();

        if (! $about) {
            $about = new AboutSetting;
        }

        $about->hero_title = $request->hero_title;
        $about->hero_subtitle = $request->hero_subtitle;
        $about->hero_image = $request->hero_image;

        $about->save();

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

    public function updateMission(Request $request, $id)
    {
        $request->validate([
            'mission' => 'required',
        ]);

        $mission = AboutMission::findOrFail($id);

        $mission->mission = $request->mission;
        $mission->save();

        return back()->with('success', 'Misi berhasil diperbarui.');
    }

    public function destroyMission($id)
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

    public function updateTimeline(Request $request, $id)
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

    public function destroyTimeline($id)
    {
        $timeline = AboutTimeline::findOrFail($id);

        $timeline->delete();

        return back()->with('success', 'Timeline berhasil dihapus.');
    }

    public function updateFounder(Request $request)
    {
        $request->validate([
            'founder_name' => 'required',
            'founder_position' => 'required',
            'founder_photo' => 'nullable|url',
            'founder_description' => 'nullable',
        ]);

        $about = AboutSetting::first();

        $about->founder_name = $request->founder_name;
        $about->founder_position = $request->founder_position;
        $about->founder_photo = $request->founder_photo;
        $about->founder_description = $request->founder_description;

        $about->save();

        return back()->with('success', 'Data Pendiri Resto berhasil diperbarui.');
    }

    public function storeTeam(Request $request)
    {
        $request->validate([
            'photo' => 'nullable|url',
            'name' => 'required',
            'position' => 'required',
            'description' => 'nullable',
        ]);

        AboutTeam::create([
            'photo' => $request->photo,
            'name' => $request->name,
            'position' => $request->position,
            'description' => $request->description,
            'sort_order' => (AboutTeam::max('sort_order') ?? 0) + 1,
        ]);

        return back()->with('success', 'Tim berhasil ditambahkan.');
    }

    public function updateTeam(Request $request, $id)
    {
        $request->validate([
            'photo' => 'nullable|url',
            'name' => 'required',
            'position' => 'required',
            'description' => 'nullable',
        ]);

        $team = AboutTeam::findOrFail($id);

        $team->photo = $request->photo;
        $team->name = $request->name;
        $team->position = $request->position;
        $team->description = $request->description;

        $team->save();

        return back()->with('success', 'Data tim berhasil diperbarui.');
    }

    public function destroyTeam($id)
    {
        $team = AboutTeam::findOrFail($id);

        $team->delete();

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
