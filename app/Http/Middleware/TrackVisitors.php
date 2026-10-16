<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitors
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        /*
        |--------------------------------------------------------------------------
        | Hanya mencatat halaman publik
        |--------------------------------------------------------------------------
        */

        if (
            $request->isMethod('GET') &&
            ! $request->ajax() &&
            ! $request->expectsJson() &&
            $request->routeIs(
                'home',
                'about.front',
                'menu.front',
                'gallery.front',
                'reservation.front',
                'service-packages.front'
            )
        ) {
            Visit::create([
                'session_id' => Session::getId(),
                'ip_address' => $request->ip(),
                'url' => $request->fullUrl(),
                'last_activity' => now(),
            ]);
        }

        return $response;
    }
}
