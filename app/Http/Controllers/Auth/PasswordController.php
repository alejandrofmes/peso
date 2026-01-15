<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        // Define the custom validation rule
        Validator::extend('different_from_current', function ($attribute, $value, $parameters, $validator) use ($request) {
            return !Hash::check($value, $request->user()->password);
        }, 'The new password must not be the same as the current password.');

        // Validate the request with the custom rule
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'confirmed',
                'min:8', // Minimum length (adjust as needed)
                'regex:/[a-z]/', // At least one lowercase letter
                'regex:/[A-Z]/', // At least one uppercase letter
                'regex:/[0-9]/', // At least one number
                'regex:/[@$!%*?&]/', // At least one special character
                'different_from_current', // Custom rule
            ],
        ], [
            'current_password.required' => 'The current password is required.',
            'current_password.current_password' => 'The current password is incorrect.',
            'password.required' => 'A new password is required.',
            'password.confirmed' => 'The new password confirmation does not match.',
            'password.min' => 'The password must be at least :min characters long.',
            'password.regex' => 'The password must be at least 8 characters long and include at least one lowercase letter, one uppercase letter, one number, and one special character.',
            'password.different_from_current' => 'The new password must not be the same as the current password.',
        ]);

        // Update the user's password
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Redirect back with success message
        return back()->with('status', 'password-updated');
    }

}
