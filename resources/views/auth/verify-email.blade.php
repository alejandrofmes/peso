<x-guest-layout>
    <div class="max-w-xl mx-auto p-6">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">
                {{ __('VERIFY YOUR EMAIL ADDRESS') }}
            </h1>
            <p class="text-gray-600 mt-4">
                {{ __('Thank you for signing up! To get started, please verify your email address by clicking the link we just sent you. If you didn\'t receive the email, you can request a new one.') }}
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="bg-green-100 border border-green-200 text-green-700 rounded-md p-4 mb-4">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        {{-- Display Throttle Error --}}
        @if (session('error'))
            <div class="bg-red-100 border border-red-200 text-red-700 rounded-md p-4 mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex justify-between mt-10">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button class="w-full">
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-secondary-button type="submit"
                    class="">
                    {{ __('Log Out') }}
                </x-secondary-button>
            </form>
        </div>
    </div>
</x-guest-layout>
