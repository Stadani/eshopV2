<x-app-layout>
{{--    <x-slot name="header">--}}
{{--        <h2 class="text">--}}
{{--            {{ __('Profile') }}--}}
{{--        </h2>--}}
{{--    </x-slot>--}}
    @extends('components/layout')
    @section('listcss')
    @endsection

{{--    <div class="py-12">--}}
{{--        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">--}}
            <div class="containerGeneral profileCont">
                <div>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="containerGeneral profileCont">
                <div>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="containerGeneral profileCont">
                <div>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
{{--        </div>--}}
{{--    </div>--}}
</x-app-layout>
