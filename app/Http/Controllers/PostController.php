<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $followingIds = Follow::where('user_id', $userId)
            ->whereIn('status', ['Accepted', 'Followed'])
            ->pluck('following_id');
            
        // Get users that follow the current user with "Followed" status (mutual following)
        $followerIds = Follow::where('following_id', $userId)
            ->where('status', 'Followed')
            ->pluck('user_id');
        // Merge both user lists and include the logged-in user's posts
        $allowedUserIds = $followingIds->merge($followerIds)->push($userId);

        $posts = Post::with('comments','reactions')->whereIn('created_by', $allowedUserIds)->latest()->get();
        foreach ($posts as $post) {
            $post->user_liked = false;
            $post->user_disliked = false;
    
            if ($post->reactions) {
                $likes = $post->reactions->likes ?? '[]';
                $dislikes = $post->reactions->dislikes ?? '[]';
    
                $post->user_liked = in_array($userId, $likes);
                $post->user_disliked = in_array($userId, $dislikes);
            }
        }
        // dd($posts);
        return view('blog.index', ['posts' => $posts]);
    }

    public function createPost(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi,wmv|max:10240',
        ]);

        // dd($request->all());
        $post = new Post();
        $post->description = $request->input('description');
        $post->created_by = Auth::user()->id;
        // Handle image upload and convert to base64
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();

            // Store the file in storage/app/public/uploads/posts
            $filename = time() . '.' . $extension;
            $path = $file->storeAs('uploads/posts', $filename, 'public');

            // Save file path in the database
            $post->image = $path;
        }

        $post->save();
        return redirect()->route('posts')->with('success', 'Post created successfully!');
    }
}
