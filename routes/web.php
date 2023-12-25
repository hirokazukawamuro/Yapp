<?php

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

Route::post('/register', [\App\Http\Controllers\UserController::class, 'register']);
Route::get('/register', [\App\Http\Controllers\UserController::class, 'showRegister']);
Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::post('/login', [\App\Http\Controllers\UserController::class, 'login']);
Route::post('logout', [\App\Http\Controllers\UserController::class, 'logout'])->name('user.logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/v/{any}', function () {
        return view('dashboard');
    })->where('any', '.*');
    Route::post('/send', [App\Http\Controllers\PostController::class, 'send'])->name('send');
    Route::get('/timeline', [App\Http\Controllers\PostController::class, 'fetchMessages'])->name('fetchMessages');
    Route::get('/my_timeline', [App\Http\Controllers\PostController::class, 'fetchAuthUserMessages'])->name('fetchAuthUserMessages');
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'showProfile'])->name('showProfile');
    Route::get('/others', [App\Http\Controllers\ProfileController::class, 'showOthersProfile'])->name('showOthersProfile');
    Route::post('/update', [App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('updateProfile');
    Route::get('/follow/check', [App\Http\Controllers\FollowController::class, 'checkFollow'])->name('checkFollow');
    Route::post('/follow', [App\Http\Controllers\FollowController::class, 'store'])->name('store');
    Route::post('/follow/destroy', [App\Http\Controllers\FollowController::class, 'destroy'])->name('destroy');
    Route::get('/follow/followings_number', [App\Http\Controllers\FollowController::class, 'CountFollowings'])->name('CountFollowings');
    Route::get('/follow/followed_number', [App\Http\Controllers\FollowController::class, 'CountFollowed'])->name('CountFollowed');
    Route::post('/like', [App\Http\Controllers\LikeController::class, 'like'])->name('like');
    Route::post('/unlike', [App\Http\Controllers\LikeController::class, 'unlike'])->name('unlike');
    Route::get('/checkLikeStatus', [App\Http\Controllers\LikeController::class, 'checkLikeStatus'])->name('checkLikeStatus');
    Route::get('/allusers', [App\Http\Controllers\UserController::class, 'fetchUsers'])->name('fetchUsers');
    Route::get('/search', [App\Http\Controllers\SearchController::class, 'search'])->name('search');
});
