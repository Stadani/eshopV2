<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <link rel="icon" type="image/x-icon" href="/images/favicon-32x32.png">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @if (Route::currentRouteName() == 'login')
            <title>Login</title>
        @else
            <title>Register</title>
        @endif


        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @extends('components/layout')
        @section('listcss')
        @endsection
    </head>

    <body>
    <x-navbarIndex>
    </x-navbarIndex>

{{--        <div class="containerGeneral justify-items-center">--}}
{{--            <div class="containerGeneral w-full py-4 ">--}}
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
