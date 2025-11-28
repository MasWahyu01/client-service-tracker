<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Contoh pemakaian:
     * route: ->middleware('role:super_admin')
     * route: ->middleware('role:super_admin,staff')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Kalau belum login
        $user = Auth::user();
        if (!$user) {
            // kalau mau langsung forbidden:
            // abort(403, 'Unauthorized');
            return redirect()->route('login');
        }

        // Kalau role user tidak ada di daftar yang diizinkan
        if (!in_array($user->role, $roles, true)) {
            abort(403, 'You do not have permission to access this resource.');
        }

        return $next($request);
    }
}
