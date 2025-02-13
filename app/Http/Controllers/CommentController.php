<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function saveComment(Request $request)
    {
        $data = [
            'user_id' => $request->userId,
            'post_id' => $request->postId,
            'comment' => $request->message
        ];
        $comment = new Comment;
        $comment->fill($data);
        $comment->save();
        return response()->json(200);
    }
}
