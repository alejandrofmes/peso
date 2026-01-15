<section x-data="">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form x-ref="passwordForm" x-on:submit.prevent="$dispatch('open-modal', 'confirm-password-change-modal')" method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    <x-modal name="confirm-password-change-modal" focusable>
        <div class="w-full max-w-4xl px-6 py-6 items-center">
            <!-- Header Section -->
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Confirm Password Change') }}
            </h2>
            <hr>
    
            <!-- Content Section -->
            <div class="flex flex-col my-4">
                <div class="flex flex-col mt-4 mb-4 w-full justify-center items-center px-4">
                    <span class="text-xl font-semibold text-red-600">
                        {{ __('Warning: This action cannot be undone.') }}
                    </span>
                    <p class="mt-4 text-gray-600 text-center">
                        {{ __('Changing your password will log you out of all devices.') }}
                        <br>
                        {{ __('Please ensure that your new password is secure and memorable.') }}
                    </p>
                </div>
            </div>
    
            <!-- Buttons Section -->
            <div class="mt-6 flex justify-between">
                <!-- Cancel Button -->
                <x-secondary-button x-on:click="$dispatch('close-modal', 'confirm-password-change-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>
    
                <!-- Confirm Button -->
                <x-danger-button x-on:click="document.querySelector('[x-ref=passwordForm]').submit()">
                    {{ __('Confirm Password Change') }}
                </x-danger-button>
            </div>
        </div>
    </x-modal>
</section>