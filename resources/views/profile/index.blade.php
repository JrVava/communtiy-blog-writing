@php
    $initials = strtoupper(substr($user->full_name, 0, 1));
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
        </ul>

        <div class="tab-content" id="profileTabsContent">
            {{-- My Post Code Start Here --}}
            <div class="tab-pane fade show active" id="posts" role="tabpanel">
                @include('blog.form')
                <div class="row mt-2 me-2 mx-2 g-3 justify-content-center">
                    <div class="col-12 col-md-8 col-lg-8">
                        @if (count($posts) > 0)
                            {{-- @include('profile.my-posts') --}}
                            @include('blog.posts')
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
                                        <a href="javascript:void(0);"
                                            class="d-block text-start text-decoration-none m-2 active"
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
                        @include('profile.friend-list')
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
    @include('profile.modals.post-modal')
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            const tab = urlParams.get('tab');
            const section = urlParams.get('section');

            if (tab) {
                const tabButton = document.getElementById(`${tab}-tab`);
                if (tabButton) {
                    new bootstrap.Tab(tabButton).show();
                }

                if (tab === 'about' && section) {
                    $('a[data-tab-id]').removeClass('active');
                    $(`a[data-tab-id="${section}"]`).addClass('active');

                    $('a[data-tab-id]').each(function() {
                        const tabId = $(this).data('tab-id');
                        $(`#${tabId}`).addClass('d-none');
                    });

                    $(`#${section}`).removeClass('d-none');
                }
            }
            getOverView()
        });

        $(document).on('click', 'a[data-tab-id]', function() {
            const activeTabId = $(this).data('tab-id');

            $('a[data-tab-id]').removeClass('active');
            $(this).addClass('active');

            $('a[data-tab-id]').each(function() {
                const tabId = $(this).data('tab-id');
                $(`#${tabId}`).addClass('d-none');
            });
            $(`#${activeTabId}`).removeClass('d-none');

            if (activeTabId === 'overview') {
                getOverView()
            }

            const newUrl = new URL(window.location.href);
            newUrl.searchParams.set('tab', 'about');
            newUrl.searchParams.set('section', activeTabId);
            window.history.pushState({}, '', newUrl);
        });

        $(document).on('click', 'button[data-bs-toggle="tab"]', function() {
            const targetId = $(this).data('bs-target').replace('#', '');
            const newUrl = new URL(window.location.href);
            newUrl.searchParams.set('tab', targetId);
            console.log(targetId);
            if (targetId === 'about') {
                getOverView();
            }
            // Remove section param if not on "about"
            if (targetId !== 'about') {
                newUrl.searchParams.delete('section');
            }

            window.history.pushState({}, '', newUrl);
        });

        function getOverView() {
            let userId = "{{ $user->id }}";
            $.ajax({
                url: "{{ route('get-overview-by-user-id') }}",
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "userId": userId
                },
                success: function(res) {
                    if (res.status === 200) {
                        const user = res.user;

                        // Work
                        if (user.workplace && user.workplace.position && user.workplace.workplace) {
                            $('#currentWork').html(
                                `${user.workplace.position} at <b>${user.workplace.workplace}</b>`);
                        } else {
                            $('#currentWork').html(`Not available`);
                        }

                        // Education
                        if (user.education && user.education.position && user.education.workplace) {
                            $('#education').html(
                                `Studied ${user.education.position} at <b>${user.education.workplace}</b>`);
                        } else {
                            $('#education').html(`Not available`);
                        }

                        // Current Living
                        if (user.currentLiving && user.currentLiving.place) {
                            $('#livedIn').html(`Lives in <b>${user.currentLiving.place}</b>`);
                        } else {
                            $('#livedIn').html(`Not available`);
                        }

                        // Hometown
                        if (user.hometown && user.hometown.place) {
                            $('#from').html(`From <b>${user.hometown.place}</b>`);
                        } else {
                            $('#from').html(`Not available`);
                        }

                        // Marital Status
                        if (user.contact_basic_info && user.contact_basic_info.relationship_status) {
                            $('#maritalStatus').html(`${user.contact_basic_info.relationship_status}`);
                        } else {
                            $('#maritalStatus').html(`Not available`);
                        }

                        // Email
                        if (user.contact_basic_info && user.contact_basic_info.email_address) {
                            $('#email').html(`Email: <b>${user.contact_basic_info.email_address}</b>`);
                        } else {
                            $('#email').html(`Email: Not available`);
                        }

                        // Phone
                        if (user.contact_basic_info && user.contact_basic_info.phone_number) {
                            $('#phone').html(`Phone Number: <b>${user.contact_basic_info.phone_number}</b>`);
                        } else {
                            $('#phone').html(`Phone Number: Not available`);
                        }
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            })
        }


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

        document.getElementById('addWorkplaceBtn').addEventListener('click', function() {
            document.getElementById('workplaceFormCard').classList.remove('d-none');
            document.getElementById('labelWorkplace').textContent = 'Workplace';
            document.getElementById('labelPosition').textContent = 'Position';
            document.getElementById('entryType').value = 'workplace';
        });


        document.getElementById('addCollegeBtn').addEventListener('click', function() {
            document.getElementById('workplaceFormCard').classList.remove('d-none');
            document.getElementById('labelWorkplace').textContent = 'College';
            document.getElementById('labelPosition').textContent = 'Degree';
            document.getElementById('entryType').value = 'College';
        });

        document.getElementById('addHighSchoolBtn').addEventListener('click', function() {
            document.getElementById('workplaceFormCard').classList.remove('d-none');
            document.getElementById('labelWorkplace').textContent = 'High School';
            document.getElementById('labelPosition').textContent = 'Degree';
            document.getElementById('entryType').value = 'High School';
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
            // Get all currently selected family IDs
            const selectedIds = Array.from(document.querySelectorAll('select[name="family_id[]"]'))
                .map(select => select.value)
                .filter(val => val !== "");

            // Build dropdown options, excluding selected IDs
            let optionsHtml = `<option value="">--Select Family Member--</option>`;
            @foreach ($forRelationShips as $forRelationShip)
                if (!selectedIds.includes('{{ $forRelationShip->id }}')) {
                    optionsHtml +=
                        `<option value="{{ $forRelationShip->id }}">{{ $forRelationShip->full_name }}</option>`;
                }
            @endforeach

            // Create the new input group
            const newFamilyMemberInput = document.createElement('div');
            newFamilyMemberInput.classList.add('mb-3', 'family-member-group');
            newFamilyMemberInput.innerHTML = `
    <div class="row">
        <div class="col-6">
            <select name="family_id[]" class="form-select ms-2">
                ${optionsHtml}
            </select>
        </div>
        <div class="col-5">
            <select class="form-select ms-2" name="relationship[]">
                <option value="">Select relationship</option>
                <option value="Parent">Parent</option>
                <option value="Sibling">Sibling</option>
                <option value="Child">Child</option>
                <option value="Spouse">Spouse</option>
                <option value="Friend">Friend</option>
            </select>
        </div>
        <div class="col-1 d-flex align-items-center">
            <button class="btn btn-danger remove-family-member" type="button">-</button>
        </div>
    </div>
`;

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
            const editButtons = document.querySelectorAll('.editPostModal');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('editPostDescription').value = this.dataset
                        .description || '';
                    document.getElementById('editOldPostImage').value = this.dataset.old_post_image;
                    document.getElementById('editPostId').value = this.dataset.post_id;

                    const imageUrl = this.dataset.postimage;
                    const imagePreview = document.getElementById('editImagePreview');
                    const previewContainer = document.getElementById('editImagePreviewContainer');

                    if (imageUrl) {
                        imagePreview.src = imageUrl;
                        previewContainer.classList.remove('d-none');
                    } else {
                        imagePreview.src = '';
                        previewContainer.classList.add('d-none');
                    }
                });
            });

            // Preview selected image before uploading
            document.getElementById('postImage').addEventListener('change', function() {
                const file = this.files[0];
                const imagePreview = document.getElementById('editImagePreview');
                const previewContainer = document.getElementById('editImagePreviewContainer');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        previewContainer.classList.remove('d-none');
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.src = '';
                    previewContainer.classList.add('d-none');
                }
            });
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

                    var position = 'Position'
                    if (this.dataset.type === "High School" || this.dataset.type === "College") {
                        position = 'Degree'
                    }
                    document.getElementById('eidtLabelPosition').textContent = position;
                    document.getElementById('editLabelWorkplace').textContent = this.dataset.type;
                    document.getElementById('editWorkPlaceModalLabel').textContent = "Edit " + this
                        .dataset.type
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
                    document.getElementById('editPlaceType').value = this.dataset.place_type;
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.editFamilyRelationShipModal');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('editFamilyId').value = this.dataset.family_id;
                    document.getElementById('editRelationShip').value = this.dataset.relationship;
                    document.getElementById('editFamilyRelationShipId').value = this.dataset
                        .family_relationship_id;
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

        $(".contactBasicFrom").each(function() {
            $(this).validate({
                rules: {
                    email_address: {
                        required: true,
                        email: true,
                        maxlength: 255
                    },
                    phone_number: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 15
                    },
                    relationship_status: {
                        required: true,
                        maxlength: 50
                    },
                    birthday: {
                        required: true,
                        date: true
                    }
                },
                messages: {
                    email_address: {
                        required: "Please enter your email address.",
                        email: "Please enter a valid email address.",
                        maxlength: "Email must not exceed 255 characters."
                    },
                    phone_number: {
                        required: "Please enter your phone number.",
                        digits: "Phone number should only contain numbers.",
                        minlength: "Phone number should be at least 10 digits.",
                        maxlength: "Phone number should not exceed 15 digits."
                    },
                    relationship_status: {
                        required: "Please select your relationship status.",
                        maxlength: "Relationship status must not exceed 50 characters."
                    },
                    birthday: {
                        required: "Please enter your birthday.",
                        date: "Please enter a valid date."
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

        $(".familyRelationshipForm").validate({
            rules: {
                'family_id[]': {
                    required: true
                },
                'relationship[]': {
                    required: true
                }
            },
            messages: {
                'family_id[]': {
                    required: "Please select a family member."
                },
                'relationship[]': {
                    required: "Please select the relationship."
                }
            },
            errorClass: 'text-danger',
            errorElement: 'div',
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            },
            errorPlacement: function(error, element) {
                // Append the error below the current select element
                console.log(element);
                error.insertAfter(element);
            }

        });

        $(document).ready(function() {

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
