<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>EShop | Discussion</title>

    <!-- Add these lines in your HTML -->


    @extends('components/layout')
    @section('listcss')
        <link rel="stylesheet" href="/css/forumStyle.css">
    @endsection
{{--    had to link like this because after opening post it doesnt work--}}
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon-32x32.png') }}">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>
<body>

@extends('components.navbar')
@section('content')
    <!--PAGE CONTENT-->
    <div class="container bar">
        <div>
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

                <form id="filterForm" method="get" action="/forum">
                    <div class="dropdown">
                        <button class="dropdown-toggle button_arrow" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            Tags
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @foreach($tags as $tag)
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="tag[]" value="{{ $tag->slug }}" id="Checkme{{ $tag->slug }}" {{ in_array($tag->slug, request('tag', [])) ? 'checked' : '' }} />
                                            <label class="form-check-label" for="Checkme{{ $tag->slug }}">{{ $tag->name }}</label>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                </form>

                <form method="get" action="#">
                    @if(request('tag'))
                        @foreach(request('tag') as $selectedTag)
                            <input type="hidden" name="tag[]" value="{{ $selectedTag }}">
                        @endforeach
                    @endif
                        <div class="search-container">
                            <div class="search-icon">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <input type="text" class="searchbar" name="search" value="{{ isset($showSearch) ? $showSearch : '' }}" placeholder=" ..." class="searchbar"> {{--    placeholder="{{ isset($showSearch) ? $showSearch : '' }}"--}}
                        </div>
                </form>
            </div>
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
        <script>
            $(document).ready(function() {
                $('input[type=checkbox]').on('change', function() {
                    $('#filterForm').submit();
                });
            });
        </script>
</body>
