<?php

use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PostController;

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

// Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');

Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/',  [AuthController::class, 'index'])->name('login');


Route::middleware([
    'auth',
    'admin',
    'prevent-back-history',
    'no.cache'
])->group(function () {
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('users', [UserController::class, 'index'])->name('users');
    Route::get('users-view/{id}', [UserController::class, 'viewUserProfile'])->name('users-view');
    Route::get('users-approve-deny/{id}', [UserController::class, 'userProfileApproveDeny'])->name('users-approve-deny');
    Route::get('users-post', [AdminPostController::class, 'index'])->name('users-post');
    Route::get('view-post/{id}', [AdminPostController::class, 'viewPost'])->name('view-post');
    Route::get('post-approve-deny/{id}', [AdminPostController::class, 'postApproveDeny'])->name('post-approve-deny');
});

Route::middleware([
    'auth',
    'prevent-back-history',
    'no.cache'
])->group(function () {
    // Below Route is for Example of user Route to define as a logged in user without Admin Role Remove for user Login.
    Route::get('posts',[PostController::class,'index'])->name('posts');
    Route::post('create-post',[PostController::class,'createPost'])->name('create-post');
});
