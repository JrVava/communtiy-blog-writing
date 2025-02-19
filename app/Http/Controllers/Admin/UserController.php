<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('countryRecord')->where('is_admin', false)->get();

        // dd($users);
        if ($request->ajax()) {
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('users-view', ['id' => $row['id']]) . '" class="edit btn btn-primary btn-sm">View Profile</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.user.index', ['users' => $users]);
    }

    public function viewUserProfile($id)
    {
        $user = User::with('countryRecord')->where('id', '=', $id)->first();
        return view('admin.user.profile', ['user' => $user]);
    }

    public function userProfileApproveDeny($id)
    {
        $user = User::where('id', '=', $id)->first();
        $is_approve = !$user->is_approve ? true : false;

        User::where('id', '=', $id)->update(['is_approve' => $is_approve]);

        return redirect()->route('users-view', ['id' => $id]);
    }
}
