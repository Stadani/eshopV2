<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSuspended;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\UserSuspendedMail;

class UserProfileController extends Controller
{
    public function show($id)
    {
        $perPage = 10;
        $user = User::findOrFail($id);
        $posts = $user->posts()->paginate($perPage);
        $reviews = $user->reviews()->paginate($perPage);

        return view('profile', compact('user', 'posts', 'reviews'));
    }

    public function suspendUser(User $user, Request $request)
    {
        $request->validate([
            'reason' => 'required|string',
        ]);

        $user->update(['is_suspended' => !$user->is_suspended]);

        UserSuspended::updateOrCreate(
            ['user_id' => $user->id],
            ['reason' => $request->input('reason')]
        );

        Mail::to($user->email)->send(new UserSuspendedMail($user, $request->input('reason')));

        return back()->with('success', 'User suspended successfully.');
    }

    public function deleteUser(User $user)
    {
        if($user->profile_picture) {
            if (!basename('albertwhisker.png')) {
                if (Storage::disk('public')->exists($user->profile_picture)) {
                    Storage::disk('public')->delete($user->profile_picture);
                }
            }
        }

        $user->delete();
        return redirect('/')->with('success', 'User deleted successfully.');
    }
}
