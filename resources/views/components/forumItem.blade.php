@foreach($forum as $post)
    <div>
        <div class="container">
            <div class="table_item">
                <div class="table_cell table_cell_icon">
                    <div class="table_cell_icon_cont">
                        <img src="{{ $post->user->ProfilePictureUrl }}" alt="profile">
                    </div>
                </div>
                <div class="table_cell table_cell_main">
                    <div>
                        <div class="table_cell_title">
                            <a href="/post/{{ $post->slug }}">
                                {{$post->title}}
                            </a>
                        </div>
                        <div class="table_cell_info">
                            <a href="">{{ $post->user->name }}</a>
                        </div>
                    </div>
                </div>

                <div class="table_cell table_cell_middle table_cell_info">
                    <div class="table_cell_stats">
                        <div>
                            Views
                        </div>
                        <div>
                            Replies
                        </div>
                    </div>
                    <div class="table_cell_stats table_cell_stats_right">
                        <div>
                            {{ $post->views }}
                        </div>
                        <div>
                             {{ $post->comment_count }} {{--comment_count is automatically generated attribute --}}
                        </div>
                    </div>
                </div>
                @php
                    $latestComment = $post->comment()->latest()->first();
                @endphp
                @if($latestComment)
                    <div class="table_cell table_cell_side">
                        <div>
                            <div class="table_cell_info">
                                {{ $latestComment->created_at->diffForHumans() }}
                            </div>
                            <div class="table_cell_info ">
                                <a href="#">{{ $latestComment->user->name }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="table_cell table_cell_icon">
                        <div class="table_cell_icon_cont">
                            <img src="{{ $latestComment->user->profilePictureUrl }}" alt="profile">
                        </div>
                    </div>
                @else
                    <div class="table_cell table_cell_side">
                        <div>
                            <div class="table_cell_info">
                                {{ $post->created_at->diffForHumans() }}
                            </div>
                            <div class="table_cell_info">
                                <a href="#">{{ $post->user->name }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="table_cell table_cell_icon">
                        <div class="table_cell_icon_cont">
                            <img src="{{ $post->user->profilePictureUrl }}" alt="profile">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endforeach

