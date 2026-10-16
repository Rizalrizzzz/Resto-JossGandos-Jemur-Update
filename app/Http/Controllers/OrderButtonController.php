<?php

namespace App\Http\Controllers;

use App\Models\OrderButton;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderButtonController extends Controller
{
    public function index()
    {
        if (! session()->has('account_id')) {
            return redirect()
                ->route('login.form')
                ->with(
                    'error',
                    'Session anda telah habis, silakan login ulang.'
                );
        }

        $orderButtons = OrderButton::orderBy('id')->get();

        return view('order-buttons.index', compact('orderButtons'));
    }

    public function update(Request $request, OrderButton $orderButton)
    {
        if (! session()->has('account_id')) {
            return redirect()
                ->route('login.form')
                ->with(
                    'error',
                    'Session anda telah habis, silakan login ulang.'
                );
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'required|string|max:500',
            'icon_url' => 'nullable|string|max:500',
            'icon_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Simpan judul dan link baru
        $orderButton->title = $validated['title'];
        $orderButton->link = $validated['link'];

        /*
        |--------------------------------------------------------------------------
        | JIKA ADMIN UPLOAD GAMBAR BARU
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('icon_file')) {

            // Simpan path gambar lama
            $oldIcon = trim($orderButton->icon ?? '');

            /*
            | Hanya hapus jika gambar lama adalah file lokal/storage.
            | URL eksternal tidak perlu dihapus.
            */
            if (
                $oldIcon !== '' &&
                ! filter_var($oldIcon, FILTER_VALIDATE_URL)
            ) {
                $oldIcon = ltrim($oldIcon, '/');

                // Jika database menyimpan "storage/..."
                if (str_starts_with($oldIcon, 'storage/')) {
                    $oldIcon = substr($oldIcon, 8);
                }

                // Hapus file lama dari storage/app/public
                if (
                    Storage::disk('public')->exists($oldIcon)
                ) {
                    Storage::disk('public')->delete($oldIcon);
                }
            }

            /*
            | Upload file baru
            */
            $newIcon = $request
                ->file('icon_file')
                ->store('order-buttons', 'public');

            // Ganti path lama dengan path baru
            $orderButton->icon = $newIcon;
        }

        /*
        |--------------------------------------------------------------------------
        | JIKA ADMIN MENGGUNAKAN URL GAMBAR
        |--------------------------------------------------------------------------
        */
        elseif (! empty($validated['icon_url'])) {

            // Simpan path gambar lama
            $oldIcon = trim($orderButton->icon ?? '');

            /*
            | Kalau gambar lama merupakan file upload,
            | hapus karena sekarang diganti URL.
            */
            if (
                $oldIcon !== '' &&
                ! filter_var($oldIcon, FILTER_VALIDATE_URL)
            ) {
                $oldIcon = ltrim($oldIcon, '/');

                if (str_starts_with($oldIcon, 'storage/')) {
                    $oldIcon = substr($oldIcon, 8);
                }

                if (
                    Storage::disk('public')->exists($oldIcon)
                ) {
                    Storage::disk('public')->delete($oldIcon);
                }
            }

            // Simpan URL gambar baru
            $orderButton->icon = $validated['icon_url'];
        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN PERUBAHAN
        |--------------------------------------------------------------------------
        */
        $orderButton->save();

        return redirect()
            ->back()
            ->with(
                'success',
                'Order Now berhasil diperbarui.'
            );
    }
}
