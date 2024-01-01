@foreach ($games->items() as $game)
    <div >
{{--        {{ dd($game) }}--}}

            <div class="card mb-4 shadow-smd">
                @if(isset($game['background_image']))
                    <a href="{{ route('game.show', ['id' => $game['id']]) }}">
                        <img src="{{ $game['background_image'] }}" alt="{{ $game['name'] }}">
                    </a>
                @endif
                <div class="">
                    <div class="cardTextContainer">
                        <div class="cardText">{{ $game['name'] }}</div>
                        <table class="gameDesc">
                            <tr>
                                <td><i class="fa-solid fa-star"></i> {{$game['metacritic']}}</td>
                                <td>cena</td>
                            </tr>
                        </table>
                    </div>

                    <div class="gameTags" >
                        <p>
                            @foreach($game['genres'] as $genre)
                                <a href="{{ url('/list') . '?genres%5B%5D=' . $genre['id'] }}">
                                    <span class="tag genre mt-1">{{ $genre['name'] }}</span>
                                </a>
                            @endforeach
                        </p>
                        <p>
                            @foreach($game['platforms'] as $platform)
                                <a href="{{ url('/list') . '?platforms%5B%5D=' . $platform['platform']['id'] }}">
                                    <span class="tag mt-1">{{ $platform['platform']['name'] }}</span>
                                </a>
                            @endforeach
                        </p>
{{--                        <p>--}}
{{--                            @foreach ($game['tags'] as $index => $tag)--}}
{{--                                @if($index < 20)--}}
{{--                                    <span class="tag mt-1">{{ $tag['name'] }}</span>--}}
{{--                                @else--}}
{{--                                    @break--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        </p>--}}
                    </div>
                </div>
            </div>

    </div>
@endforeach

