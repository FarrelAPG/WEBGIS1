<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
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

        if ($request->user()?->role === 'damkar') {
            return redirect()->intended(route('damkar.dashboard', absolute: false));
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Login cepat 1-klik sebagai Admin Damkar (demo)
     */
    public function demoDamkar(Request $request): RedirectResponse
    {
        $admin = \App\Models\User::where('email', 'damkar@sigap.test')->first();

        if (! $admin) {
            $admin = \App\Models\User::firstOrCreate(
                ['email' => 'damkar@sigap.test'],
                [
                    'name' => 'Admin Damkar',
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'role' => 'damkar',
                ]
            );
        }

        Auth::login($admin, true);
        $request->session()->regenerate();

        return redirect()->route('damkar.dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
