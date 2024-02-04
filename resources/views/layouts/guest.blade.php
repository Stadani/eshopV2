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
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    </head>

    <body>
    <x-navbarIndex>
    </x-navbarIndex>

    @if(session('error'))
        <div id="successMessage" class="alert alert-danger messageBL">
            {{ session('error') }}
        </div>
    @endif

                {{ $slot }}

    </body>
</html>
