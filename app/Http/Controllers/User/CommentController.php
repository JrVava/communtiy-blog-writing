<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required'
        ]);

        $comment = $post->comments()->create([
            'content' => $request->content,
            'user_id' => auth()->id()
        ]);
        $comment->load(['user.currentProfileImage']);
        
        // return response()->json([
        //     'success' => true,
        //     'comment' => $comment->load('user'),
        //     'message' => 'Comment added successfully'
        // ]);

        return response()->json([
        'success' => true,
        'comment' => [
            'id' => $comment->id,
            'content' => $comment->content,
            'created_at' => $comment->created_at->diffForHumans(),
            'user' => [
                'id' => $comment->user->id,
                'full_name' => $comment->user->full_name,
                'currentProfileImage' => [
                    'path' => $comment->user->currentProfileImage 
                        ? Storage::url($comment->user->currentProfileImage->path) 
                        : asset('assets/img/dummy-user.jpg')
                ]
            ]
        ],
        'message' => 'Comment added successfully'
    ]);
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $comment->update(['content' => $request->content]);

        return response()->json([
            'success' => true,
            'comment' => $comment,
            'message' => 'Comment updated successfully'
        ]);
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully'
        ]);
    }
}
