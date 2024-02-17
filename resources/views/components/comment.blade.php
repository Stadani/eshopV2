@foreach ($comments as $comment)

    <div class="containerGeneral">
        {{--        USER INFO--}}
        <div class="postUser">
            <img src="{{ $comment->user->ProfilePictureURL }}" alt="profile">
            <h5 class="username"><a
                    href="{{route('profile.show', ['id' => $comment->user->id])}}">{{ $comment->user->name }}</a></h5>

            @if(auth()->user() != null)
                @if((auth()->user() && auth()->user()->id === $comment->user->id) || auth()->user()->is_admin == 1 )
                    <div class="postNameAndTags eanddbuttons comment">
                        <button title="Edit" class="button_bar" onclick="toggleEditForm({{ $comment->id }})"><i
                                class="fa-solid fa-file-pen"></i></button>
                        @if(auth()->user()->is_admin == 1)
                            <button type="submit" title="Delete" class="button_bar"
                                    onclick="toggleDeleteForm({{ $comment->id }})"><i class="fa-solid fa-trash-can"></i>
                            </button>
                        @else
                            <form id="deleteForm{{ $comment->id }}" action="{{ route('comments.delete', $comment) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Delete" class="button_bar"><i
                                        class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            @endif
        </div>
        {{--CONTENT OF COMMENT--}}
        <div class="postContent">
            <div class="hiddenName">
                <div class="navbar_main">
                    <a class=""
                       href="{{route('profile.show', ['id' => $comment->user->id])}}">{{ $comment->user->name }}</a>
                </div>
                <div class="sidenav">
                    <button title="Edit" class="button_bar" onclick="toggleEditForm({{ $comment->id }})"><i
                            class="fa-solid fa-file-pen"></i></button>
                    {{--                    <form id="deleteForm{{ $comment->id }}" action="{{ route('comments.delete', $comment) }}"--}}
                    {{--                          method="POST">--}}
                    {{--                        @csrf--}}
                    {{--                        @method('DELETE')--}}
                    {{--                        <button type="submit" title="Delete" class="button_bar"><i class="fa-solid fa-trash-can"></i>--}}
                    {{--                        </button>--}}
                    {{--                    </form>--}}
                </div>
            </div>
            <time><i class="fa-solid fa-clock" title="Created"></i> {{ $comment->created_at }} </time>
            <div class="postNameAndTags eanddbuttons">
                {{--                <form action="{{ route('comments.delete', $comment) }}" method="POST">--}}
                {{--                    @csrf--}}
                {{--                    @method('DELETE')--}}
                {{--                </form>--}}
                <div class="postContent">
                    <div id="editForm{{ $comment->id }}" style="display: none;">
                        <form action="{{ route('comments.update', $comment) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <textarea name="body" placeholder="Edit your comment">{{ $comment->body }}</textarea>
                            <button type="submit" class="button_bar">Save</button>
                        </form>
                    </div>
                    <div id="deleteForm{{ $comment->id }}" style="display: none;">
                        <form action="{{ route('comments.delete', $comment) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <textarea name="reason" placeholder="Reason for deletion"></textarea>
                            <button type="submit" class="button_bar">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            {{ $comment-> body }}
        </div>
    </div>
@endforeach



