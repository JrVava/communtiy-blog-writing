<?php

namespace App\Providers;

use App\Models\Follow;
use App\Models\Message;
use App\Models\Notification;
use App\Models\PostReaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $user_id = Auth::id();

            $pendingCount = Follow::where('following_id', $user_id)
                ->where('status', Follow::STATUS_PENDING)
                ->count();

            $followRequests = Follow::where('following_id', $user_id)
                ->where('status', Follow::STATUS_PENDING)
                ->get();

            $messageNotificationCount = Message::where('receiver_id', $user_id)
                ->where('is_read', false)
                ->count();

            $_nofications = Notification::with([
                'user.currentProfileImage',
                'comments',
                'post.reactions'
            ])->where('post_owner_id', '=', $user_id)->where('is_read', '=', false);

            $notifications = $_nofications->get();
            $noficationsCount = $_nofications->count();

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
                    'created_at' => $notification->created_at->diffForHumans(),
                    'user' => [
                        'name' => $notification->user->full_name,
                        'avatar' => $notification->user->currentProfileImage
                            ? Storage::url($notification->user->currentProfileImage->path)
                            : secure_asset('assets/img/dummy-user.jpg'),
                    ],
                    'message' => $message
                ];
            });
            // dd($formattedNotifications);
            $compact = [
                'pendingCount' => $pendingCount,
                'followRequests' => $followRequests,
                'messageNotificationCount' => $messageNotificationCount,
                'notifications' => $formattedNotifications,
                'noficationsCount' => $noficationsCount
            ];
            $view->with($compact);
        });
    }
}
