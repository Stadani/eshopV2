<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function suspendUser(User $user)
    {
        if ($user->is_suspended == 1) {
            $user->update(['is_suspended' => 0]);
        } else {
            $user->update(['is_suspended' => 1]);
        }

        return back()->with('success', 'User suspended successfully.');
    }

    public function deleteUser(User $user)
    {
        if($user->profile_picture) {
            if (!basename('albertwhisker.png')) {
                Storage::delete('app/public/profile_pictures/' . basename($user->profile_picture));
            }
        }

        $user->delete();
        return redirect('/')->with('success', 'User deleted successfully.');
    }
}
