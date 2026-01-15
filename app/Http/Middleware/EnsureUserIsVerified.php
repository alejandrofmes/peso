<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsVerified
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
        // Check if the user is logged in
        if (Auth::check()) {
            $user = Auth::user();

            // Check if the user implements MustVerifyEmail and if they have verified their email
            if ($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()) {
                // User is logged in but not verified, redirect to verification page
                return redirect()->route('verification.notice');
            }
        }

        // No user is logged in or user is verified, allow access
        return $next($request);
    }
}
