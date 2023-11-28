@props(['comment'])
<div class="postUser">

    <img src="https://i.pravatar.cc/100?u={{ $comment->user->id }}" alt="profile">
    <h5 class="username">{{ $comment->user->name }}</h5>
    @if(auth()->user() && auth()->user()->id === $comment->user->id)
        <div class="postNameAndTags eanddbuttons comment">
            <button title="Edit" class="button_bar" onclick="toggleEditForm({{ $comment->id }})"><i class="fa-solid fa-file-pen"></i></button>
            <form id="deleteForm{{ $comment->id }}" action="{{ route('comments.delete', $comment) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" title="Delete" class="button_bar"><i class="fa-solid fa-trash-can"></i></button>
            </form>
        </div>
    @endif
</div>

<div class="postContent">
    <time><i class="fa-solid fa-clock" title="Created"></i> {{ $comment->created_at }} </time>


        <div class="postNameAndTags eanddbuttons">
            <form action="{{ route('comments.delete', $comment) }}" method="POST">
                @csrf
                @method('DELETE')
            </form>
            <div class="postContent">
                <div id="editForm{{ $comment->id }}" style="display: none;">
                    <form action="{{ route('comments.update', $comment) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <textarea name="body" placeholder="Edit your comment">{{ $comment->body }}</textarea>
                        <button type="submit" class="button_bar">Save</button>
                    </form>
                </div>
            </div>
        </div>

    {{ $comment-> body }}
</div>



<script>
    function toggleEditForm(commentId) {
        const editForm = document.getElementById(`editForm${commentId}`);
        editForm.style.display = editForm.style.display === 'none' ? 'block' : 'none';
    }
</script>
