<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facebook Clone</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body::-webkit-scrollbar {
            width: 12px;
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

        .people-list {
            display: none;
            position: absolute;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 10px;
            list-style: none;
            border-radius: 5px;
            width: 200px;
            z-index: 1000;
        }
    </style>
</head>

<body>

    @include('_partial.frontend-navbar')

    <div class="container mt-5 pt-5">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')

    <script>
        const userId = "{{ Auth::id() }}";
        $(document).ready(function() {
            $('.totalRequest').css({
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
            getFriendRequest(userId)

            $(document).on('click', '.accept-request, .deny-request', function() {
                let requestId = $(this).data('request-id');
                let action = $(this).hasClass('accept-request') ? 'accept' : 'deny';

                $.ajax({
                    url: "{{ route('friend-request-response') }}",
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        action: action,
                        requestId: requestId
                    },
                    success: function(response) {
                        if (response.status === 200) {
                            console.log(response.html);
                            $('#' + requestId).find('button').remove();
                            $('#' + requestId).html(response.html)
                        }
                    }
                });
            });

            $(document).on('click', '.follow-back', function() {
                let userId = $(this).data('user-id');
                let  followBackId = $(this).data('follow-back-id');
                followFun(userId, followBackId)
                // $.ajax({
                //     url: "{{ route('follow-request') }}",
                //     type: "POST",
                //     data: {
                //         user_id: followBackId,
                //         follower_id: userId,
                //         _token: "{{ csrf_token() }}"
                //     },
                //     success: function(response) {
                //         $('#followBtn').text('Requested');
                //     },
                //     error: function(xhr) {
                //         alert("Error: " + xhr.responseText);
                //     }
                // });
            });

        });

        function followFun(followingId, userId) {
            $.ajax({
                url: "{{ route('follow-request') }}",
                type: "POST",
                data: {
                    user_id: userId,
                    follower_id: followingId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#followBtn').text('Requested');
                },
                error: function(xhr) {
                    alert("Error: " + xhr.responseText);
                }
            });
        }

        let socket = new WebSocket("ws://127.0.0.1:8082?user_id=" + userId);

        socket.onopen = function() {
            console.log("✅ WebSocket connected");
        };

        socket.onmessage = function(event) {
            let data = JSON.parse(event.data);

            // Alert when another user refreshes
            if (data.type === 'refresh_alert') {
                console.log(userId);
                getFriendRequest(userId)
            }
        };

        socket.onclose = function() {
            console.warn("⚠️ WebSocket connection closed");
        };

        socket.onerror = function(error) {
            console.error("❌ WebSocket Error:", error);
        };

        $(document).ready(function() {
            $(".people-toggle").click(function() {
                $(".people-list").toggle();
            });
        });

        function getFriendRequest(follower_id) {
            $.ajax({
                url: "{{ route('friend-request') }}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    follower_id: follower_id
                },
                success: function(response) {
                    if (response.status === 200) {
                        if (response.totalCount > 0) {
                            $('.totalRequest').css({
                                display: 'block'
                            });
                            $('.totalRequest').text(response.totalCount)
                            $('.people-list').html(response.html)
                        }
                    }
                }
            });
        }
    </script>
</body>

</html>
