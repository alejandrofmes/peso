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
    <link href="https://pagecdn.io/lib/easyfonts/fonts.css" rel="stylesheet" />


    {{-- ICONS --}}
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.5.2-web/css/all.min.css') }}">

    {{-- FLOWBITE --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <!-- TOOLTIP -->
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css" />

    {{-- SUMMERNOTE --}}
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="flex flex-col min-h-screen font-sans antialiased bg-gray-100">

    @include('layouts.navigation')



    <div class="flex flex-row">
        @include('admin.admin_partials.admin-navbar')




        {{ $slot }}




    </div>










    @livewireChartsScripts
    @livewireScripts

    {{-- TOOLTIP --}}
    <script src="https://cdn.jsdelivr.net/npm/@ryangjchandler/alpine-tooltip@1.x.x/dist/cdn.min.js" defer></script>
    {{-- SUMMERNOTE --}}
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    {{-- QR CODE --}}
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>

    {{-- FLOWBITE --}}
    <script src="https://unpkg.com/flowbite@1.5.1/dist/flowbite.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script>
        @if (session('login_success'))
            localStorage.removeItem('user-logged-out');
        @endif


        function handleLogout() {
            if (localStorage.getItem('user-logged-out') === 'true') {
                localStorage.removeItem('user-logged-out'); // Clean up
                window.location.href = '/'; // Redirect to the welcome page
            }
        }

        // Listen for storage events
        window.addEventListener('storage', function(event) {
            if (event.key === 'user-logged-out') {
                handleLogout();
            }
        });
    </script>

    @stack('scripts')

</body>

</html>
