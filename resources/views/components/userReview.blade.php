@foreach ($reviews as $review)
    <div class="containerGeneral">
{{--                USER INFO--}}
        <div class="postUser">
            <img src="{{ $review->user->ProfilePictureURL }}" alt="profile">
            <h5 class="username">{{ $review->user->name }}</h5>
            @if(auth()->user() != null)
            @if((auth()->user() && auth()->user()->id === $review->user->id) || auth()->user()->is_admin == 1)
                <div class="postNameAndTags eanddbuttons comment">
                    <button title="Edit" class="button_bar" onclick="toggleEditForm({{ $review->id }})"><i
                            class="fa-solid fa-file-pen"></i></button>
                    <form id="deleteForm{{ $review->id }}" action="{{ route('reviews.delete', $review) }}"
                          method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Delete" class="button_bar"><i class="fa-solid fa-trash-can"></i>
                        </button>
                    </form>
                </div>
            @endif
            @endif
        </div>
{{--        CONTENT OF COMMENT--}}
        <div class="postContent">
            <div class="hiddenName">
                <div class="navbar_main">
                    {{$review->user->name}}
                </div>
                <div class="sidenav">
                    <button title="Edit" class="button_bar" onclick="toggleEditForm({{ $review->id }})"><i
                            class="fa-solid fa-file-pen"></i></button>
                    <form id="deleteForm{{ $review->id }}" action="{{ route('reviews.delete', $review) }}"
                          method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Delete" class="button_bar"><i class="fa-solid fa-trash-can"></i>
                        </button>
                    </form>
                </div>
            </div>
            <time><i class="fa-solid fa-clock" title="Created"></i> {{ $review->created_at }}
               <p> <i class="fa-solid fa-star"></i> {{$review->rating}}/5</p>
            </time>

            <div class="postNameAndTags eanddbuttons">
                <form action="{{ route('reviews.delete', $review) }}" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
                <div class="postContent">
                    <div id="editForm{{ $review->id }}" style="display: none;">
                        <form action="{{ route('reviews.update', $review) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <textarea name="body" placeholder="Edit your comment">{{ $review->body }}</textarea>

                            <button type="submit" class="button_bar">Save</button>
                        </form>
                    </div>
                </div>
            </div>
            {{ $review-> body }}
        </div>
    </div>
@endforeach



