<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/PESO-Logo.png') }}">


    <title>{{ config('app.name', 'PESO') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=ubuntu:300,300i,400,400i,500,500i,700,700i" rel="stylesheet" />

    {{-- ICONS --}}
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.5.2-web/css/all.min.css') }}">

    {{-- FLOWBITE --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <!-- TOOLTIP -->
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css" />
    {{-- SUMMERNOTE --}}
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    {{-- SUMMERNOTE --}}
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    {{-- ALPINE TOOLTIP --}}
    <script src="https://cdn.jsdelivr.net/npm/@ryangjchandler/alpine-tooltip@1.x.x/dist/cdn.min.js" defer></script>

    <link href="https://pagecdn.io/lib/easyfonts/fonts.css" rel="stylesheet" />

    {{-- QR CODE --}}
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>

    {{-- CHARTS --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @livewireChartsScripts

    <!-- Scripts -->
    @livewireStyles
    @livewireScripts
    @vite(['resources/css/app.css'])
</head>

<body class="font-sans text-gray-900 antialiased">

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <a href="/">
                <x-application-logo style="width: 150px; height: 150px;" class="fill-current text-gray-500" />
            </a>
        </div>

        <div class="max-w-lg mx-auto mt-12 p-8 bg-white shadow-lg rounded-lg border border-gray-200">
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-3">
                    {{ __('Account Disabled') }}
                </h1>
                <p class="text-gray-600 text-lg">
                    {{ __('Your account has been disabled. To reactivate your account, please contact your local municipality for further assistance.') }}
                </p>
            </div>

            <div class="flex flex-col items-center bg-gray-50 p-6 rounded-lg border border-gray-200">
                <p class="text-sm text-gray-600 mb-4">
                    {{ __('For more information or if you need help, you can reach out to your municipality office or visit their website.') }}
                </p>
                <a href="mailto:support@yourdomain.com" class="text-blue-500 hover:text-blue-600 font-medium text-lg">
                    {{ __('Contact Support') }}
                </a>
            </div>

            <div class="flex justify-center mt-8">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="bg-blue-500 text-white hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        {{ __('Return to Home') }}
                    </button>
                </form>
            </div>
        </div>

    </div>
    <script>
        window.addEventListener('storage', function(event) {
            if (event.key === 'user-logged-out') {
                localStorage.removeItem('user-logged-out'); // Clean up
                window.location.href = '/'; // Redirect to the welcome page
            }
        });
    </script>

</body>

</html>
