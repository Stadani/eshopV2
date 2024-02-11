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
                            <td><i class="fa-solid fa-user"></i><i class="fa-solid fa-star fa-2xs"></i> {{ number_format($game->average_rating, 2) }}</td>
                        </tr>
                    </table>
                </div>

                <div class="gameTags">
                    <p class="linkColor">
                        @foreach($game->category as $genre)
                            <a href="{{ url('/list') . '?genres%5B%5D=' . $genre->id }}" class="linkColor">
                                <span class="tag genre linkColor mt-1">{{ $genre->category }}</span>
                            </a>
                        @endforeach
                    </p>
                    <p class="linkColor" >
                        @foreach($game->platform as $platform)
                            <a href="{{ url('/list') . '?platforms%5B%5D=' . $platform->id }}" class="linkColor">
                                <span class="tag  mt-1">{{ $platform->name }}</span>
                            </a>
                        @endforeach
                    </p>
                </div>
            </div>
        </div>
    </div>
@endforeach

