<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Post;

class PostController extends Controller
{
    /*
     * show posts in forum that are in accordance with search query
     * filter() is scopeFilter in Post.php
     * */
    public function index()
    {
        return view('forum', [
           'forum' => Post::latest()->filter(request(['search', 'tag']))->get(),
            'show' => request('search')
        ]);
    }

    public function show(Post $post)
    {
        return view('post', [
            'post' => $post
        ]);
    }




}
