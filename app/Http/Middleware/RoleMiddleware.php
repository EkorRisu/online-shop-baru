<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Middleware untuk membatasi akses berdasarkan peran pengguna
class RoleMiddleware
{
    // Memeriksa apakah pengguna memiliki peran yang sesuai
    public function handle(Request $request, Closure $next, $role)
    {
        if (Auth::check() && Auth::user()->role === $role) {
            // Jika peran sesuai, lanjutkan ke rute
            return $next($request);
        }
        // Jika tidak, redirect ke halaman utama dengan pesan error
        return redirect('/')->with('error', 'Unauthorized access');
    }
}
