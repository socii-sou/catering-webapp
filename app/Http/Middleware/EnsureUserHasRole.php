<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Contoh pakai di routes:
     *   Route::middleware('role:penjual')->group(...)
     *   Route::middleware('role:penjual,pelanggan')->group(...) // boleh salah satu
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return response()->json(['message' => 'Silakan login terlebih dahulu.'], 401);
        }

        if (! in_array($user->role, $roles, true)) {
            return response()->json(['message' => 'Kamu tidak punya akses ke halaman ini.'], 403);
        }

        return $next($request);
    }
}