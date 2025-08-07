<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function follow(User $user)
    {
        if (auth()->id() === $user->id) {
            return response()->json(['error' => 'You cannot follow yourself'], 400);
        }

        // Check if we already follow this user
        $existingFollow = Follow::where('follower_id', auth()->id())
            ->where('following_id', $user->id)
            ->first();

        if ($existingFollow) {
            return response()->json(['error' => 'You already follow this user'], 400);
        }

        // Check if the user follows us (reverse relationship)
        $reverseFollowExists = Follow::where('follower_id', $user->id)
            ->where('following_id', auth()->id())
            ->where('status', Follow::STATUS_ACCEPTED)
            ->exists();

        // Create the new follow relationship
        $follow = Follow::create([
            'follower_id' => auth()->id(),
            'following_id' => $user->id,
            'status' => Follow::STATUS_PENDING
        ]);

        return response()->json([
            'status' => $follow->status,
            'following' => $follow->status === Follow::STATUS_ACCEPTED,
            'is_mutual' => $reverseFollowExists
        ]);
    }

    public function unfollow(User $user)
    {
        $follow = Follow::where('follower_id', auth()->id())
            ->where('following_id', $user->id)
            ->first();

        if (!$follow) {
            return response()->json(['error' => 'Follow relationship not found'], 404);
        }

        // Check if this was a mutual follow
        $reverseFollow = Follow::where('follower_id', $user->id)
            ->where('following_id', auth()->id())
            ->where('status', 'accepted')
            ->first();

        if ($reverseFollow) {
            // Downgrade reverse follow to pending if it exists
            $reverseFollow->update(['status' => Follow::STATUS_PENDING]);
        }

        $follow->delete();

        return response()->json([
            'status' => 'removed',
            'following' => false,
            'follow_back' => $user->isFollowing(auth()->user()),
            'mutual' => false
        ]);
    }

    public function acceptFollow(User $user)
    {
        $follow = Follow::where('follower_id', $user->id)
            ->where('following_id', auth()->id())
            ->where('status', Follow::STATUS_PENDING)
            ->firstOrFail();

        $follow->update(['status' => Follow::STATUS_ACCEPTED]);

        return response()->json(['success' => 'Follow request accepted']);
    }

    public function declineFollow(User $user)
    {
        $follow = Follow::where('follower_id', $user->id)
            ->where('following_id', auth()->id())
            ->where('status', Follow::STATUS_PENDING)
            ->firstOrFail();

        $follow->delete();

        return response()->json(['success' => 'Follow request declined']);
    }

    public function cancelRequest(User $user)
    {
        $follow = Follow::where('follower_id', auth()->id())
            ->where('following_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if (!$follow) {
            return response()->json(['error' => 'Pending request not found'], 404);
        }

        $follow->delete();

        return response()->json([
            'status' => 'cancelled',
            'following' => false,
            'follow_back' => $user->isFollowing(auth()->user())
        ]);
    }


}
