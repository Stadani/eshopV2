<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>PixelNexus | Form</title>

    <!-- Add these lines in your HTML -->


    @extends('components/layout')
    @section('listcss')
        <link rel="stylesheet" href="/css/forumStyle.css">
        <link rel="stylesheet" href="/css/postFormStyle.css">
        <link rel="stylesheet" href="/css/gameFormStyle.css">
    @endsection
    {{--    had to link like this because after opening post it doesnt work--}}
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon-32x32.png') }}">
    {{--    https://github.com/habibmhamadi/multi-select-tag--}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.0/dist/js/multi-select-tag.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


</head>
<body>
@extends('components.navbar')
@section('content')

    <div class="containerGeneral gameForm">
        {{--        INPUT FIELDS--}}

        <form action="{{ isset($game) ? route('update.game', $game) : route('store.game') }}" method="POST">
            @csrf
            @if(isset($game))
                @method('PATCH')
            @endif

            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" class="searchbarPostForm" name="name" required
                       value="{{ old('name', isset($game) ? $game->name : '') }}" placeholder="Title...">
            </div>

            <div>
                <label for="game_picture">Game Picture URL:</label>
                <input type="text" id="game_picture" name="game_picture" required>
            </div>

            <div>
                <label for="release_date">Release Date:</label>
                <input type="date" id="release_date" name="release_date" required>
            </div>

            <div>
                <label for="rating">Rating:</label>
                <input type="number" id="rating" name="rating" min="0" max="5" required>
            </div>

            <div>
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>

            <div>
                <label for="developers">Developers:</label>
                <select name="developers[]" id="developers" multiple>
                    @foreach($developers as $developer)
                        {{--                                                    <option value="{{ $developer->id }}" {{ in_array($developer->id, old('$developers', isset($games) ? $games->developer->pluck('id')->toArray() : [])) ? 'selected' : '' }}>{{ $games->name }}</option>--}}
                        <option value="{{ $developer->id }}">{{ $developer->name }}</option>
                    @endforeach
                </select>
                <script>
                    new MultiSelectTag('developers')  // id
                </script>
            </div>

            <div>
                <label for="publishers">Publishers:</label>
                <select name="publishers[]" id="publishers" multiple>
                    @foreach($publishers as $publisher)
                        {{--                            <option value="{{ $developer->id }}" {{ in_array($developer->id, old('$developers', isset($game) ? $game->developer->pluck('id')->toArray() : [])) ? 'selected' : '' }}>{{ $game->name }}</option><option value="{{ $developer->id }}" {{ in_array($developer->id, old('$developers', isset($game) ? $game->developer->pluck('id')->toArray() : [])) ? 'selected' : '' }}>{{ $developer->name }}</option>--}}
                        <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                    @endforeach
                </select>
                <script>
                    new MultiSelectTag('publishers')  // id
                </script>
            </div>

            <div>
                <label for="trailers">Trailers:</label>
            </div>

            <div>
                <label for="screenshots">Screenshots:</label>
            </div>

            <div>
                <label for="genres">Genres:</label>
                <select name="genres[]" id="genres" multiple>
                    @foreach($genres as $genre)
                        {{--                            <option value="{{ $developer->id }}" {{ in_array($developer->id, old('$developers', isset($game) ? $game->developer->pluck('id')->toArray() : [])) ? 'selected' : '' }}>{{ $game->name }}</option><option value="{{ $developer->id }}" {{ in_array($developer->id, old('$developers', isset($game) ? $game->developer->pluck('id')->toArray() : [])) ? 'selected' : '' }}>{{ $developer->name }}</option>--}}
                        <option value="{{ $genre->id }}">{{ $genre->category }}</option>
                    @endforeach
                </select>
                <script>
                    new MultiSelectTag('genres')  // id
                </script>
            </div>

            <div>
                <label for="platforms">Platform & Price:</label>
                <select name="platforms[]" id="platforms" multiple>
                    @foreach($platforms as $platform)
                        <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                    @endforeach
                </select>
{{--                <script>--}}
{{--                    new MultiSelectTag('platforms')  // id--}}
{{--                </script>--}}
                <div id="platform_prices_container">
                    <!-- Price input fields will be dynamically generated here -->
                </div>
            </div>



            {{--                            <div>--}}
            {{--                <label for="dlcs">DLCs:</label>--}}
            {{--                                <select id="dlcs" name="dlcs[]" multiple required>--}}
            {{--                                    @foreach($dlcs as $dlc)--}}
            {{--                                        <option value="{{ $dlc->id }}">{{ $dlc->name }}</option>--}}
            {{--                                    @endforeach--}}
            {{--                                </select>--}}
            {{--                            </div>--}}

            <div>
                <label for="same_series">Games of Same Series:</label>
                <select name="games[]" id="games" multiple>
                    @foreach($games as $game)
                        {{--                            <option value="{{ $developer->id }}" {{ in_array($developer->id, old('$developers', isset($game) ? $game->developer->pluck('id')->toArray() : [])) ? 'selected' : '' }}>{{ $game->name }}</option><option value="{{ $developer->id }}" {{ in_array($developer->id, old('$developers', isset($game) ? $game->developer->pluck('id')->toArray() : [])) ? 'selected' : '' }}>{{ $developer->name }}</option>--}}
                        <option value="{{ $game->id }}">{{ $game->name }}</option>
                    @endforeach
                </select>
                <script>
                    new MultiSelectTag('games')  // id
                </script>

            </div>

            <div>
                <button type="submit" class="button_bar">Post</button>
            </div>
        </form>
    </div>


@endsection
</body>
