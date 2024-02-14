<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Post;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /*
     * show posts in forum that are in accordance with search query
     * filter passes request params to the scopeFilter
     * */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 15);
        $tags = Tag::all();
        $forum = Post::withCount('comment')->latest()->filter(request(['search', 'tag']))->paginate($perPage)->withQueryString();

        if ($request->ajax()) {
            $forumItemsView = view('components.forumItem', ['forum' => $forum])->render();
            $paginationView = $forum->links()->render();

            return response()->json([
                'forumItemsHTML' => $forumItemsView,
                'paginationHTML' => $paginationView,

            ]);
        } else {
            return view('forum', [
                'forum' => $forum,
                'tags' => $tags,
                'perPage' => $perPage,
                'showSearch' => request('search'),
            ]);
        }
    }

    public function show(Post $post)
    {
        $post->increment('views');
        return view('post', [
            'post' => $post
        ]);
    }

    public function create()
    {
        $tags = Tag::all();
        return view('postForm', ['tags' => $tags]);
    }

    protected function makeUniqueSlug($slug)
    {
        $count = 1;
        $originalSlug = $slug;

        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . $count;
            $count++;
        }

        return $slug;
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:20|min:3',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
            'body' => 'required|string|min:10',
        ]);
        $slug = Str::slug($request->title);
        $uSlug = $this->makeUniqueSlug($slug);

        $post = auth()->user()->posts()->create([
            'title' => $request->title,
            'body' => $request->body,
            'slug' => $uSlug,
        ]);
        $post->tag()->sync($request->tags);
        return redirect('/forum');
    }

    public function edit(Post $post)
    {
        $tags = Tag::all();
        if (auth()->user() && auth()->user()->id === $post->user->id) {
            return view('postForm', [
                'post' => $post,
                'tags' => $tags
            ]);
        }
        return redirect()->back();
    }


    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:20|min:3',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
            'body' => 'required|string|min:10',
        ]);

        //keep slug if didnt change title
        if ($request->title !== $post->title) {
            $slug = Str::slug($request->title);
            $uSlug = $this->makeUniqueSlug($slug);
        } else {
            $uSlug = $post->slug;
        }

        $post->update([
            'title' => $request->title,
            'body' => $request->body,
            'slug' => $uSlug,
        ]);
        $post->tag()->sync($request->tags);
        return redirect(url('/post/' . $post->slug));
    }


    public function delete(Post $post)
    {
        if (auth()->user() && (auth()->user()->id === $post->user->id || auth()->user()->is_admin == 1)) {
            $post->delete();
            return redirect('/forum');
        }
        return redirect()->back();
    }

    public function like(Post $post)
    {
        $post->toggleLike(auth()->user());

        return redirect()->back();
    }

}
