<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\PostReaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $notifications = Post::with([
            'comments' => function ($query) {
                $query->where('is_read', false);
            },
            'reactions' => function ($query) {
                $query->whereNotNull('recent_likes')->orWhereNotNull('recent_dislikes');
            }
        ])->where('created_by', $userId)->get();

        $html = '';
        $totalCount = 0;
        foreach ($notifications as $notification) {
            if ($notification->comments->count() > 0) {
                // Summing up total unread comments instead of overwriting
                $totalCount += $notification->comments->count();

                foreach ($notification->comments as $comment) {
                    $html .= $this->generateReactionHtml($comment->user, 'commented');
                }
            }

            if (isset($notification->reactions) && $notification->reactions != null) {
                $likedUsers = $this->getUsers($notification->reactions->recent_likes);
                $dislikedUsers = $this->getUsers($notification->reactions->recent_dislikes);

                if ($likedUsers->count() > 0) {
                    $totalCount += $likedUsers->count();
                    foreach ($likedUsers as $likedUser) {
                        $html .= $this->generateReactionHtml($likedUser, 'Liked');
                    }
                }

                if ($dislikedUsers->count() > 0) {
                    $totalCount += $dislikedUsers->count();
                    foreach ($dislikedUsers as $dislikedUser) {
                        $html .= $this->generateReactionHtml($dislikedUser, 'Disliked');
                    }
                }
            }
        }

        return response()->json([
            'html' => $html,
            'totalCount' => $totalCount,
            'status' => 200
        ]);
    }

    private function getUsers($userId)
    {
        return User::whereIn('id', $userId)->get();
    }

    private function generateReactionHtml($user, $action)
    {
        $html = '<li class="p-2 border-bottom d-flex align-items-center">';

        if (!empty($user->image)) {
            $html .= '<img src="' . asset( $user->image) . '" class="rounded-circle me-2" width="40" height="40" alt="User">';
        } else {
            $html .= '<div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white me-2"
                        style="width: 40px; height: 40px; font-size: 1rem; font-weight: bold;">
                        ' . $user->initials . '
                    </div>';
        }

        $html .= '<strong>' . $user->full_name . '</strong> &nbsp; has ' . $action . ' on your post.';
        $html .= '</li>';

        return $html;
    }

    public function clearNotification()
    {
        $userId = Auth::id();
        $posts = Post::where('created_by', $userId)->pluck('id');
        Comment::whereIn('post_id', $posts)->update(['is_read' => true]);
        PostReaction::whereIn('post_id', $posts)->update(['recent_likes' => null, 'recent_dislikes' => null]);
        return response()->json([
            'status' => 200
        ]);
    }
}
