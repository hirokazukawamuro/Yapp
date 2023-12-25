<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Log;


class ProfileController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();
        return response()->json(['user' => $user]);
    }

    public function showOthersProfile(Request $request)
    {
        $userId = $request->query('userId');
        $user = User::where('id', $userId)->first();

        if (!$user) {
            Log::error("ユーザーが存在しません。 ID: {$userId}");
            return response()->json(['user' => null, 'message' => 'User not found']);
        }

        return response()->json(['user' => $user]);
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $user = \App\Models\User::find($user->id);
        $user->name = $request->input('name');
        $user->profile = $request->input('profile');

        if ($request->hasFile('image_1')) {
            $request->validate([
                'image_1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $original = $request->file('image_1')->getClientOriginalName();
            $name = date('Ymd_His') . '_' . $original;
            $request->file('image_1')->move('storage/images', $name);
            $user->image_1 = $name;
        }

        if ($request->hasFile('image_2')) {
            $request->validate([
                'image_2' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $original = $request->file('image_2')->getClientOriginalName();
            $name2 = date('Ymd_His') . '_' . $original;
            $request->file('image_2')->move('storage/images', $name2);
            $user->image_2 = $name2;
        }

        $user->save();

        return response()->json('Profile is successfully updated!');
    }
}
