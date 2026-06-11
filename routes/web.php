<?php

use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LearnController;
use App\Http\Controllers\MyPostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\StoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LearnColumnController;
use App\Http\Controllers\Admin\LearnSectionController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ThemeController;


Route::get('/', HomeController::class)->name('home');

Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])
    ->middleware('guest')
    ->name('google.redirect');

Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])
    ->name('google.callback');

Route::get('/stories', [StoryController::class, 'index'])->name('stories.index');
Route::get('/stories/search', [StoryController::class, 'search'])->name('stories.search');
Route::get('/stories/by/worry', [StoryController::class, 'byWorryIndex'])->name('stories.worry.index');
Route::get('/stories/by/worry/{slug}', [StoryController::class, 'byWorry'])->name('stories.worry.show');
Route::get('/stories/by/age', [StoryController::class, 'byAgeIndex'])->name('stories.age.index');
Route::get('/stories/by/age/{slug}', [StoryController::class, 'byAge'])->name('stories.age.show');
Route::get('/stories/by/situation', [StoryController::class, 'bySituationIndex'])->name('stories.situation.index');
Route::get('/stories/by/situation/{slug}', [StoryController::class, 'bySituation'])->name('stories.situation.show');
Route::get('/stories/tags/{slug}', [StoryController::class, 'byTag'])->name('stories.tag');
Route::get('/stories/{slug}', [StoryController::class, 'show'])->name('stories.show');

Route::get('/learn', [LearnController::class, 'index'])->name('learn.index');
Route::get('/learn/{sectionSlug}', [LearnController::class, 'section'])->name('learn.section');
Route::get('/learn/{sectionSlug}/{columnSlug}', [LearnController::class, 'show'])->name('learn.show');

Route::view('/terms', 'legal.terms')->name('terms');
Route::view('/privacy', 'legal.privacy')->name('privacy');

Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/share', [ShareController::class, 'create'])->name('share.create');
    Route::post('/share', [ShareController::class, 'store'])->name('share.store');

    Route::get('/me/posts', [MyPostController::class, 'index'])->name('me.posts');
    Route::get('/me/posts/{post}/edit', [MyPostController::class, 'edit'])->name('me.posts.edit');
    Route::patch('/me/posts/{post}', [MyPostController::class, 'update'])->name('me.posts.update');
    Route::post('/me/posts/{post}/accept-suggestion', [MyPostController::class, 'acceptSuggestion'])
    ->name('me.posts.accept-suggestion');
    Route::delete('/me/posts/{post}', [MyPostController::class, 'destroy'])->name('me.posts.destroy');
    Route::post('/posts/{post}/like', [LikeController::class, 'togglePost'])
        ->name('posts.like');
    Route::post('/learn-columns/{learnColumn}/like', [LikeController::class, 'toggleLearnColumn'])
        ->name('learn-columns.like');

});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.posts.index'));

    Route::get('/posts', [AdminPostController::class, 'index'])->name('posts.index');
    Route::resource('learn-sections', LearnSectionController::class)
    ->except(['show']);
    Route::resource('learn-columns', LearnColumnController::class)
    ->except(['show']);
    Route::resource('tags', TagController::class)
    ->except(['show']);

    Route::get('/posts/{post}/edit', [AdminPostController::class, 'edit'])->name('posts.edit');
    Route::post('/posts/{post}', [AdminPostController::class, 'update'])->name('posts.update');
    Route::delete('/me/posts/{post}', [MyPostController::class, 'destroy'])->name('me.posts.destroy');
    Route::post('/posts/{post}/unpublish', [AdminPostController::class, 'unpublish'])->name('posts.unpublish');
    Route::post('/posts/{post}/reject', [AdminPostController::class, 'reject'])->name('posts.reject');
    
    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');

    Route::patch('/users/{user}/stop',[UserController::class, 'stop'])
        ->name('users.stop');

    Route::patch('/users/{user}/activate',[UserController::class, 'activate'])
        ->name('users.activate');
    Route::resource('themes', ThemeController::class)
    ->except(['show']);
    
});

require __DIR__.'/auth.php';
