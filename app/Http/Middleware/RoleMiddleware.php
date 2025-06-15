<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            // Jika tidak login, redirect ke halaman login
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Memeriksa apakah user memiliki salah satu role yang diizinkan
        if (!in_array($user->role, $roles)) {
            // Jika tidak memiliki role yang diizinkan, redirect ke dashboard yang sesuai
            if ($user->role == 'admin') {
                return redirect()->route('admin.dashboard');
            } else { // pasien
                return redirect()->route('pasien.dashboard');
            }
        }

        return $next($request);
    }
}