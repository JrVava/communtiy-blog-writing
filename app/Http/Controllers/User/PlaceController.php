<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class PlaceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $currentCity = $user->places()->where('type', 'current_city')->first();
        $hometown = $user->places()->where('type', 'hometown')->first();
        $otherPlaces = $user->places()->where('type', 'other')->get();

        return view('profile.places', compact('currentCity', 'hometown', 'otherPlaces'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => ['required', Rule::in(['current_city', 'hometown', 'other'])],
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'from_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'to_year' => 'nullable|required_if:is_present,false|integer|min:1900|max:' . date('Y'),
            'is_present' => 'nullable|boolean',
        ]);

        // Check if this type already exists (only one current city and hometown per user)
        if (in_array($request->type, ['current_city', 'hometown'])) {
            $existing = Place::where('user_id', Auth::id())
                ->where('type', $request->type)
                ->first();

            if ($existing) {
                return back()->with('error', 'You already have a ' . str_replace('_', ' ', $request->type) . ' set.');
            }
        }
        $place = Auth::user()->places()->create([
            'type' => $request->type,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'from_year' => $request->from_year,
            'to_year' => $request->is_present ? null : $request->to_year,
            'is_present' => $request->is_present ?? false,
        ]);

        return redirect()->route('profile', ['user_id' => Auth::id(), 'parentTab' => 'about-tab', 'tab' => 'place-lived'])->with('success', 'Place added successfully!');
    }

    public function destroy($id)
    {
        $place = Place::where('id', '=', $id)->first();
        // Authorization check - user can only delete their own places
        if ($place->user_id !== Auth::id()) {
            abort(403);
        }

        $place->delete();
        return redirect()->route('profile', ['user_id' => Auth::id(), 'parentTab' => 'about-tab', 'tab' => 'place-lived'])->with('success', 'Place removed successfully!');
    }

}
