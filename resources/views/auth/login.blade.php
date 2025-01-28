@extends('layouts.admin-app')
@section('content')
<section class="section main-section flex justify-center items-center min-h-screen bg-gray-100">
    <div class="card w-full max-w-md shadow-lg rounded-lg bg-white">
        <header class="card-header bg-blue-500 text-white rounded-t-lg">
            <p class="card-header-title text-lg font-semibold p-4">
                <span class="icon mr-2"><i class="mdi mdi-lock"></i></span>
                Login
            </p>
        </header>
        <div class="card-content p-6">
            <form method="get">
                <!-- Username Field -->
                <div class="field spaced mb-4">
                    <label class="label text-gray-700 font-medium">Username</label>
                    <div class="control icons-left relative">
                        <input class="input w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500" 
                               type="text" name="login" placeholder="Enter your username" autocomplete="username">
                        <span class="icon is-small left absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <i class="mdi mdi-account"></i>
                        </span>
                    </div>
                    <p class="help text-sm text-gray-500 mt-1">
                        Please enter your username.
                    </p>
                </div>

                <!-- Password Field -->
                <div class="field spaced mb-4">
                    <label class="label text-gray-700 font-medium">Password</label>
                    <div class="control icons-left relative">
                        <input class="input w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500" 
                               type="password" name="password" placeholder="Enter your password" autocomplete="current-password">
                        <span class="icon is-small left absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <i class="mdi mdi-asterisk"></i>
                        </span>
                    </div>
                    <p class="help text-sm text-gray-500 mt-1">
                        Please enter your password.
                    </p>
                </div>

                <!-- Registration Link -->
                <div class="mb-6 mt-6 text-sm text-center">
                    <a href="#" class="text-blue-500 hover:underline">Registration</a>
                </div>

                <!-- Action Buttons -->
                <div class="field grouped flex justify-between items-center">
                    <button type="submit" class="button blue">
                        Login
                    </button>
                    <a href="index.html" class="button">
                        Back
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
