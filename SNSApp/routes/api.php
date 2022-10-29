<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->group(function () {
    Route::get('/posts', 'PostController@index');
    Route::post('/posts', 'PostController@store');
    
    Route::get('/posts/{id}', 'PostController@show');
    Route::post('/posts/{id}', 'PostController@update');
    Route::delete('/posts/{id}', 'PostController@destroy');

    Route::post('/like/{postId}', 'LikeController@store');
    Route::delete('/unlike/{postId}', 'LikeController@destroy');

    Route::post('/follow/{userId}', 'FollowController@follow');
    Route::delete('/unfollow/{userId}', 'FollowController@unfollow');

    Route::get('/users', 'UserController@index');

    Route::post('/comments', 'CommentsController@store');
    Route::delete('/comments/{commentId}', 'CommentsController@destroy');
});
