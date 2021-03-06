<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [PostController::class, 'index'])
    ->name('posts.index');

Route::get('/posts/{post}', [PostController::class, 'show'])
    ->name('posts.show');

Route::middleware('auth')->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])
        ->name('posts.create');
    Route::post('/posts/store', [PostController::class, 'store'])
        ->name('posts.store');

    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])
        ->name('posts.edit');
    Route::put('/posts/{post}/update', [PostController::class, 'update'])
        ->name('posts.update');

    Route::delete('/posts/{post}/destroy', [PostController::class, 'destroy'])
        ->name('posts.destroy');

    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
        ->name('comments.store');

    Route::delete('/posts/{post}/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy');

    Route::get('/posts/{post}/comments/auth', [CommentController::class, 'auth'])
        ->name('comments.auth');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
