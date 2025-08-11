<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Place;
use App\Models\Relationship;
use App\Models\User;
use App\Models\WorkExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('is_admin', false)->get();

        // dd($users);
        if ($request->ajax()) {
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('image',function($row){
                    $image = "";
                    if (isset($row->currentProfileImage)){
                        $image = Storage::url($row->currentProfileImage->path);
                    }else{
                        $image = secure_asset('assets/img/dummy-user.jpg');
                    }
                    return "<img src='" . $image . "' width='100' height='100' class='rounded-circle'>";
                })
                ->addColumn('status', function ($row) {
                    $status = $row->is_approve ? 'Approved' : 'Not Approved';
                    $badgeClass = $row->is_approve ? 'bg-success' : 'bg-danger';
                    return '<span class="badge ' . $badgeClass . '">' . $status . '</span>';
                })
                ->addColumn('approve_switch', function ($row) {
                    $checked = $row->is_approve ? 'checked' : '';
                    return '<div class="form-check form-switch">
                            <input class="form-check-input approve-switch" type="checkbox" data-user-id="' . $row->id . '" ' . $checked . '>
                        </div>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('admin.users-view', ['id' => $row['id']]) . '" class="edit btn btn-primary btn-sm">View Profile</a>';
                    return $btn;
                })
                ->rawColumns(['status', 'approve_switch', 'action','image'])
                ->make(true);
        }
        return view('admin.user.index', ['users' => $users]);
    }

    public function viewUserProfile($id)
    {
        $user = User::where('id', '=', $id)->first();

        $works = WorkExperience::where('user_id', $id)
            ->where('is_current', true)
            ->get();

        // If no current work, get most recent
        if (!$works) {
            $works = WorkExperience::where('user_id', $id)
                ->latest('created_at')
                ->get();
        }

        $educations = Education::where('user_id', '=', $id)->latest('created_at')
            ->get();
        // dd($education);
        $currentCity = Place::where([
            ['user_id', '=', $id],
            ['type', '=', 'other'],
            ['is_present', '=', true],
        ])->first();

        if (!$currentCity) {
            $currentCity = Place::where([
                ['user_id', '=', $id],
                ['type', '=', 'current_city']
            ])->first();
        }

        $homeTown = Place::where([
            ['user_id', '=', $id],
            ['type', '=', 'hometown']
        ])->first();

        $relationShip = Relationship::where('user_id', '=', $id)->first();

        $currentProfileImage = $user->currentProfileImage()->first();
        $currentCoverImage = $user->currentCoverImage()->first();

        return view('admin.user.profile', [
            'user' => $user,
            'works' => $works,
            'educations' => $educations,
            'homeTown' => $homeTown,
            'currentCity' => $currentCity,
            'relationShip' => $relationShip,
            'currentProfileImage' => $currentProfileImage,
            'currentCoverImage' => $currentCoverImage
        ]);
    }

    public function userProfileApproveDeny($id)
    {
        $user = User::where('id', '=', $id)->first();
        $is_approve = !$user->is_approve ? true : false;

        User::where('id', '=', $id)->update(['is_approve' => $is_approve]);

        return redirect()->route('admin.users-view', ['id' => $id]);
    }

    public function approveUser(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->is_approve = $request->is_approve;
        $user->save();

        return response()->json(['success' => true]);
    }
}
