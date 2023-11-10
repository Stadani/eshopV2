 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Game</title>




    @extends('components/layout')
    @section('listcss')
        <link rel="stylesheet" href="{{ asset('css/forumStyle.css') }}">
        <link rel="stylesheet" href="{{ asset('css/gameDiscussionStyle.css') }}">
        <link rel="stylesheet" href="{{ asset('css/gamePageStyle.css') }}">
    @endsection
</head>
<body>

@extends('components/otherLayout')

@section('content')
<div class="containerGeneral">
    <div class="videoPanel">video panel</div>
    <div class="sidePanel">
        <div>
            image
        </div>
        <div>
            description?
        </div>
        <div>
            release date
            developer
            publisher
            release date
        </div>
        <div>
            tags
        </div>
    </div>
</div>

<div class="containerGeneral">
    content panel
</div>
@endsection
</body>
</html>
