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

</head>
<body>

@extends('components.navbar')

@section('content')
    <div class="containerGeneral postNameAndTags">
        <div>
            {{$post->title}}
        </div>

        <div class="postNameAndTags postTags">
            <ul>
                <li>{{ $post->user->name }}</li>
                <li><time> {{ $post->created_at }} </time></li>
                <li>
                    <dl>
                        <dd>
                            <i class="fa-solid fa-tags"></i>
                            @foreach($post->tag as $tag)
                                <a href="/tags/{{ $tag->slug }}">{{$tag->name}}</a>
                            @endforeach
                        </dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>

    <div class="containerGeneral">
        <div class="postUser">
            <img src="/images/albertwhisker.png" alt="profile">
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
