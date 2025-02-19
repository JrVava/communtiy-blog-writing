@php
    $initials = strtoupper(substr($user->full_name, 0, 1));
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
                    <img src="{{ asset("storage/".$user->image) }}" class="profile-avatar" alt="{{ $user->full_name }}"
                        id="profileImage" @if(Auth::id() == $user->id) onclick="document.getElementById('fileInput').click();" @endif>
                @else
                    <div class="without-profile-avatar" id="profileImage"
                        onclick="document.getElementById('fileInput').click();">
                        {{ $initials }}
                    </div>
                @endif
                
                @if(Auth::id() == $user->id)
                <div class="camera-icon" onclick="document.getElementById('fileInput').click();">
                    <i class="bi bi-camera"></i>
                </div>
                <input type="file" id="fileInput" class="file-input">
                @endif

                {{-- <button class="btn btn-primary btn-follow" id="followBtn">Follow</button> --}}

                <button type="button" data-user-id="{{ Auth::id() }}" data-following-id="{{ $user->id }}"
                    class="btn btn-primary btn-follow" id="followBtn">
                    Follow
                </button>
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
                        @if (count($posts) > 0)
                            @include('profile.my-posts')
                        @else
                            <h1 class="text-center">No Post</h1>
                        @endif
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

            let followingId = $('#followBtn').data('following-id');
            let userId = $('#followBtn').data('user-id');
            $.ajax({
                url: "{{ route('get-follow') }}",
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "followingId": followingId,
                    "userId": userId
                },
                success: function(res) {
                    $('#followBtn').text(res.data);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            })

            $("#fileInput").change(function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $("#profileImage").attr("src", e.target.result).show();
                    };
                    reader.readAsDataURL(file);

                    // Create FormData object for AJAX
                    var formData = new FormData();
                    formData.append("image", file);
                    formData.append("_token", "{{ csrf_token() }}"); // CSRF Token

                    // AJAX call to upload the image
                    $.ajax({
                        url: "{{ route('upload-avatar') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status === 200) {
                                alert("Profile image updated successfully!");
                            } else {
                                alert("Error uploading image.");
                            }
                        },
                        error: function() {
                            alert("Something went wrong!");
                        }
                    });
                }
            });
        });
    </script>
@endsection
