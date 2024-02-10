<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\UserReview;
use Illuminate\Http\Request;

class UserReviewController extends Controller
{

    public function store(Game $game)
    {
        request()->validate([
            'body' => 'required'
        ]);

        $game->review()->create([
            'user_id' => auth()->id(),
            'body' => request('body')
        ]);

        return back();

    }

    public function edit(UserReview $review)
    {
        if (auth()->user()->id === $review->user_id) {
            return view('edit-comment', ['review' => $review]);
        }

        return back();
    }

    public function update(Request $request, UserReview $review)
    {
        if (auth()->user()->id === $review->user_id) {
            $request->validate([
                'body' => 'required|string',
            ]);

            $review->update([
                'body' => $request->body,
            ]);

            return redirect()->back();
        }
        return back();
    }


    public function delete(UserReview $review)
    {
        if ((auth()->user()->id === $review->user_id) || auth()->user()->is_admin == 1) {
            $review->delete();
            return back();
        }
        return back();
    }
}
