<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\FollowRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index($user_id)
    {
        $user = User::where('id', '=', $user_id)->first();
        $posts = Post::with('user')->where('created_by', '=', $user->id)->get();
        
        return view('profile.index', [
            'posts' => $posts,
            'user' => $user, 
        ]);
    }
}
