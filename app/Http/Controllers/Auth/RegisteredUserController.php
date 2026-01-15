<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => [
                'required',
                'confirmed',
                'min:8', // Minimum length (adjust as needed)
                'regex:/[a-z]/', // At least one lowercase letter
                'regex:/[A-Z]/', // At least one uppercase letter
                'regex:/[0-9]/', // At least one number
                'regex:/[@$!%*?&]/', // At least one special character
            ],
            'role' => ['required', 'in:2,3'],
            'terms' => ['required'],
            'privacy' => ['required'],
            'g-recaptcha-response' => 'recaptcha',

        ], [
            'email.required' => 'Email is required.',
            'email.string' => 'Email must be a valid string.',
            'email.lowercase' => 'Email must be in lowercase.',
            'email.email' => 'Please provide a valid email address.',
            'email.max' => 'Email may not be greater than 255 characters.',
            'email.unique' => 'This email is already registered.',

            'password.required' => 'A password is required.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min' => 'The password must be at least :min characters long.',
            'password.regex' => 'The password must include at least one lowercase letter, one uppercase letter, one number, and one special character.',

            'role.required' => 'Role selection is required.',
            'role.in' => 'The selected role is invalid. Choose between the allowed roles.',

            'terms.required' => 'You must agree to the terms and conditions.',
            'privacy.required' => 'You must agree to the privacy policy.',

        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'usertype' => $request->role, // Validate role selection
        ]);

        event(new Registered($user));

        Auth::login($user);

        return $this->redirectBasedOnRole($user->usertype);
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
            default:
                return redirect(RouteServiceProvider::HOME);
        }
    }
}
