
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{$gameDetails['name']}}</title>


    @extends('components/layout')
    @section('listcss')

        <link rel="stylesheet" href="/css/forumStyle.css">
        <link rel="stylesheet" href="/css/cardStyle.css">
        <link rel="stylesheet" href="/css/gamePageStyle.css">
    @endsection
</head>
<body>

@extends('components.navbar')

@section('content')
{{--    {{dd($gameSeries)}}--}}
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
            <div>
                <!-- Tab Buttons -->
                <div class="tab">
                    <button class="tablinks button_bar" onclick="openMedia(event, 'Trailers')">Trailers</button>
                    <button class="tablinks button_bar" onclick="openMedia(event, 'Screenshots')">Screenshots</button>
                </div>

{{--                {{dd($gameTrailers)}}--}}
                <!-- Trailers Tab -->
                <div id="Trailers" class="tabcontent">
                    <div class="mediaContainer">
                        <div class="selectedTrailer">
                            @if(!empty($gameTrailers['results']))
                                <video id="mainTrailer" controls>
                                    @if(($gameTrailers['results']) > 0)
                                        <source src="{{ $gameTrailers['results'][0]['data']['480'] }}" type="video/mp4">
                                    @endif

                                </video>
                            @else
                                No available trailers
                            @endif
                        </div>
                        <div class="thumbnails">
                            @foreach($gameTrailers['results'] as $trailer)
                                <img class="thumbnail" src="{{ $trailer['preview'] }}" alt="trailerThumbnail" onclick="showTrailer('{{ $trailer['data']['480'] }}')">
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Screenshots Tab -->
                <div id="Screenshots" class="tabcontent">
                    <div class="mediaContainer">
                        <div class="selectedImage">
                            @if(!empty($gameScreenshots['results']))
                                <img id="mainImage" src={{ $gameScreenshots['results'][0]['image'] }} alt="selectedImage">
                            @else
                                No available screenshots
                            @endif

                        </div>
                        <div class="thumbnails">
                            @foreach($gameScreenshots['results'] as $screenshot)
                                <img class="thumbnail" src="{{ $screenshot['image'] }}" alt="thumbnail" onclick="showImage('{{ $screenshot['image'] }}')">
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="containerGeneral sidePanel">
            <div class="sidePanelImage">
                <img src="{{$gameDetails['background_image']}}" alt="{{$gameDetails['id']}}">
            </div>
            <div>
                <div>
                    {{ Str::limit(strip_tags(html_entity_decode($englishDescription)), 200) }}


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

    <div class="containerGeneral contentCont px-4 py-4">
        <h2> Additional content</h2>
        <table>
            @foreach($gameDLCs['results'] as $dlc)
                <tr>
                    <td>
                        @if(empty($dlc['background_image']))
                            <img class="dlcImage" src="{{ $gameDetails['background_image'] }}" alt="dlcImage" >
                        @else
                            <img class="dlcImage" src="{{ $dlc['background_image'] }}" alt="dlcImage" >
                        @endif
                    </td>
                    <td>
                        {{ $dlc['name'] }}
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="containerGeneral contentCont px-4 py-4">
        <h2> Games of same series</h2>

        <div class="container gamePanel">
            <x-gameCardSeries :gameSeries="$gameSeries">

            </x-gameCardSeries>

        </div>
        <div>
            <button id="showMore" class="button_bar">Show More</button>
            <button id="showLess" class="button_bar" style="display: none">Show Less</button>
        </div>

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
    <script>
        function showTrailer(url) {
            document.getElementById('mainTrailer').src = url;
        }
    </script>
    <script>
        function openMedia(evt, mediaName) {
            var i, tabcontent, tablinks;
            //hides all content
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            //removes active
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            //clicked element gets displayed
            document.getElementById(mediaName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var selectedTrailer = document.querySelector('.selectedTrailer');
            if (selectedTrailer.textContent.includes('No available trailers')) {
                var screenshotsTab = document.querySelector("button[onclick*='Screenshots']");
                    screenshotsTab.click();
            } else {
                document.querySelector('.tablinks').click();
            }
        });
    </script>
<script>
    document.getElementById('showMore').addEventListener('click', function() {
        var hiddenElements = document.querySelectorAll('.gameContainer .hidden');
        hiddenElements.forEach(function(el) {
            el.classList.replace('hidden', 'shown');
        });
        this.style.display = 'none';
        document.getElementById('showLess').style.display = 'block';
    });
    document.getElementById('showLess').addEventListener('click', function() {
        var hiddenElements = document.querySelectorAll('.gameContainer .shown');
        hiddenElements.forEach(function(el) {
            el.classList.replace('shown', 'hidden');
        });
        this.style.display = 'none';
        document.getElementById('showMore').style.display = 'block';
    });
</script>

@endsection

</body>
</html>
