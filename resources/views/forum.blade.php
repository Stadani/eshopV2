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

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    @extends('components.navbar')

</head>
<body>

@section('content')


    <!--BUTTON TO POST POSTS-->
    <div class="container bar">
        @auth()
            <div>
                <a href="/postForm">
                    <button type="button" class="button_bar">
                        <i class="fa-solid fa-pencil"></i> Post Thread
                    </button>
                </a>
            </div>
        @endauth
        @guest()
            <div>
                You are not logged in. Please <a href="{{ route('login') }}">log in</a> or <a
                    href="{{ route('register') }}">register</a> to post on the forum.
            </div>
        @endguest

        {{--PAGINATION--}}
        <div class="container arrow_bar">
            <div id="paginationContainer" class="navbar_main">
                {{ $forum->links() }}
            </div>

            {{--TAGS DROPDOWN--}}
            <div class="sidenav just">
                <select id="postsPerPageDropdown" onchange="updatePostsPerPage(this.value)">
                    <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5 per page</option>
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 per page</option>
                    <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15 per page</option>
                    <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20 per page</option>
                </select>
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
                                            <input class="form-check-input" type="checkbox" name="tag[]"
                                                   value="{{ $tag->slug }}"
                                                   id="Checkme{{ $tag->slug }}" {{ in_array($tag->slug, request('tag', [])) ? 'checked' : '' }} />
                                            <label class="form-check-label"
                                                   for="Checkme{{ $tag->slug }}">{{ $tag->name }}</label>
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

{{--                SEARCHBAR--}}
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
                        <input type="text" class="searchbar" name="search"
                               value="{{ isset($showSearch) ? $showSearch : '' }}" placeholder=" ...">
                    </div>
                </form>
            </div>
        </div>
    </div>





{{--    POSTS--}}
    <div id="forumContainer">
        <x-forumItem :forum="$forum">

        </x-forumItem>
    </div>

@endsection

{{--<script src="{{ asset('js/dropdownSubmit.js') }}"></script>--}}
<script src="{{ asset('js/forumAjax.js') }}"></script>


</body>
