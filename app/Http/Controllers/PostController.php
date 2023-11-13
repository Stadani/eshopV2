<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {

        return view('forum', [
           'forum' => $this->getPosts(),
           'tags' => Tag::all()
        ]);

    }

    public function show(Post $post)
    {
        return view('post', [
            'post' => $post
        ]);
    }

    protected function getPosts() {
        $posts = Post::latest();

        if (request('search')) {
            $posts
                ->where('title', 'like', '%' . request('search') . '%');
        }
        return $posts->get();
    }


}
