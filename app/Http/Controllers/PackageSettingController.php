<?php

namespace App\Http\Controllers;

use App\Models\PackageSetting;
use Illuminate\Http\Request;

class PackageSettingController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'section_title' => 'sometimes|required|string|max:255',
            'section_description' => 'sometimes|nullable|string|max:3000',
            'cta_title' => 'sometimes|required|string|max:255',
            'cta_description' => 'sometimes|nullable|string|max:3000',
        ]);

        // Mengambil pengaturan yang sudah tersimpan
        $settings = PackageSetting::first();

        if (!$settings) {
            return back()->withErrors([
                'settings' => 'Data pengaturan belum tersedia.',
            ]);
        }

        // Memperbarui tulisan sesuai input dari admin
        $settings->update($validated);

        return back()->with(
            'success',
            'Pengaturan Paket & Layanan berhasil diperbarui.'
        );
    }
}