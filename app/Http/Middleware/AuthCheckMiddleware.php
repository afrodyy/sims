<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Memeriksa apakah pengguna sudah login dan token JWT ada di session
        if ($request->session()->has('jwt_token') && Auth::check()) {
            // Jika sudah login dan token JWT ada, lanjutkan request
            return $next($request);
        }

        // Jika belum login atau tidak ada token JWT, redirect ke halaman login dengan pesan error
        return redirect('/login')->with('error', 'Anda harus login terlebih dahulu.');
    }
}
