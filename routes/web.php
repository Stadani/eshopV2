<?php

use App\Models\Post;
use App\Models\Tag;
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
        //'forum' => Post::with('tag')->get()   menej queries pre posty ktore vypisuju tagy
    ]);
});
Route::get('post/{post:slug}', function (Post $post) {
    return view('post', [
        'post' => $post
    ]);
});
Route::get('tags/{tag:slug}', function (Tag $tag) {
    return view('forum', [
        'forum' => $tag->posts
    ]);
});
