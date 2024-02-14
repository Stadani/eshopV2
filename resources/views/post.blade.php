<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>Post | {{$post->title}}</title>


    @extends('components/layout')
    @section('listcss')
        <link rel="stylesheet" href="/css/forumStyle.css">
        <link rel="stylesheet" href="/css/gameDiscussionStyle.css">
    @endsection
    {{--    had to link like this because after opening post it doesnt work--}}
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon-32x32.png') }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>
<body>
@extends('components.navbar')
@section('content')

{{--    HEADER--}}
    <div class="postNameAndTags postNameAndTags">
        <ul>
            <li><h1>{{$post->title}}</h1></li>
            <li><i class="fa-solid fa-user"></i> <a href="{{route('profile.show', ['id' => $post->user->id])}}">{{ $post->user->name }}</a></li>
            <li><time><i class="fa-solid fa-clock"></i> {{ $post->created_at }} </time></li>
            <li>
                <dl>
                    <dd>
                        <i class="fa-solid fa-tags"></i>
                        @foreach($post->tag as $tag)
                            <div class="tagLink">
                                <a href="/forum?tag%5B%5D={{ $tag->slug }}" >{{$tag->name}}</a>
                            </div>
                        @endforeach
                    </dd>
                </dl>
            </li>
            <li class="hiddenName">
                <i class="fa-solid fa-eye" title="Views"></i> {{ $post->views }}
            </li>
            <li class="hiddenName">
                <i class="fa-solid fa-thumbs-up" title="Likes"></i> {{ $post->likes()->count() }}
                @auth()
                    <form method="POST" action="{{ route('posts.like', $post) }}">
                        @csrf
                        <button type="submit"  class="button_bar">
                            {{ $post->likes()->where('user_id', auth()->id())->exists() ? 'Unlike' : 'Like' }}
                        </button>
                    </form>
                @endauth
            </li>
        </ul>
    </div>

{{--EDIT AND DELETE BUTTONS--}}
    @if(auth()->user() && (auth()->user()->id === $post->user->id || auth()->user()->is_admin == 1))
        <div class="postNameAndTags eanddbuttons">
            <form action="{{ route('delete.post', $post) }}" method="POST">
                @csrf
                @method('DELETE')
                <button title="Delete" class="button_bar"><i class="fa-solid fa-trash-can"></i>  </button>
            </form>
            <a href="{{ route('posts.edit', $post) }}"><button title="Edit" class="button_bar"><i class="fa-solid fa-file-pen"></i></button></a>
        </div>
    @endif

{{--POST ITSELF--}}
    <div class="containerGeneral">
{{--        USER INFO PANEL--}}
        <div class="postUser">
            <img src="{{ $post->user->profilePictureUrl }}" alt="profile">
            <h5 class="username"><a href="{{route('profile.show', ['id' => $post->user->id])}}">{{ $post->user->name }}</a></h5>
            <div>
                <i class="fa-solid fa-eye" title="Views"></i> {{ $post->views }}
            </div>
            <div>
                <i class="fa-solid fa-thumbs-up" title="Likes"></i> {{ $post->likes()->count() }}
                @auth()
                    <form method="POST" action="{{ route('posts.like', $post) }}">
                        @csrf
                        <button type="submit"  class="button_bar">
                            {{ $post->likes()->where('user_id', auth()->id())->exists() ? 'Unlike' : 'Like' }}
                        </button>
                    </form>
                @endauth
            </div>
        </div>
{{--CONTENT OF POST PANEL--}}
        <div class="postContent">
            {{$post->body}}
        </div>
    </div>

{{--COMMENTS--}}
    @guest()
        <div class="container bar">
            You are not logged in. Please <a href="{{ route('login') }}">log in</a> or <a href="{{ route('register') }}">register</a> to comment on the post.
        </div>
    @endguest
    @auth()
        <form method="POST" action="{{ route('store.comment', $post) }}">
            @csrf
            <div class="containerGeneral">
                <div class="postUser">
                    <img src="{{Auth::user()->profile_picture_url }}" alt="">
                </div>
                <div class="postContent">
                    <textarea name="body" placeholder="Comment on post!"></textarea>
                    <button type="submit" class="button_bar">
                        Post
                    </button>
                </div>
            </div>
            </div>
        </form>
    @endauth
@error('body')
<li class="error-message alert alert-danger">{{ $message }}</li>
@enderror
{{--DISPLAY COMMENTS--}}
<div class="container arrow_bar just">
    <div id="paginationContainer" class="navbar_main px-2">
        {{ $comments->links() }}
    </div>
    <div class="sidenav py-3">
    <select id="commentsPerPageDropdown"  onchange="updateCommentsPerPage(this.value)">
        <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5 per page</option>
        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 per page</option>
        <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15 per page</option>
        <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20 per page</option>
    </select>
    </div>
</div>

    <div id="commentContainer">
        <x-comment :comments="$comments">

        </x-comment>
    </div>

@endsection
<script src="/js/toggleEditComment.js"></script>
<script src="{{ asset('js/postAjax.js') }}"></script>
<script>
    var postSlug = "{{ $post->slug }}";
</script>
</body>
</html>
