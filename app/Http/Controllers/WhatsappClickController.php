<?php

namespace App\Http\Controllers;

use App\Models\WhatsappClick;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class WhatsappClickController extends Controller
{
    public function store(Request $request)
    {
        WhatsappClick::create([
            'page' => $request->input('page'),
            'session_id' => Session::getId(),
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
        ]);
    }
}
