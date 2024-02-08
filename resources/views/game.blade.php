<!DOCTYPE html>
{{--{{dd($gameDLCs)}}--}}
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{$game->name}}</title>
    <link rel="icon" type="image/x-icon" href="{{asset("/images/favicon-32x32.png")}}">

    @extends('components/layout')
    @section('listcss')

        <link rel="stylesheet" href="/css/forumStyle.css">
        <link rel="stylesheet" href="/css/cardStyle.css">
        <link rel="stylesheet" href="/css/gamePageStyle.css">
    @endsection

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>
<body>

@extends('components.navbar')

@section('content')

<div id="buyMessage" class="messageBL"></div>

{{--    HEADER--}}
    <div class="containerGeneral containerGame">
        <h1>{{$game->name}}</h1>
    </div>
{{--@dd($game->gameSeries)--}}
{{--    MAIN PANEL--}}
    <div class="containerGeneral containerGame">
        <div class="containerGeneral videoPanel">
            <!-- Tab Buttons -->
            <div class="tab">
                <button class="tablinks button_bar" onclick="openMedia(event, 'Trailers')">Trailers</button>
                <button class="tablinks button_bar" onclick="openMedia(event, 'Screenshots')">Screenshots</button>
            </div>
            <div>
                <!-- Trailers Tab -->
                <div id="Trailers" class="tabcontent">
                    <div class="mediaContainer">
                        <div class="selectedTrailer">
                            @if(!empty($game->trailer))
                                <video id="mainTrailer" controls>
                                    @if(($game->trailer->count()) > 0)

                                        <source src="{{ $game->trailer[0]['trailer'] }}" type="video/mp4">
                                    @endif

                                </video>
                            @else
                                No available trailers
                            @endif
                        </div>
                        <div class="thumbnails">
                            @foreach($game->trailer as $trailer)
{{--                                @dd($trailer->preview_url)--}}
                                <img class="thumbnail" src="{{ $trailer->preview }}" alt="trailerThumbnail" onclick="showTrailer('{{ $trailer->trailer }}')">
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Screenshots Tab -->
                <div id="Screenshots" class="tabcontent">
                    <div class="mediaContainer">
                        <div class="selectedImage">
                            @if(!empty($game->screenshot))
                                <img id="mainImage"
                                     src={{ $game->screenshot[0] }} alt="selectedImage">
                            @else
                                No available screenshots
                            @endif

                        </div>
                        <div class="thumbnails">
                            @foreach($game->screenshot as $screenshot)
                                <img class="thumbnail" src="{{ $screenshot['screenshot'] }}" alt="thumbnail"
                                     onclick="showImage('{{ $screenshot['screenshot'] }}')">
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

{{--        SIDE PANEL--}}
        <div class="containerGeneral sidePanel">
            <div class="sidePanelImage">
                <img src="{{$game->game_picture}}" alt="{{$game->id}}">
            </div>
            <div>
                <div>
                    {{ Str::limit(strip_tags(html_entity_decode($game->description)), 200) }}
                </div>
                <div id="description-modal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        {!! $game->description !!}
                    </div>
                </div>
                <button id="read-more-btn" class="button_bar">Read More</button>
            </div>
            <div class="containerGeneral info">
                <table>
                    <tr>
                        <td class="leftColumn">Release Date:</td>
                        <td class="rightColumn">{{$game->release_date}}</td>
                    </tr>
                    <tr>
                        <td class="leftColumn">Developer:</td>
                        <td class="rightColumn">
                            @foreach($game->developer as $developer)
                                <a href="/list?developers%5B%5D={{$developer->id}}">{{$developer['name']}}</a>{{ $loop->last ? '' : ',' }}
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td class="leftColumn">Publisher:</td>
                        <td class="rightColumn">
                            @foreach($game->publisher as $publisher)
                                <a href="/list?publishers%5B%5D={{$publisher->id}}">{{$publisher->name}}</a>{{ $loop->last ? '' : ',' }}
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td class="leftColumn">Genres:</td>
                        <td class="rightColumn">
                            @foreach($game->category as $genres)
                                <a href="/list?genres%5B%5D={{$genres->id}}">{{$genres->category}}</a>{{ $loop->last ? '' : ',' }}
                            @endforeach

                        </td>
                    </tr>
                    <tr>
                        <td class="leftColumn">Rating:</td>
                        <td class="rightColumn">{{$game->rating}}/5</td>
                    </tr>
                </table>

            </div>
        </div>
    </div>

