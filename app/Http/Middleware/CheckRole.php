<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{

    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $userRole = $request->user()->role?->name;

        if (! $userRole) {
            abort(403, 'Akses ditolak. Pengguna tidak memiliki role yang valid.');
        }

        $allowedRoles = [];
        foreach ($roles as $role) {
            foreach (explode(',', $role) as $subRole) {
                $allowedRoles[] = trim($subRole);
            }
        }

        if (in_array($userRole, $allowedRoles, true)) {
            return $next($request);
        }

        abort(403, 'Akses ditolak. Anda tidak memiliki hak akses untuk halaman ini.');
    }
}