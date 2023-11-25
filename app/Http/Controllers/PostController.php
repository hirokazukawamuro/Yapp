<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function send(Request $request)
    {
        $post = Post::query()->create([
            'post' => $request['post'],

        ]);
        return response()->json(['message' => 'Post created successfully']);
    }

    public function fetchMessages(Request $request)
    {

        $posts = Post::select('post')->get();
        return response()->json(['posts' => $posts]);
    }
}
