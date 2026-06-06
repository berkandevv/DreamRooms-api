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
        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- Lightbox compartido para ver las fotos del panel -->
        <div
            x-data="{ open: false, url: '', alt: '' }"
            x-on:open-lightbox.window="url = $event.detail.url; alt = $event.detail.alt; open = true"
            x-on:keydown.escape.window="open = false"
            x-show="open"
            x-cloak
            x-transition.opacity
            @click="open = false"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4"
        >
            <button
                type="button"
                @click="open = false"
                class="absolute right-5 top-4 text-4xl leading-none font-bold text-white/80 transition hover:text-white"
                aria-label="Close"
            >&times;</button>
            <img
                :src="url"
                :alt="alt"
                @click.stop
                class="max-h-[90vh] max-w-[90vw] rounded-lg object-contain shadow-2xl"
            >
        </div>
    </body>
</html>
