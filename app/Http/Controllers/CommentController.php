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
        // Check if the authenticated user is authorized to edit the comment
        if (auth()->user()->id === $comment->user_id) {
            return view('edit-comment', ['comment' => $comment]);
        }

        // If the user is not authorized, you might want to handle this case appropriately
        abort(403, 'Unauthorized action');
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

        // If the user is not authorized, you might want to handle this case appropriately
        abort(403, 'Unauthorized action');

    }


    public function delete(Comment $comment)
    {
        // Check if the authenticated user is authorized to delete the comment
        if (auth()->user()->id === $comment->user_id) {
            $comment->delete();
            return back();
        }
        abort(403, 'Unauthorized action');
    }

}
