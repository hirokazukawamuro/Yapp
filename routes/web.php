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
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'showProfile'])->name('showProfile');
    Route::post('/update', [App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('updateProfile');
});
