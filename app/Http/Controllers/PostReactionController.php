<?php

namespace App\Http\Controllers;

use App\Models\PostReaction;
use Illuminate\Http\Request;

class PostReactionController extends Controller
{
    public function likePost(Request $request, $postId)
    {
        $userId = auth()->id();
        $reaction = PostReaction::firstOrCreate(['post_id' => $postId]);

        // Remove user ID from dislikes if present
        $dislikes = $reaction->dislikes ?? [];
        $dislikes = array_diff($dislikes, [$userId]);

        // Toggle like
        $likes = $reaction->likes ?? [];
        if (in_array($userId, $likes)) {
            $likes = array_diff($likes, [$userId]); // Unlike
        } else {
            $likes[] = $userId; // Like
        }

        $reaction->update([
            'likes' => array_values($likes),
            'dislikes' => array_values($dislikes),
        ]);

        return response()->json(['message' => 'Reaction updated successfully', 'data' => $reaction]);
    }

    public function dislikePost(Request $request, $postId)
    {
        $userId = auth()->id();
        $reaction = PostReaction::firstOrCreate(['post_id' => $postId]);

        // Remove user ID from likes if present
        $likes = $reaction->likes ?? [];
        $likes = array_diff($likes, [$userId]);

        // Toggle dislike
        $dislikes = $reaction->dislikes ?? [];
        if (in_array($userId, $dislikes)) {
            $dislikes = array_diff($dislikes, [$userId]); // Remove dislike
        } else {
            $dislikes[] = $userId; // Add dislike
        }

        $reaction->update([
            'likes' => array_values($likes),
            'dislikes' => array_values($dislikes),
        ]);

        return response()->json(['message' => 'Reaction updated successfully', 'data' => $reaction]);
    }

    public function getReactions($postId)
    {
        $reaction = PostReaction::where('post_id', $postId)->first();

        return response()->json([
            'likes' => $reaction->likes ?? [],
            'dislikes' => $reaction->dislikes ?? [],
        ]);
    }
}
