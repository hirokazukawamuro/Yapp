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

  public function CountFollowings(Request $request)
  {
    $userId = $request->has('userId') ? $request->query('userId') : Auth::id();

    $followings_number = Follow::where('follower_id', $userId)->count();

    return response()->json(['followings_number' => $followings_number]);
  }

  public function CountFollowed(Request $request)
  {
    $userId = $request->has('userId') ? $request->query('userId') : Auth::id();

    $followed_number = Follow::where('followee_id', $userId)->count();

    return response()->json(['followed_number' => $followed_number]);
  }

  public function checkFollow(Request $request)
  {
    $followerId = Auth::id();
    $followeeId = $request->input('userId');

    $follow_checked = Follow::where('follower_id', $followerId)
      ->where('followee_id', $followeeId)
      ->exists();

    return response()->json(['isFollowing' => $follow_checked]);
  }
}
