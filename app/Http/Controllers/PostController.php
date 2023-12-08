<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'post' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $postText = $request->input('post');
        $image = $request->file('image');
        $imageName = null;

        if ($image) {
            $original = $image->getClientOriginalName();
            $imageName = date('Ymd_His') . '_' . $original;
            $image->move('storage/images', $imageName);
        }
        $user_id = Auth::id();
        $postModel = Post::create([
            'user_id' => $user_id,
            'post' => $postText,
            'image' => $imageName,
        ]);

        return response()->json(['message' => '投稿が正常に作成されました']);
    }

    public function fetchMessages(Request $request)
    {
        $posts = Post::with('user:name,image_1')
            ->select('posts.post', 'posts.image as post_image', 'users.name as username', 'users.image_1 as user_image')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->orderBy('posts.created_at', 'desc')
            ->get();

        return response()->json(['posts' => $posts]);
    }

    public function fetchAuthUserMessages(Request $request)
    {

        $userId = Auth::id();

        $posts = Post::with('user:name,image_1')
            ->select('posts.post', 'posts.image as post_image', 'users.name as username', 'users.image_1 as user_image')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->where('posts.user_id', $userId)
            ->orderBy('posts.created_at', 'desc')
            ->get();

        return response()->json(['posts' => $posts]);
    }
}
