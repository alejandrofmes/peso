<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$usertypes)
    {
        // Check if the user is authenticated and has one of the required usertypes
        if (Auth::check() && in_array(Auth::user()->usertype, $usertypes)) {
            return $next($request);
        }

        // If the user doesn't have the required usertype, redirect or abort
        return redirect()->route('dashboard'); // Or you can use abort(403);
    }
}
