<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

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

        $postModel = Post::create([
            'post' => $postText,
            'image' => $imageName,
        ]);

        return response()->json(['message' => '投稿が正常に作成されました']);
    }

    public function fetchMessages(Request $request)
    {

        $posts = Post::select('post', 'image')->get();
        return response()->json(['posts' => $posts]);
    }
}
