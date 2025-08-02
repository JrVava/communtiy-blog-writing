<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(){
        $user = User::find(Auth::id());
        $friends = $user->followingUsers;
        return view('frontend.chats.index',['friends' => $friends]);
    }
}
