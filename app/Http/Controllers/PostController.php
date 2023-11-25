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
        // Validate the form data
        $request->validate([
            'title' => 'required|string|max:255',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
            'body' => 'required|string',
        ]);


        $slug = Str::slug($request->title);
//        dd($slug);
        // Create a new post
        $post = auth()->user()->posts()->create([
            'title' => $request->title,
            'body' => $request->body,
            'slug' => $slug,
        ]);

        // Attach tags to the post
        $post->tag()->sync($request->tags);

        // Redirect to the post or forum page
        return redirect('/forum');
    }

    public function edit(Post $post)
    {
        $tags = Tag::all(); // Assuming you have a Tag model

        // Check if the authenticated user is the author
        if (auth()->user() && auth()->user()->id === $post->user->id) {
            return view('postForm', [
                'post' => $post,
                'tags' => $tags
            ]);
        }

        // If not the author redirect back
        return redirect()->back();
    }


    public function update(Request $request, Post $post)
    {
        // Validate the form data
        $request->validate([
            'title' => 'required|string|max:255',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
            'body' => 'required|string',
        ]);

        // Update the existing post
        $post->update([
            'title' => $request->title,
            'body' => $request->body,
            'slug' => Str::slug($request->title),
        ]);

        // Sync the tags
        $post->tag()->sync($request->tags);

        // Redirect to the post or forum page
        return redirect('/forum');
    }

    public function destroy(Post $post)
    {
        // Check if the authenticated user is the author
        if (auth()->user() && auth()->user()->id === $post->user->id) {
            // Delete the post
            $post->delete();

            // Redirect to the forum or any other page you want
            return redirect('/forum');
        }

        // If not the author, redirect back
        return redirect()->back();
    }

}
