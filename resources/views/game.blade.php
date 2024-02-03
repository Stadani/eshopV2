<!DOCTYPE html>
{{--{{dd($gameDetails)}}--}}
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{$gameDetails['name']}}</title>


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

{{--    @if(session('success'))--}}
{{--        <div class="alert alert-success">--}}
{{--            {{ session('success') }}--}}
{{--        </div>--}}
{{--    @endif--}}

<div id="buy-message-container"></div>

    {{--HEADER--}}
    <div class="containerGeneral containerGame">
        <h1>{{$gameDetails['name']}}</h1>
    </div>
    <div class="containerGeneral containerGame tags">
        @foreach ($gameDetails['tags'] as $tag)
            <span class="tag mt-1">{{ $tag['name'] }}</span>
        @endforeach
    </div>

    {{--MAIN PANEL--}}
    <div class="containerGeneral containerGame">
        <div class="containerGeneral videoPanel">
            <div>
                <!-- Tab Buttons -->
                <div class="tab">
                    <button class="tablinks button_bar" onclick="openMedia(event, 'Trailers')">Trailers</button>
                    <button class="tablinks button_bar" onclick="openMedia(event, 'Screenshots')">Screenshots</button>
                </div>


                <!-- Trailers Tab -->
                <div id="Trailers" class="tabcontent">
                    <div class="mediaContainer">
                        <div class="selectedTrailer">
                            @if(!empty($gameTrailers['results']))
                                <video id="mainTrailer" controls>
                                    @if(($gameTrailers['results']) > 0)
                                        <source src="{{ $gameTrailers['results'][0]['data']['480'] }}" type="video/mp4">
                                    @endif

                                </video>
                            @else
                                No available trailers
                            @endif
                        </div>
                        <div class="thumbnails">
                            @foreach($gameTrailers['results'] as $trailer)
                                <img class="thumbnail" src="{{ $trailer['preview'] }}" alt="trailerThumbnail"
                                     onclick="showTrailer('{{ $trailer['data']['480'] }}')">
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Screenshots Tab -->
                <div id="Screenshots" class="tabcontent">
                    <div class="mediaContainer">
                        <div class="selectedImage">
                            @if(!empty($gameScreenshots['results']))
                                <img id="mainImage"
                                     src={{ $gameScreenshots['results'][0]['image'] }} alt="selectedImage">
                            @else
                                No available screenshots
                            @endif

                        </div>
                        <div class="thumbnails">
                            @foreach($gameScreenshots['results'] as $screenshot)
                                <img class="thumbnail" src="{{ $screenshot['image'] }}" alt="thumbnail"
                                     onclick="showImage('{{ $screenshot['image'] }}')">
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--SIDE PANEL--}}
        <div class="containerGeneral sidePanel">
            <div class="sidePanelImage">
                <img src="{{$gameDetails['background_image']}}" alt="{{$gameDetails['id']}}">
            </div>
            <div>
                <div>
                    {{ Str::limit(strip_tags(html_entity_decode($englishDescription)), 200) }}
                </div>
                <div id="description-modal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        {!! $englishDescription !!}
                    </div>
                </div>
                <button id="read-more-btn" class="button_bar">Read More</button>
            </div>
            <div class="containerGeneral info">
                <table>
                    <tr>
                        <td class="leftColumn">Release Date:</td>
                        <td class="rightColumn">{{$gameDetails['released']}}</td>
                    </tr>
                    <tr>
                        <td class="leftColumn">Developer:</td>
                        <td class="rightColumn">
                            @foreach($gameDetails['developers'] as $developer)
                                <span>{{$developer['name']}}</span>{{ $loop->last ? '' : ',' }}
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td class="leftColumn">Publisher:</td>
                        <td class="rightColumn">
                            @foreach($gameDetails['publishers'] as $publisher)
                                <span>{{$publisher['name']}}</span>{{ $loop->last ? '' : ',' }}
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td class="leftColumn">Genres:</td>
                        <td class="rightColumn">
                            @foreach($gameDetails['genres'] as $genres)
                                <span>{{$genres['name']}}</span>{{ $loop->last ? '' : ',' }}
                            @endforeach

                        </td>
                    </tr>
                    <tr>
                        <td class="leftColumn">Rating:</td>
                        <td class="rightColumn">{{$gameDetails['rating']}}/5</td>
                    </tr>
                </table>

            </div>
        </div>
    </div>

    {{--BUY SECTION--}}
    <div class="containerGeneral contentCont px-4 py-4">
        <h2>BUY A GAME</h2>
        <table>
        @foreach($gameDetails['platforms'] as $gameBuy)
            <div>
                <tr>
                    <td>
                        <h3> {{  $gameBuy['platform']['name']}}</h3>
                    </td>
                    <td>
                        <div class="buttonContainer">
                            <button class="button_bar buyButton" data-id="{{ $gameDetails['id'] }}" data-platform="{{ $gameBuy['platform']['name'] }}">
                                BUY
                                <span class="buttonPrice">59.99$</span>
                            </button>
                        </div>
                    </td>
                </tr>
            </div>
        @endforeach
        </table>

    </div>

    {{--DLCS--}}
    <div class="containerGeneral contentCont px-4 py-4">
        <h2> Additional content</h2>
        <table>
            @foreach($gameDLCs['results'] as $dlc)
                <tr>
                    <td>
                        @if(empty($dlc['background_image']))
                            <img class="dlcImage" src="{{ $gameDetails['background_image'] }}" alt="dlcImage">
                        @else
                            <img class="dlcImage" src="{{ $dlc['background_image'] }}" alt="dlcImage">
                        @endif
                    </td>
                    <td>
                        {{ $dlc['name'] }}
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    {{--GAME SERIES--}}
    <div class="containerGeneral contentCont px-4 py-4">
        <h2> Games of same series</h2>
        <div class="container gamePanel">
            <x-gameCardSeries :gameSeries="$gameSeries">

            </x-gameCardSeries>
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
                    $("#buy-message-container").html('<div class="alert alert-success">' + message + '</div>');

                    $('.cartCount').text(response.cartCount);
                    setTimeout(function() {
                        $("#buy-message-container").html('');
                    }, 5000);
                }
            });
        });
    });
</script>

</html>
