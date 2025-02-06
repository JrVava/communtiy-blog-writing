@php
    $user = Auth::user();
    $initials = strtoupper(substr($user->full_name, 0, 1)); // Get the first letter of full_name
@endphp

@extends('layouts.app-layout')
@section('title', 'Dashboard')
@section('content')
    <style>
        .profile-info {
            position: sticky;
            top: 20px;
        }

        a,
        button {
            text-decoration: none !important;
        }

        .profile-cover {
            height: 300px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid white;
            margin-right: 10px;
            /* Space between image and icon */
        }

        .without-profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid white;
            margin-right: 10px;
            /* Space between image and icon */
            font-size: 4rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #007bff;
            color: white;
        }

        /* Style for camera icon */
        .camera-icon {
            font-size: 3rem;
            /* Increased the size for visibility */
            font-weight: bold;
            /* Ensure bold styling */
            cursor: pointer;
            color: black;
            position: relative;
            right: 42px;
            top: 43px;
            z-index: 999999999;
        }

        /* Hide the file input */
        .file-input {
            display: none;
        }
    </style>

    <div class="card pb-4">
        <div class="card-body">
            <div class="profile-cover">
                @if ($user->image)
                    <img src="{{ asset('uploads/profile/' . $user->image) }}" class="profile-avatar" alt="User Profile" id="profileImage" onclick="document.getElementById('fileInput').click();">
                @else
                    <div class="without-profile-avatar" id="profileImage" onclick="document.getElementById('fileInput').click();">
                        {{ $initials }}
                    </div>
                @endif

                <!-- Camera icon for uploading new avatar -->
                <div class="camera-icon" onclick="document.getElementById('fileInput').click();">
                    <i class="bi bi-camera"></i>
                </div>

                <!-- Hidden file input to choose a new image -->
                <input type="file" id="fileInput" class="file-input" >
            </div>
        </div>
        <hr>
        <div class="row mt-2 me-2 mx-2 g-3">
            <div class="col-12 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h1>Intro</h1>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        @include('profile.my-posts')
                    </div>
                </div>
            </div>
        </div>
    </div>
   
@endsection
