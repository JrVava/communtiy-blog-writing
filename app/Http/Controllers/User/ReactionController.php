<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Post;
use App\Models\PostReaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReactionController extends Controller
{
    public function react(Request $request, Post $post)
    {
        $request->validate([
            'reaction' => 'required|in:like,love,haha,wow,sad,angry'
        ]);

        $user = Auth::user();
        $reactionType = $request->reaction;

        // Find or create reaction record
        $reaction = PostReaction::firstOrCreate(
            ['post_id' => $post->id],
            ['reactions' => array_fill_keys(array_keys(PostReaction::$reactionTypes), [])]
        );

        $currentReactions = $reaction->reactions;
        $action = 'added';
        $previousReaction = null;

        // Check if user already has this reaction
        $userIndex = array_search($user->id, $currentReactions[$reactionType]);

        if ($userIndex !== false) {
            // Remove the reaction
            array_splice($currentReactions[$reactionType], $userIndex, 1);
            $action = 'removed';
        } else {
            // Remove user from all other reaction types first
            foreach ($currentReactions as $type => &$userIds) {
                if (($key = array_search($user->id, $userIds)) !== false) {
                    $previousReaction = $type;
                    array_splice($userIds, $key, 1);
                }
            }

            // Add the new reaction
            $currentReactions[$reactionType][] = $user->id;
        }

        // Save the updated reactions
        $reaction->update(['reactions' => $currentReactions]);

        $checkNotification = Notification::where([
            ['post_id', "=", $post->id],
            ['post_owner_id', "=", $post->user_id],
            ['user_id', "=", $user->id],
        ])->exists();

        if ($checkNotification) {
            Notification::where([
                ['post_id', "=", $post->id],
                ['post_owner_id', "=", $post->user_id],
                ['user_id', "=", $user->id],
            ])->update(
                    [
                        'reaction' => $reactionType,
                    ]
                );
            if ($action == 'removed') {
                Notification::where([
                    ['post_id', "=", $post->id],
                    ['post_owner_id', "=", $post->user_id],
                    ['user_id', "=", $user->id],
                ])->delete();
            }
        } else {
            $notification = new Notification();
            $notification->fill([
                'post_id' => $post->id,
                'post_owner_id' => $post->user_id,
                'user_id' => $user->id,
                'reaction' => $reactionType,
            ]);
            $notification->save();
        }

        return response()->json([
            'success' => true,
            'action' => $action,
            'reaction' => $reactionType,
            'reaction_counts' => $reaction->getReactionCounts(),
            'total_reactions' => $reaction->getTotalReactions(),
            'post_id' => $post->id,
            'post_owner_id' => $post->user_id,
            'user_id' => $user->id,
        ]);
    }

    public function getReactions(Post $post)
    {
        $reaction = PostReaction::where('post_id', $post->id)->first();

        if (!$reaction) {
            return response()->json([
                'success' => true,
                'reactions' => []
            ]);
        }

        $result = [];
        foreach ($reaction->reactions as $type => $userIds) {
            if (!empty($userIds)) {
                $users = User::whereIn('id', $userIds)
                    ->take(3)
                    ->pluck('full_name')
                    ->toArray();

                $result[$type] = [
                    'count' => count($userIds),
                    'users' => $users,
                    'emoji' => PostReaction::$reactionTypes[$type]
                ];
            }
        }

        return response()->json([
            'success' => true,
            'reactions' => $result,
            'total_reactions' => $reaction->getTotalReactions()
        ]);
    }
}
