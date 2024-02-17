<?php

namespace App\Http\Controllers;

use App\Mail\ContentDeletedMail;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    public function index(Post $post, Request $request)
    {
        $perPage = $request->input('perPage', 20);
        $comments = $post->comment()->paginate($perPage)->withQueryString();

        if ($request->ajax()) {
            $forumItemsView = view('components.comment', ['comments' => $comments])->render();
            $paginationView = $comments->links()->render();

            return response()->json([
                'forumItemsHTML' => $forumItemsView,
                'paginationHTML' => $paginationView,
            ]);
        } else {
            return view('post', compact('post', 'comments', 'perPage'));
        }
    }

    public function store(Post $post)
    {
        request()->validate([
            'body' => 'required|min:5'
        ]);

        $post->comment()->create([
            'user_id' => auth()->id(),
            'body' => request('body')
        ]);

        return back();

    }

//    public function edit(Comment $comment)
//    {
//        if (auth()->user()->id === $comment->user_id) {
//            return view('edit-comment', ['comment' => $comment]);
//        }
//
//        return back();
//    }

    public function update(Request $request, Comment $comment)
    {
        if (auth()->user()->id === $comment->user_id) {
            $request->validate([
                'body' => 'required|string|min:5',
            ]);

            $comment->update([
                'body' => $request->body,
            ]);

            return redirect()->back();
        }
        return back();
    }


    public function delete(Comment $comment, Request $request)
    {
        if ((auth()->user()->id === $comment->user_id)) {
            $comment->delete();
            return redirect()->back()->with('success', 'Comment deleted successfully.');
        } elseif (auth()->user()->is_admin == 1) {
            Mail::to($comment->user->email)->send(new ContentDeletedMail($comment->user, $request->input('reason')));
            $comment->delete();
            return redirect()->back()->with('success', 'Comment deleted successfully.');
        }
        return back();
    }

}
