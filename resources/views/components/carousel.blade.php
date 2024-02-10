{{--{{dd($games)}}--}}
<div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
    <div class="carousel-indicators">
        @foreach ($games as $index => $game)
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" aria-label="Slide {{ $index + 1 }}"></button>
        @endforeach
    </div>


    <div class="carousel-inner">
        @foreach ($games as $index => $game)

            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                @if(!empty($game->game_picture))
                    <img src="{{ $game->game_picture}}" alt="{{ $game->name }}" style="object-fit: fill">
                @else
                    <img src="{{ asset('images/Background13.png') }}" alt="{{ $game->name }}">
                @endif
                <div class="container">
                    <div class="carousel-caption text-start">
                        <a href="{{ route('game.show', ['id' => $game->id]) }}" class="link">
                            <h1>{{ $game->name }}</h1>
                        </a>
                        <p><a class="btn btn-lg btn-primary" href="/list">Browse games</a></p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

