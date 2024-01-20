<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>PixelNexus | Form</title>

    <!-- Add these lines in your HTML -->


    @extends('components/layout')
    @section('listcss')
        <link rel="stylesheet" href="/css/forumStyle.css">
        <link rel="stylesheet" href="/css/postFormStyle.css">
    @endsection
    {{--    had to link like this because after opening post it doesnt work--}}
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon-32x32.png') }}">
{{--    https://github.com/habibmhamadi/multi-select-tag--}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.0/dist/js/multi-select-tag.js"></script>


</head>
<body>
@extends('components.navbar')
@section('content')

    {{--        LEFT SIDE OF FORM--}}
    <div class="containerGeneral">
        <div class="leftHalf">
            <p class="mt-2">Title</p>
            <p class="mt-2">Tags</p>
            <p class="mt-2">Body</p>
        </div>

{{--        INPUT FIELDS--}}
        <div class="rightHalf">
            <form action="{{ isset($post) ? route('update.post', $post) : route('store.post') }}" method="POST">
                @csrf
                @if(isset($post))
                    @method('PATCH')
                @endif
                <div>
                    <input type="text" id="title" class="searchbarPostForm" name="title"
                           value="{{ old('title', isset($post) ? $post->title : '') }}" placeholder="Title...">
                </div>
                <div>
                    <select name="tags[]" id="tags" multiple>
                        @foreach($tags as $tag)
                            <option
                                value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', isset($post) ? $post->tag->pluck('id')->toArray() : [])) ? 'selected' : '' }}>{{ $tag->name }}</option>
                        @endforeach
                    </select>

                    <script>
                        new MultiSelectTag('tags')  // id
                    </script>
                </div>
                <div>
                    <textarea id="body" rows="5" cols="30" placeholder="Content of your post..."
                              class="searchbarPostForm"
                              name="body">{{ old('body', isset($post) ? $post->body : '') }}</textarea>
                </div>

{{--                ERRORS--}}
                @error('title')
                <li class="error-message alert alert-danger">{{ $message }}</li>
                @enderror
                @error('tags')
                <li class="error-message alert alert-danger">{{ $message }}</li>
                @enderror
                @error('body')
                <li class="error-message alert alert-danger">{{ $message }}</li>
                @enderror
                <div id="titleErr" class="alert alert-danger" style="display: none"></div>
                <div id="bodyErr" class="alert alert-danger" style="display: none"></div>
                <div>
                    <button type="submit" class="button_bar">Post</button>
                </div>
            </form>
        </div>
    </div>
@endsection
<script src="/js/postFormError.js"></script>
</body>
