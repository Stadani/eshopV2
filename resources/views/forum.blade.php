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
                You are not logged in. Please <a href="{{ route('login') }}">log in</a> or <a href="{{ route('register') }}">register</a> to post on the forum.
            </div>
        @endguest
        <div class="container arrow_bar">
            <div class="navbar_main">
                {{ $forum->links() }}
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
                            <input type="text" class="searchbar" name="search" value="{{ isset($showSearch) ? $showSearch : '' }}" placeholder=" ...">
                        </div>
                </form>
            </div>
        </div>
    </div>

    <select id="postsPerPageDropdown" onchange="updatePostsPerPage(this.value)">
        <option value="6">6 per page</option>
        <option value="12">12 per page</option>

    </select>






        <script src="{{ asset('js/dropdownSubmit.js') }}"></script>

    <div id="forum-container">
        <x-forumItem :forum="$forum">

        </x-forumItem>
    </div>


@endsection


<script>
    $(document).ready(function () {
        function updatePostsPerPage(perPage) {
            console.log('Updating posts per page:', perPage);
            $.ajax({
                type: 'GET',
                url: '/forum',
                data: {perPage: perPage},
                success: function (response) {
                    console.log('Success:', response);
                    // Update the HTML content with the new posts
                    $('body').html(response);
                },
                error: function (error) {
                    console.error('Error updating posts per page:', error);
                }
            });
        }

        // Handle the onchange event of the select element
        $('#postsPerPageDropdown').on('change', function () {
            updatePostsPerPage($(this).val());
        });
    });
</script>
</body>
