<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});

//list is list of games
Route::get('/list', function () {
    return view('list');
});
Route::get('/game', function () {
    return view('game');
});

//forum is list of posts
Route::get('/forum', function () {
    return view('forum', [
        'forum' => Post::all()
    ]);
});
Route::get('post/{post:slug}', function (Post $post) {
    return view('post', [
        'post' => $post
    ]);
});
