@foreach ($game as $game)
    <div>
        <div class="card mb-4 shadow-smd">
            @if(isset($game->game_picture))
                <a href="{{ route('game.show', ['id' => $game->id]) }}">
                    <img src="{{ $game->game_picture }}" alt="{{ $game->name }}">
                </a>
            @else
                <a href="{{ route('game.show', ['id' => $game->id]) }}">
                    <img src="{{ asset('images/Background14.jpg') }}" alt="{{ $game->name }}">
                </a>
            @endif
            <div class="">
                <div class="cardTextContainer">
                    <div class="cardText">{{ $game->name }}</div>
                    <table class="gameDesc">
                        <tr>
                            <td><i class="fa-solid fa-star"></i> {{$game->rating}}</td>
                        </tr>
                    </table>
                </div>

                <div class="gameTags">
                    <p>
                        @foreach($game->category as $genre)
                            <a href="{{ url('/list') . '?genres%5B%5D=' . $genre->id }}">
                                <span class="tag genre mt-1">{{ $genre->category }}</span>
                            </a>
                        @endforeach
                    </p>
                    <p>
                        @foreach($game->platform as $platform)
                            <a href="{{ url('/list') . '?platforms%5B%5D=' . $platform->id }}">
                                <span class="tag mt-1">{{ $platform->name }}</span>
                            </a>
                        @endforeach
                    </p>
                </div>
            </div>
        </div>
    </div>
@endforeach

