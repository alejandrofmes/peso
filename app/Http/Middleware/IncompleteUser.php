<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IncompleteUser
{
    public function handle($request, Closure $next)
    {

        // Redirect based on user type
        if (Auth::check() && Auth::user()->usertype == 2) {
            return redirect()->route('fill_profile'); // Route name for jobseeker details
        } elseif (Auth::check() && Auth::user()->usertype == 3) {
            return redirect()->route('fill_employer'); // Route name for employer details
        }

        return $next($request);

    }
}
