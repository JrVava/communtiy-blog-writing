<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\PostReaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Notification::where('post_owner_id', $request->post_owner_id)
            ->where('user_id', $request->user_id)
            ->where('is_read', false);

        $count = $query->count(); // Single count query
        $notifications = $query->with([
            'user.currentProfileImage',
            'comments',
            'post.reactions'
        ])->get(); // Then get results

        $formattedNotifications = $notifications->map(function ($notification) {
            // Get the reaction emoji if it exists
            $reactionEmoji = null;
            if ($notification->reaction && $notification->post && $notification->post->reactions) {
                $reactionType = $notification->post->reactions->getUserReaction($notification->user_id);
                $reactionEmoji = PostReaction::$reactionTypes[$reactionType] ?? null;
            }

            // Build the message
            $message = $notification->user->full_name;
            if ($notification->comment_id) {
                $message .= " commented on your post";
            } else {
                $message .= " reacted on your post";
                if ($reactionEmoji) {
                    $message .= " with " . $reactionEmoji;
                }
            }

            return [
                'id' => $notification->id,
                'post_id' => $notification->post_id,
                'post_owner_id' => $notification->post_owner_id,
                'user_id' => $notification->user_id,
                'reaction' => $notification->reaction ? ucfirst($notification->reaction) : null,
                'reaction_emoji' => $reactionEmoji, // Add the emoji to the response
                'created_at' => $notification->created_at,
                'user' => [
                    'name' => $notification->user->full_name,
                    'avatar' => $notification->user->currentProfileImage
                        ? Storage::url($notification->user->currentProfileImage->path)
                        : secure_asset('assets/img/dummy-user.jpg'),
                ],
                'message' => $message
            ];
        });

        return response()->json(['notifications' => $formattedNotifications, 'count' => $count]);
    }

    public function markAsRead(Request $request)
    {
        $validated = $request->validate([
            'notification_ids' => 'required|array',
            'notification_ids.*' => 'uuid' // or whatever ID type you use
        ]);
        
        Notification::whereIn('id', $request->notification_ids)
            ->where('post_owner_id', auth()->id())
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
        ]);
    }
}
