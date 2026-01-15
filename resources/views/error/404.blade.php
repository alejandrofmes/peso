<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PESO') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<a href="/">

</a>

<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen text-center">
    <div class="mb-8">
        <x-application-logo style="width: 150px; height: 150px;" class="fill-current text-gray-500" />
        <!-- Adjust the path and height as needed -->
    </div>
    <div>
        <p class="text-5xl font-extrabold text-gray-800">404</p>
        <p class="text-lg font-medium text-gray-600 mt-4">Oops! The page you're looking for could not be found.</p>
        <a href="{{ url('/') }}"
            class="mt-8 inline-block px-6 py-3 text-white bg-blue-600 hover:bg-blue-700 rounded-lg text-lg font-medium transition">Go
            to Home</a>
    </div>
</body>

</html>
