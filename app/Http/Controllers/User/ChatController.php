<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());
        $friends = $user->followingUsers()
            ->with(['currentProfileImage'])
            ->get()
            ->map(function ($friend) use ($user) {
                $lastMessage = $user->lastMessageWith($friend);
                return [
                    'id' => $friend->id,
                    'full_name' => $friend->full_name,
                    'avatar' => $friend->currentProfileImage
                        ? Storage::url($friend->currentProfileImage->path)
                        : secure_asset('assets/img/dummy-user.jpg'),
                    'last_message' => $lastMessage ? $lastMessage->message : null,
                    'last_message_time' => $lastMessage ? $lastMessage->created_at : null,
                    'is_sender' => $lastMessage ? $lastMessage->sender_id == $user->id : false,
                    'unread_count' => Message::where('sender_id', $friend->id)
                        ->where('receiver_id', $user->id)
                        ->where('is_read', false)
                        ->count()
                ];
            });
        // dd($friends);
        return view('frontend.chats.index', ['friends' => $friends]);
    }

    public function getMessageNotificationCount($receiver_id)
    {
        $count = Message::where('receiver_id', $receiver_id)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'count' => $count,
            'status' => 'success'
        ]);
    }
}
