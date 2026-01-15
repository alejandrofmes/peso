<?php

namespace App\Http\Middleware\profile;

use App\Models\Employee;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class profileStatus
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
        $profileId = $request->route('id');
        $user = Auth::user();

        // Find the jobseeker based on the id
        $profileOwner = Employee::find($profileId);

        if (!$profileOwner) {
            // If the profile owner or employee doesn't exist, abort with a 404
            return abort(404, 'Profile not found');
        }

        $profileUserStatus = $profileOwner->empprofile; // Profile visibility status

        // Case 1: Profile is private (profileUserStatus == 1)
        if ($profileUserStatus == 1) {
            // Only the profile owner or users with usertype of 8 and above can view
            if ($user->id !== $profileOwner->user_id && $user->usertype < 8) {
                return abort(404, 'Profile not found');
            }
        }

        // Case 2: Profile is visible to users with usertype of 6 and up, or to the profile owner (profileUserStatus == 2)
        elseif ($profileUserStatus == 2) {
            if ($user->id !== $profileOwner->user_id && $user->usertype < 6) {
                return abort(404, 'Profile not found');
            }
        }

        // Case 3: Profile is public to users with usertype of 4 and up (profileUserStatus == 3)
        elseif ($profileUserStatus == 3) {
            if ($user->usertype < 4) {
                return abort(404, 'Profile not found');
            }
        }

        return $next($request);
    }

}
