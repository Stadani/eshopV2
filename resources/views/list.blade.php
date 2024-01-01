<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>EShop | Games</title>

    <link rel="stylesheet" href="/css/listStyle.css">

    @extends('components/layout')

    @section('listcss')
        <link rel="stylesheet" href="/css/forumStyle.css">
        <link rel="stylesheet" href="/css/listStyle.css">
        <link rel="stylesheet" href="/css/cardStyle.css">
    @endsection
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.0/dist/js/multi-select-tag.js"></script>
</head>
<body>
@extends('components.navbar')

@section('content')
    <!--PAGE CONTENT-->
    <div class="container centring">
        <div class="navbar_main centring">

            <form method="get" action="/list">
                @if(request('genres'))
                    @foreach(request('genres') as $selectedGenre)
                        <input type="hidden" name="genres[]" value="{{ $selectedGenre }}">
                    @endforeach
                @endif
                    @if(request('platforms'))
                        @foreach(request('platforms') as $selectedPlatforms)
                            <input type="hidden" name="platforms[]" value="{{ $selectedPlatforms }}">
                        @endforeach
                    @endif
                <div class="search-container">
                    <div class="search-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input type="text" class="searchbar" name="search" value="{{ $search ?? '' }}" placeholder=" ..."> {{--    placeholder="{{ isset($showSearch) ? $showSearch : '' }}"--}}
                </div>
            </form>
                <div>
                    <button class="button_bar" onclick="toggleFilters()"><i class="fa-solid fa-filter"></i></button>
                </div>
        </div>

        <div class="sidenav centring">
            {{$games->links()}}
{{--            <button class="button_bar" onclick="toggleFilters()"><i class="fa-solid fa-filter"></i></button>--}}
        </div>
    </div>
    <div class="container content mt-4 ">


        <div class="container gamePanel">
            <x-gameCard :games="$games">

            </x-gameCard>
        </div>

        <div id="filter" class="container filters hidden ">

            <div id="pageSizeSliderContainer">
                <input type="range" id="pageSizeSlider" min="10" max="50" step="10" value="{{ $page_size }}">
                <span id="pageSizeDisplay">{{ $page_size }}</span> per page
            </div>

                <form action="/list" method="get">
                    <div >
                        <div class="scrollForm ">
                            @foreach($gameGenres['results'] as $index => $genre)
                                <div class="{{ $index >= 5 ? 'additionalGenres' : '' }}" style="{{ $index >= 5 ? 'display: none;' : '' }}">
                                    <input type="checkbox" id="genre{{ $genre['id'] }}" name="genres[]" value="{{ $genre['id'] }}"
                                        {{ in_array($genre['id'], request('genres', [])) ? 'checked' : '' }}>
                                    <label for="genre{{ $genre['id'] }}">{{ $genre['name'] }}</label>
                                </div>
                            @endforeach

                        </div>
                        @if(count($gameGenres['results']) > 5)
                            <button type="button" id="showAllGenres" class="button_bar" >Show All</button>
                        @endif
                        <button type="button" id="showLessGenres" class="button_bar" style="display: none;">Show Less</button>
                    </div>
                    <div>
                        <div class="scrollForm mt-4">
                            @foreach($gamePlatforms['results'] as $index => $platform)
                                <div class="{{ $index >= 5 ? 'additionalPlatforms' : '' }}" style="{{ $index >= 5 ? 'display: none;' : '' }}">
                                    <input type="checkbox" id="platform{{ $platform['id'] }}" name="platforms[]" value="{{ $platform['id'] }}"
                                        {{ in_array($platform['id'], request('platforms', [])) ? 'checked' : '' }}>
                                    <label for="platform{{ $platform['id'] }}">{{ $platform['name'] }}</label>
                                </div>
                            @endforeach
                        </div>
                        @if(count($gamePlatforms['results']) > 5)
                            <button type="button" id="showAllPlatforms" class="button_bar" >Show All</button>
                        @endif
                        <button type="button" id="showLessPlatforms" class="button_bar" style="display: none;">Show Less</button>
                    </div>

                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <button type="submit" class="button_bar mt-4">Filter</button>
                </form>

        </div>

    </div>



@endsection

<script src="{{ asset('js/toggleFilters.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var showAllButton = document.getElementById('showAllPlatforms');
        var showLessButton = document.getElementById('showLessPlatforms');

        showAllButton.addEventListener('click', function() {
            var additionalPlatforms = document.querySelectorAll('.additionalPlatforms');
            additionalPlatforms.forEach(function(platform) {
                platform.style.display = 'block';
            });
            this.style.display = 'none';
            showLessButton.style.display = 'block';
        });

        showLessButton.addEventListener('click', function() {
            var additionalPlatforms = document.querySelectorAll('.additionalPlatforms');
            additionalPlatforms.forEach(function(platform) {
                platform.style.display = 'none';
            });
            this.style.display = 'none';
            showAllButton.style.display = 'block';
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var showAllGenresButton = document.getElementById('showAllGenres');
        var showLessGenresButton = document.getElementById('showLessGenres');

        showAllGenresButton.addEventListener('click', function() {
            var additionalGenres = document.querySelectorAll('.additionalGenres');
            additionalGenres.forEach(function(genre) {
                genre.style.display = 'block';
            });
            this.style.display = 'none';
            showLessGenresButton.style.display = 'block';
        });

        showLessGenresButton.addEventListener('click', function() {
            var additionalGenres = document.querySelectorAll('.additionalGenres');
            additionalGenres.forEach(function(genre) {
                genre.style.display = 'none';
            });
            this.style.display = 'none';
            showAllGenresButton.style.display = 'block';
        });
    });
</script>

</body>
</html>
