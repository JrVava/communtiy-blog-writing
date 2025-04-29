@php
    $initials = strtoupper(substr($user->full_name, 0, 1));

    $friends = (object) [
        [
            'name' => 'John Cena',
            'profile_picture' => 'https://upload.wikimedia.org/wikipedia/commons/6/60/John_Cena_July_2018.jpg',
            'location' => 'West Newbury, MA',
        ],
        [
            'name' => 'Dwayne Johnson',
            'profile_picture' => 'https://upload.wikimedia.org/wikipedia/commons/e/e0/Dwayne_The_Rock_Johnson_2013.jpg',
            'location' => 'Hayward, CA',
        ],
        [
            'name' => 'Emma Watson',
            'profile_picture' => 'https://upload.wikimedia.org/wikipedia/commons/5/5a/Emma_Watson_2013.jpg',
            'location' => 'Paris, France',
        ],
    ];

@endphp
@extends('layouts.app-layout')
@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid p-0">
        <!-- Cover Section -->
        <div class="cover-photo" id="coverPhoto">
            <button class="edit-cover-btn" id="editCoverBtn" onclick="document.getElementById('coverInput').click()">Edit Cover
                Photo</button>

            <!-- Profile Image -->
            <div class="profile-photo-wrapper">
                @if ($user->image)
                    <img id="profileImage" src="{{ asset('storage/' . $user->image) }}" alt="Profile Photo"
                        class="profile-photo"
                        @if (Auth::id() == $user->id) onclick="document.getElementById('fileInput').click();" @endif>
                @else
                    <div class="without-profile-avatar" id="profileImage"
                        @if (Auth::id() == $user->id) onclick="document.getElementById('fileInput').click();" @endif>
                        {{ $initials }}
                    </div>
                @endif
                @if (Auth::id() == $user->id)
                    <button class="edit-avatar-btn" onclick="document.getElementById('fileInput').click()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-camera" viewBox="0 0 16 16">
                            <path
                                d="M10.5 4a.5.5 0 0 0-.5.5V5H6v-.5a.5.5 0 0 0-.5-.5h-3A.5.5 0 0 0 2 4v8a.5.5 0 0 0 .5.5h11a.5.5 0 0 0 .5-.5v-8a.5.5 0 0 0-.5-.5h-3zM3 5h2v.5a.5.5 0 0 0 .5.5H10a.5.5 0 0 0 .5-.5V5h2v7H3V5zm6.5 3a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                        </svg>
                    </button>
                @endif
                <input type="file" id="fileInput" accept="image/*" hidden onchange="changeAvatar(event)">
            </div>
        </div>
        <!-- Hidden Cover Input -->
        <input type="file" id="coverInput" accept="image/*" onchange="changeCover(event)" hidden>
    </div>
    <div class="container profile-info">
        <h2>{{ $user->full_name }}</h2>
        <p>Current Country | Photographer</p>
        @if ($user->id != Auth::user()->id)
            <div class="action-buttons">
                <button type="button" data-user-id="{{ Auth::id() }}" data-following-id="{{ $user->id }}"
                    class="btn btn-primary btn-follow" id="followBtn">
                    Follow
                </button>
            </div>
        @endif
        <ul class="nav nav-tabs" id="profileTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="posts-tab" data-bs-toggle="tab" data-bs-target="#posts" type="button"
                    role="tab">Posts</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="about-tab" data-bs-toggle="tab" data-bs-target="#about" type="button"
                    role="tab">About</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="friends-tab" data-bs-toggle="tab" data-bs-target="#friends" type="button"
                    role="tab">Friends</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="photos-tab" data-bs-toggle="tab" data-bs-target="#photos" type="button"
                    role="tab">Photos</button>
            </li>
        </ul>

        <div class="tab-content" id="profileTabsContent">
            {{-- My Post Code Start Here --}}
            <div class="tab-pane fade show active" id="posts" role="tabpanel">
                @include('blog.form')
                <div class="row mt-2 me-2 mx-2 g-3 justify-content-center">
                    <div class="col-12 col-md-8 col-lg-8">
                        @if (count($posts) > 0)
                            @include('profile.my-posts')
                        @else
                            <h1 class="text-center my-5">No Post</h1>
                        @endif
                    </div>
                </div>
            </div>
            {{-- My Post Code End Here --}}
            {{-- About Code Start Here --}}
            <div class="tab-pane fade" id="about" role="tabpanel">
                <div class="row mb-4">
                    <!-- Sidebar Menu -->
                    <div class="col-12 col-md-4 mb-3 mb-md-0">
                        <div class="card h-100">
                            <div class="card-body">
                                <h1 class="text-start fs-4">About</h1>
                                <hr>
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="javascript:void(0);" class="d-block text-start text-decoration-none m-2"
                                            data-tab-id="overview">Overview</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="d-block text-start text-decoration-none m-2"
                                            data-tab-id="work-and-education">Work and Education</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="d-block text-start text-decoration-none m-2"
                                            data-tab-id="place-lived">Place Lived</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="d-block text-start text-decoration-none m-2"
                                            data-tab-id="contact-basic-info">Contact and Basic info</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="d-block text-start text-decoration-none m-2"
                                            data-tab-id="family-and-relationship">Family and Relationship</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Content -->
                    <div class="col-12 col-md-8">
                        <div class="tab-contents">
                            <div class="tab-pane" id="overview" role="tabpanel">
                                @include('profile.overview')
                            </div>

                            <div class="tab-pane d-none" id="work-and-education" role="tabpanel">
                                @include('profile.work-and-education')
                            </div>

                            <div class="tab-pane d-none" id="place-lived" role="tabpanel">
                                @include('profile.place-lived')
                            </div>

                            <div class="tab-pane d-none" id="contact-basic-info" role="tabpanel">
                                @include('profile.contact-basic-info')
                            </div>

                            <div class="tab-pane d-none" id="family-and-relationship" role="tabpanel">
                                @include('profile.family-and-relationship')
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- About Code End Here --}}
            {{-- Friends List Code Start Here --}}
            <div class="tab-pane fade" id="friends" role="tabpanel">
                <div class="list-group">
                    <div class="row">
                        @foreach ($friends as $friend)
                            <div class="col-6 col-md-4 col-lg-6 mt-3">
                                <div class="list-group-item d-flex align-items-center justify-content-between p-4">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $friend['profile_picture'] ?? 'default.png' }}"
                                            alt="{{ $friend['name'] }}" class="rounded-circle"
                                            style="width: 60px; height: 60px; object-fit: cover;">
                                        <div class="ms-3">
                                            <h6 class="mb-0">{{ $friend['name'] }}</h6>
                                            @if ($friend['location'])
                                                <small class="text-muted">From {{ $friend['location'] }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-sm">Send Request</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- Friends List Code End Here --}}
            <div class="tab-pane fade" id="photos" role="tabpanel">
                <h4>Photos</h4>
                <p>This is where photos will appear...</p>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(document).on('click', 'a[data-tab-id]', function() {
            var activeTabId = $(this).data('tab-id');
            $('a[data-tab-id]').each(function() {
                var tabId = $(this).data('tab-id');
                if (activeTabId !== tabId) {
                    $(`#${tabId}`).addClass('d-none');
                }
            });
            $(`#${activeTabId}`).removeClass('d-none');
        });

        $(document).ready(function() {
            $('#addWorkplaceBtn').on('click', function() {
                $('#workplaceFormCard').removeClass('d-none');
            });

            $('#cancelWorkplaceBtn').on('click', function() {
                $('#workplaceFormCard').addClass('d-none');
            });


            $('#addPlaceLivedBtn').on('click', function() {
                $('#placeLivedFormCard').removeClass('d-none');
            });

            $('#cancelPlaceLivedBtn').on('click', function() {
                $('#placeLivedFormCard').addClass('d-none');
            });
        });

        document.getElementById('addSocialMediaUrlBtn').addEventListener('click', function() {
            // Create a new input group for social media URL
            const newSocialMediaInput = document.createElement('div');
            newSocialMediaInput.classList.add('input-group', 'mb-3', 'social-media-group');
            newSocialMediaInput.innerHTML = `
            <input type="text" class="form-control" name="social_media_url[]" placeholder="Enter Social Media URL">
            <button class="btn btn-danger remove-social" type="button">-</button>
        `;

            // Append the new input group to the social media container
            document.getElementById('socialMediaUrls').appendChild(newSocialMediaInput);
        });

        // Event delegation to handle the removal of social media input fields
        document.getElementById('socialMediaUrls').addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-social')) {
                // Remove the parent input group (the social media URL input)
                e.target.closest('.social-media-group').remove();
            }
        });

        document.getElementById('addFamilyMemberBtn').addEventListener('click', function() {
            // Create a new input group for a family member name and relationship
            const newFamilyMemberInput = document.createElement('div');
            newFamilyMemberInput.classList.add('input-group', 'mb-3', 'family-member-group');
            newFamilyMemberInput.innerHTML = `
            <input type="text" class="form-control" placeholder="Enter family member name">
            <select class="form-select ms-2">
                <option value="">Select relationship</option>
                <option value="parent">Parent</option>
                <option value="sibling">Sibling</option>
                <option value="child">Child</option>
                <option value="spouse">Spouse</option>
                <option value="friend">Friend</option>
            </select>
            <button class="btn btn-danger remove-family-member" type="button">-</button>
        `;

            // Append the new input group to the family members list
            document.getElementById('familyMembersList').appendChild(newFamilyMemberInput);
        });

        // Event delegation to handle the removal of family member input fields
        document.getElementById('familyMembersList').addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-family-member')) {
                // Remove the parent input group (the family member input)
                e.target.closest('.family-member-group').remove();
            }
        });



        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.edit-button');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('editWorkplace').value = this.dataset.workplace;
                    document.getElementById('editPosition').value = this.dataset.position;
                    document.getElementById('editStartDate').value = this.dataset.start_date;
                    document.getElementById('editEndDate').value = this.dataset.end_date;
                    document.getElementById('editCity').value = this.dataset.city;
                    document.getElementById('editDescription').value = this.dataset.description;
                    document.getElementById('editWorkplaceId').value = this.dataset.workplace_id;
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.editPlaceLiveModal');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('editPlace').value = this.dataset.place;
                    document.getElementById('editDateMoved').value = this.dataset.date_moved;
                    document.getElementById('editPlaceLiveId').value = this.dataset.place_lived_id;
                });
            });
        });

        $(document).ready(function() {
            $(".workplaceForm").each(function() { // Loop if multiple forms
                $(this).validate({
                    rules: {
                        workplace: {
                            required: true,
                            maxlength: 255
                        },
                        position: {
                            required: true,
                            maxlength: 255
                        },
                        start_date: {
                            required: true,
                            date: true
                        },
                        end_date: {
                            date: true
                        },
                        city: {
                            required: true,
                            maxlength: 100
                        },
                        description: {
                            required: true,
                            maxlength: 500
                        }
                    },
                    messages: {
                        workplace: {
                            required: "Please enter the workplace.",
                            maxlength: "Workplace must not exceed 255 characters."
                        },
                        position: {
                            required: "Please enter the position.",
                            maxlength: "Position must not exceed 255 characters."
                        },
                        start_date: {
                            required: "Please select the start date.",
                            date: "Please enter a valid date."
                        },
                        end_date: {
                            date: "Please enter a valid date."
                        },
                        city: {
                            required: "Please enter the city or town.",
                            maxlength: "City/Town must not exceed 100 characters."
                        },
                        description: {
                            required: "Please enter the description.",
                            maxlength: "Description must not exceed 500 characters."
                        }
                    },
                    errorClass: 'text-danger',
                    errorElement: 'div',
                    highlight: function(element) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element) {
                        $(element).removeClass('is-invalid');
                    }
                });
            });

            $(".placeLiveFrom").each(function() { // Loop if multiple forms
                $(this).validate({
                    rules: {
                        place: {
                            required: true,
                            maxlength: 255
                        },
                        date_moved: {
                            required: true,
                            date: true
                        }
                    },
                    messages: {
                        place: {
                            required: "Please enter the place.",
                            maxlength: "place must not exceed 255 characters."
                        },
                        date_moved: {
                            required: "Please select the date moved.",
                            date: "Please enter a valid date."
                        },
                    },
                    errorClass: 'text-danger',
                    errorElement: 'div',
                    highlight: function(element) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element) {
                        $(element).removeClass('is-invalid');
                    }
                });
            });
        });



        $(document).ready(function() {
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
        });

        function changeAvatar(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const reader = new FileReader();
                reader.onload = function(e) {
                    let profileImage = document.getElementById('profileImage');
                    if (profileImage.tagName.toLowerCase() === 'img') {
                        profileImage.src = e.target.result;
                    } else {
                        let newImage = document.createElement('img');
                        newImage.src = e.target.result;
                        newImage.className = 'profile-photo';
                        newImage.id = 'profileImage';
                        newImage.onclick = function() {
                            document.getElementById('fileInput').click();
                        };
                        profileImage.replaceWith(newImage);
                    }
                };
                reader.readAsDataURL(file);

                // AJAX here too
                const formData = new FormData();
                formData.append("image", file);
                formData.append("_token", "{{ csrf_token() }}");

                $.ajax({
                    url: "{{ route('upload-avatar') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === 200) {
                            window.location.reload()
                        } else {
                            alert("Error uploading image.");
                        }
                    },
                    error: function() {
                        alert("Something went wrong!");
                    }
                });
            }
        }

        function changeCover(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const reader = new FileReader();
                reader.onload = function(e) {
                    let coverImageUrl = e.target.result;
                    // Set background-image properly
                    $('.cover-photo').css({
                        'background-image': 'url(' + coverImageUrl + ')',
                        'background-size': 'cover',
                        'background-position': 'center',
                        'background-repeat': 'no-repeat'
                    });
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
