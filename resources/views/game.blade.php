<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Game</title>


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
        <p>{{$gameDetails['name']}}</p>
    </div>
    <div class="containerGeneral containerGame tags">
        @foreach ($gameDetails['tags'] as $tag)
            <span class="tag mt-1">{{ $tag['name'] }}</span>
        @endforeach
    </div>
    <div class="containerGeneral containerGame">
        <div class="containerGeneral videoPanel">
{{--            <iframe src="{{ $gameDetails['preview'] }}" frameborder="0" allowfullscreen></iframe>--}}
        </div>
        <div class="containerGeneral sidePanel">
            <div>
{{--                {{dd($gameDetails)}}--}}
                <img src="{{$gameDetails['background_image']}}" alt="{{$gameDetails['id']}}">
            </div>
            <div>
                <div id="short-description">
                    @php
                        $noTagsDesc = strip_tags($englishDescription);
                    @endphp
                    {{ Str::limit($noTagsDesc, 200) }}
                </div>
                <div id="full-description" style="display:none;">
                    {!! $englishDescription !!}
                </div>
                <button id="read-more-btn" class="button_bar">Read More</button>
            </div>
            <div class="containerGeneral info">
                <div class="leftHalf">
                    <div>Release Date: </div>
                    <div>Developer: </div>
                    <div>Publisher:</div>
                </div>
                <div class="rightHalf">
                    <span>{{$gameDetails['released']}}</span>
                    <div class="multiline-ellipsis">
                        @foreach($gameDetails['developers'] as $developer)
                            <span>{{$developer['name']}}</span>
                        @endforeach
                    </div>
                    <span>{{$gameDetails['publishers'][0]['name']}}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="containerGeneral">
        content panel
    </div>
    <script>
        document.getElementById('read-more-btn').addEventListener('click', function() {
            var shortDesc = document.getElementById('short-description');
            var fullDesc = document.getElementById('full-description');
            var btn = this;

            if (fullDesc.style.display === "none") {
                fullDesc.style.display = "block";
                shortDesc.style.display = "none";
                btn.textContent = "Read Less";
            } else {
                fullDesc.style.display = "none";
                shortDesc.style.display = "block";
                btn.textContent = "Read More";
            }
        });
    </script>
@endsection

</body>
</html>
