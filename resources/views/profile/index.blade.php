@php
    $initials = strtoupper(substr($user->full_name, 0, 1));
@endphp
@extends('layouts.app-layout')
@section('title', 'Dashboard')
@section('content')

    <style>
        /* Cover Photo */
        .cover-photo {
            background: url('https://cdn-ilapbah.nitrocdn.com/IMXLyaGRiKeYrzbMzkhtxIIrOEPefEBF/assets/images/optimized/rev-c1630ed/iitianguide.com/wp-content/uploads/2023/12/Dummy-School-for-IIT-JEE.png') no-repeat center center;
        }

    </style>
    </head>

    <body>

        <div class="container-fluid p-0">
            <!-- Cover Photo -->
            <div class="cover-photo" id="coverPhoto">
                <button class="edit-cover-btn" id="editCoverBtn">Edit Cover Photo</button>

                <!-- Profile Photo -->
                <div class="profile-photo-wrapper">
                   
                    <img id="profileImage" src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="Profile"
                        class="profile-photo @if (!$user->image) d-none @endif" onclick="document.getElementById('avatarInput').click()">

                    <div class="without-profile-avatar @if ($user->image) d-none @endif" id="profileImage"
                        onclick="document.getElementById('avatarInput').click()">
                        {{ $initials }}
                    </div>
                    {{-- <img id="profileImage" src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="Profile"
                        class="profile-photo" onclick="document.getElementById('avatarInput').click()"> --}}
                    <button class="edit-avatar-btn" onclick="document.getElementById('avatarInput').click()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-camera" viewBox="0 0 16 16">
                            <path
                                d="M10.5 4a.5.5 0 0 0-.5.5V5H6v-.5a.5.5 0 0 0-.5-.5h-3A.5.5 0 0 0 2 4v8a.5.5 0 0 0 .5.5h11a.5.5 0 0 0 .5-.5v-8a.5.5 0 0 0-.5-.5h-3zM3 5h2v.5a.5.5 0 0 0 .5.5H10a.5.5 0 0 0 .5-.5V5h2v7H3V5zm6.5 3a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                        </svg>
                    </button>
                    <input type="file" id="avatarInput" accept="image/*" onchange="changeAvatar(event)">
                </div>
            </div>

            <!-- Hidden Cover Input -->
            <input type="file" id="coverInput" accept="image/*" onchange="changeCover(event)">

            <!-- Profile Info -->
            <div class="container profile-info">
                <h2>{{ $user->full_name }}</h2>
                <p>Web Developer | Photographer</p>

                <!-- Navigation Tabs -->
                <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="posts-tab" data-bs-toggle="tab" data-bs-target="#posts"
                            type="button" role="tab">Posts</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="about-tab" data-bs-toggle="tab" data-bs-target="#about" type="button"
                            role="tab">About</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="friends-tab" data-bs-toggle="tab" data-bs-target="#friends"
                            type="button" role="tab">Friends</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="photos-tab" data-bs-toggle="tab" data-bs-target="#photos"
                            type="button" role="tab">Photos</button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="profileTabsContent">
                    <div class="tab-pane fade show active" id="posts" role="tabpanel">
                        @if (count($posts) > 0)
                            @include('profile.my-posts')
                        @else
                            <h1 class="text-center">No Post</h1>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="about" role="tabpanel">
                        <h4>About</h4>
                        <p>This is where about info will appear...</p>
                    </div>
                    <div class="tab-pane fade" id="friends" role="tabpanel">
                        <h4>Friends</h4>
                        <p>This is where friends list will appear...</p>
                    </div>
                    <div class="tab-pane fade" id="photos" role="tabpanel">
                        <h4>Photos</h4>
                        <p>This is where photos will appear...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS Bundle -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            // Change Avatar
            function changeAvatar(event) {
                const input = event.target;
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const profileImage = document.getElementById('profileImage');
                        profileImage.src = e.target.result;
                    };
                    reader.readAsDataURL(input.files[0]);
                    $('.without-profile-avatar').addClass('d-none');
                    $('#profileImage').removeClass('d-none');
                }
            }

            // Change Cover Photo
            document.getElementById('editCoverBtn').addEventListener('click', function() {
                document.getElementById('coverInput').click();
            });

            function changeCover(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('coverPhoto').style.backgroundImage = `url('${e.target.result}')`;
                    };
                    reader.readAsDataURL(file);
                }
            }
        </script>

    @endsection
