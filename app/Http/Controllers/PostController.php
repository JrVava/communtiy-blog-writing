<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->get();

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
