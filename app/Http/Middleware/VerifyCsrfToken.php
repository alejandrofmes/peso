<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // 'livewire/*',
    ];

    public function handle($request, Closure $next)
    {
        // Check if user is logged out and trying to access a route requiring CSRF protection
        if (!Auth::check() && $request->route()->named('logout')) {
            // Redirect to homepage instead of throwing 419 error
            return redirect('/');
        }

        // Catch the 419 error due to CSRF token mismatch caused by session expiration
        try {
            return parent::handle($request, $next);
        } catch (\Illuminate\Session\TokenMismatchException $e) {
            // If the session expired and a CSRF error occurs

            // Check if the user is logged in, meaning the session expired but user logged in again
            if (Auth::check()) {
                // Regenerate the CSRF token to prevent further 419 errors
                Session::regenerateToken();

                // Redirect back to the same page with the refreshed CSRF token
                // return redirect()->back()->with('warning', 'Your session was refreshed. Please try again.');
                return redirect()->back();

            }

            // If not authenticated, redirect to the homepage
            // return redirect('/')->with('error', 'Session expired, you have been redirected.');
            return redirect('/');

        }
    }
}
