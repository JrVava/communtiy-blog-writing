<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Follow;
use App\Models\Place;
use App\Models\Post;
use App\Models\PostReaction;
use App\Models\Relationship;
use App\Models\User;
use App\Models\UserBasicInfo;
use App\Models\UserContact;
use App\Models\WorkExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index($user_id, $parentTab = null, $tab = null)
    {
        $user = User::find($user_id);

        $followingIds = $user->following()
            ->where('status', Follow::STATUS_ACCEPTED)
            ->pluck('users.id');
        $userProfileId = null;
        if (isset($followingIds[0]) && $followingIds[0] != $user_id) {
            $userProfileId = $user_id;
        } elseif ($user_id == Auth::id()) {
            $userProfileId = Auth::id();
            ;
        }
        // Get posts from followed users AND the authenticated user
        $posts = Post::where('user_id', '=', $userProfileId)
            ->with('user', 'reactions') // Eager load the user relationship
            ->withCount(['comments'])
            ->latest()
            ->get();

        $currentCity = $user->places()->where('type', 'current_city')->first();
        $hometown = $user->places()->where('type', 'hometown')->first();
        $otherPlaces = $user->places()->where('type', 'other')->get();

        $contacts = $user->contacts()->get();
        $basicInfo = $user->basicInfo()->firstOrNew();

        $works = Auth::user()->workExperiences()->orderBy('start_date', 'desc')->get();
        $educations = Auth::user()->educations()->orderBy('start_date', 'desc')->get();

        $relationship = Auth::user()->relationship;

        // dd($relationship);
        $familyMembers = Auth::user()->familyMembers()->with('familyMember')->get();
        $friendList = Auth::user()->followingUsers;
        // dd($familyMembers);
        $overViewData = $this->getOverviewData($user_id);
        
        return view('frontend.profile.index', [
            'user' => $user,
            'followingIds' => $followingIds,
            'posts' => $posts,
            'reactions' => PostReaction::$reactionTypes,
            'currentCity' => $currentCity,
            'hometown' => $hometown,
            'otherPlaces' => $otherPlaces,
            'contacts' => $contacts,
            'basicInfo' => $basicInfo,
            'works' => $works,
            'educations' => $educations,
            'friendList' => $friendList,
            'relationship' => $relationship,
            'familyMembers' => $familyMembers,

            'work' => isset($overViewData['work']) ? $overViewData['work'] : null,
            'education' => isset($overViewData['education']) ? $overViewData['education'] : null,
            'homeTown' => isset($overViewData['homeTown']) ? $overViewData['homeTown'] : null,
            'currentCityOverView' => isset($overViewData['currentCity']) ? $overViewData['currentCity'] : null,
            'relationShip' => isset($overViewData['relationShip']) ? $overViewData['relationShip'] : null,

            'tab' => $tab,
            'parentTab' => $parentTab,
        ]);
    }

    public function addContact(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'type' => ['required', Rule::in(['email', 'phone', 'website', 'social'])],
            'value' => 'required|string|max:255',
            'is_primary' => 'sometimes|boolean',
        ]);

        // dd("hello");

        // Additional validation based on type
        if ($request->type === 'email') {
            $request->validate(['value' => 'email']);
        } elseif ($request->type === 'phone') {
            $request->validate(['value' => 'regex:/^\+?[0-9\s\-\(\)]+$/']);
        } elseif ($request->type === 'website') {
            $request->validate(['value' => 'url']);
        }

        $contact = new UserContact([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'value' => $request->value,
            'is_primary' => $request->boolean('is_primary'),
        ]);

        // If this is set as primary, unset any existing primary of the same type
        if ($contact->is_primary) {
            UserContact::where('user_id', Auth::id())
                ->where('type', $request->type)
                ->update(['is_primary' => false]);
        }

        $contact->save();

        return redirect()->route('profile', ['user_id' => Auth::id(), 'parentTab' => 'about-tab', 'tab' => 'contact-info'])->with('success', 'Contact added successfully!');
    }

    public function deleteContact($id)
    {
        $contact = UserContact::where('user_id', Auth::id())->findOrFail($id);
        $contact->delete();

        return redirect()->route('profile', ['user_id' => Auth::id(), 'parentTab' => 'about-tab', 'tab' => 'contact-info'])->with('success', 'Contact deleted successfully!');
    }

    public function createBasicInfo(Request $request)
    {
        $request->validate([
            'birthday' => 'nullable|date',
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'languages' => 'nullable|array',
            'languages.*' => 'string|max:50',
        ]);

        $basicInfo = Auth::user()->basicInfo()->updateOrCreate(
            ['user_id' => Auth::id()], // Match condition
            [                          // Data to update/create
                'birthday' => $request->birthday,
                'gender' => $request->gender,
                'languages' => $request->languages,
            ]
        );

        $basicInfo->save();
        return redirect()->route('profile', ['user_id' => Auth::id(), 'parentTab' => 'about-tab', 'tab' => 'contact-info'])->with('success', 'Basic info created successfully!');
    }

    private function getOverviewData($user_id)
    {
        $user = User::find($user_id);
        $work = WorkExperience::where('user_id', $user_id)
            ->where('is_current', true)
            ->first();

        // If no current work, get most recent
        if (!$work) {
            $work = WorkExperience::where('user_id', $user_id)
                ->latest('created_at')
                ->first();
        }

        $education = Education::where('user_id', '=', $user_id)->latest('created_at')
            ->first();
        // dd($education);
        $currentCity = Place::where([
            ['user_id', '=', $user_id],
            ['type', '=', 'other'],
            ['is_present', '=', true],
        ])->first();

        if (!$currentCity) {
            $currentCity = Place::where([
                ['user_id', '=', $user_id],
                ['type', '=', 'current_city']
            ])->first();
        }

        $homeTown = Place::where([
            ['user_id', '=', $user_id],
            ['type', '=', 'hometown']
        ])->first();

        $relationShip = Relationship::where('user_id', '=', $user_id)->first();

        return [
            'work' => $work,
            'education' => $education,
            'homeTown' => $homeTown,
            'currentCity' => $currentCity,
            'relationShip' => $relationShip
        ];
    }
}
