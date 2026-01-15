<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(Request $request)
    {
        $user = User::find($request->route()->id);

        if (!hash_equals(sha1($user->getEmailForVerification()), (string) $request->route('hash'))) {
            throw new AuthorizationException();
        }

        if ($user->hasVerifiedEmail()) {
            Auth::loginUsingId($user->id, $remember = true);

            if ($user->usertype == 2) {
                return redirect()->route('fill_profile');

            } elseif ($user->usertype == 3) {
                return redirect()->route('fill_employer');

            } else {
                return redirect()->route('dashboard');
            }

        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        Auth::loginUsingId($user->id, $remember = true);

        if ($user->usertype == 2) {
            return redirect()->route('fill_profile');

        } elseif ($user->usertype == 3) {
            return redirect()->route('fill_employer');

        } else {
            return redirect()->route('dashboard');
        }

    }
}
