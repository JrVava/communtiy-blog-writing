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
            $is_admin = auth()->user()->is_admin;
            $adminRoute = redirect()->route('dashboard');
            $userRoute = redirect()->route('posts');
            
            return $is_admin ? $adminRoute : $userRoute;
        }
    }
    public function registration()
    {
        return view('auth.registration');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'user_name' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('user_name', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if(!$user->is_approve){
                return redirect()->route('posts');
            }else{
                return redirect()->intended('dashboard')
                    ->withSuccess('You have Successfully loggedin');
            }
        }

        return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
    }

    public function postRegistration(Request $request)
    {
        $request->validate([
            'user_name' => 'required|unique:users',
            'email' => 'nullable|email',
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
