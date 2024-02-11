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
            'body' => request('body'),
            'rating' => request('rating'),
        ]);

        return back();

    }

    public function update(Request $request, UserReview $review)
    {
        if (auth()->user()->id === $review->user_id) {
            $request->validate([
                'body' => 'required|string',
                'rating' => 'required|integer',
            ]);

            $review->update([
                'body' => $request->body,
                'rating' => $request->rating,
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
