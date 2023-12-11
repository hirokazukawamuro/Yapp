<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LikeController extends Controller
{
    public function like(Request $request)
    {
        Log::info('Received post_id:', ['post_id' => $request->post_id]);
        $like = Like::create([
            'user_id' => Auth::id(),
            'post_id' => $request->post_id,
        ]);

        return response()->json(['message' => 'Post liked successfully']);
    }

    public function destroy(Like $like)
    {
        $like->delete();

        return response()->json(null, 204);
    }
}
