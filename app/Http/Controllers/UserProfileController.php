<?php

namespace App\Http\Controllers;

use App\Mail\UserDeletedMail;
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

    public function suspendUser(User $user, Request $request, UserSuspended $userSuspended)
    {
        $request->validate([
            'reason' => 'required|string',
        ]);

        $user->update(['is_suspended' => !$user->is_suspended]);

        $userSuspended->where('user_id', $user->id)->update([
            'reason' => $request->input('reason')
        ]);


        if ($user->is_suspended == 1) {
            Mail::to($user->user->email)->send(new UserSuspendedMail($user, $request->input('reason')));
        }

        return back()->with('success', 'User suspended successfully.');
    }

    public function deleteUser(User $user, Request $request,)
    {
        if($user->profile_picture) {
            if (!basename('albertwhisker.png')) {
                if (Storage::disk('public')->exists($user->profile_picture)) {
                    Storage::disk('public')->delete($user->profile_picture);
                }
            }
        }

        Mail::to($user->email)->send(new UserDeletedMail($user, $request->input('reason')));

        $user->delete();
        return redirect('/')->with('success', 'User deleted successfully.');
    }
}
