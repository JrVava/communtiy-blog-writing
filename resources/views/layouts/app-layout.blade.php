<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>On TRACK EDUCATION</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon/favicon-16x16.png') }}">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
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

        .content-container {
            position: absolute;
            top: 52px;
        }

        .bi-hand-thumbs-up-fill.active {
            color: white;
        }
    </style>
</head>

<body>

    @include('_partial.frontend-navbar')

    <div class="container content-container mt-5 pt-5">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


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
    </script>
    @yield('scripts')
</body>

</html>
