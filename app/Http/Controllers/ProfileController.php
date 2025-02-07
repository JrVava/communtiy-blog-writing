<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\FollowRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index($user_id)
    {
        $user = User::where('id', '=', $user_id)->first();
        $posts = Post::with('user')->where('created_by', '=', $user->id)->get();
        $followRequest = FollowRequest::where('follower_id', '=', $user->id)->first();

        return view('profile.index', ['posts' => $posts, 'user' => $user, 'followRequest' => $followRequest]);
    }

    public function followRequest(Request $request)
    {
        $request->validate([
            'follower_id' => 'required|exists:users,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $followRequest = FollowRequest::where([
            'follower_id' => $request->follower_id,
            'user_id' => $request->user_id
        ])->first(); // Retrieve the existing request if it exists

        if ($followRequest) {
            return response()->json(['message' => 'Follow request already sent.'], 200);
        }

        // Create a new follow request if not already sent
        FollowRequest::create($request->all());

        return response()->json(['message' => 'Follow request has been sent successfully.'], 200);
    }


    public function checkRequest(Request $request)
    {
        $followRequest = FollowRequest::where([
            'follower_id' => $request->follower_id,
            'user_id' => $request->user_id
        ])->first();

        $message = '';
        if (!empty($followRequest)) {
            $message = "Requested";
        } else {
            $message = "Follow";
        }
        return response()->json(['message' => $message, 'status' => 200], 200);
    }

    public function friendRequest(Request $request)
    {
        $followRequests = FollowRequest::with('user')->where('follower_id', '=', $request->follower_id)->get();
        $totalCount = count($followRequests);
        $html = '';

        foreach ($followRequests as $followRequest) {
            if (isset($followRequest->user)) {
                $html .= '<li class="p-2 border-bottom">
                        <a class="dropdown-item d-block" href="' . route('profile', ['user_id' => $followRequest->user->id]) . '">'
                    . $followRequest->user->full_name .
                    '</a>
                        <div class="mt-2" id="' . $followRequest->id . '">
                            <button class="btn btn-success btn-sm accept-request" data-request-id="' . $followRequest->id . '">Accept</button>
                            <button class="btn btn-danger btn-sm deny-request" data-request-id="' . $followRequest->id . '">Deny</button>
                        </div>
                      </li>';
            }
        }

        return response()->json(['status' => 200, 'html' => $html, 'totalCount' => $totalCount], 200);
    }

    public function friendRequestResponse(Request $request)
    {
        $follower = FollowRequest::where('id', '=', $request->requestId)->first();
        $html = '';
        if ($request->action == 'accept') {
            $follow = new Follow;
            $follow->fill([
                'user_id' => $follower->user_id,
                'following_id' => $follower->follower_id
            ]);
            $follow->save();

            $followBackRequest = Follow::with(['user', 'followBack'])->where('id', '=', $follow->id)->first();
            // dd($followBackRequest);
            $html .= '<div class="mt-2" id="' . $followBackRequest->id . '">
                        <button class="btn btn-success btn-sm follow-back" data-user-id="' . $followBackRequest->user->id . '" data-follow-back-id="' . $followBackRequest->followBack->id . '">Follow Back</button>
                        </div>';
        }
        FollowRequest::where('id', $request->requestId)->delete();
        return response()->json(['status' => 200, 'html' => $html], 200);
    }
}
