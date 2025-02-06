<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        $this->loginRedirection();
        return $this->loginRedirection() ?: view('auth.login');
    }
    public function loginRedirection()
    {
        if (auth()->check()) {
            $is_admin = auth()->user();
            $adminRoute = redirect()->route('dashboard');
            $userRoute = redirect()->route('posts');
            return $is_admin->is_admin ? $adminRoute : $userRoute;
        }
    }
    public function registration()
    {
        return view('auth.registration');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user(); // Fetch authenticated user AFTER login

            if ((int) $user->is_admin === 0 && (int) $user->is_approve === 1) {
                return redirect()->route('posts');
            } elseif ((int) $user->is_admin === 1 && (int) $user->is_approve === 1) {
                return redirect()->intended('dashboard')->with('success','You have Successfully logged in');
            }

            // If user is not approved, force logout
            Auth::logout();
            return redirect()->route('login')->with('error' ,'Sorry, Your account is not approved.');
        }

        return redirect()->route('login')->with('error' ,'Oops! You have entered invalid credentials.');
    }


    public function postRegistration(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'full_name' => 'required|unique:users',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'password' => 'required|min:6|confirmed',

        ]);

        // dd($request->all());

        $request['password'] = Hash::make($request->password);
        $user = new User;
        $user->fill($request->all());
        $user->save();

        return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
    }

    public function dashboard()
    {
        // dd("he;;");
        if (Auth::check()) {
            return view('admin.dashboard');
        }

        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('login');
    }
}
