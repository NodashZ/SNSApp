<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentsController extends Controller
{
    public function store(Request $request)
    {
        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->post_id = $request->post_id;
        $comment->user_id = $request->user()->id;
        $comment->save();

        return response()->json([
            "message" => "new Comment"
        ]);
    }

    public function destroy(Request $request)
    {
        $comment = Comment::find($request->comment_id);
        $comment->delete();

        return response()->json([
            "message" => "delete Comment"
        ]);
    }
}
