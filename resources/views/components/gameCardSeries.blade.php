
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


