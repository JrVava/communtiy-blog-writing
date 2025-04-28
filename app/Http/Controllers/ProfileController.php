<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\PlaceLived;
use App\Models\Post;
use App\Models\User;
use App\Models\WorkPlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index($user_id)
    {
        $user = User::where('id', '=', $user_id)->with('workPlace','placeLived')->first();
        // dd($user);
        $userId = Auth::user()->id;
        $followingIds = Follow::where('user_id', $userId)
            ->whereIn('status', ['Accepted', 'Followed'])
            ->pluck('following_id');

        // Get users that follow the current user with "Followed" status (mutual following)
        $followerIds = Follow::where('following_id', $userId)
            ->where('status', 'Followed')
            ->pluck('user_id');
        // Merge both user lists and include the logged-in user's posts
        $allowedUserIds = $followingIds->merge($followerIds);

        if ($user->id == $userId) {
            $allowedUserIds = [$userId];
        }
        $posts = Post::with('comments', 'reactions')->whereIn('created_by', $allowedUserIds)->latest()->get();

        return view('profile.index', [
            'posts' => $posts,
            'user' => $user,
        ]);
    }

    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpg,webp,jpeg,png|max:10240',
        ]);

        $user = Auth::id();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();

            // Store the file in storage/app/public/uploads/posts
            $filename = time() . '.' . $extension;
            $path = $file->storeAs('uploads/user/' . $user . '/', $filename, 'public');
            User::where('id', '=', $user)
                ->update([
                    'image' => $path
                ]);

            return response()->json([
                'status' => 200,
                'message' => 'Profile image updated successfully.',
                'path' => asset('storage/' . $path) // if you want to return full URL too
            ]);
        }
        return response()->json([
            'status' => 400,
            'message' => 'No image uploaded.',
        ], 400);
    }

    public function uploadCoverImage(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpg,webp,jpeg,png|max:10240',
        ]);
    }

    public function addUpdateWorkPlace(Request $request)
    {
        $request['end_date'] = $request['end_date'] == '' ? 'Present' : $request->end_date;

        if (isset($request->id)) {
            unset($request['_token']);
            WorkPlace::where('id', '=', $request->id)->update($request->all());
            $msg = 'Work place and Education has been Update';
        } else {
            $request['user_id'] = Auth::id();
            $workplace = new WorkPlace();
            $workplace->fill($request->all());
            $workplace->save();
            $msg = 'Work place and Education has been added';
        }
        return redirect()->back()->with('message', $msg);
    }

    public function deleteWorkPlace($id)
    {
        WorkPlace::where('id', '=', $id)->delete();
        return redirect()->back()->with('message', 'Work place and Education has been deleted.');
    }

    public function addUpdatePlaceLived(Request $request){
        if (isset($request->id)) {
            unset($request['_token']);
            PlaceLived::where('id', '=', $request->id)->update($request->all());
            $msg = 'Place lived has been Update';
        } else {
            $request['user_id'] = Auth::id();
            $workplace = new PlaceLived();
            $workplace->fill($request->all());
            $workplace->save();
            $msg = 'Place lived has been added';
        }
        return redirect()->back()->with('message', $msg);
    }

    public function deletePlaceLived($id){
        PlaceLived::where('id', '=', $id)->delete();
        return redirect()->back()->with('message', 'Place Lived has been deleted.');
    }
}
