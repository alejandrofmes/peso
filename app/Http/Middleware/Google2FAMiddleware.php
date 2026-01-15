<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FALaravel\Support\Authenticator;
use Symfony\Component\HttpFoundation\Response;

class Google2FAMiddleware
{
    protected $authenticator;

    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Check if the user has 2FA enabled
        if ($user && $user->google2fa_secret && !$request->session()->has('google2fa')) {
            // Boot the authenticator with the request
            $this->authenticator->boot($request);

            // If the user is not authenticated and needs to provide OTP
            if (!$this->authenticator->isAuthenticated()) {
                return $this->authenticator->makeRequestOneTimePasswordResponse();

            }
        }

        return $next($request);
    }
}