{{--    BUY SECTION--}}
    <div class="containerGeneral contentCont px-4 py-4">
        <h2>BUY A GAME</h2>
        <table>
        @foreach($game->platform as $gameBuy)

            <div>
                <tr>
                    <td>
                        <h3> {{  $gameBuy->name}}</h3>
                    </td>
                    <td>
                        <div class="buttonContainer">
                            <button class="button_bar buyButton" data-id="{{ $game->id }}" data-platform="{{ $gameBuy->id }}">
                                BUY
                                <span class="buttonPrice">{{$gameBuy->pivot->price}}$</span>
                            </button>
                        </div>
                    </td>
                </tr>
            </div>
        @endforeach
        </table>

    </div>

{{--    DLCS--}}
    <div class="containerGeneral contentCont px-4 py-4">
        <h2> Additional content</h2>
        <table>
            @foreach($game->gameDLCs as $dlc)
                <tr>
                    <td>
                        @if(empty($dlc->image))
                            <img class="dlcImage" src="{{ $game->game_picture }}" alt="dlcImage">
                        @endif
                    </td>
                    <td>
                        <div class="buttonContainer">
                            {{ $dlc->name }}
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

{{--    GAME SERIES--}}
    <div class="contentCont px-4 py-4">
        <h2> Games of same series</h2>
        <div class="gameSeriesCards">
            @foreach ($game->gameSeries as $index => $seriesGame)
                @php
                    $game = App\Models\Game::find($seriesGame->series_id);
                @endphp
                <div>
                    <a href="{{ route('game.show', ['id' => $game->id]) }}">
                        <div class="card mb-4 shadow-smd {{ $index >= 4 ? 'hidden' : '' }}">

                            @if(isset($game->game_picture))
                                <img src="{{ $game->game_picture }}" alt="{{ $game->name }}">
                            @endif
                            <div class="">
                                <div class="cardTextContainer">
                                    <p class="cardText">{{ $game->name }}</p>
                                </div>
                                <div class="gameTags">
                                    <p>
                                        @foreach($game->category as $genre)
                                            <span class="tag genre mt-1">{{ $genre->category }}</span>
                                        @endforeach
                                    </p>
                                    <p>
                                        @foreach($game->platform as $platform)
                                            <span class="tag mt-1">{{ $platform->name }}</span>
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div>
            <button id="showMore" class="button_bar">Show More</button>
            <button id="showLess" class="button_bar" style="display: none">Show Less</button>
        </div>
    </div>

    <script src="{{ asset('js/gameModal.js') }}"></script>
    <script src="{{ asset('js/gameMedia.js') }}"></script>
    <script src="{{ asset('js/gameClic.js') }}"></script>
    <script src="{{ asset('js/gameSeriesExpand.js') }}"></script>


@endsection

</body>

<script>
    $(document).ready(function() {
        $(".buyButton").click(function (e) {
            e.preventDefault();

            var element = $(this);
            var gameId = element.data("id");
            var platform = element.data("platform");
            console.log('Game ID:', gameId);
            console.log('Platform:', platform);

            $.ajax({
                url: '{{ route('addToCart', ['id' => ':gameId', 'platform' => ':platform']) }}'.replace(':gameId', gameId).replace(':platform', platform),
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: gameId,
                    platform: platform
                },
                success: function (response) {
                    var message = "Item added to cart!";
                    $("#buyMessage").html('<div class="alert alert-success">' + message + '</div>');

                    $('.cartCount').text(response.cartCount);
                    setTimeout(function() {
                        $("#buyMessage").html('');
                    }, 2000);
                }
            });
        });
    });
</script>


</html>
