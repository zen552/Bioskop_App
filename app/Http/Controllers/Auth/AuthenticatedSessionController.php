<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
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
     * Display the admin login view.
     */
    public function adminCreate(): View
    {
        return view('admin.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        if (Auth::user()->isAdmin()) {
            $this->logoutInvalidRole($request);

            throw ValidationException::withMessages([
                'email' => 'Akun admin hanya bisa masuk melalui halaman login admin.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(url('/'));
    }

    /**
     * Handle an incoming admin authentication request.
     */
    public function adminStore(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        if (! Auth::user()->isAdmin()) {
            $this->logoutInvalidRole($request);

            throw ValidationException::withMessages([
                'email' => 'Halaman login admin hanya dapat digunakan oleh admin.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
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

    private function logoutInvalidRole(Request $request): void
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
