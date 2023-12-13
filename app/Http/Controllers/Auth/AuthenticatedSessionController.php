<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
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

        // Log or display the user's role
        \Log::info('User role: ' . $request->user()->role);

        $url = '';

        if ($request->user()->role === 'admin') {
            $url = '/admin/dashboard';
        } elseif ($request->user()->role === 'agent') {
            $url = '/agent/dashboard';
        } else if ($request->user()->role === 'user') {
            $url = $request->session()->previousUrl() ?? '/accueil';

        }
        $message = 'Vous êtes connecté en tant que' . $request->user()->name . '!';
        return redirect()->intended($url)->with('success', $message);
    }


    public function destroy(Request $request): RedirectResponse
    {
        \Log::info('User role before logout: ' . auth()->user()->role);

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}
