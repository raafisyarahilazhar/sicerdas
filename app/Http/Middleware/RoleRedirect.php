<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleRedirect
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Mengambil semua argumen yang dikirim ke method ini
        $args = func_get_args();

        // Membuang 2 argumen pertama ($request dan $next) untuk mendapatkan daftar peran
        $roles = array_slice($args, 2);
        
        if (!Auth::check() || !in_array(Auth::user()->role, $roles)) {
            // Arahkan ke halaman utama. Anda juga bisa menggunakan abort(403, 'Unauthorized action.');
            return redirect('/');
        }

        return $next($request);
    }
}
