<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post</title>


    @extends('components/layout')
    @section('listcss')
        <link rel="stylesheet" href="/css/forumStyle.css">
        <link rel="stylesheet" href="/css/gameDiscussionStyle.css">
    @endsection
    {{--    had to link like this because after opening post it doesnt work--}}
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon-32x32.png') }}">

</head>
<body>

@extends('components.navbar')

@section('content')

        <div class="postNameAndTags postNameAndTags">
            <ul>
                <li>{{$post->title}}</li>
                <li><i class="fa-solid fa-user"></i> {{ $post->user->name }}</li>
                <li><time><i class="fa-solid fa-clock"></i> {{ $post->created_at }} </time></li>
                <li>
                    <dl>
                        <dd>
                            <i class="fa-solid fa-tags"></i>
                            @foreach($post->tag as $tag)
                                <a href="/forum?tag%5B%5D={{ $tag->slug }}" >{{$tag->name}}</a>
                            @endforeach
                        </dd>
                    </dl>
                </li>
            </ul>
        </div>

        @if(auth()->user() && auth()->user()->id === $post->user->id)
            <div class="postNameAndTags eanddbuttons">
                <form action="{{ route('destroy.post', $post) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button title="Delete"><i class="fa-solid fa-trash-can"></i>  </button>
                </form>
                <a href="{{ route('posts.edit', $post) }}"><button title="Edit"><i class="fa-solid fa-file-pen"></i></button></a>
            </div>
        @endif

    <div class="containerGeneral">
        <div class="postUser">
            <img src="https://i.pravatar.cc/100" alt="profile">
            <h4 class="username">{{ $post->user->name }}</h4>
        </div>

        <div class="postContent">
            {{$post->body}}
        </div>
    </div>

    <div class="containerGeneral">
        <div class="postUser">user</div>
        <div class="postContent">content</div>
    </div>
@endsection
</body>
</html>
