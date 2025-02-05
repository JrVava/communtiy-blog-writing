<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(){
        $posts = Post::with('user')->where('is_approve' ,'=',true)->get();
        
        return view('blog.index',['posts' => $posts]);
    }

    public function createPost(Request $request){
        // dd($request->all());
        $request->validate([
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Optional image validation
        ]);
        $post = new Post();
        $post->description = $request->input('description');
        $post->created_by = Auth::user()->id;
        // Handle image upload and convert to base64
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $mimeType = $image->getMimeType(); 
            $imageData = base64_encode(file_get_contents($image)); // Convert to base64
            $post->image = "data:$mimeType;base64,$imageData"; // Save the base64 data in the image column
        }

        $post->save();
        return redirect()->route('posts')->with('success', 'Post created successfully!');
    }
}
