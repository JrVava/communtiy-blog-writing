<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function index(Request $request)
    {
        $follow = Follow::where('following_id', '=', $request->followingId)->first();
        return response()->json([
            'data' => isset($follow) ? $follow->status : "Follow"
        ], 200);
    }

    public function sendFollowRequest(Request $request)
    {
        $followExist = Follow::where('following_id', '=', $request->followingId)->exists();
        if (!$followExist) {
            $data = [
                'user_id' => $request->userId,
                'following_id' => $request->followingId,
            ];
            $follow = new Follow;
            $follow->fill($data);
            $follow->save();
            return response()->json(['message' => 'Follow request has been sent successfully.', 'data' => 'Pending'], 200);
        } else {
            return response()->json(['message' => 'Follow request already sent.', 'data' => 'Pending'], 200);
        }
    }

    public function totalFollowRequest()
    {
        $followCount = Follow::where('following_id', '=', Auth::user()->id)
            ->whereIn('status', ['Pending', 'Accepted'])
            ->count();

        return response()->json(['data' => $followCount], 200);
    }

    public function getRequestList()
    {
        $followRequests = Follow::with('user')->where('following_id', '=', Auth::user()->id)
            ->whereIn('status', ['Pending', 'Accepted'])
            ->get();

        $html = '';
        foreach ($followRequests as $followRequest) {
            if (isset($followRequest->user)) {
                $action = $followRequest->status == "Accepted" ? "Follow back" : 'Accept';
                $class = $followRequest->status == "Accepted" ? "follow-back" : 'accept-request';
                // dd($action);
                // If request is already accepted, hide the Deny button
                $denyButton = $followRequest->status == "Accepted" ? '' :
                    '<button class="btn btn-danger btn-sm deny-request" data-request-id="' . $followRequest->id . '">Deny</button>';

                $html .= '<li class="p-2 border-bottom">
                        <a class="dropdown-item d-block" href="' . route('profile', ['user_id' => $followRequest->user->id]) . '">'
                    . $followRequest->user->full_name .
                    '</a>
                        <div class="mt-2" id="' . $followRequest->id . '">
                            <button class="btn btn-success btn-sm ' . $class . '" data-request-id="' . $followRequest->id . '">' . $action . '</button>
                            ' . $denyButton . '
                        </div>
                    </li>';

            }
        }

        return response()->json(['data' => $html], 200);
    }

    public function responseToRequest(Request $request)
    {
        $action = $request->action == "accept" ? "Accepted" : "deny";
        if ($request->action == 'Followed') {
            $action = $request->action;
        }

        if ($action == 'deny') {
            Follow::where('id', '=', $request->followId)->delete();
        }
        Follow::where('id', '=', $request->followId)->update(['status' => $action]);


        return response()->json(['data' => $action], 200);
    }
}
