@foreach ($games['results'] as $game)
    <div >

        <div class="card mb-4 shadow-sm game-card">
            @if(isset($game['background_image']))
                <img src="{{ $game['background_image'] }}" alt="{{ $game['name'] }}" class="bd-placeholder-img card-img-top">
            @endif
            <div class="">
                <div class="card_text_container">
                    <a href="{{ route('game.show', ['id' => $game['id']]) }}"><p class="card-text">{{ $game['name'] }}</p></a>
                </div>
                <div class="game-tags" >
                    @foreach ($game['tags'] as $index => $tag)
                        @if($index < 20)
                            <span class="tag mt-1">{{ $tag['name'] }}</span>
                        @else
                            @break
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endforeach
