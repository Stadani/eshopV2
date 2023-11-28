<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
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
Route::get('/forum', [PostController::class, 'index']);
//        //'forum' => Post::with('tag')->get()   menej queries pre posty ktore vypisuju tagy


Route::get('post/{post:slug}', [PostController::class, 'show']);

Route::get('tags/{tag:slug}', function (Tag $tag) {
    return view('forum', [
        'forum' => $tag->posts
    ]);
});

Route::get('/forum', [PostController::class, 'index']);

Route::get('/postForm', [PostController::class, 'create']) ->name('create.post');
Route::post('/postForm', [PostController::class, 'store'])->name('store.post');

Route::get('/postForm/{post}', [PostController::class, 'edit'])->name('posts.edit');
Route::patch('/postForm/{post}', [PostController::class, 'update'])->name('update.post');
Route::delete('/post/{post:slug}', [PostController::class, 'destroy'])->name('destroy.post');

Route::post('/post/{post:slug}', [CommentController::class, 'store'])->name('store.comment');
Route::post('/posts/{post:slug}', [PostController::class, 'like'])->name('posts.like');


Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
Route::delete('/comments/{comment}', [CommentController::class, 'delete'])->name('comments.delete');


//auth
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
