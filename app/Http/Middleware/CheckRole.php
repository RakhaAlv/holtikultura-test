<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Jika belum login
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Ambil nama role user
        $userRole = $request->user()->role->nama_role;

        // Jika role sesuai
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Jika tidak sesuai
        abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
    }
}