<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Post $post)
    {
        request()->validate([
            'body' => 'required'
        ]);

        $post->comment()->create([
            'user_id' => auth()->id(),
            'body' => request('body')
        ]);
        return back();
    }

    public function edit(Comment $comment)
    {
        if (auth()->user()->id === $comment->user_id) {
            return view('edit-comment', ['comment' => $comment]);
        }

        return back();
    }

    public function update(Request $request, Comment $comment)
    {
        if (auth()->user()->id === $comment->user_id) {
            $request->validate([
                'body' => 'required|string',
            ]);

            $comment->update([
                'body' => $request->body,
            ]);

            return redirect()->back();
        }
        return back();
    }


    public function delete(Comment $comment)
    {
        if (auth()->user()->id === $comment->user_id) {
            $comment->delete();
            return back();
        }
        return back();
    }

}
