<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" type="image/png" href="{{ asset('brand/logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col justify-center items-center px-4 py-10 bg-gradient-to-br from-sky-50 via-cyan-50 to-white">
            <a href="/" class="flex items-center gap-3 mb-7">
                <x-application-logo class="h-14 w-14" />
                <span class="text-2xl font-bold text-sky-950">Dream Rooms</span>
            </a>

            <div class="w-full sm:max-w-md bg-white/90 border border-sky-100 shadow-sm overflow-hidden sm:rounded-2xl px-6 py-8 sm:px-8">
                {{ $slot }}
            </div>

            <p class="mt-6 text-sm text-slate-500">Panel de administración de Dream Rooms</p>
        </div>
    </body>
</html>
