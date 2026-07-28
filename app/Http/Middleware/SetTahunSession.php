<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// day 9 progress, middleware tahun agar tahun tersimpan di session tidak hilang 
// meskipun sudah ganti halaman

class SetTahunSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('tahun')) {
            session(['tahun' => $request->tahun]);
        }

        return $next($request);
    }
}
