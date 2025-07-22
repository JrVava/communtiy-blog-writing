<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        $users = User::where('full_name', 'LIKE', "%{$query}%")
            ->where('id', '!=', auth()->id()) // Exclude current user
            ->limit(10)
            ->get(['id', 'full_name', 'email', 'image']); // Include image if available

        return response()->json($users);
    }
}
