<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
  public function search(Request $request)
  {
    $searchTerm = $request->searchTerm;

    Log::info('Search term: ' . $searchTerm);

    $postResults = Post::where('post', 'like', '%' . $searchTerm . '%')->get();
    $userResults = User::where('name', 'like', '%' . $searchTerm . '%')->get();

    Log::info('Received postResults and userResults:', [
      'posts' => $postResults,
      'users' => $userResults,
    ]);
    return response()->json([
      'posts' => $postResults,
      'users' => $userResults,
    ]);
  }
}
