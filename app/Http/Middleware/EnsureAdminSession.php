<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminSession
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('account_id')) {
            return redirect()
                ->route('login.form')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
