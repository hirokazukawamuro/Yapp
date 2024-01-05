<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Request $request)
    {
        $existingLike = Like::where('user_id', Auth::id())
            ->where('post_id', $request->post_id)
            ->first();

        if (!$existingLike) {
            $like = Like::create([
                'user_id' => Auth::id(),
                'post_id' => $request->post_id,
            ]);

            return response()->json(['message' => 'Post liked successfully']);
        }

        return response()->json(['message' => 'Post already liked']);
    }


    public function unlike(Request $request)
    {
        Like::where('user_id', Auth::id())
            ->where('post_id', $request->post_id)
            ->delete();

        return response()->json(null, 204);
    }

    public function checkLikeStatus(Request $request)
    {
        $liked_posts = Like::where('user_id', Auth::id())
            ->get();

        return response()->json(['liked_exists' => $liked_posts]);
    }
}
