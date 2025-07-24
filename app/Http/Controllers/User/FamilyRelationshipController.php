<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FamilyMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
class FamilyRelationshipController extends Controller
{
    public function updateRelationship(Request $request)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in(config('relationship.statuses'))
            ],
            'partner_id' => 'nullable|exists:users,id',
            'anniversary_date' => 'nullable|date'
        ]);
        // dd($request->all());

        $relationship = Auth::user()->relationship()->updateOrCreate(
            ['user_id' => Auth::id()],
            $validated
        );

        return redirect()->route('profile', ['user_id' => Auth::id(), 'parentTab' => 'about-tab', 'tab' => 'family-relationship'])->with('success', 'Relationship updated successfully');
    }

    public function addFamilyMember(Request $request)
    {

        $validated = $request->validate([
            'family_member_id' => 'required|exists:users,id',
            'relationship' => [
                'required',
                Rule::in(config('relationship.family_relationship'))
            ]
        ]);

        $validated['user_id'] = Auth::id();
        FamilyMember::create($validated);

        return redirect()->route('profile', ['user_id' => Auth::id(), 'parentTab' => 'about-tab', 'tab' => 'family-relationship'])->with('success', 'Family member added successfully');
    }

    public function removeFamilyMember(FamilyMember $familyMember)
    {
        if ($familyMember->user_id !== Auth::id()) {
            abort(403);
        }

        $familyMember->delete();
        return redirect()->route('profile', ['user_id' => Auth::id(), 'parentTab' => 'about-tab', 'tab' => 'family-relationship'])->with('success', 'Family member removed successfully');
    }

    public function searchFollwingUser(Request $request)
    {
        $query = $request->input('q');
        $user = Auth::user();

        // Get the base friend list
        $friendList = $user->followingUsers();

        // Apply search if query exists
        if ($query && strlen($query) >= 2) {
            $friendList->where(function ($q) use ($query) {
                $q->where('users.full_name', 'like', "%{$query}%")
                    ->orWhere('users.email', 'like', "%{$query}%")
                    ->orWhere('users.phone', 'like', "%{$query}%");
            });
        }

        // Execute query with fully qualified column names
        $results = $friendList->limit(10)->get([
            'users.id',
            'users.full_name',
            'users.email',
            'users.phone',
            'users.image'
        ]);

        return response()->json($results);
    }
}
