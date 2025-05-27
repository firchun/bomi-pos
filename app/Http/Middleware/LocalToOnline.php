<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class LocalToOnline
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (App::environment('local')) {
            $targetBase = config('app.server'); // Ambil dari config

            // Buat URL lengkap ke server produksi
            $targetUrl = rtrim($targetBase, '/') . $request->getRequestUri();

            return redirect()->away($targetUrl);
        }

        return $next($request);
    }
}