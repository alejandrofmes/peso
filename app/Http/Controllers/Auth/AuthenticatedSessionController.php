<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use PragmaRX\Google2FA\Google2FA;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember'); // Check if 'remember' checkbox is checked

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = $request->user();
            $request->session()->put('user_type', $user->usertype);

            session()->flash('login_success', true);

            return $this->redirectBasedOnRole($user->usertype);
        }

        // Return back with errors and old input (email)
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email')); // Keeps the email field populated
    }

    public function verify2FA(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6', // Validate OTP input
        ]);

        $user = Auth::user(); // Get the currently authenticated user
        $google2fa = new Google2FA();

        // Verify the OTP
        $isValid = $google2fa->verifyKey($user->google2fa_secret, $request->input('otp'));

        if ($isValid) {
            $request->session()->put('google2fa', true);
            // OTP is valid, log the user in
            Auth::login($user);

            // Redirect to intended page or home
            return redirect()->intended('dashboard');
        } else {
            // OTP is invalid
            return redirect()->back()->withInput()->withErrors(['otp' => 'The OTP you entered is invalid.']);

        }
    }

    /**
     * Redirect based on user role.
     */
    private function redirectBasedOnRole(int $usertype): RedirectResponse
    {

        switch ($usertype) {
            case 2:
                return redirect()->route('fill_profile');
            case 3:
                return redirect()->route('fill_employer');
            case 10:
                return redirect()->route('admin');
            default:
                return redirect(RouteServiceProvider::HOME);
        }
    }
    /**
     * Destroy an authenticated session.
     */
    // public function destroy(Request $request): RedirectResponse
    // {
    //     Auth::guard('web')->logout();

    //     $request->session()->invalidate();

    //     $request->session()->regenerateToken();

    //     return redirect('/');
    // }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->view('welcome', [], 200, [
            'Content-Type' => 'text/html',
        ])->header('Content-Type', 'text/html')
            ->header('Cache-Control', 'no-store')
            ->header('Pragma', 'no-cache')
            ->setContent('<script>
                localStorage.setItem("user-logged-out", "true");
                window.location.href = "/";
            </script>');
    }

}

// Set a flag in local storage and redirect to the welcome page
