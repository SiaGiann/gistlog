<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GistsController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AuthorsRssController;
use App\Http\Controllers\GistCommentsController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('logout', [AuthController::class, 'getLogout']);
Route::get('auth/github', [AuthController::class, 'redirectToProvider']);
Route::get('auth/github/callback', [AuthController::class, 'handleProviderCallback']);
Route::get('posts/create', [HomeController::class, 'createForm']);
Route::post('posts/create', [GistsController::class, 'storeAndRedirect'])->name('post.create');

Route::group(['middleware', 'auth' ], function () {

    Route::put('posts/{gistId}/star', [GistsController::class, 'star'])->name('post.star');
    Route::delete('posts/{gistId}/unstar', [GistsController::class, 'unstar'])->name('post.unstar');
    Route::post('comment/{gistId}', [GistCommentsController::class, 'store'])->name('comments.store');
});

Route::get('{username}/feed.atom', [AuthorsRssController::class, 'show'])->name('authors.rss.show');

Route::get('{username}/{gistId}', [GistsController::class, 'show'])->name('gists.show');
Route::get('{username}/{gistId}/comments.json', [GistCommentsController::class, 'jsonIndex'])->name('gists.comments.index');
Route::get('{username}', [AuthorsController::class, 'show'])->name('authors.show');
