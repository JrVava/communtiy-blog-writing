<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $followers = Follow::where([
            ['user_id', '=', $userId],
            ['status', '=', 'Followed'],
        ])->pluck('following_id');

        $followings = Follow::where([
            ['following_id', '=', $userId],
            ['status', '=', 'Followed'],
        ])->pluck('user_id');

        $userIds = $followers->concat($followings);

        $users = User::whereIn('id', $userIds)->get();

        return view('messages.index', ['users' => $users]);
    }

    public function sendMessage(Request $request){
        $message = new Message;
        $message->fill($request->all());
        $message->save();
    }

    public function getMessages(Request $request){
        $receiver_id = $request->receiver_id;
        $messages = Message::where(function ($query) use ($receiver_id) {
            $query->where('sender_id', Auth::id())
            ->where('receiver_id', $receiver_id);
        })
        ->orWhere(function ($query) use ($receiver_id) {
            $query->where('sender_id', $receiver_id)
                  ->where('receiver_id', Auth::id());
        })
        ->orderBy('created_at', 'asc')
        ->get();

        $html = '';
        foreach($messages as $message){
            $readTick = ($message->is_read) ? '<i class="bi bi-check-all text-white"></i>' : '<i class="bi bi-check"></i>';
        
        if ($message->sender_id == Auth::id()) {
            $html .= '<div class="message sent">'.$message->messages . ' ' . $readTick . '</div>';
        } else {
            $html .= '<div class="message received">'.$message->messages.'</div>';
        }
        }
        
        return response()->json(['html' => $html]);
    }
}
