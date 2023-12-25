<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>EShop | Games</title>

    <link rel="stylesheet" href="/css/listStyle.css">

    @extends('components/layout')

    @section('listcss')
        <link rel="stylesheet" href="/css/forumStyle.css">
        <link rel="stylesheet" href="/css/listStyle.css">
    @endsection

</head>
<body>
@extends('components.navbar')

@section('content')
    <!--PAGE CONTENT-->
    <div class="container">
        <div class="navbar_main">
            <input type="text" placeholder="Search..">
        </div>

        <div class="sidenav">
            <button class="button_bar" onclick="toggleFilters()"><i class="fa-solid fa-filter"></i></button>
        </div>

    </div>

    <div class=" container page_content">
        <div class="container gamePanel">
            <x-gameCard :games="$games">

            </x-gameCard>
        </div>
        <div id="filter" class="container filters hidden">
            <div class="slider-container">
                <label for="gameSlider">Games per Page:</label>
                <span>1</span>
                <input type="range" id="gameSlider" min="1" max="50" value="{{ $page_size }}" oninput="fetchGames(value)">
                <span id="sliderValue">{{ $page_size }}</span>
            </div>
        </div>
    </div>



@endsection

<script src="{{ asset('js/toggleFilters.js') }}"></script>
<script>

    async function fetchGames(pageSize) {
        try {
            document.getElementById('sliderValue').innerText = pageSize;
            const response = await fetch(`/list?page_size=${pageSize}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest', //assures it works with laravel
                }
            });
            const html = await response.text();
            document.querySelector('.gamePanel').innerHTML = html;
        } catch (error) {
            console.error('Error fetching games:', error);
        }
    }
</script>
</body>
</html>
