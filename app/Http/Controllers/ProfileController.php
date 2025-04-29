<?php

namespace App\Http\Controllers;

use App\Models\ContactBasicInfo;
use App\Models\ContactBasicSocialMedia;
use App\Models\FamilyRelationShip;
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
        $user = User::where('id', '=', $user_id)->with('workPlace', 'placeLived', 'contactBasicInfo.socialMedia', 'familyRelationShip.relatedUser')->first();
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

        $follows = Follow::where('status', 'Followed')
            ->where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->orWhere('following_id', $userId);
            })
            ->get();


            $friendFollowLists = $this->getFriendList($userId);
            
        $relatedFamilyUserIds = FamilyRelationShip::where('user_id', $userId)
            ->pluck('family_id');

        $relatedUserIds = $follows->pluck('user_id')
            ->merge($follows->pluck('following_id'))
            ->unique()
            ->filter(fn($id) => $id != $userId);

        $forRelationShips = User::whereIn('id', $relatedUserIds)
            ->whereNotIn('id', $relatedFamilyUserIds)
            ->get();
            // dd($friendFollowLists);
        return view('profile.index', [
            'posts' => $posts,
            'user' => $user,
            'forRelationShips' => $forRelationShips,
            'friendFollowLists' => $friendFollowLists
        ]);
    }

    private function getFriendList($userId){
        $friendFollowLists = Follow::where(function ($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->orWhere('following_id', $userId);
        })
        ->with([
            'follower:id,full_name,image',      // assuming 'user_id' is follower
            'following:id,full_name,image'      // assuming 'following_id' is followee
        ])
        ->get()
        ->map(function ($follow) use ($userId) {
            $friend = $follow->user_id == $userId ? $follow->following : $follow->follower;
            return [
                'id' => $follow->id,
                'user_id' => $friend->id,
                'name' => $friend->full_name,
                'image' => $friend->image,
                'status' => $follow->status,
            ];
        });
        return $friendFollowLists;
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

    public function addUpdatePlaceLived(Request $request)
    {
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

    public function deletePlaceLived($id)
    {
        PlaceLived::where('id', '=', $id)->delete();
        return redirect()->back()->with('message', 'Place Lived has been deleted.');
    }

    public function addUpdateContactBasicInfo(Request $request)
    {
        // dd($request->all());
        $socialMedias = $request->social_media_url;
        unset($request['social_media_url']);
        $contactId = null;
        if (isset($request->contact_basic_id)) {
            $contactId = $request->contact_basic_id;
            unset($request['_token']);
            unset($request['contact_basic_id']);
            ContactBasicInfo::where('id', '=', $contactId)->update($request->all());
            ContactBasicSocialMedia::where('contact_basic_id', '=', $contactId)->delete();
        } else {
            $request['user_id'] = Auth::id();
            $contactBasicInfo = new ContactBasicInfo();
            $contactBasicInfo->fill($request->all());
            $contactBasicInfo->save();
            $contactId = $contactBasicInfo->id;
        }

        foreach ($socialMedias as $socialMedia) {
            $socialMediaObj = new ContactBasicSocialMedia();
            $socialMediaObj->fill(
                [
                    'social_media_url' => $socialMedia,
                    'contact_basic_id' => $contactId
                ]
            );
            $socialMediaObj->save();
        }
        return redirect()->back()->with('message', 'Contact Basic Info has been updated.');
    }

    public function deleteSocialMediaURL($id)
    {
        ContactBasicSocialMedia::where('id', '=', $id)->delete();
        return redirect()->back()->with('message', 'Social Media has been deleted.');
    }

    public function addUpdateFamilyRelationShip(Request $request)
    {
        // dd($request->all());
        if (isset($request->id)) {
            unset($request['_token']);
            FamilyRelationShip::where('id', '=', $request->id)->update($request->all());
        } else {
            $user_id = Auth::id();
            $relations = $request->relationship;
            foreach ($relations as $key => $relation) {
                $family = new FamilyRelationShip();
                $family->fill([
                    'relationship' => $relation,
                    'family_id' => $request['family_id'][$key],
                    'user_id' => $user_id
                ]);
                $family->save();
            }
        }
        return redirect()->back()->with('message', 'Family Relationship has been updated.');
    }

    public function deleteFamilyMember($id)
    {
        FamilyRelationShip::where('id', '=', $id)->delete();
        return redirect()->back()->with('message', 'Social Media has been deleted.');
    }
}
