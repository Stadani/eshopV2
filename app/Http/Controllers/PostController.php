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
     * filter() is scopeFilter in Post.php
     * */
    public function index()
    {
        $tags = Tag::all();
        $forum = Post::latest()->filter(request(['search', 'tag']))->paginate(6)->withQueryString();


        return view('forum', [
            'forum' =>$forum,
            'tags' => $tags,
            'showSearch' => request('search')
        ]);
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
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
            'body' => 'required|string',
        ]);
        $slug = Str::slug($request->title);
        $post = auth()->user()->posts()->create([
            'title' => $request->title,
            'body' => $request->body,
            'slug' => $slug,
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
            'title' => 'required|string|max:255',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
            'body' => 'required|string',
        ]);
        $post->update([
            'title' => $request->title,
            'body' => $request->body,
            'slug' => Str::slug($request->title),
        ]);
        $post->tag()->sync($request->tags);
        return redirect('/forum');
    }

    public function destroy(Post $post)
    {
        if (auth()->user() && auth()->user()->id === $post->user->id) {
            $post->delete();
            return redirect('/forum');
        }
        return redirect()->back();
    }

    public function like(Post $post)
    {
        $post->toggleLike(auth()->user());

        return back();
    }
}
