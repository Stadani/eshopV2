<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>EShop | Discussion</title>


    @extends('components/layout')
    @section('listcss')
        <link rel="stylesheet" href="/css/forumStyle.css">
    @endsection
{{--    had to link like this because after opening post it doesnt work--}}
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon-32x32.png') }}">
</head>
<body>

@extends('components.navbar')
@section('content')
    <!--PAGE CONTENT-->
    <div class="container bar">
        <button type="button" class="button_bar">
            <i class="fa-solid fa-pencil"></i> Post Thread
        </button>
    </div>

    <div class="container arrow_bar">
        <div class="navabar_main">
            <button class="button_arrow">
                <
            </button>
            1
            <button class="button_arrow">
                >
            </button>
        </div>
        <div class="sidenav just">
            <form method="get" action="#">
                <input type="text"  name="search" value="{{ isset($show) ? $show : '' }}">
            </form>
        </div>
    </div>

    <!--TABLE-->
    @foreach($forum as $post)
        <div>
            <div class="container">
                <div class="table_item">
                    <div class="table_cell table_cell_icon">
                        <div class="table_cell_icon_cont">
                            <img src="/images/favicon-32x32.png" alt="profile">
                        </div>
                    </div>
                    <div class="table_cell table_cell_main">
                        <div>
                            <div class="table_cell_title">
                                <a href="/post/{{ $post->slug }}">
                                    {{$post->title}}
                                </a>
                            </div>
                            <div class="table_cell_info">
                                <a href="">{{ $post->user->name }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="table_cell table_cell_middle table_cell_info">
                        <div class="table_cell_stats">
                            <div>
                                Views
                            </div>
                            <div>
                                Replies
                            </div>
                        </div>
                        <div class="table_cell_stats table_cell_stats_right">
                            <div>
                                123
                            </div>
                            <div>
                                1233
                            </div>
                        </div>
                    </div>

                    <div class="table_cell table_cell_side">
                        <div>
                            <div class="table_cell_info">
                                1 min ago
                            </div>
                            <div class="table_cell_info ">
                                <a href="">Username</a>
                            </div>
                        </div>
                    </div>
                    <div class="table_cell table_cell_icon">
                        <div class="table_cell_icon_cont">
                            <img src="/images/albertwhisker.png" alt="profile">
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endsection

        </div>
</body>
