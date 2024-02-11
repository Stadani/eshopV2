@foreach($showUsersReview as $review)
    Edit your review
    <div class="containerGeneral">
        <div class="postUser">
            <img src="{{ auth()->user()->ProfilePictureURL }}" alt="profile">
            <h5 class="username">{{ auth()->user()->name }}</h5>
            @if((auth()->user() || auth()->user()->is_admin == 1))
                <div class="postNameAndTags eanddbuttons comment">
                    <button title="Edit" class="button_bar" onclick="toggleEditForm({{ $review->id }})">
                        <i
                            class="fa-solid fa-file-pen"></i></button>
                    <form id="deleteForm{{ $review->id }}"
                          action="{{ route('reviews.delete', $review) }}"
                          method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Delete" class="button_bar"><i
                                class="fa-solid fa-trash-can"></i>
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <div class="postContent">
            <div class="hiddenName">
                <div class="navbar_main">
                    {{auth()->user()->name}}
                </div>
                <div class="sidenav">
                    <button title="Edit" class="button_bar" onclick="toggleEditForm({{ $review->id }})">
                        <i
                            class="fa-solid fa-file-pen"></i></button>
                    <form id="deleteForm{{ $review->id }}"
                          action="{{ route('reviews.delete', $review) }}"
                          method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Delete" class="button_bar"><i
                                class="fa-solid fa-trash-can"></i>
                        </button>
                    </form>
                </div>
            </div>
            <time><i class="fa-solid fa-clock" title="Created"></i> {{ $review->created_at }}
                <p> <i class="fa-solid fa-star" title="Rating"></i> {{$review->rating}}/5</p>
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
                            <textarea name="body"
                                      placeholder="Edit your comment">{{ $review->body }}</textarea>
                            <div class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}"
                                       class="star" onclick="gfg({{ $i }})"
                                    {{ $i == $review->rating ? 'checked' : '' }} />
                                <label for="star{{ $i }}" title="{{ $i }} star">★</label>
                                @endfor
                            </div>
                            <h3 id="output">
                                Rating is: 0/5
                            </h3>
                            <button type="submit" class="button_bar">Save</button>
                        </form>
                    </div>
                </div>
            </div>
            {{ $review-> body }}
        </div>
    </div>
@endforeach
