<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchUser(Request $request)
    {
        $users = User::where('full_name', 'LIKE', '%' . $request->search . '%')
            ->where('is_approve', 1) // Only fetch approved users
            ->get();

        $html = "";

        if ($users->count() > 0) {
            foreach ($users as $user) {
                $html .= '<li class="list-group-item">';
                $html .= '<a href="'.route('profile',['user_id' => $user->id]).'" class="user-item text-decoration-none d-block" data-name="' . $user->full_name . '">';
                $html .= $user->full_name;
                $html .= '</a></li>';
                
            }
        } else {
            $html .= '<li class="list-group-item text-muted">No users found</li>';
        }

        return response()->json(['html' => $html]);
    }
}
