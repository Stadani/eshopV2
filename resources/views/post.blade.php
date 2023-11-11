<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post</title>



    @extends('components/layout')
    @section('listcss')
        <link rel="stylesheet" href="{{ asset('css/forumStyle.css') }}">
        <link rel="stylesheet" href="{{ asset('css/gameDiscussionStyle.css') }}">
    @endsection

</head>
<body>

@extends('components/otherLayout')

@section('content')
<div class="containerGeneral postNameAndTags">
    <div>
        {{$post->title}}
    </div>
    <div class="postNameAndTags postTags">
        <ul>
            <li>username</li>
            <li>date</li>
            <li>tags
                <dl>
                    <dt>
                        ikona pre tagy
                    </dt>
                    <dd>
                        tu bude zoznam tagov
                    </dd>
                </dl>
            </li>
        </ul>
    </div>
</div>

<div class="containerGeneral">
    <div class="postUser">
        <img src="{{ asset('images/albertwhisker.png') }}" alt="profile">
        <h4 class="username">albert whisker</h4>
    </div>

    <div class="postContent">
        {{$post->body}}
    </div>
</div>

<div class="containerGeneral">
    <div class="postUser">user </div>
    <div class="postContent">content</div>
</div>
@endsection
</body>
</html>
