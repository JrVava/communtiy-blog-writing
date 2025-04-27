<?php

use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostReactionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;
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
    Route::get('/', [PostController::class, 'index'])->name('posts');
    Route::post('create-post', [PostController::class, 'createPost'])->name('create-post');

    Route::get('profile/{user_id}', [ProfileController::class, 'index'])->name('profile');
    Route::post('upload-avatar', [ProfileController::class, 'uploadAvatar'])->name('upload-avatar');
    Route::post('upload-cover-image', [ProfileController::class, 'uploadCoverImage'])->name('upload-cover-image');

    Route::post('search-user', [SearchController::class, 'searchUser'])->name('search-user');

    Route::post('get-follow', [FollowController::class, 'index'])->name('get-follow');
    Route::post('send-follow-request', [FollowController::class, 'sendFollowRequest'])->name('send-follow-request');
    Route::get('total-follow-request', [FollowController::class, 'totalFollowRequest'])->name('total-follow-request');
    Route::get('follow-request-list', [FollowController::class, 'getRequestList'])->name('follow-request-list');
    Route::post('response-to-request', [FollowController::class, 'responseToRequest'])->name('response-to-request');

    Route::get('messages', [MessageController::class, 'index'])->name('messages');
    Route::post('send-message', [MessageController::class, 'sendMessage'])->name('send-message');
    Route::post('get-messages', [MessageController::class, 'getMessages'])->name('get-messages');

    Route::post('save-comment', [CommentController::class, 'saveComment'])->name('save-comment');

    Route::post('/post/{postId}/like', [PostReactionController::class, 'likePost'])->name('post.like');
    Route::post('/post/{postId}/dislike', [PostReactionController::class, 'dislikePost'])->name('post.dislike');
    Route::get('/post/{postId}/reactions', [PostReactionController::class, 'getReactions'])->name('post.reactions');

    Route::get('/get-notification', [NotificationController::class, 'index'])->name('get-notification');
    Route::get('/clear-notification', [NotificationController::class, 'clearNotification'])->name('clear-notification');
});
