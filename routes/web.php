<?php

use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;

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

Route::get('/login',  [AuthController::class, 'index'])->name('login');


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
    Route::get('/',[PostController::class,'index'])->name('posts');
    Route::post('create-post',[PostController::class,'createPost'])->name('create-post');

    Route::get('profile/{user_id}',[ProfileController::class,'index'])->name('profile');
    Route::post('follow-request',[ProfileController::class,'followRequest'])->name('follow-request');
    Route::post('check-request',[ProfileController::class,'checkRequest'])->name('check-request');
    Route::post('friend-request',[ProfileController::class,'friendRequest'])->name('friend-request');
    Route::post('friend-request-response',[ProfileController::class,'friendRequestResponse'])->name('friend-request-response');

    Route::post('search-user',[SearchController::class,'searchUser'])->name('search-user');
});
