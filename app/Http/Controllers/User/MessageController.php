<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function getMessages($userId)
    {
        $currentUserId = Auth::id();

    // Mark messages as read when fetching
    Message::where('sender_id', $userId)
        ->where('receiver_id', $currentUserId)
        ->where('is_read', false)
        ->update(['is_read' => true]);

    $messages = Message::where(function ($query) use ($currentUserId, $userId) {
            $query->where('sender_id', $currentUserId)
                ->where('receiver_id', $userId);
        })
        ->orWhere(function ($query) use ($currentUserId, $userId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', $currentUserId);
        })
        ->orderBy('created_at', 'asc')
        ->get();

    return response()->json($messages);
    }

    public function markAsRead(Message $message)
    {
        if ($message->receiver_id == Auth::id()) {
            $message->update(['is_read' => true]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 403);
    }

}
