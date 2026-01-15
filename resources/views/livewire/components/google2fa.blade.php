<div>

    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Two-Factor Authentication') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Enhance your account security by enabling Two-Factor Authentication (2FA). Use the Google Authenticator app to generate a time-based, one-time code that provides an extra layer of protection beyond your password.') }}
        </p>
    </header>

    <div class="mt-6">



        @if ($is2FAEnabled == false)
            <x-primary-button wire:click.prevent='openModal'>
                Enable
            </x-primary-button>
        @else
            <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'disable-modal')">
                Disable
            </x-danger-button>
        @endif


    </div>



    <x-modal name="2fa-modal" focusable>
        <div class="w-full  px-6 py-6 bg-white shadow-lg rounded-lg">
            <h2 class="text-lg font-semibold text-gray-900">
                {{ __('Enable Two-Factor Authentication') }}
            </h2>
            <hr class="my-4 border-gray-200">

            <div class="flex flex-col space-y-6">
                <p class="text-sm text-gray-600">
                    {{ __('To enhance your account security, enable Two-Factor Authentication by following the steps below.') }}
                </p>

                @if ($secretKey && !$verified)
                    <div class="space-y-4">
                        <p class="text-sm text-gray-700">
                            {{ __('Scan the QR code below using your 2FA app or manually enter the code provided.') }}
                        </p>

                        <div class="flex justify-center mb-4">
                            @if ($qrCodeUrl)
                                {!! QrCode::size(200)->generate($qrCodeUrl) !!}
                            @endif
                        </div>

                        <p class="text-sm text-gray-600">
                            {{ __('Manual entry code:') }} <strong>{{ $secretKey }}</strong>
                        </p>

                        <div>
                            <x-input-label for="otpCodeEnable" :value="__('6-Digit OTP')" />
                            <x-text-input wire:model="otpCodeEnable" id="otpCodeEnable"
                                class="mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="otp"
                                autofocus placeholder="Enter 6-digit code" maxlength="6" x-data
                                x-on:input="if (!/^[0-9]*$/.test($event.target.value)) $event.target.value = $event.target.value.replace(/[^0-9]/g, '')" />
                            <x-input-error :messages="$errors->get('otpCodeEnable')" class="text-red-600 text-sm mt-1" />
                        </div>

                    </div>
                @endif
            </div>

            <div class="mt-6 flex justify-between items-center">
                <x-secondary-button x-on:click="$dispatch('close')" class="bg-gray-200 text-gray-700 hover:bg-gray-300">
                    {{ __('Close') }}
                </x-secondary-button>

                @if ($secretKey && !$verified)
                    <x-green-button wire:click.prevent="verifyCode">
                        {{ __('Enable 2FA') }}
                    </x-green-button>
                @endif
            </div>
        </div>
    </x-modal>

    <x-modal name="disable-modal" focusable>
        <div class="w-full  px-6 py-6 bg-white shadow-lg rounded-lg">
            <h2 class="text-lg font-semibold text-gray-900">
                {{ __('Disable Two-Factor Authentication') }}
            </h2>
            <hr class="my-4 border-gray-200">
            <div class="flex flex-col space-y-4">
                <p class="text-sm text-gray-600">
                    {{ __('To disable Two-Factor Authentication, please enter the 6-digit OTP code from your authenticator app.') }}
                </p>

                <div>
                    <x-input-label for="otpCodeDisable" :value="__('6-Digit OTP')" />
                    <x-text-input wire:model="otpCodeDisable" id="otpCodeDisable"
                        class="w-full border-gray-300 rounded-md shadow-sm" type="text" name="otp" required
                        autofocus placeholder="Enter OTP" maxlength="6" x-data
                        x-on:input="if (!/^[0-9]*$/.test($event.target.value)) $event.target.value = $event.target.value.replace(/[^0-9]/g, '')" />
                    <x-input-error :messages="$errors->get('otpCodeDisable')" class="text-red-600 text-sm mt-1" />
                </div>
            </div>

            <div class="mt-6 flex justify-between items-center">
                <x-secondary-button x-on:click="$dispatch('close')" class="bg-gray-200 text-gray-700 hover:bg-gray-300">
                    {{ __('Close') }}
                </x-secondary-button>

                <x-danger-button wire:click.prevent='disableTwoFactor' class="bg-red-600 hover:bg-red-700">
                    {{ __('Disable 2FA') }}
                </x-danger-button>
            </div>
        </div>
    </x-modal>


</div>
