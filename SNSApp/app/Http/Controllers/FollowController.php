<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function follow(Request $request, int $userId)
    {
        $request->user()->follow($userId);
        return response()->json([
            "message" => "follow"
        ]);
    }

    public function unfollow(Request $request, int $userId)
    {
        $request->user()->unfollow($userId);
        return response()->json([
            "message" => "unfollow"
        ]);
    }
}
