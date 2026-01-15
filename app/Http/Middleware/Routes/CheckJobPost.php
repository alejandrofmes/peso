<?php

namespace App\Http\Middleware\Routes;

use App\Models\Job_Posting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckJobPost
{
    public function handle(Request $request, Closure $next)
    {
        $jobPost = Job_Posting::findOrFail($request->route('id'));

        if ($jobPost) {
            if (Auth::user()->usertype <= 6 && $jobPost->job_Status == 'PENDING') {
                return redirect()->route('dashboard');
            }
        } else {
            return redirect()->route('dashboard');
        }

        return redirect()->route('dashboard');

    }
}
