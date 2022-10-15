<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('post.list');
    })->name('todos');
    Route::get('/post/create', function () {
        return view('post.form');
    });
    Route::get('/post/edit/{id}', function () {
        return view('post.edit');
    });
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/logout', 'PostController@logout')->name('logout');  

