<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
  public function store(Request $request)
  {
    $follow = Follow::create([
      'follower_id' => Auth::id(),
      'followee_id' => $request->followee_id,
    ]);


    return response()->json(['message' => 'Followed successfully']);
  }

  public function destroy(Request $request)
  {
    $follow = Follow::where('follower_id', Auth::id())
      ->where('followee_id', $request->followee_id)
      ->delete();

    return response()->json(['message' => 'UnFollowed successfully']);
  }


  public function CountFollowings()
  {
    $followings_number = Follow::where('follower_id', Auth::id())
      ->count();
    return response()->json(['followings_number' => $followings_number]);
  }

  public function CountFollowed()
  {
    $followed_number = Follow::where('followee_id', Auth::id())
      ->count();
    return response()->json(['followed_number' => $followed_number]);
  }
}
