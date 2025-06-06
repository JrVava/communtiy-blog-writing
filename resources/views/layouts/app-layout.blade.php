<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>On TRACK EDUCATION</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset(userAssetPath().'/img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset(userAssetPath().'/img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset(userAssetPath().'/img/favicon/favicon-16x16.png') }}">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset(userAssetPath().'/css/profile.css') }}">
    <style>
        body::-webkit-scrollbar {
            width: 12px;
        }

        @media (min-width: 1400px) {

            .container,
            .container-lg,
            .container-md,
            .container-sm,
            .container-xl,
            .container-xxl {
                max-width: 100%;
            }
        }

        /* Track (background of the scrollbar) */
        body::-webkit-scrollbar-track {
            background: white;
        }

        /* Scrollbar thumb (draggable part) */
        body::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            border-radius: 20px;
            border: 3px solid white;
        }

        .main-wrapper {
            padding-top: 105px;
        }

        #userList {
            max-height: 200px;
            overflow-y: auto;
            position: absolute !important;
            top: calc(100% + 5px);
            left: 0;
            border: 1px solid black;
            border-radius: 5px;
            background: white;
            padding: 1px;
            margin-top: 3px;
        }


        .people-badge {
            position: absolute;
            top: 5px;
            right: 5px;
            background: red;
            color: white;
            font-size: 12px;
            font-weight: bold;
            padding: 3px 7px;
            border-radius: 50%;
            min-width: 20px;
            text-align: center;
        }

        .people-list,
        .notification-lists {
            display: none;
            position: absolute;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 10px;
            list-style: none;
            border-radius: 5px;
            width: 100%;
            min-width: 400px;
            z-index: 1000;
        }

        .logo {
            width: 100%;
            max-width: 200px;
            height: 100%;
            min-height: 50px;
        }

        .btn-primary,
        .bg-primary {
            background-color: #374697 !important;
            border: 1px solid transparent !important;
        }

        .text-primary::before {
            color: #374697 !important;
        }

        .bi-hand-thumbs-up-fill.active {
            color: white;
        }

        @media screen and (max-width:991px) {
            .main-wrapper {
                padding-top: 95px;
            }

            .user-avatar-btn.dropdown-toggle::after {
                display: none;
            }

            .navigation-wrapper {
                position: absolute;
                left: 0%;
                right: 0%;
                top: 84px;
                background-color: #ffffff;
                box-shadow: 0px 0px 6px 0px #f3ecec;
                padding: 15px 15px;
            }
        }

        @media screen and (max-width:767px) {
            .navigation-wrapper {
                top: 124px;
            }
        }

        .postImageUpload {
            cursor: pointer;
        }

        a[data-tab-id].active {
            font-weight: bold;
            color: #0d6efd;
            /* Bootstrap primary */
        }

        .btn-sm.btn-light {
            background-color: #374697;
            color: white;
        }

        .dropdown-item.active,
        .dropdown-item:active {
            background-color: #374697;
        }
    </style>
</head>

