<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
//        return $request->expectsJson() ? null : route('login');
        if ($request->expectsJson()) {
            return null;
        }

        Session::flash('error', 'You must be logged in to access this page.');

        return route('login');
    }
}
