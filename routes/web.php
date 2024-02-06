<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameController;

use App\Http\Controllers\PurchaseHistoryController;
use App\Http\Controllers\StripeController;
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
Route::get('/', [GameController::class, 'carouselItems'])->name('index');

//list is list of games
Route::get('/list', function () {
    return view('list');
});
Route::get('/game', function () {
    return view('game');
});
Route::get('/list', [GameController::class, 'index']);
Route::get('/game/{id}', [GameController::class, 'show'])->name('game.show');

Route::middleware('auth')->group(function () {
Route::post('/cart/{id}/{platform}', [GameController::class, 'addToCart'])->name('addToCart');
Route::delete('removeFromCart', [GameController::class, 'removeFromCart'])->name('removeFromCart');
Route::patch('updateCart', [GameController::class, 'updateCart'])->name('updateCart');
Route::get('/cart', [GameController::class, 'cart'])->name('cart');
Route::post('/session', [StripeController::class, 'session'])->name('session');
Route::get('/success', [StripeController::class, 'success'])->name('success');
Route::get('/cancel', [StripeController::class, 'cancel'])->name('cancel');
});


Route::get('post/{post:slug}', [PostController::class, 'show']);

Route::get('tags/{tag:slug}', function (Tag $tag) {
    return view('forum', [
        'forum' => $tag->posts
    ]);
});

Route::get('/forum', [PostController::class, 'index']);

Route::middleware('auth')->group(function () {
Route::get('/postForm', [PostController::class, 'create']) ->name('create.post');
Route::post('/postForm', [PostController::class, 'store'])->name('store.post');

Route::get('/postForm/{post}', [PostController::class, 'edit'])->name('posts.edit');
Route::patch('/postForm/{post}', [PostController::class, 'update'])->name('update.post');
Route::delete('/post/{post:slug}', [PostController::class, 'delete'])->name('delete.post');


Route::post('/post/{post:slug}', [CommentController::class, 'store'])->name('store.comment');
Route::get('/post/{post:slug}', [CommentController::class, 'index'])->name('index.comment');
Route::post('/posts/{post:slug}', [PostController::class, 'like'])->name('posts.like');


Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
Route::delete('/comments/{comment}', [CommentController::class, 'delete'])->name('comments.delete');
});




//auth
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::put('/profile', [ProfileController::class, 'updateProfile'])
    ->middleware(['auth', 'verified'])->name('user-profile-picture.update');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/inventory', [PurchaseHistoryController::class, 'index'])->name('profile.inventory');
});

require __DIR__.'/auth.php';
