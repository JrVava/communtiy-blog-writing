<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(){
        $user = Auth::user();
        $posts = Post::with('user')->where('created_by','=',$user->id)->get();
        return view('profile.index', ['posts' => $posts,'user' => $user]);
    }
}
