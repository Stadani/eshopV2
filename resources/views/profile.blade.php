<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PixelNexus | {{$user->name}}</title>


    @extends('components/layout')
    @section('listcss')
        <link rel="stylesheet" href="/css/userProfileStyle.css">
    @endsection
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
@if(session()->has('success'))
    <div id="successMessage" class="alert alert-success messageBL">
        {{ session('success') }}
    </div>
@endif
<x-app-layout>
    <div class="containerGeneral profileCont">
        <div>
            <img src="{{ $user->profile_picture_url }}" alt="Profile Picture" class="profilePic">
        </div>
        <div class="ml-3">
            <p> Username: {{$user->name }}</p>
            <p> Joined: {{$user->created_at->format('Y-m-d') }}</p>
            <p> Role: @if($user->is_admin === 1)
                    Admin
                @else
                    User
                @endif
            </p>
            <p>Status: @if($user->is_suspended === 1)
                    Suspended
                @else
                    Normal
                @endif
            </p>
        </div>
        <div class="ml-3">
            @if(auth()->user()->is_admin == 1 && $user->email !== auth()->user()->email)
                <div class="buttons">
                    <form action="{{ route('profile.suspend', $user) }}" method="POST">
                        @csrf
                        <textarea type="text" name="reason" placeholder="Reason for suspension"
                                  style="color: #222222" cols="40"></textarea>
                        <button title="Suspend" class="button_bar align-top" type="submit"><i class="fa-solid fa-user-slash"></i></button>
                    </form>
                    <div>
                        <form action="{{ route('profile.delete', $user) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <textarea type="text" name="reason" placeholder="Reason for deleting"
                                      style="color: #222222" cols="40"></textarea>
                            <button title="Delete" class="button_bar align-top px-2" type="submit"><i
                                    class="fa-solid fa-trash-can"></i></button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="containerGeneral paddingContainer" style="display: block">
        {{ $posts->links() }}
    </div>
    <div class="containerGeneral paddingContainer" style="display: block">
        <h3>Posts</h3>

        @foreach ($posts as $post)
            <ul>
                <li><a href="/post/{{ $post->slug }}" class="linkText"><h4>{{ $post->title }}</h4></a></li>
            </ul>
        @endforeach
    </div>
    <div class="containerGeneral paddingContainer" style="display: block">
        <h3>Reviews</h3>
        @foreach ($reviews as $review)
            <ul>
                <li><a href="{{route('game.show', ['id' => $review->game_id])}}" class="linkText">
                        <h4>{{ $review->game->name }}</h4></a></li>
            </ul>
        @endforeach
    </div>
</x-app-layout>







