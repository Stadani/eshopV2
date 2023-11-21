<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>EShop | Discussion</title>

    <!-- Add these lines in your HTML -->


    @extends('components/layout')
    @section('listcss')
        <link rel="stylesheet" href="/css/forumStyle.css">
        <link rel="stylesheet" href="/css/postFormStyle.css">
    @endsection
    {{--    had to link like this because after opening post it doesnt work--}}
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.0/dist/js/multi-select-tag.js"></script>

</head>
<body>
    @extends('components.navbar')
    @section('content')

        <div class="containerGeneral">
            <form action="{{ route('store.post') }}" method="POST">
                @csrf
                <div>
                    Title
                    <input type="text" class="searchbar" name="title">
                </div>
                <div>
                    tags
                    <select name="tags[]" id="tags" class="asd" multiple>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>

                    <script>
                        new MultiSelectTag('tags')  // id
                    </script>
                </div>
                <div>
                    <textarea rows="5" cols="30" placeholder="Content of your post..." class="searchbar text" name="body"></textarea>
                </div>
                <div>
                    <button type="submit">Post</button>
                </div>
            </form>

        </div>

    @endsection
</body>