<body>

    @include('_partial.frontend-navbar')
    <div class="main-wrapper">
        <div class="container content-container">
            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
    <script>
        document.addEventListener('contextmenu', function(event) {
            event.preventDefault(); // Disable default right-click menu
        }, false);
        let userId = "{{ Auth::id() }}";

        let socket = new WebSocket(`ws://127.0.0.1:8082?user_id=${userId}`);

        socket.onopen = function() {
            console.log("✅ WebSocket connected");
        };

        socket.onmessage = function(event) {
            let data = JSON.parse(event.data);
            console.log(data.type);
            if (data.type === 'follow_request') {
                getTotatRequest()
            } else if (data.type === 'chat_message') {
                // Append the received message to the chat UI
                $(".chat-body").append(`<div class="message received">${data.message}</div>`);
                $(".chat-body").scrollTop($(".chat-body")[0].scrollHeight);
            } else if (data.type === 'get_notification') {
                console.log("hello");
                getNotification()
            }
        };

        socket.onclose = function() {
            console.warn("⚠️ WebSocket connection closed");
        };

        socket.onerror = function(error) {
            console.error("❌ WebSocket Error:", error);
        };

        function getNotification() {
            $.ajax({
                url: "{{ route('get-notification') }}",
                type: "GET",
                success: function(res) {
                    if (res.status === 200) {
                        $('.notification-lists').html(res.html)
                        if (res.totalCount > 0) {
                            $('.totalNotification').css({
                                display: 'block'
                            })
                            $('.totalNotification').text(res.totalCount)
                        } else {
                            let html =
                                '<li class="p-2 border-bottom d-flex align-items-center"><h5>No Notification</h3></h5>';
                            $('.notification-lists').html(html)
                            $('.totalNotification').css({
                                display: 'none'
                            })
                            $('.totalNotification').text(0)
                        }
                    }
                }
            })
        }

        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('postImage');
            if (input) {
                input.addEventListener('change', function() {
                    const file = this.files[0];
                    const imagePreview = document.getElementById('addImagePreview');
                    const previewContainer = document.getElementById('addImagePreviewContainer');

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
            }
        });


        $(document).ready(function() {
            getNotification()
            $('.totalRequest').css({
                display: 'none'
            });
            $('.totalNotification').css({
                display: 'none'
            });
            $("#searchUser").on("keyup", function() {
                let query = $(this).val();
                if (query.length > 1) {
                    $.ajax({
                        url: "{{ route('search-user') }}",
                        method: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            search: query
                        },
                        success: function(response) {
                            $("#userList").html(response.html).show();
                        }
                    });
                } else {
                    $("#userList").hide();
                }
            });

            // Click on user name to fill input box
            $(document).on("click", ".user-item", function(e) {
                // Prevent page navigation
                let selectedUser = $(this).data("name");
                $("#searchUser").val(selectedUser);
                $("#userList").hide();
            });

            // Hide list when clicking outside
            $(document).on("click", function(e) {
                if (!$(e.target).closest("#searchUser, #userList").length) {
                    $("#userList").hide();
                }
            });



            $(document).on('click', '#followBtn', function() {
                let followingId = $(this).data('following-id');
                let userId = $(this).data('user-id');

                $.ajax({
                    url: "{{ route('send-follow-request') }}",
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "followingId": followingId,
                        "userId": userId
                    },
                    success: function(res) {
                        // Send WebSocket notification to the followed user
                        let message = JSON.stringify({
                            type: "follow_request",
                            to_user_id: followingId,
                            from_user_id: userId
                        });

                        if (socket.readyState === WebSocket.OPEN) {
                            socket.send(message);
                        } else {
                            console.warn("⚠️ WebSocket not open yet");
                        }

                        // Update button text (optional)
                        $('#followBtn').text(res.data);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });
            $(document).on('click', '.accept-request, .deny-request', function() {
                let action = $(this).hasClass('accept-request') ? 'accept' : 'deny';
                let followId = $(this).data('request-id');

                $.ajax({
                    url: "{{ route('response-to-request') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "followId": followId,
                        "action": action
                    },
                    success: function(res) {
                        getRequestList()
                    }
                })
            });

            $(document).on('click', '.follow-back', function() {
                let followId = $(this).data('request-id');

                $.ajax({
                    url: "{{ route('response-to-request') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "followId": followId,
                        "action": "Followed"
                    },
                    success: function(res) {
                        getRequestList()
                        getTotatRequest()
                    }
                })
            });
            getTotatRequest()
        });

        function getTotatRequest() {
            $.ajax({
                url: "{{ route('total-follow-request') }}",
                type: "get",
                success: function(res) {
                    if (res.data > 0) {
                        $('.totalRequest').css({
                            display: 'block'
                        })
                        $('.totalRequest').text(res.data)
                        getRequestList()
                    } else {
                        let html =
                            '<li class="p-2 border-bottom d-flex align-items-center"><h5>No Follow Request</h3></h5>';
                        $('.people-list').html(html)
                        $('.totalRequest').css({
                            display: 'none'
                        })
                        $('.totalRequest').text(0)
                    }
                }
            })
        }

        function getRequestList() {
            $.ajax({
                url: "{{ route('follow-request-list') }}",
                type: "get",
                success: function(res) {
                    let html = '<li class="class="p-2 border-bottom"><h5>No Follow Request</h5>';
                    $('.people-list').html(html)
                    $('.people-list').html(res.data)
                }
            })
        }

        $(document).ready(function() {
            $(".people-toggle").click(function() {
                $(".notification-lists").hide(); // Close notification list when people list opens
                $(".people-list").toggle();
            });

            $(".notification-toggle").click(function() {
                $.ajax({
                    url: "{{ route('clear-notification') }}",
                    type: "GET",
                    success: function(res) {
                        $('.totalNotification').css({
                            display: 'none'
                        });
                        $('.totalNotification').text(0);
                    }
                });

                $(".people-list").hide(); // Close people list when notification list opens
                $(".notification-lists").toggle();
            });
        });



        $(document).ready(function() {
            $('.comment-btn').on('click', function() {
                let commentSection = $(this).closest('.d-flex').next('.comments-section');
                commentSection.toggleClass('d-none');
            });

            $(".read-more-btn").click(function() {
                let isExpanded = $(this).attr("data-expanded") === "true";

                let card = $(this).closest(".card-body");

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

            $(".like-btn").click(function() {
                let postId = $(this).data("post-id");
                let isLiked = $(this).attr("data-liked") === "true";
                let dislikeBtn = $(this).siblings(".dislike-btn");
                let postedId = $(this).data('posted-id')
                // Toggle UI
                if (!isLiked) {
                    $(this).addClass("btn-primary").removeClass("btn-light");
                    $(this).find("i").addClass("bi-hand-thumbs-up-fill").removeClass("bi-hand-thumbs-up");

                    // Reset dislike button if selected
                    dislikeBtn.removeClass("btn-danger").addClass("btn-light");
                    dislikeBtn.find(".bi").removeClass("bi-hand-thumbs-down-fill").addClass(
                        "bi-hand-thumbs-down");
                    dislikeBtn.attr("data-disliked", "false");
                } else {
                    $(this).removeClass("btn-primary").removeClass("active").addClass("btn-light");
                    $(this).find("i").removeClass("bi-hand-thumbs-up-fill").addClass("bi-hand-thumbs-up");
                }

                $(this).attr("data-liked", !isLiked);

                // AJAX request to Laravel
                $.ajax({
                    url: `/post/${postId}/like`,
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response.data.likes.length);
                        console.log("dislikes", response.data.dislikes.length);
                        $("#likes-count-" + postId).text(response.data.likes.length);
                        $("#dislikes-count-" + postId).text(response.data.dislikes.length);

                        let notification = JSON.stringify({
                            type: "get_notification",
                            userId: postedId
                        });

                        if (socket.readyState === WebSocket.OPEN) {
                            socket.send(notification);
                        } else {
                            console.warn("⚠️ WebSocket not open yet");
                        }
                    }
                });
            });


            $(".dislike-btn").click(function() {
                let postId = $(this).data("post-id");
                let isDisliked = $(this).attr("data-disliked") === "true";
                let likeBtn = $(this).siblings(".like-btn");
                let postedId = $(this).data('posted-id')
                // Toggle UI
                if (!isDisliked) {
                    $(this).addClass("btn-danger").removeClass("btn-light");
                    $(this).find("i").addClass("bi-hand-thumbs-down-fill").removeClass(
                        "bi-hand-thumbs-down");

                    // Reset like button if selected
                    likeBtn.removeClass("btn-primary").addClass("btn-light");
                    likeBtn.find(".bi").removeClass("bi-hand-thumbs-up-fill").addClass("bi-hand-thumbs-up");
                    likeBtn.attr("data-liked", "false");
                } else {
                    $(this).removeClass("btn-danger").removeClass("active").addClass("btn-light");
                    $(this).find("i").removeClass("bi-hand-thumbs-down-fill").addClass(
                        "bi-hand-thumbs-down");
                }

                $(this).attr("data-disliked", !isDisliked);

                // AJAX request to Laravel
                $.ajax({
                    url: `/post/${postId}/dislike`,
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $("#likes-count-" + postId).text(response.data.likes.length);
                        $("#dislikes-count-" + postId).text(response.data.dislikes.length);
                        let notification = JSON.stringify({
                            type: "get_notification",
                            userId: postedId
                        });

                        if (socket.readyState === WebSocket.OPEN) {
                            socket.send(notification);
                        } else {
                            console.warn("⚠️ WebSocket not open yet");
                        }
                    }
                });
            });

            $(".send-comment-btn").click(function() {
                let commentInput = $(this).siblings(".send-comment");
                let postId = commentInput.data('post-id');
                let postedId = commentInput.data('posted-id')
                let userId = "{{ Auth::user()->id }}"
                let message = commentInput.val().trim();

                if (message !== "") {
                    let commentSection = $(this).closest(".comments-section");
                    let commentBlock = commentSection.find(".comment-block");
                    $.ajax({
                        url: "{{ route('save-comment') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            postId: postId,
                            userId: userId,
                            message: message
                        },
                        success: function(res) {
                            console.log(res);
                        }
                    })
                    let newComment = `
                        <div class="d-flex align-items-start mb-2">
                            <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
                                class="rounded-circle border me-2" width="40" height="40" alt="User Image">
                            <div class="bg-light p-2 rounded w-100">
                                <h6 class="mb-1 fw-bold">Ashish</h6>
                                <p class="comment-text mb-1">${message}</p>
                                <small class="text-muted">Just now</small>
                            </div>
                        </div>
                    `;
                    // Append the new comment
                    commentBlock.append(newComment);
                    commentInput.val("");

                    let notification = JSON.stringify({
                        type: "get_notification",
                        userId: postedId
                    });

                    if (socket.readyState === WebSocket.OPEN) {
                        socket.send(notification);
                    } else {
                        console.warn("⚠️ WebSocket not open yet");
                    }
                } else {
                    console.log("No comment entered.");
                }
            });

            $(".send-comment").keypress(function(e) {
                if (e.which === 13) {
                    $(this).siblings(".send-comment-btn").click();
                }
            });


        });
    </script>
    @yield('scripts')
</body>

</html>
