<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class LikeController extends Controller
{
    public function store(Request $request, int $postId)
    {
        $request->user()->like($postId);
        return response()->json([
            "message" => "like"
        ]); 
    }

    public function destroy(Request $request, int $postId)
    {
        $request->user()->unlike($postId);
        return response()->json([
            "message" => "unlike"
        ]);
    }
}
