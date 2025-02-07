@php
    $initials = strtoupper(substr($user->full_name, 0, 1)); // Get the first letter of full_name
    $followRequest = !empty($followRequest) ? 'Requested' : 'Follow';

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
            position: relative;
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            border-radius: 10px;
        }

        .profile-avatar,
        .without-profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 4px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            font-weight: bold;
            background-color: #007bff;
            color: white;
            transition: transform 0.3s ease-in-out;
        }

        .profile-avatar:hover,
        .without-profile-avatar:hover {
            transform: scale(1.05);
            cursor: pointer;
        }

        .camera-icon {
            position: absolute;
            left: 130px;
            bottom: 15px;
            font-size: 2rem;
            background: rgb(16 16 16 / 80%);
            border-radius: 50%;
            cursor: pointer;
            padding-top: 10px;
            padding-bottom: 10px;
            padding-left: 14px;
            padding-right: 14px;
        }

        .camera-icon>i {
            color: white;
        }

        .file-input {
            display: none;
        }

        .btn-follow {
            padding: 10px 20px;
            font-weight: bold;
            border-radius: 20px;
            transition: all 0.3s;
        }

        .btn-follow:hover {
            background: white;
            color: black;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>

    <div class="card pb-4">
        <div class="card-body">
            <div class="profile-cover">
                @if ($user->image)
                    <img src="{{ asset('uploads/profile/' . $user->image) }}" class="profile-avatar" alt="User Profile"
                        id="profileImage" onclick="document.getElementById('fileInput').click();">
                @else
                    <div class="without-profile-avatar" id="profileImage"
                        onclick="document.getElementById('fileInput').click();">
                        {{ $initials }}
                    </div>
                @endif

                <div class="camera-icon" onclick="document.getElementById('fileInput').click();">
                    <i class="bi bi-camera"></i>
                </div>

                {{-- <button class="btn btn-primary btn-follow" id="followBtn">Follow</button> --}}
                <input type="file" id="fileInput" class="file-input">

                <button type="button" data-user-id="{{ Auth::id() }}" data-following-id="{{ $user->id }}"
                    class="btn btn-primary btn-follow" id="followBtn">
                    Follow
                </button>
                {{-- <a href="{{ route('follow-request', [
                    'user_id' => Auth::user()->id,
                    'following_id' => $user->id,
                ]) }}"
                    class="btn btn-primary btn-follow" id="followBtn">
                    {{ $followRequest }}
                </a> --}}
            </div>
        </div>
        <hr>
        <div class="row mt-2 me-2 mx-2 g-3">
            <div class="col-12 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="fw-bold">Intro</h4>
                        <hr>
                        <h5 class="fw-bold">Places Lived</h5>
                        <p>Current Country <strong>{{ $user->location ?? 'Unknown' }}</strong></p>
                        <p>Current City <strong>{{ $user->location ?? 'Unknown' }}</strong></p>
                        <p>Original Country <strong>{{ $user->workplace ?? 'Not specified' }}</strong></p>
                        <p>Home Town <strong>{{ $user->workplace ?? 'Not specified' }}</strong></p>
                        <hr>
                        <h5 class="fw-bold">Education</h5>
                        <p>Current University <strong>{{ $user->location ?? 'Unknown' }}</strong></p>
                        <p>Batch Year <strong>{{ $user->location ?? 'Unknown' }}</strong></p>
                        <p>Pursuing Degree <strong>{{ $user->workplace ?? 'Not specified' }}</strong></p>
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
@section('scripts')
    <script>
        $(document).ready(function() {
            // Read More / Read Less Toggle
            $(".read-more-btn").click(function() {
                let isExpanded = $(this).attr("data-expanded") === "true";
                let card = $(this).closest(".post");

                if (!isExpanded) {
                    card.find(".short-content").hide();
                    card.find(".full-content").removeClass("d-none");
                    $(this).text("Read Less");
                } else {
                    card.find(".short-content").show();
                    card.find(".full-content").addClass("d-none");
                    $(this).text("Read More");
                }

                $(this).attr("data-expanded", !isExpanded);
            });

            $('#followBtn').on('click', function() {
                let userId = $(this).data('user-id');
                let followingId = $(this).data('following-id');
                followFun(followingId, userId)
                // $.ajax({
                //     url: "{{ route('follow-request') }}",
                //     type: "POST",
                //     data: {
                //         user_id: userId,
                //         follower_id: followingId,
                //         _token: "{{ csrf_token() }}"
                //     },
                //     success: function(response) {
                //         $('#followBtn').text('Requested');
                //     },
                //     error: function(xhr) {
                //         alert("Error: " + xhr.responseText);
                //     }
                // });
            })
            checkRequest()
        });

        function checkRequest() {
            let userId = $('#followBtn').data('user-id');
            let followingId = $('#followBtn').data('following-id');

            $.ajax({
                url: "{{ route('check-request') }}",
                type: "POST",
                data: {
                    user_id: userId,
                    follower_id: followingId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if(response.status === 200){
                        $('#followBtn').text(response.message)
                    }
                },
                error: function(xhr) {
                    alert("Error: " + xhr.responseText);
                }
            });
        }
    </script>
@endsection
