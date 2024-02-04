<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Session;
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
    public function create(Request $request): View
    {
        $request->session()->put('url.intended', url()->previous());

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
//        dd($request->session()->all());
        $request->authenticate();

        $request->session()->regenerate();

//        return redirect()->intended(RouteServiceProvider::HOME);
//        return redirect('/'); //after logging in it redirects user to home page
        $intendedUrl = $request->session()->pull('url.intended', '/');


        return redirect($intendedUrl)->with('success', 'You have been successfully logged in.');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/'); //after logging out it redirects user to home page
    }
}
