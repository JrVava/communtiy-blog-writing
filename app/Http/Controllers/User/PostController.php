<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\Post;
use App\Models\PostReaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(User $user)
    {
        $followingIds = auth()->user()->following()
            ->where('status', Follow::STATUS_ACCEPTED)
            ->pluck('users.id');

        // Include the authenticated user's ID
        $followingIds->push(auth()->id());

        // Get posts from followed users AND the authenticated user
        $posts = Post::whereIn('user_id', $followingIds)
            ->with('user') // Eager load the user relationship
            ->withCount(['comments'])
            ->latest()
            ->get();

        return view('frontend.posts.index', [
            'posts' => $posts,
            'reactions' => PostReaction::$reactionTypes
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:5000',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:51200' // 50MB max
        ]);
        // $request['user_id'] = Auth::id();
        $post = new Post([
            'content' => $request->content,
            'user_id' => Auth::id()
        ]);
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $path = $file->store(
                'post_media/' . Auth::id(), // User-specific directory
                'public'
            );

            $post->media_path = $path;
            $post->media_type = str_starts_with($file->getMimeType(), 'video/') ? 'video' : 'image';
        }

        $post->save();

        return redirect()->back()->with('success', 'Post created successfully!');
    }
}
