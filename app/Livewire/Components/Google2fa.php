<?php

namespace App\Livewire\Components;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use PragmaRX\Google2FA\Google2FA as Google2FAGoogle2FA;

class Google2fa extends Component
{

    public $secretKey;
    public $qrCodeUrl;
    public $otpCodeEnable;
    public $otpCodeDisable;
    public $verified = false;
    public $is2FAEnabled = false;

    public function mount()
    {
        $user = Auth::user();

        $this->is2FAEnabled = false;

        if ($user) {
            if ($user->google2fa_secret) {
                $this->is2FAEnabled = true;
            }
        }

    }
    public function openModal()
    {
        $this->generateSecretKey();
        $this->dispatch('open-modal', '2fa-modal');
    }

    // Generate a new 2FA Secret Key
    public function generateSecretKey()
    {
        $google2fa = new Google2FAGoogle2FA();

        // Generate a new secret key
        $this->secretKey = $google2fa->generateSecretKey();

        // Generate the QR Code URL
        $this->generateQrCodeUrl($google2fa);
    }

    // Generate the QR Code URL for 2FA
    public function generateQrCodeUrl($google2fa)
    {
        $user = Auth::user();
        $appName = 'PESOCareers';

        // Get the QR code URL using the Google2FA helper
        $this->qrCodeUrl = $google2fa->getQRCodeUrl(
            $appName, // Issuer (App Name)
            $user->email, // Account name (user email)
            $this->secretKey// The 2FA secret key
        );
    }

    // Verify the 6-digit OTP code entered by the user

    public function verifyCode()
    {
        DB::beginTransaction();

        try {
            $google2fa = new Google2FAGoogle2FA();

            // Verify the code entered by the user
            $isValid = $google2fa->verifyKey($this->secretKey, $this->otpCodeEnable);

            if ($isValid) {
                // Mark the 2FA as verified
                $this->verified = true;

                // Update the user's two-factor authentication fields
                $userID = Auth::user();
                $user = User::findOrFail($userID->id);
                $user->google2fa_secret = $this->secretKey;
                $user->google2fa_enabled_at = now();
                $user->save();

                // Commit the transaction
                DB::commit();

                toastr()->success('Two-Factor Authentication has been enabled successfully!');
                $this->dispatch('close-modal', '2fa-modal');
                $this->reset('otpCodeEnable');
                $this->is2FAEnabled = true;
                session()->put('google2fa', true);

            } else {
                // Rollback the transaction if the OTP is invalid
                DB::rollBack();
                $this->addError('otpCodeEnable', 'Invalid authentication code. Please try again.');
            }
        } catch (\Exception $e) {
            // Rollback the transaction on any exception
            DB::rollBack();
            // Log the exception message for debugging
            Log::error('Error enabling 2FA: ' . $e->getMessage());
            toastr()->error('An error occurred while enabling Two-Factor Authentication. Please try again.');
        }
    }

    public function disableTwoFactor()
    {
        DB::beginTransaction();

        try {
            $google2fa = new Google2FAGoogle2FA();
            $secretKey = Auth::user()->google2fa_secret;
            $isValid = $google2fa->verifyKey($secretKey, $this->otpCodeDisable);

            if ($isValid) {
                // Remove the 2FA secret key from the user's account
                $userID = Auth::user();
                $user = User::findOrFail($userID->id);
                $user->google2fa_secret = null;
                $user->google2fa_enabled_at = null;
                $user->save();

                // Commit the transaction
                DB::commit();

                toastr()->success('Two-Factor Authentication has been disabled successfully!');
                $this->dispatch('close-modal', 'disable-modal');
                $this->reset('otpCodeDisable');
                $this->is2FAEnabled = false;
                session()->forget('google2fa');
            } else {
                // Rollback the transaction if the OTP is invalid
                DB::rollBack();
                $this->addError('otpCodeDisable', 'Invalid authentication code. Please try again.');
            }
        } catch (\Exception $e) {
            // Rollback the transaction on any exception
            DB::rollBack();
            // Log the exception message for debugging
            Log::error('Error disabling 2FA: ' . $e->getMessage());
            toastr()->error('An error occurred while disabling Two-Factor Authentication. Please try again.');
        }
    }

    public function render()
    {

        return view('livewire.components.google2fa');
    }
}
