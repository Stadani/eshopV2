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
            <li><h1>{{$post->title}}</h1></li>
            <li><i class="fa-solid fa-user"></i> {{ $post->user->name }}</li>
            <li><time><i class="fa-solid fa-clock"></i> {{ $post->created_at }} </time></li>
            <li>
                <dl>
                    <dd>
                        <i class="fa-solid fa-tags"></i>
                        @foreach($post->tag as $tag)
                            <div class="tagLink">
                                <a href="/forum?tag%5B%5D={{ $tag->slug }}" >{{$tag->name}}</a>
                            </div>
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
                <button title="Delete" class="button_bar"><i class="fa-solid fa-trash-can"></i>  </button>
            </form>
            <a href="{{ route('posts.edit', $post) }}"><button title="Edit" class="button_bar"><i class="fa-solid fa-file-pen"></i></button></a>
        </div>
    @endif

    <div class="containerGeneral">
        <div class="postUser">
            <img src="https://i.pravatar.cc/100?u={{ $post->id }}" alt="profile">
            <h5 class="username">{{ $post->user->name }}</h5>
            <div>
                <i class="fa-solid fa-eye" title="Views"></i> {{ $post->views }}
            </div>
            <div>
                <i class="fa-solid fa-thumbs-up" title="Likes"></i> {{ $post->likes()->count() }}
                @auth()
                    <form method="POST" action="{{ route('posts.like', $post) }}">
                        @csrf
                        <button type="submit"  >
                            {{ $post->likes()->where('user_id', auth()->id())->exists() ? 'Unlike' : 'Like' }}
                        </button>
                    </form>
                @endauth
            </div>
        </div>

        <div class="postContent">
            {{$post->body}}
        </div>
    </div>

    @guest()
        <div>
            You are not logged in. Please <a href="{{ route('login') }}">log in</a> or <a href="{{ route('register') }}">register</a> to comment on the post.
        </div>
    @endguest
    @auth()
        <form method="POST" action="{{ route('store.comment', $post) }}">
            @csrf
            <div class="containerGeneral">
                <div class="postUser">
                    <img src="https://i.pravatar.cc/100?u={{ auth()->id() }}" alt="">
                </div>
                <div class="postContent">
                    <textarea name="body" placeholder="Comment on post!"></textarea>
                    <button type="submit" class="button_bar">
                        Post
                    </button>
                </div>
            </div>
        </form>
    @endauth


    @foreach($post-> comment as $comment)
        <div class="containerGeneral">
            <x-comment :comment="$comment"/>
        </div>
    @endforeach



@endsection
</body>
</html>
