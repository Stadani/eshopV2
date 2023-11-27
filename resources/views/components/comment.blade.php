@props(['comment'])
<div class="postUser">
    <img src="https://i.pravatar.cc/100?u={{ $comment->user->id }}" alt="profile">
    <h5 class="username">{{ $comment->user->name }}</h5>
</div>

<div class="postContent">
    <time><i class="fa-solid fa-clock" title="Created"></i> {{ $comment->created_at }} </time>
    {{ $comment-> body }}
</div>
