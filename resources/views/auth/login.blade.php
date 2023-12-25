@extends('components/layout')

@section('listcss')
    <link rel="stylesheet" href="/css/postFormStyle.css">
@endsection

<x-guest-layout>
    <div class="containerGeneral">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="leftHalf  py-4">
        <p class="mt-1"><x-input-label for="email" :value="__('Email')" /></p>
        <p class="mt-1"><x-input-label for="password" :value="__('Password')" /></p>
    </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf

                <!-- Left Half for Labels -->


                <!-- Right Half for Input Fields and Buttons -->
                <div class="rightHalf py-4">
                    <!-- Email Input -->
                    <div>
                        <x-text-input id="email" class=" block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password Input -->
                    <div class="">
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <span class="text ms-2 text-sm text-gray-600">{{ __('Stay logged in') }}</span>
                        </label>
                    </div>

                    <!-- Buttons and Links -->
                    <div class="flex items-center justify-end mt-4">
                        @if (Route::has('password.request'))
                            <a class=" text" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <x-primary-button class="ms-3">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                </div>

        </form>
    </div>
</x-guest-layout>

