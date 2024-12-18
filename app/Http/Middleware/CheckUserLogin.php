<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next, ...$role): Response
    // {
    //     if (($request->user() && in_array($request->user()->role, $role))) {
    //         return $next($request);
    //     }

    //     return back()->with('danger', 'Anda tidak memiliki akses pada halaman ini');
    // }
    public function handle(Request $request, Closure $next, ...$roles): Response
    {

        if (!$request->user()) {
            return redirect()->route('login')->with('danger', 'Silakan login untuk mengakses halaman ini');
        }

        if (!in_array($request->user()->role, $roles)) {
            return redirect()->back()->with('danger', 'Anda tidak memiliki akses pada halaman ini');
        }


        return $next($request);
    }
}
