<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
// use App\Providers\RouteServiceProvider; // Baris ini tidak perlu lagi jika tidak ada Home constant
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Dapatkan user yang baru saja login
        $user = Auth::user();

        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        } elseif ($user->role === 'pasien') {
            return redirect()->intended(route('pasien.dashboard', absolute: false));
        }

        // Fallback jika role tidak terdefinisi (seharusnya tidak terjadi)
        // Bisa redirect ke root, atau rute 'login' lagi
        return redirect('/');
        // Atau jika Anda tetap ingin 'dashboard' sebagai fallback umum:
        // return redirect()->intended(route('dashboard', absolute: false)); // Dengan catatan ada rute 'dashboard'
    }

    /**
     * Destroy an authentication session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}