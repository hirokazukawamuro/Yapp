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

  public function destroy($id)
  {
    $follow = Follow::find($id);
    $follow->delete();

    return response()->json(['message' => 'UnFollowed successfully']);
  }
}
