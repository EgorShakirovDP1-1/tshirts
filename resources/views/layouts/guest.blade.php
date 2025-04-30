<!DOCTYPE html>

        <!-- Navigation -->
        @include('layouts.navigation')

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Tshirts') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css?family=alumni-sans:100,200,300,400" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-pink-50 to-purple-100">

        <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0">
      

            <!-- Content Card -->
            <div class="py-6">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
