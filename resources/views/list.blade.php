

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
                    @if(request('developers'))
                        @foreach(request('developers') as $selectedDevelopers)
                            <input type="hidden" name="developers[]" value="{{ $selectedDevelopers }}">
                        @endforeach
                    @endif
                    @if(request('publishers'))
                        @foreach(request('publishers') as $selectedPublishers)
                            <input type="hidden" name="developers[]" value="{{ $selectedPublishers }}">
                        @endforeach
                    @endif
                    @if(request('ordering'))
                        <input type="hidden" name="ordering" value="{{ request('ordering') }}">
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
                <form action="/list" method="get">
                    <div>
                        <label for="ordering">Sort By:</label>
                        <select name="ordering" id="ordering" onchange="handleSortChange(this.value)">
                            <option value="" {{ request('ordering') == '' ? 'selected' : '' }}>Relevance</option>
                            <option value="-name" {{ request('ordering') == '-name' ? 'selected' : '' }}>Name Desc</option>
                            <option value="name" {{ request('ordering') == 'name' ? 'selected' : '' }}>Name Asc</option>
                            <option value="-released" {{ request('ordering') == '-released' ? 'selected' : '' }}>Released Desc</option>
                            <option value="released" {{ request('ordering') == 'released' ? 'selected' : '' }}>Released Asc</option>
                            <option value="-rating" {{ request('ordering') == '-rating' ? 'selected' : '' }}>Rating Desc</option>
                            <option value="rating" {{ request('ordering') == 'rating' ? 'selected' : '' }}>Rating Asc</option>
                            <option value="-metacritic" {{ request('ordering') == '-metacritic' ? 'selected' : '' }}>Metacritic Desc</option>
                            <option value="metacritic" {{ request('ordering') == 'metacritic' ? 'selected' : '' }}>Metacritic Asc</option>
                        </select>

                    </div>
                    <div >
                        <div class="scrollForm mt-4">
                           <span class="filterFont">GENRES</span>
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
                           <span class="filterFont">PLATFORMS</span>
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
                    <div>
                        <div class="scrollForm mt-4">
                            <span class="filterFont">DEVELOPERS</span>
                            @foreach($gameDevelopers['results'] as $index => $developer)
                                <div class="{{ $index >= 5 ? 'additionalDevelopers' : '' }}" style="{{ $index >= 5 ? 'display: none;' : '' }}">
                                    <input type="checkbox" id="developer{{ $developer['id'] }}" name="developers[]" value="{{ $developer['id'] }}"
                                        {{ in_array($developer['id'], request('developers', [])) ? 'checked' : '' }}>
                                    <label for="developer{{ $developer['id'] }}">{{ $developer['name'] }}</label>
                                </div>
                            @endforeach
                        </div>
                        @if(count($gameDevelopers['results']) > 5)
                            <button type="button" id="showAllDevelopers" class="button_bar" >Show All</button>
                        @endif
                        <button type="button" id="showLessDevelopers" class="button_bar" style="display: none;">Show Less</button>
                    </div>
                    <div>
                        <div class="scrollForm mt-4">
                            <span class="filterFont">PUBLISHERS</span>
                            @foreach($gamePublishers['results'] as $index => $publisher)
                                <div class="{{ $index >= 5 ? 'additionalPublishers' : '' }}" style="{{ $index >= 5 ? 'display: none;' : '' }}">
                                    <input type="checkbox" id="publisher{{ $publisher['id'] }}" name="publishers[]" value="{{ $publisher['id'] }}"
                                        {{ in_array($publisher['id'], request('publishers', [])) ? 'checked' : '' }}>
                                    <label for="publisher{{ $publisher['id'] }}">{{ $publisher['name'] }}</label>

                                </div>
                            @endforeach
                        </div>
                        @if(count($gamePublishers['results']) > 5)
                            <button type="button" id="showAllPublishers" class="button_bar" >Show All</button>
                        @endif
                        <button type="button" id="showLessPublishers" class="button_bar" style="display: none;">Show Less</button>
                    </div>

                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <button type="submit" class="button_bar mt-4">Filter</button>
                    <button type="button" id="resetFilters" class="button_bar mt-4">Reset Filters</button>
                </form>

        </div>

    </div>



@endsection

<script src="{{ asset('js/toggleFilters.js') }}"></script>

<script src="{{ asset('js/platformButtons.js') }}"></script>
<script src="{{ asset('js/genreButtons.js') }}"></script>
<script src="{{ asset('js/developerButtons.js') }}"></script>
<script src="{{ asset('js/publisherButtons.js') }}"></script>
<script src="{{ asset('js/resetFilters.js') }}"></script>

</body>
</html>
