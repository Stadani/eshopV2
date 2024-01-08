<x-app-layout>

    @extends('components/layout')
    @section('listcss')
    @endsection


    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="containerGeneral profileCont">
        <img src="{{ Auth::user()->profile_picture_url }}" alt="Profile Picture">
    </div>
            <div class="containerGeneral profileCont">
                <form method="POST" action="{{ route('user-profile-picture.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div>
                       <h2 class="text"><label for="profile_picture">Profile Picture</label></h2>
                       <p><input id="profile_picture" type="file" name="profile_picture" required></p>
                    </div>

                    <div>
                        <button type="submit" class="button_bar">Update Profile Picture</button>
                    </div>
                </form>
            </div>
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

</x-app-layout>
