<!DOCTYPE html>
{{--@dd($reviews)--}}
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{$game->name}}</title>
    <link rel="icon" type="image/x-icon" href="{{asset("/images/favicon-32x32.png")}}">

    @extends('components/layout')
    @section('listcss')
        <link rel="stylesheet" href="/css/gameDiscussionStyle.css">
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
    @if(auth()->user() && auth()->user()->is_admin == 1)
        <div class="postNameAndTags eanddbuttons">
            <form action="{{ route('delete.game', $game) }}" method="POST">
                @csrf
                @method('DELETE')
                <button title="Delete" class="button_bar"><i class="fa-solid fa-trash-can"></i></button>
            </form>
            <a href="{{ route('edit.game', $game) }}">
                <button title="Edit" class="button_bar"><i class="fa-solid fa-file-pen"></i></button>
            </a>
        </div>
    @endif
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
                            @if($game->trailer->count() > 0)
                                @if(Str::startsWith($game->trailer[0]['trailer'], ['http://', 'https://']))
                                    <video id="mainTrailer" controls>
                                        <source src="{{ $game->trailer[0]['trailer'] }}" type="video/mp4">
                                    </video>
                                @else
                                    <video id="mainTrailer" controls>
                                        <source src="{{ asset('storage/' . $game->trailer[0]['trailer']) }}"
                                                type="video/mp4">
                                    </video>
                                @endif
                            @else
                                No available trailers
                            @endif
                        </div>
                        <div class="thumbnails">
                            @foreach($game->trailer as $trailer)
                                @if(Str::startsWith($trailer->trailer, ['http://', 'https://']))
                                    <img class="thumbnail" src="{{ asset('storage/' . $trailer->preview) }}"
                                         alt="trailerThumbnail"
                                         onclick="showTrailer('{{ $trailer->trailer }}')">
                                @else
                                    <img class="thumbnail" src="{{ asset('storage/' . $trailer->preview) }}"
                                         alt="trailerThumbnail"
                                         onclick="showTrailer('{{ asset('storage/' . $trailer->trailer) }}')">
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Screenshots Tab -->
                <div id="Screenshots" class="tabcontent">
                    <div class="mediaContainer">
                        <div class="selectedImage">
                            @if($game->screenshot->count() > 0)
                                @if(Str::startsWith($game->screenshot[0]['screenshot'], ['http://', 'https://']))
                                    <img id="mainImage"
                                         src="{{ $game->screenshot[0]['screenshot'] }} " alt="selectedImage">
                                @else
                                    <img id="mainImage"
                                         src="{{ asset('storage/' . $game->screenshot[0]['screenshot'])  }}"
                                         alt="selectedImage">
                                @endif
                            @else
                                No available screenshots
                            @endif

                        </div>
                        <div class="thumbnails">
                            @foreach($game->screenshot as $screenshot)
                                @if(Str::startsWith($screenshot->screenshot, ['http://', 'https://']))
                                    <img class="thumbnail" src="{{ $screenshot->screenshot }}" alt="thumbnail"
                                         onclick="showImage('{{ $screenshot->screenshot }}')">
                                @else
                                    <img class="thumbnail" src="{{ asset('storage/' . $screenshot->screenshot) }}"
                                         alt="thumbnail"
                                         onclick="showImage('{{ asset('storage/' . $screenshot->screenshot) }}')">
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--        SIDE PANEL--}}
        <div class="containerGeneral sidePanel">
            <div class="sidePanelImage">
                @if(filter_var($game->game_picture, FILTER_VALIDATE_URL))
                    <a href="{{ route('game.show', ['id' => $game->id]) }}">
                        <img src="{{ $game->game_picture }}" alt="{{ $game->name }}">
                    </a>
                @else
                    <a href="{{ route('game.show', ['id' => $game->id]) }}">
                        <img src="{{ asset('storage/' . $game->game_picture) }}" alt="{{ $game->name }}">
                    </a>
                @endif
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
            <div class="containerGeneral info ">
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
                    <tr>
                        <td class="leftColumn">User rating:</td>
                        <td class="rightColumn">{{number_format($averageRating, 2)}}/5</td>
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
                                <button class="button_bar buyButton" data-id="{{ $game->id }}" data-platform="{{ $gameBuy->id }}" data-dlc="false">
                                    BUY
                                    @php $showPrice = true; @endphp
                                    @foreach($priceHistory as $history)
                                        @if($history->platform_id == $gameBuy->id && $history->price > $gameBuy->pivot->price)
                                            <span class="buttonPrice"><span class="discount">{{$history->price}}$</span> {{$gameBuy->pivot->price}}$</span>
                                            @php $showPrice = false; @endphp
                                            @break
                                        @endif
                                    @endforeach
                                    @if($showPrice)
                                        <span class="buttonPrice">{{$gameBuy->pivot->price}}$</span>
                                    @endif
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
                        <h3>{{ $dlc->name }} </h3>
                    </td>
                    <td>
                        <div class="buttonContainer">
                            <button class="button_bar buyButton" data-id="{{ $dlc->id }}" data-platform="All"
                                    data-dlc="true">
                                BUY
                                @php $showPrice = true; @endphp
{{--                                @dd($dlcPriceHistory)--}}
                                @foreach($dlcPriceHistory as $history)
                                    @if($history->dlc_id == $dlc->id && $history->price > $dlc->price)
                                        <span class="buttonPrice"><span class="discount">{{$history->price}}$</span> {{$dlc->price}}$</span>
                                        @php $showPrice = false; @endphp
                                        @break
                                    @endif
                                @endforeach
                                @if($showPrice)
                                    <span class="buttonPrice">{{$dlc->price}}$</span>
                                @endif
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    {{--    GAME SERIES--}}
    <div class="containerGeneral contentCont px-4 py-4">
        <h2> Games of same series</h2>
        <div class="gameSeriesCards">
            <x-gameCardSeries :game="$game">

            </x-gameCardSeries>
        </div>

        <div>
            <button id="showMore" class="button_bar">Show More</button>
            <button id="showLess" class="button_bar" style="display: none">Show Less</button>
        </div>
    </div>

    {{--    USER REVIEWS--}}
    <div class="containerGeneral contentCont px-4 py-4">
        <h2> User reviews</h2>
        @guest()
            <div class="container">
                You are not logged in. Please <a href="{{ route('login') }}">log in</a> or <a
                    href="{{ route('register') }}">register</a> to review a game.
            </div>
        @endguest
        @auth()
            @if(!$game->review()->where('user_id', Auth::id())->first())
                <form method="POST" action="{{ route('store.review', $game) }}">
                    @csrf
                    <div class="containerGeneral">
                        <div class="postUser">
                            <img src="{{Auth::user()->profile_picture_url }}" alt="">
                        </div>
                        <div class="postContent">
                            <textarea id="textBody" name="body" placeholder="Review this game!"></textarea>
                            <div class="rating">
                                <input type="radio" id="star5" name="rating" value="1" class="star"
                                       onclick="gfg(1)"/><label for="star5" title="1 star">★</label>
                                <input type="radio" id="star4" name="rating" value="2" class="star"
                                       onclick="gfg(2)"/><label for="star4" title="2 stars">★</label>
                                <input type="radio" id="star3" name="rating" value="3" class="star"
                                       onclick="gfg(3)"/><label for="star3" title="3 stars">★</label>
                                <input type="radio" id="star2" name="rating" value="4" class="star"
                                       onclick="gfg(4)"/><label for="star2" title="4 stars">★</label>
                                <input type="radio" id="star1" name="rating" value="5" class="star"
                                       onclick="gfg(5)"/><label for="star1" title="5 stars">★</label>
                            </div>
                            <h3 id="output">
                                Rating is: 0/5
                            </h3>
                            <button id="submitButton" type="submit" class="button_bar">
                                Post a review
                            </button>
                        </div>
                    </div>
                </form>
            @else
                <div id="commentContainer">
                    <x-editUserReview :showUsersReview="$showUsersReview">

                    </x-editUserReview>
                </div>
            @endif
        @endauth
    </div>
    <div class="container arrow_bar just">
        <div id="paginationContainer" class="navbar_main px-2">
            {{ $reviews->links() }}
        </div>
        <div class="sidenav py-3">
            <select id="commentsPerPageDropdown" onchange="updateCommentsPerPage(this.value)">
                <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5 per page</option>
                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 per page</option>
                <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15 per page</option>
                <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20 per page</option>
            </select>
        </div>
    </div>

    <div id="commentContainer">
        <x-userReview :reviews="$reviews">

        </x-userReview>
    </div>




    <script src="{{ asset('js/gameModal.js') }}"></script>
    <script src="{{ asset('js/gameMedia.js') }}"></script>
    <script src="{{ asset('js/gameClic.js') }}"></script>
    <script src="{{ asset('js/gameSeriesExpand.js') }}"></script>
    <script src="{{ asset('js/gameAjax.js') }}"></script>
    <script src="{{ asset('js/rating.js') }}"></script>
    <script src="{{ asset('js/checkFields.js') }}"></script>
    <script src="{{ asset('js/toggleEditComment.js') }}"></script>
    <x-footer>

    </x-footer>
@endsection

</body>
<script>
    var gameId = "{{ $game->id }}";
</script>


<script>
    $(document).ready(function () {
        $(".buyButton").click(function (e) {
            e.preventDefault();

            var element = $(this);
            var gameId = element.data("id");
            var platform = element.data("platform");
            var dlc = element.data("dlc");
            console.log('Game ID:', gameId);
            console.log('Platform:', platform);
            console.log('dlc:', dlc);

            $.ajax({
                url: '{{ route('addToCart', ['id' => ':gameId', 'platform' => ':platform', 'dlc' => ':dlc']) }}'.replace(':gameId', gameId).replace(':platform', platform).replace(':dlc', dlc),
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: gameId,
                    platform: platform,
                    dlc: dlc
                },
                success: function (response) {
                    var message = "Item added to cart!";
                    $("#buyMessage").html('<div class="alert alert-success">' + message + '</div>');

                    $('.cartCount').text(response.cartCount);
                    setTimeout(function () {
                        $("#buyMessage").html('');
                    }, 2000);
                }
            });
        });
    });
</script>


</html>
