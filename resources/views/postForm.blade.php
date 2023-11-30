<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>EShop | Form</title>

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
            <div class="leftHalf">
                <p>Title</p>
                <p>Tags</p>
                <p>Body</p>
            </div>

            <div class="rightHalf">
                <form action="{{ isset($post) ? route('update.post', $post) : route('store.post') }}" method="POST">
                    @csrf
                    @if(isset($post))
                        @method('PATCH')
                    @endif
                    <div>

                        <input type="text" id="title" class="searchbar" name="title" value="{{ old('title', isset($post) ? $post->title : '') }}" placeholder="Title...">

                    </div>
                    <div>

                        <select name="tags[]" id="tags" multiple>
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', isset($post) ? $post->tag->pluck('id')->toArray() : [])) ? 'selected' : '' }}>{{ $tag->name }}</option>
                            @endforeach
                        </select>

                        <script>
                            new MultiSelectTag('tags')  // id
                        </script>
                    </div>
                    <div>
                        <textarea id="body" rows="5" cols="30" placeholder="Content of your post..." class="searchbar text" name="body" >{{ old('body', isset($post) ? $post->body : '') }}</textarea>
                    </div>
                    @error('title')
                        <li class="error-message">{{ $message }}</li>
                    @enderror
                    @error('tags')
                        <li class="error-message">{{ $message }}</li>
                    @enderror
                    @error('body')
                        <li class="error-message">{{ $message }}</li>
                    @enderror
                        <div id="titleErr"></div>
                        <div id="bodyErr"></div>
                    <div>
                        <button type="submit" class="button_bar">Post</button>
                    </div>
                </form>
                <script src="/js/postFormError.js"></script>

            </div>

        </div>


    @endsection

</body>
