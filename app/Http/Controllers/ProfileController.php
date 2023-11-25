<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();
        return response()->json(['user' => $user]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $user = \App\Models\User::find($user->id);
        $user->name = $request->input('name');
        $user->profile = $request->input('profile');
        $user->save();

        return response()->json('Profile is successfully updated!');
    }
}
