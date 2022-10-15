<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = $request->sort;
        $userId = $request->user()->id;
        if (isset($userId)) {
            $posts = $request->user()->posts();
            if (isset($sort)) {
                if($sort == "likes_count") {
                    //withCountは引数と同じ名前の関数(Post:likes)のcountを"引数_count"(likes_count)として持つようにする
                    $posts = $posts->withCount('likes')->orderBy($sort, 'desc');
                } else {
                    $posts = $posts->orderBy($sort, 'asc');
                }
            }
            $posts = $posts->paginate(3);
        } else {
            $posts = [];
        }

        return new PostCollection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Post;
        $form = json_decode($request->post,true);
        $file_name = $form['image'];
        request()->file->storeAs('public/', $file_name);

        $post->user_id = $request->user()->id;
        $post->fill($form)->save();

        return response()->json([]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, int $id)
    {
        $item = Post::findOrFail($id);
        return new PostResource($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $post = Post::find($id);
        $form = $request->post;
        
        $post->fill($form)->save();

        return response()->json([]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
   
    public function update(Request $request, Post $post, int $id)
    {
        $post = Post::find($id);
        $form = json_decode($request->post,true);
        $file_name = $form['image'];
        request()->file->storeAs('public/', $file_name);

        $post->user_id = $request->user()->id;
        $post->fill($form)->save();

        return response()->json([]);
    }
  */
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if (isset($post->image)) {
            \Storage::disk('public')->delete($post->image);
        }

        Post::destroy($id);
        return response()->json([
            "message" => "records deleted"
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            "message" => "logout"
        ]);
    }
}
