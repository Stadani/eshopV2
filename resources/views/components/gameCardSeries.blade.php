
@foreach ($gameSeries['results'] as $index =>$game)
    <div>
        <a href="{{ route('game.show', ['id' => $game['id']]) }}">
            <div class="card mb-4 shadow-smd {{ $index >= 4 ? 'hidden' : '' }}">

                @if(isset($game['background_image']))
                    <img src="{{ $game['background_image'] }}" alt="{{ $game['name'] }}">
                @endif
                <div class="">
                    <div class="cardTextContainer">
                        <p class="cardText">{{ $game['name'] }}</p>


                    </div>
                    <div class="gameTags" >
                        <p>
                            @foreach($game['genres'] as $genre)
                                <span class="tag genre mt-1">{{ $genre['name'] }}</span>
                            @endforeach
                        </p>
                        <p>
                            @foreach($game['platforms'] as $platform)
                                <span class="tag mt-1">{{ $platform['platform']['name'] }}</span>
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>
        </a>
    </div>
@endforeach

