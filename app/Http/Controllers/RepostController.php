<?php

namespace App\Http\Controllers;

use App\Models\Repost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepostController extends Controller
{
    public function repost(Request $request)
    {
        $existingLike = Repost::where('user_id', Auth::id())
            ->where('post_id', $request->post_id)
            ->first();

        if (!$existingLike) {
            $like = Repost::create([
                'user_id' => Auth::id(),
                'post_id' => $request->post_id,
            ]);

            return response()->json(['message' => 'Repost successfully']);
        }

        return response()->json(['message' => 'Post already reposted']);
    }


    public function undoRepost(Request $request)
    {
        Repost::where('user_id', Auth::id())
            ->where('post_id', $request->post_id)
            ->delete();

        return response()->json(null, 204);
    }

    public function CountReposted(Request $request)
    {
        $reposted_number = Repost::where('post_id', $request->post_id)
            ->count();
        return response()->json(['reposted_number' => $reposted_number]);
    }

    public function checkRepostStatus(Request $request)
    {
        $reposted_posts = Repost::where('user_id', Auth::id())
            ->get();

        return response()->json(['reposted_exists' => $reposted_posts]);
    }
}
