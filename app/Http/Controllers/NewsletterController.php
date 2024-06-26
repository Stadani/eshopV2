<?php

namespace App\Http\Controllers;

use App\Services\Newsletter;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{

    /**
     * vytvorenie newsletteru bolo inspirovane laracastom
     * https://laracasts.com/series/laravel-8-from-scratch/episodes/60
     */
    public function __invoke(Newsletter $newsletter)
    {
        request()->validate(['email' => 'required|email']);

        try {
            $newsletter->subscribe(request('email'));
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'email' => 'This email cannot be added to newsletter.'
            ]);
        }

        return redirect('/')->with('success', 'You are signed up for newsletter.');
    }
}
