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
    @endsection
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.0/dist/js/multi-select-tag.js"></script>
</head>
<body>
@extends('components.navbar')

@section('content')
    <!--PAGE CONTENT-->
    <div class="container">
        <div class="navbar_main">
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
        </div>

        <div class="sidenav">
            {{$games->links()}}
            <button class="button_bar" onclick="toggleFilters()"><i class="fa-solid fa-filter"></i></button>
        </div>

    </div>

    <div class=" container pageContent">
        <div class="container gamePanel">
            <x-gameCard :games="$games">

            </x-gameCard>



        </div>
        <div id="filter" class="container filters hidden">
{{--            <div>--}}
{{--                <label for="gameSlider">Games per Page:</label>--}}
{{--                <span>1</span>--}}
{{--                <input type="range" id="gameSlider" min="1" max="50" value="{{ $page_size }}" oninput="fetchGames(value)">--}}
{{--                <span id="sliderValue">{{ $page_size }}</span>--}}
{{--            </div>--}}
{{--            <div>--}}
{{--                --}}
{{--                <form action="/list" method="get" id="genreForm">--}}
{{--                    <div>--}}
{{--                        <select name="genres[]" id="genres" multiple>--}}
{{--                            @foreach($gameGenres['results'] as $genre)--}}
{{--                            <option value="{{ $genre['id'] }}">--}}
{{--                                {{ $genre['name'] }}--}}
{{--                            </option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                    <button type="submit" >Filter</button>--}}
{{--                    @if(request('search'))--}}
{{--                        <input type="hidden" name="search" value="{{ request('search') }}">--}}
{{--                    @endif--}}
{{--                    @if(request('platforms'))--}}
{{--                        @foreach(request('platforms') as $selectedPlatforms)--}}
{{--                            <input type="hidden" name="platforms[]" value="{{ $selectedPlatforms }}">--}}
{{--                        @endforeach--}}
{{--                    @endif--}}
{{--                </form>--}}
{{--            </div>--}}

{{--            <div>--}}
{{--                <form action="/list" method="get" id="platformForm">--}}
{{--                    <div>--}}
{{--                        <select name="platforms[]" id="platforms" multiple>--}}
{{--                            @foreach($gamePlatforms['results'] as $platform)--}}
{{--                                <option value="{{ $platform['id'] }}" {{ in_array($platform['id'], request('platforms', [])) ? 'selected' : '' }}>--}}
{{--                                    {{  $platform['name'] }}--}}
{{--                                </option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </div>--}}

{{--                    @if(request('search'))--}}
{{--                        <input type="hidden" name="searchP" value="{{ request('search') }}">--}}
{{--                    @endif--}}
{{--                    @if(request('genres'))--}}
{{--                        @foreach(request('genres') as $selectedGenre)--}}
{{--                            <input type="hidden" name="genres[]" value="{{ $selectedGenre }}">--}}
{{--                        @endforeach--}}
{{--                    @endif--}}
{{--                </form>--}}
{{--            </div>--}}
            <form action="/list" method="get">
                <div>
                    <select name="genres[]" id="genres" multiple>
                        @foreach($gameGenres['results'] as $genre)
                            <option value="{{ $genre['id'] }}">{{ $genre['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="platforms[]" id="platforms" multiple>
                        @foreach($gamePlatforms['results'] as $platform)
                            <option value="{{ $platform['id'] }}" {{ in_array($platform['id'], request('platforms', [])) ? 'selected' : '' }}>
                                {{ $platform['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                <button type="submit">Filter</button>
            </form>

        </div>
    </div>



@endsection

<script src="{{ asset('js/toggleFilters.js') }}"></script>
{{--<script>--}}

{{--    async function fetchGames(pageSize) {--}}
{{--        try {--}}
{{--            document.getElementById('sliderValue').innerText = pageSize;--}}
{{--            const response = await fetch(`/list?page_size=${pageSize}`, {--}}
{{--                headers: {--}}
{{--                    'X-Requested-With': 'XMLHttpRequest', //assures it works with laravel--}}
{{--                }--}}
{{--            });--}}
{{--            const html = await response.text();--}}
{{--            document.querySelector('.gamePanel').innerHTML = html;--}}
{{--        } catch (error) {--}}
{{--            console.error('Error fetching games:', error);--}}
{{--        }--}}
{{--    }--}}
{{--</script>--}}
{{--<script>--}}
{{--    submitAll = function () {--}}
{{--        document.getElementById('genres').submit();--}}
{{--        document.getElementById('platforms').submit();--}}
{{--    }--}}
{{--</script>--}}


</body>
</html>
