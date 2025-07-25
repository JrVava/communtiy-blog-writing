<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\ChatController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\FamilyRelationshipController;
use App\Http\Controllers\User\FollowController;
use App\Http\Controllers\User\PlaceController;
use App\Http\Controllers\User\PostController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ReactionController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\WorkEducationController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// In your web.php routes file
Route::post('/clear-success-session', function () {
    session()->forget('success');
    return response()->json(['success' => true]);
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/login/form', 'signForm')->name('login.form');
    Route::get('sign-up', 'signUp')->name('sign-up');
    Route::post('sign-up/form', [AuthController::class, 'signUpUser'])->name('sign-up.form');
    Route::get('logout', 'logout')->name('logout');
});

Route::middleware([
    'auth',
    'prevent-back-history',
    'no.cache'
])->group(function () {
    Route::controller(PostController::class)->group(function () {
        Route::get('/', 'index')->name('user.post');
        Route::post('posts-store', 'store')->name('posts.store');
    });

    Route::controller(CommentController::class)->group(function () {
        Route::post('/posts/{post}/comments', 'store')->name('comments.store');
        Route::put('/comments/{comment}', 'update')->name('comments.update');
        Route::delete('/comments/{comment}', 'destroy')->name('comments.destroy');
    });

    Route::controller(ReactionController::class)->group(function () {
        Route::post('/posts/{post}/react', 'react')->name('posts.react');
        Route::get('/posts/{post}/reactions', 'getReactions')->name('posts.reactions');
    });

    Route::controller(ChatController::class)->group(function () {
        Route::get('/chats', 'index')->name('chats');
    });

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile/{user_id}/{parentTab?}/{tab?}', 'index')->name('profile');

        Route::post('/profile/contact-info/add', 'addContact')->name('profile.contact-info.add');
        Route::delete('/profile/contact-info/{id}/delete', 'deleteContact')->name('profile.contact-info.delete');
        Route::post('/profile/contact-info/basic/create', 'createBasicInfo')->name('profile.contact-info.basic.create');
        Route::post('/media/upload',  'uploadMedia')->name('media/upload');
    });

    Route::controller(FollowController::class)->group(function () {
        Route::post('/users/{user}/follow', 'follow')->name('users.follow');
        Route::post('/users/{user}/unfollow', 'unfollow')->name('users.unfollow');
        Route::post('/users/{user}/follow/accept', 'acceptFollow')->name('follow.accept');
        Route::post('/users/{user}/follow/decline', 'declineFollow')->name('follow.decline');
        Route::post('/users/{user}/follow/cancel', 'cancelRequest')->name('follow.cancel');
    });

    Route::controller(PlaceController::class)->group(function () {
        Route::post('/places/save', 'store')->name('places.store');
        Route::delete('/places/delete/{id}', 'destroy')->name('places.destroy');
    });

    // routes/api.php
    Route::get('/search/users', [UserController::class, 'search'])->name('users.search');

    Route::controller(WorkEducationController::class)->group(function () {
        Route::post('/work', 'storeWork')->name('work.store');
        Route::put('/work/{id}', 'updateWork')->name('work.update');
        Route::delete('/work/{id}', 'destroyWork')->name('work.destroy');
        Route::get('/work/{id}', 'showWork')->name('work.show');

        // Education Routes
        Route::post('/education', 'storeEducation')->name('education.store');
        Route::put('/education/{id}', 'updateEducation')->name('education.update');
        Route::delete('/education/{id}', 'destroyEducation')->name('education.destroy');
        Route::get('/education/{id}', 'showEducation')->name('education.show');
    });

    Route::controller(FamilyRelationshipController::class)->group(function () {
        Route::post('/update-relationship', 'updateRelationship')->name('relationship.update');

        Route::post('/add-family-member', 'addFamilyMember')->name('family.member.add');
        
        Route::delete('/remove-family-member/{familyMember}', 'removeFamilyMember')->name('family.member.remove');
        Route::get('/search-following','searchFollwingUser')->name('search-following');
    });
});