<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Symfony\Component\HttpFoundation\Response;

class EnsureDataMasjidCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->masjid == null) {
            Flash('Data Masjid Belum Lengkap, Silakan Lengkapi Data Masjid Terlebih Dahulu')->error();
            return redirect()->route("masjid.create");
        }
        return $next($request);
    }
}
