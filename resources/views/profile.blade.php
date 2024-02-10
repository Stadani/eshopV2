<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PixelNexus | Inventory</title>


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
    <div class="containerGeneral paddingContainer" style="display: block">
        <p><img src="{{$user->profile_picture_url}}" alt="ProfilePicture" width="200"></p>
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

        @if(auth()->user()->is_admin == 1 && $user->email !== auth()->user()->email)
            <div class="buttons">
                <form action="{{ route('profile.suspend', $user) }}" method="POST">
                    @csrf
                    <button title="Suspend" class="button_bar "><i class="fa-solid fa-user-slash"></i></button>
                </form>
                <form action="{{ route('profile.delete', $user) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button title="Delete" class="button_bar ml-4"><i class="fa-solid fa-trash-can"></i></button>
                </form>
            </div>
        @endif


    </div>

    <div class="containerGeneral paddingContainer" style="display: block">
        <h3>Posts</h3>
        {{ $posts->links() }}
        @foreach ($posts as $post)
            <ul>
                <li><a href="/post/{{ $post->slug }}" class="linkText"><h4>{{ $post->title }}</h4></a></li>
            </ul>
        @endforeach
    </div>
    <div class="containerGeneral paddingContainer">
        <h3>Reviews</h3>
    </div>
</x-app-layout>







