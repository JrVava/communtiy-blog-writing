<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\WorkExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class WorkEducationController extends Controller
{

    public function showWork($id)
    {
        $work = WorkExperience::where('user_id', Auth::id())->findOrFail($id);
        return response()->json([
            'id' => $work->id,
            'position' => $work->position,
            'company' => $work->company,
            'location' => $work->location,
            'start_date' => $work->start_date->format('Y-m-d'),
            'end_date' => $work->end_date ? $work->end_date->format('Y-m-d') : null,
            'is_current' => $work->is_current,
            'description' => $work->description
        ]);
    }

    public function storeWork(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'position' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'boolean',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'work')
                ->withInput();
        }

        // If marking as current job, unset others first
        if (isset($request->is_current) && $request->is_current) {
            $request['end_date'] = null;
            WorkExperience::where('user_id', Auth::id())
                ->update(['is_current' => false]);
        }

        $work = new WorkExperience($validator->validated());
        $work->user_id = Auth::id();
        $work->save();
        return redirect()->route('profile', ['user_id' => Auth::id(), 'parentTab' => 'about-tab', 'tab' => 'work-education'])->with('success', 'Work experience added successfully.');
    }

    public function updateWork(Request $request, $id)
    {
        $work = WorkExperience::where('user_id', Auth::id())->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'position' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'boolean',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'work')
                ->withInput();
        }
        if (!isset($request->is_current)) {
            $request['is_current'] = 0;
        }else{
            $request['end_date'] = null;
            WorkExperience::where('user_id', Auth::id())
            ->where('id', '!=', $id)
            ->update(['is_current' => false]);
        }
        $work->update($request->all());

        return redirect()->route('profile', ['user_id' => Auth::id(), 'parentTab' => 'about-tab', 'tab' => 'work-education'])->with('success', 'Work experience updated successfully.');
    }

    public function storeEducation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'school' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'education')
                ->withInput();
        }

        $education = new Education($request->validated());
        $education->user_id = Auth::id();
        $education->save();

        return redirect()->route('profile', ['user_id' => Auth::id(), 'parentTab' => 'about-tab', 'tab' => 'work-education'])->with('success', 'Education added successfully.');
    }

    public function showEducation($id)
    {
        $education = Education::where('user_id', Auth::id())->findOrFail($id);
        return response()->json([
            'id' => $education->id,
            'school' => $education->school,
            'degree' => $education->degree,
            'field_of_study' => $education->field_of_study,
            'start_date' => $education->start_date->format('Y-m-d'),
            'end_date' => $education->end_date ? $education->end_date->format('Y-m-d') : null,
            'description' => $education->description
        ]);
    }

    public function updateEducation(Request $request, $id)
    {
        $education = Education::where('user_id', Auth::id())->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'school' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'education')
                ->withInput();
        }

        $education->update($validator->validated());

        return redirect()->route('profile', ['user_id' => Auth::id(), 'parentTab' => 'about-tab', 'tab' => 'work-education'])->with('success', 'Education updated successfully.');
    }
}
