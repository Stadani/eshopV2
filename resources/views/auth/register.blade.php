@extends('components/layout')

@section('listcss')
    <link rel="stylesheet" href="/css/postFormStyle.css">
@endsection
<x-guest-layout>
    <div class="containerGeneral">
        <div class="leftHalf py-4">
            <p class="mt-1"><x-input-label for="name" :value="__('Username')" /></p>
            <p class="mt-1"><x-input-label for="email" :value="__('Email')" /></p>
            <p class="mt-1"><x-input-label for="password" :value="__('Password')" /></p>
            <p class="mt-1"><x-input-label for="password_confirmation" :value="__('Confirm Password')" /></p>
        </div>
        <form method="POST" action="{{ route('register') }}">
            <div class="rightHalf py-4">
                @csrf

                <!-- Name -->
                <div >

                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div >

                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div >


                    <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>


                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="text" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="ms-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>
