<section x-data="">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form x-ref="emailChangeForm" x-on:submit.prevent="$dispatch('open-modal', 'confirm-email-change-modal')"
        method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div> --}}

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @elseif (session('status') === 'no-changes')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('No Changes.') }}</p>
            @endif
        </div>
    </form>


    <x-modal name="confirm-email-change-modal" focusable>
        <div class="w-full max-w-4xl px-6 py-6 items-center">
            <!-- Header Section -->
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Confirm Email Change') }}
            </h2>
            <hr>

            <!-- Content Section -->
            <div class="flex flex-col my-4">
                <div class="flex flex-col mt-4 mb-4 w-full justify-center items-center px-4">
                    <span class="text-xl font-semibold text-red-600">
                        {{ __('Warning: This action cannot be undone.') }}
                    </span>
                    <p class="mt-4 text-gray-600 text-center">
                        {{ __('Changing your email address will require you to verify your account again.') }}
                        <br>
                        {{ __('Please ensure that the new email is correct before proceeding.') }}
                    </p>
                </div>
            </div>

            <!-- Buttons Section -->
            <div class="mt-6 flex justify-between">
                <!-- Cancel Button -->
                <x-secondary-button x-on:click="$dispatch('close-modal', 'confirm-email-change-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <!-- Confirm Button -->
                <x-danger-button class="ms-3" x-on:click="document.querySelector('[x-ref=emailChangeForm]').submit()">
                    {{ __('Confirm Email Change') }}
                    <!-- Loading Spinner -->

                </x-danger-button>
            </div>
        </div>
    </x-modal>
</section>
