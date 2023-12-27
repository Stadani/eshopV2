<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{$gameDetails['name']}}</title>


    @extends('components/layout')
    @section('listcss')
        <link rel="stylesheet" href="/css/gamePageStyle.css">
        <link rel="stylesheet" href="/css/forumStyle.css">
    @endsection
</head>
<body>

@extends('components.navbar')

@section('content')
    <div class="containerGeneral containerGame">
        <h1>{{$gameDetails['name']}}</h1>
    </div>
    <div class="containerGeneral containerGame tags">
        @foreach ($gameDetails['tags'] as $tag)
            <span class="tag mt-1">{{ $tag['name'] }}</span>
        @endforeach
    </div>
    <div class="containerGeneral containerGame">
        <div class="containerGeneral videoPanel">
{{--            @if(isset($gameDetails['clip']))--}}
{{--                <iframe width="560" height="315" src="{{ $gameDetails['clip']['video'] }}" frameborder="0" allowfullscreen></iframe>--}}
{{--            @else--}}
{{--                <p>Trailer not available.</p>--}}
{{--            @endif--}}
            <div class="screenshotContainer">
                <div class="selectedImage">
                    <img id="mainImage" src={{ $gameScreenshots['results'][0]['image'] ?? '' }} alt="selectedImage">
                </div>
                <div class="thumbnails">
                    @foreach($gameScreenshots['results'] as $screenshot)
                        <img class="thumbnail" src="{{ $screenshot['image'] }}" alt="thumbnail" onclick="showImage('{{ $screenshot['image'] }}')">
                    @endforeach
                </div>
            </div>
        </div>
        <div class="containerGeneral sidePanel">
            <div>
                <img src="{{$gameDetails['background_image']}}" alt="{{$gameDetails['id']}}">
            </div>
            <div>
                <div>
                    {{ Str::limit(strip_tags($englishDescription), 200) }}
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

    <div class="containerGeneral">
        content panel
    </div>
    <script>
        var modal = document.getElementById('description-modal');
        var btn = document.getElementById('read-more-btn');
        //returns array of all classes in document
        var span = document.getElementsByClassName('close')[0];

        btn.onclick = function() {
            modal.style.display = 'flex';
        }


        span.onclick = function() {
            modal.style.display = 'none';
        }

        // When the user clicks anywhere outside the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
    <script>
        function showImage(src) {
            document.getElementById('mainImage').src = src;
        }
    </script>
@endsection

</body>
</html>
