<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ secure_asset('assets/img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ secure_asset('assets/img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ secure_asset('assets/img/favicon/favicon-16x16.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
    <style>
        .content-area {
            padding-bottom: 80px;
        }

        @media (min-width: 768px) {
            .content-area {
                padding-bottom: 0;
            }

        }

        @media (min-width: 375px) {
            .in-mobile-content {
                margin-bottom: 92px;
            }
        }


        .image-preview-container {
            display: none;
            position: relative;
            /* Added this */
            margin-bottom: 12px;
        }

        #imagePreview {
            max-height: 200px;
            object-fit: contain;
            width: 100%;
            border-radius: 8px;
        }

        .remove-image-btn {
            position: absolute;
            top: 8px;
            right: 8px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        /* Mobile menu styles */
        .mobile-menu {
            display: none;
            position: fixed;
            bottom: 80px;
            left: 0;
            right: 0;
            background: white;
            padding: 20px;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            z-index: 50;
            max-height: 60vh;
            overflow-y: auto;
        }

        .mobile-menu.active {
            display: block;
        }

        /* Desktop menu styles */
        .desktop-menu {
            display: none;
            position: absolute;
            right: 100px;
            top: 60px;
            background: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 50;
            width: 250px;
            border-radius: 8px;
        }

        .desktop-menu.active {
            display: block;
        }

        /* Add to your existing styles */
        .no-scroll {
            overflow: hidden;
            height: 100vh;
            position: fixed;
            width: 100%;
        }

        /* Add this to your styles */
        .mobile-menu.active~.content-area {
            overflow: hidden;
            height: 100vh;
            position: fixed;
            width: 100%;
        }

        .chat-list-item.active {
            background-color: #f5f6f6;
        }

        .chat-list-item:hover:not(.active) {
            background-color: #f9f9f9;
        }

        /* Default mobile view - users list full width */
        .mobile-users-view {
            display: flex;
            width: 100%;
        }

        .mobile-chat-view {
            display: none;
            width: 100%;
            position: relative;
            padding-bottom: 60px;
        }

        /* Mobile Bottom Navigation */
        .fixed.bottom-0 {
            z-index: 20;
            /* Lower than message input */
        }

        @media (min-width: 768px) {

            /* Desktop view - show both panels side by side */
            .mobile-users-view {
                width: 33.333333%;
            }

            .mobile-chat-view {
                /* display: flex !important;
                width: 66.666667%; */
                padding-bottom: 0;
            }
        }

        /* Add this to your existing styles */
        #chatArea {
            padding-bottom: 80px;
            /* Space for message input */
        }

        /* Message input container */
        #chatView>div:last-child {
            position: fixed;
            bottom: 60px;
            /* Above the mobile menu */
            left: 0;
            right: 0;
            z-index: 30;
            padding: 8px 16px;
            background: white;
            border-top: 1px solid #e5e7eb;
        }

        @media (min-width: 768px) {
            #chatView>div:last-child {
                position: static;
                padding: 12px;
                border-top: none;
            }

            #chatArea {
                padding-bottom: 0;
            }
        }

        .image-preview-container {
            display: none;
            position: relative;
            /* Added this */
            margin-bottom: 12px;
        }

        #imagePreview {
            max-height: 200px;
            object-fit: contain;
            width: 100%;
            border-radius: 8px;
        }

        .remove-image-btn {
            position: absolute;
            top: 8px;
            right: 8px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        #search-results {
            max-height: 300px;
            overflow-y: auto;
        }

        #search-results a {
            transition: background-color 0.2s;
        }

        #search-results a:hover {
            background-color: #f3f4f6;
        }
    </style>
</head>

<body class="min-h-screen bg-gray-50">
    <!-- Desktop Header (Top) -->
    <header class="sticky top-0 z-50 bg-white shadow-sm hidden md:block">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <!-- Logo on Left -->
            <a href="{{ route('user.post') }}" class="flex items-center">
                <img src="{{ secure_asset('assets/img/logo.png') }}" alt="Community Logo" class="h-8 md:h-10 mr-2">
                <!-- Adjust height as needed -->
                <!-- Optional text that shows only on desktop -->
            </a>

            <!-- Navigation Icons (Left) -->
            <nav class="flex items-center space-x-6">
                <a href="{{ route('user.post') }}" class="text-gray-600 hover:text-blue-500 transition-colors">
                    <i class="fas fa-home text-2xl"></i>
                </a>

                <!-- Users Dropdown -->
                <div class="relative">
                    <button id="usersButton" class="text-gray-600 hover:text-blue-500 transition-colors relative">
                        <i class="fas fa-users text-2xl"></i>
                        <span id="pendingRequestCount"
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $pendingCount }}</span>
                    </button>
                    <!-- Friend Requests Dropdown -->
                    <div id="usersDropdown"
                        class="absolute right-0 mt-2 w-72 bg-white rounded-lg shadow-lg py-2 hidden">
                        <div class="px-4 py-2 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="font-semibold">Follow Requests</h3>
                        </div>
                        <div class="max-h-96 overflow-y-auto" id="followRequestsContainer">
                            @foreach ($followRequests as $followRequest)
                                <div class="px-4 py-3 hover:bg-gray-50 flex items-center follow-request-item"
                                    data-follower-id="fc971c3e-143c-491c-ad54-c3707130c7dd">
                                    <img src="@if (isset($followRequest->follower->currentProfileImage)) {{ Storage::url($followRequest->follower->currentProfileImage->path) }} @else {{ secure_asset('assets/img/dummy-user.jpg') }} @endif"
                                        alt="User" class="w-10 h-10 rounded-full mr-3">
                                    <div class="flex-1">
                                        <a href="{{ route('profile', ['user_id' => $followRequest->follower->id]) }}"
                                            class="font-medium">{{ $followRequest->follower->full_name }}</a>
                                        <p class="text-sm text-gray-500">Sent you a follow request</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        @if (auth()->user()->hasPendingFollowRequestFrom($followRequest->follower))
                                            {{-- Show Accept/Decline buttons if someone requested to follow you --}}
                                            <div class="flex space-x-2">
                                                <button class="accept-follow text-green-500 hover:text-green-700"
                                                    data-user-id="{{ $followRequest->follower->id }}">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button class="decline-follow text-red-500 hover:text-red-700"
                                                    data-user-id="{{ $followRequest->follower->id }}">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        @else
                                            @if ($user->isFollowing(auth()->user()))
                                                <button class="follow-button bg-blue-500 text-white px-4 py-2"
                                                    data-user-id="{{ $followRequest->follower->id }}"
                                                    data-state="follow">
                                                    <i class="fas fa-user-plus"></i>
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Notifications Dropdown -->
                <div class="relative">
                    <button id="notifButton" class="text-gray-600 hover:text-blue-500 transition-colors relative">
                        <i class="fas fa-bell text-2xl"></i>
                        <span
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">5</span>
                    </button>
                    <!-- Notifications Dropdown -->
                    <div id="notifDropdown"
                        class="absolute right-0 mt-2 w-72 bg-white rounded-lg shadow-lg py-2 hidden">
                        <div class="px-4 py-2 border-b border-gray-100">
                            <h3 class="font-semibold">Notifications</h3>
                        </div>
                        <div class="max-h-96 overflow-y-auto">
                            <!-- Notification Item -->
                            <div class="px-4 py-3 hover:bg-gray-50 flex items-start">
                                <img src="https://randomuser.me/api/portraits/women/2.jpg" alt="User"
                                    class="w-10 h-10 rounded-full mr-3">
                                <div>
                                    <p class="font-medium">Sarah liked your post</p>
                                    <p class="text-sm text-gray-500">2 minutes ago</p>
                                </div>
                            </div>
                            <!-- More notifications... -->
                        </div>
                        <a href="#" class="block px-4 py-2 text-center text-blue-500 hover:bg-gray-50">View
                            All</a>
                    </div>
                </div>

                <a href="{{ route('chats') }}"
                    class="relative inline-flex items-center text-gray-600 hover:text-blue-500 transition-colors duration-200">
                    <i class="fas fa-comment-dots text-2xl"></i>
                    <span
                        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"
                        id="message-notification-badge">{{ $messageNotificationCount }}</span>
                </a>
            </nav>

            <!-- Search Box and Profile (Right) -->
            <div class="flex items-center space-x-6">
                <!-- Search Box -->
                <div class="relative w-48">
                    <input type="text" placeholder="Search..."
                        class="user-search-input w-full py-1.5 pl-10 pr-4 bg-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white text-sm">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>

                    <!-- Changed id to class -->
                    <div class="user-search-results absolute z-10 mt-1 w-full bg-white rounded-md shadow-lg hidden">
                        <!-- Results will appear here -->
                    </div>
                </div>

                <!-- Profile and Logout -->
                <a href="{{ route('profile', ['user_id' => Auth::id()]) }}"
                    class="text-gray-600 hover:text-blue-500 transition-colors">
                    {{-- <i class="fas fa-user-circle text-2xl"></i> --}}
                    @if (Auth::user()->currentProfileImage)
                        <img src="{{ Storage::url(Auth::user()->currentProfileImage->path) }}"
                            alt="{{ Auth::user()->full_name }}" class="w-8 h-8 rounded-full object-cover">
                    @else
                        <i class="fas fa-user-circle text-2xl"></i>
                    @endif
                </a>
                <a href="{{ route('logout') }}" class="text-gray-600 hover:text-red-500 transition-colors">
                    <i class="fas fa-sign-out-alt text-2xl"></i>
                </a>
            </div>
        </div>
    </header>
    <!-- Mobile Header with Search -->
    <header class="fixed top-0 left-0 right-0 z-40 bg-white shadow-sm border-b border-gray-200 md:hidden">
        <div class="flex items-center justify-between px-4 py-3">
            <!-- Logo -->
            <a href="https://communtiy-blog.test" class="flex items-center">
                <img src="{{ secure_asset('assets/img/logo.png') }}" alt="Community Logo" class="h-8">
                <!-- Fixed height matching original -->
            </a>

            <!-- Search and Notification Icons -->
            <div class="flex items-center space-x-4">
                <!-- Search Box (Right-aligned) -->
                <div class="relative w-60">
                    <input type="text" placeholder="Search..."
                        class="user-search-input w-full py-1.5 pl-8 pr-3 bg-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white text-sm">
                    <i
                        class="fas fa-search absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                    <div class="user-search-results absolute z-10 mt-1 w-full bg-white rounded-md shadow-lg hidden">
                        <!-- Results will appear here -->
                    </div>
                </div>

            </div>
        </div>
    </header>
    @yield('content')
    <!-- Mobile Bottom Navigation -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg md:hidden z-40">
        <!-- Mobile menu content -->
        <div id="mobileMenu" class="mobile-menu hidden">
            <h2 class="text-xl font-bold mb-4">Community</h2>
            <nav class="space-y-2">
                <a href="{{ route('user.post') }}" class="block py-2 px-3 rounded hover:bg-gray-100"><i
                        class="fas fa-home mr-2"></i>
                    Home</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-gray-100"><i class="fas fa-users mr-2"></i>
                    My
                    Groups</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-gray-100"><i
                        class="fas fa-comments mr-2"></i>
                    Discussions</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-gray-100"><i
                        class="fas fa-calendar-alt mr-2"></i>
                    Events</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-gray-100"><i class="fas fa-book mr-2"></i>
                    Resources</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-gray-100"><i class="fas fa-cog mr-2"></i>
                    Settings</a>
            </nav>

            <div class="mt-8">
                <h2 class="text-xl font-bold mb-4">Upcoming Events</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="font-semibold">Group Meeting</h3>
                        <p class="text-sm text-gray-600">Apr 28 - 18:00</p>
                    </div>
                    <div>
                        <h3 class="font-semibold">Community Member</h3>
                        <p class="text-sm text-gray-600">Apr 27 - 14:00</p>
                    </div>
                    <div>
                        <h3 class="font-semibold">Workshop</h3>
                        <p class="text-sm text-gray-600">May 1 - 10:35</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom navigation bar -->
        <div class="flex justify-around py-3">
            <a href="{{ route('user.post') }}"
                class="flex flex-col items-center text-gray-600 hover:text-blue-500 transition-colors px-2">
                <i class="fas fa-home text-xl"></i>
                <span class="text-xs mt-1">Home</span>
            </a>
            <a href="{{ route('chats') }}"
                class="flex flex-col items-center text-gray-600 hover:text-blue-500 transition-colors px-2">
                <i class="fas fa-comment-dots text-xl"></i>
                <span class="text-xs mt-1">Chat</span>
            </a>
            <a href="#"
                class="flex flex-col items-center text-gray-600 hover:text-blue-500 transition-colors px-2">
                <i class="fas fa-bell text-xl"></i>
                <span class="text-xs mt-1">Alerts</span>
            </a>
            <button
                class="mobile-menu-toggle flex flex-col items-center justify-center text-gray-600 hover:text-blue-500 transition-colors px-2">
                <i class="fas fa-bars text-2xl"></i>
                <span class="text-xs mt-1">Menu</span>
            </button>
            <!-- Profile dropdown toggle -->
            <div class="relative">
                <button id="profileToggle"
                    class="flex flex-col items-center text-gray-600 hover:text-blue-500 transition-colors px-2">
                    @if (Auth::user()->currentProfileImage)
                        <div class="relative">
                            <img src="{{ Storage::url(Auth::user()->currentProfileImage->path) }}"
                                alt="{{ Auth::user()->full_name }}" class="w-6 h-6 rounded-full object-cover">
                        </div>
                    @else
                        <i class="fas fa-user-circle text-xl"></i>
                    @endif
                    <span class="text-xs mt-1">Profile</span>
                </button>

                <!-- Profile dropdown menu -->
                <div id="profileDropdown"
                    class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-40 bg-white rounded-md shadow-lg py-1 hidden">
                    <a href="{{ route('profile', ['user_id' => Auth::id()]) }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-user mr-2"></i> My Profile
                    </a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-cog mr-2"></i> Settings
                    </a>
                    <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>

    <script>
        const currentUserId = "{{ auth()->id() }}";
        let currentChatUserId = null;
        let socket = null;

        // Initialize WebSocket when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            initializeWebSocket();
        });

        function initializeWebSocket() {
            socket = new WebSocket('ws://127.0.0.1:8082');

            socket.onopen = function() {
                console.log('WebSocket connection established');
                authenticateUser();
            };

            socket.onmessage = function(event) {
                const data = JSON.parse(event.data);
                switch (data.type) {
                    case 'follow_request':
                        handleFollowRequestNotification(data);
                        break;
                    case 'message':
                        handleIncomingMessage(data);
                        break;

                        // ... handle other message types if needed
                }
            };

            socket.onerror = function(error) {
                console.error('WebSocket error:', error);
            };

            socket.onclose = function() {
                console.log('WebSocket connection closed');
                setTimeout(initializeWebSocket, 3000); // Reconnect after 3 seconds
            };
        }

        function authenticateUser() {
            socket.send(JSON.stringify({
                type: 'auth',
                user_id: currentUserId
            }));
        }

        function handleFollowRequestNotification(data) {
            // Get the dropdown and container elements
            const dropdown = document.getElementById('usersDropdown');
            if (!dropdown) {
                console.error("Dropdown element not found");
                return;
            }

            const requestsContainer = dropdown.querySelector('.max-h-96');
            if (!requestsContainer) {
                console.error("Requests container not found");
                return;
            }

            if (data.pending_count != 0) {
                // Create new request element
                const requestElement = document.createElement('div');
                requestElement.className = 'px-4 py-3 hover:bg-gray-50 flex items-center follow-request-item';
                requestElement.dataset.followerId = data.follower_id;
                requestElement.innerHTML = `
                <img src="${data.follower_avatar || '/default-avatar.png'}" alt="User" class="w-10 h-10 rounded-full mr-3">
                <div class="flex-1">
                    <p class="font-medium">${data.follower_name}</p>
                    <p class="text-sm text-gray-500">Sent you a follow request</p>
                </div>
                <div class="flex space-x-2">
                    <button class="accept-follow text-green-500 hover:text-green-700" data-user-id="${data.follower_id}">
                        <i class="fas fa-check"></i>
                    </button>
                    <button class="decline-follow text-red-500 hover:text-red-700" data-user-id="${data.follower_id}">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;

                // Add the new request to the container
                requestsContainer.insertBefore(requestElement, requestsContainer.firstChild);


                // Show notification badge if dropdown is hidden
                const notificationBadge = document.getElementById('notificationBadge');
                if (notificationBadge && dropdown.classList.contains('hidden')) {
                    notificationBadge.classList.remove('hidden');
                }

                document.querySelectorAll('.accept-follow').forEach(button => {
                    button.addEventListener('click', function(e) {
                        handleFollowRequestAction(e, this, 'accept');
                    });
                });

                document.querySelectorAll('.decline-follow').forEach(button => {
                    button.addEventListener('click', function(e) {
                        handleFollowRequestAction(e, this, 'decline');
                    });
                });

                function handleFollowRequestAction(e, button, action) {
                    e.preventDefault();
                    const userId = button.getAttribute('data-user-id');
                    const url = `/users/${userId}/follow/${action}`;

                    // Get the parent container to replace with new state
                    const container = button.closest('.flex.space-x-2');
                    sendFollowRequest(button, url, true, container);
                }

                function sendFollowRequest(button, url, shouldReload = false, container = null) {
                    const userId = button.getAttribute('data-user-id');
                    // Save original state
                    const originalHTML = button.innerHTML;
                    const originalState = button.getAttribute('data-state') || '';

                    // Show loading state
                    button.disabled = true;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.error) {
                                showAlert('error', data.error);
                                return;
                            }

                            if (url.includes('/follow') && !url.includes('/cancel')) {
                                socket.send(JSON.stringify({
                                    type: 'follow_request',
                                    follower_id: "{{ auth()->id() }}",
                                    following_id: userId
                                }));
                            }

                            if (shouldReload) {
                                const currentPath = window.location.pathname;
                                if (currentPath.startsWith('/profile/')) {
                                    // We're already on a profile page, replace the ID
                                    window.location.href = `/profile/${userId}`;
                                } else {
                                    // Not on a profile page, use normal navigation
                                    window.location.href = `/profile/${userId}`;
                                }
                                // window.location.reload();
                            } else if (container) {
                                // Replace accept/decline buttons with follow state
                                updateContainerAfterResponse(container, data);
                            } else {
                                updateButtonState(button, data);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showAlert('error', 'An error occurred. Please try again.');
                        })
                        .finally(() => {
                            if (!shouldReload && !container) {
                                button.disabled = false;
                                if (!button.hasAttribute('data-updated')) {
                                    button.innerHTML = originalHTML;
                                }
                                button.removeAttribute('data-updated');
                            }
                        });
                }
                updatePendingRequestCount();
            }
        }

        function updatePendingRequestCount() {
            // Get current count from the DOM (if any requests exist)
            const currentCountElement = document.getElementById('pendingRequestCount');
            const requestItems = document.querySelectorAll('.follow-request-item');
            const newCount = requestItems.length;

            // Update the count badge
            if (currentCountElement) {
                currentCountElement.textContent = newCount;
                if (newCount > 0) {
                    currentCountElement.classList.remove('hidden');
                } else {
                    currentCountElement.classList.add('hidden');
                }
            }

            // Also update the dropdown badge if it exists
            const dropdownBadge = document.getElementById('notificationBadge');
            if (dropdownBadge) {
                dropdownBadge.textContent = newCount;
                if (newCount > 0) {
                    dropdownBadge.classList.remove('hidden');
                } else {
                    dropdownBadge.classList.add('hidden');
                }
            }
        }

        function getMessageNotificationCount(receiver_id) {
            console.log("hello from getMessageNotificationCount()", receiver_id);
            fetch(`/message-notification-count/${receiver_id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        receiver_id: receiver_id
                    })
                }).then(response => response.json())
                .then(messageNotificationCount => {
                    if (currentUserId === receiver_id) {
                        const badge = document.getElementById('message-notification-badge');
                        badge.textContent = messageNotificationCount.count;
                        console.log(messageNotificationCount.count);
                    }
                });
        }
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all follow-related buttons
            initFollowButtons();

            function initFollowButtons() {
                // Handle main follow button states
                document.querySelectorAll('.follow-button').forEach(button => {
                    button.addEventListener('click', function(e) {
                        handleFollowAction(e, this);
                    });
                });

                // Handle accept follow request
                document.querySelectorAll('.accept-follow').forEach(button => {
                    button.addEventListener('click', function(e) {
                        handleFollowRequestAction(e, this, 'accept');
                    });
                });

                // Handle decline follow request
                document.querySelectorAll('.decline-follow').forEach(button => {
                    button.addEventListener('click', function(e) {
                        handleFollowRequestAction(e, this, 'decline');
                    });
                });
            }

            function handleFollowAction(e, button) {
                e.preventDefault();

                const userId = button.getAttribute('data-user-id');
                const currentState = button.getAttribute('data-state');
                let url = `/users/${userId}/follow`;

                // Determine endpoint based on current state
                switch (currentState) {
                    case 'following':
                        url = `/users/${userId}/unfollow`;
                        break;
                    case 'requested':
                        url = `/users/${userId}/follow/cancel`;
                        break;
                    case 'pending':
                        url = `/users/${userId}/follow/accept`;
                        break;
                }

                sendFollowRequest(button, url);
            }

            function handleFollowRequestAction(e, button, action) {
                e.preventDefault();
                const userId = button.getAttribute('data-user-id');
                const url = `/users/${userId}/follow/${action}`;

                // Get the parent container to replace with new state
                const container = button.closest('.flex.space-x-2');
                sendFollowRequest(button, url, true, container);
            }

            function sendFollowRequest(button, url, shouldReload = false, container = null) {
                const userId = button.getAttribute('data-user-id');
                // Save original state
                const originalHTML = button.innerHTML;
                const originalState = button.getAttribute('data-state') || '';

                // Show loading state
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.error) {
                            showAlert('error', data.error);
                            return;
                        }

                        if (url.includes('/follow') && !url.includes('/cancel')) {
                            socket.send(JSON.stringify({
                                type: 'follow_request',
                                follower_id: "{{ auth()->id() }}",
                                following_id: userId
                            }));
                        }

                        if (shouldReload) {
                            const currentPath = window.location.pathname;
                            if (currentPath.startsWith('/profile/')) {
                                // We're already on a profile page, replace the ID
                                window.location.href = `/profile/${userId}`;
                            } else {
                                // Not on a profile page, use normal navigation
                                window.location.href = `/profile/${userId}`;
                            }
                            // window.location.reload();
                        } else if (container) {
                            // Replace accept/decline buttons with follow state
                            updateContainerAfterResponse(container, data);
                        } else {
                            updateButtonState(button, data);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('error', 'An error occurred. Please try again.');
                    })
                    .finally(() => {
                        if (!shouldReload && !container) {
                            button.disabled = false;
                            if (!button.hasAttribute('data-updated')) {
                                button.innerHTML = originalHTML;
                            }
                            button.removeAttribute('data-updated');
                        }
                    });
            }

            function updateContainerAfterResponse(container, data) {
                // Create new follow button based on response
                const newButton = document.createElement('button');
                newButton.className = 'follow-button bg-gray-200 text-black px-4 py-2 rounded-md';
                newButton.setAttribute('data-user-id', container.querySelector('button').getAttribute(
                    'data-user-id'));

                if (data.following) {
                    newButton.innerHTML = 'Following';
                    newButton.setAttribute('data-state', 'following');
                } else {
                    newButton.innerHTML = 'Follow';
                    newButton.setAttribute('data-state', 'follow');
                }

                // Replace the container with the new button
                container.parentNode.replaceChild(newButton, container);

                // Re-initialize event listeners
                newButton.addEventListener('click', function(e) {
                    handleFollowAction(e, this);
                });
            }

            function updateButtonState(button, data) {
                const stateClasses = {
                    'follow': ['bg-blue-500', 'text-white'],
                    'following': ['bg-gray-200', 'text-black'],
                    'requested': ['bg-yellow-500', 'text-white'],
                    'mutual': ['bg-green-500', 'text-white']
                };

                // Remove all state classes first
                Object.values(stateClasses).flat().forEach(cls => {
                    button.classList.remove(cls);
                });

                // Set new state
                if (data.status === 'pending' || data.status === 'requested') {
                    button.innerHTML = 'Requested';
                    button.setAttribute('data-state', 'requested');
                    button.classList.add(...stateClasses['requested']);
                } else if (data.mutual) {
                    button.innerHTML = 'Friends';
                    button.setAttribute('data-state', 'mutual');
                    button.classList.add(...stateClasses['mutual']);
                } else if (data.following) {
                    button.innerHTML = 'Following';
                    button.setAttribute('data-state', 'following');
                    button.classList.add(...stateClasses['following']);
                } else {
                    const followBack = button.getAttribute('data-follow-back') === 'true';
                    button.innerHTML = followBack ? 'Follow Back' : 'Follow';
                    button.setAttribute('data-state', 'follow');
                    button.classList.add(...stateClasses['follow']);
                }

                button.setAttribute('data-updated', 'true');
            }

            function showAlert(type, message) {
                // Replace with your preferred notification system
                alert(message);
            }
        });

        // Mobile Menu Toggle
        const mobileMenuToggles = document.querySelectorAll('.mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobileMenu');
        const contentArea = document.querySelector('.content-area');
        const body = document.body;

        // Profile Dropdown Toggle
        const profileToggle = document.getElementById('profileToggle');
        const profileDropdown = document.getElementById('profileDropdown');

        // Profile dropdown toggle
        profileToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('hidden');
            mobileMenu.classList.remove('active'); // Close mobile menu if open
            contentArea.classList.remove('no-scroll');
            body.classList.remove('no-scroll');
        });

        // Close dropdown when pressing Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (!profileDropdown.classList.contains('hidden')) {
                    profileDropdown.classList.add('hidden');
                }
                if (mobileMenu.classList.contains('active')) {
                    mobileMenu.classList.remove('active');
                    contentArea.classList.remove('no-scroll');
                    body.classList.remove('no-scroll');
                }
            }
        });

        // Add click event to all mobile menu toggle buttons
        mobileMenuToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.stopPropagation();
                mobileMenu.classList.toggle('active');
                profileDropdown.classList.add('hidden'); // Close profile dropdown if open

                // Toggle scroll lock based on menu state
                if (mobileMenu.classList.contains('active')) {
                    contentArea.classList.add('no-scroll');
                    body.classList.add('no-scroll');
                } else {
                    contentArea.classList.remove('no-scroll');
                    body.classList.remove('no-scroll');
                }
            });
        });
        // Close menus when clicking outside
        document.addEventListener('click', function(event) {
            // Check for mobile menu
            const isClickInsideMenu = mobileMenu.contains(event.target);
            const isClickOnToggle = Array.from(mobileMenuToggles).some(toggle =>
                toggle.contains(event.target)
            );

            // Check for profile dropdown
            const isClickOnProfile = profileToggle.contains(event.target);
            const isClickInsideDropdown = profileDropdown.contains(event.target);

            // Close mobile menu if needed
            if (!isClickInsideMenu && !isClickOnToggle && mobileMenu.classList.contains('active')) {
                mobileMenu.classList.remove('active');
                contentArea.classList.remove('no-scroll');
                body.classList.remove('no-scroll');
            }

            // Close profile dropdown if needed
            if (!isClickOnProfile && !isClickInsideDropdown && !profileDropdown.classList.contains('hidden')) {
                profileDropdown.classList.add('hidden');
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            const usersButton = document.getElementById('usersButton');
            const usersDropdown = document.getElementById('usersDropdown');
            const notifButton = document.getElementById('notifButton');
            const notifDropdown = document.getElementById('notifDropdown');

            // Toggle users dropdown
            usersButton.addEventListener('click', function(e) {
                e.stopPropagation();
                usersDropdown.classList.toggle('hidden');
                notifDropdown.classList.add('hidden');
            });

            // Toggle notifications dropdown
            notifButton.addEventListener('click', function(e) {
                e.stopPropagation();
                notifDropdown.classList.toggle('hidden');
                usersDropdown.classList.add('hidden');
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function() {
                usersDropdown.classList.add('hidden');
                notifDropdown.classList.add('hidden');
            });

            // Close dropdowns when clicking on dropdown content (optional)
            [usersDropdown, notifDropdown].forEach(dropdown => {
                dropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });
        });
        // Search Functionality Start Here
        document.addEventListener('DOMContentLoaded', function() {
            const searchRoute = "{{ route('users.search') }}"; // Your existing route

            // Handle both desktop and mobile search inputs
            document.querySelectorAll('.user-search-input').forEach(searchInput => {
                const searchResults = searchInput.nextElementSibling.nextElementSibling;

                if (!searchInput || !searchResults) return;

                let searchTimeout;

                searchInput.addEventListener('input', function(e) {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        const query = e.target.value.trim();

                        if (query.length < 2) {
                            searchResults.classList.add('hidden');
                            return;
                        }

                        // Loading state
                        searchResults.innerHTML = `
                    <div class="p-3 text-center text-gray-500">
                        <i class="fas fa-spinner fa-spin mr-2"></i> Searching...
                    </div>`;
                        searchResults.classList.remove('hidden');

                        fetch(`${searchRoute}?query=${encodeURIComponent(query)}`)
                            .then(response => {
                                if (!response.ok) throw new Error(
                                    'Network response was not ok');
                                return response.json();
                            })
                            .then(users => {
                                searchResults.innerHTML = '';

                                if (users.length === 0) {
                                    searchResults.innerHTML = `
                                <div class="p-3 text-center text-gray-500">
                                    No users found
                                </div>`;
                                    return;
                                }

                                users.forEach(user => {
                                    const userElement = document.createElement(
                                        'a');
                                    userElement.href = `/profile/${user.id}`;
                                    userElement.className =
                                        'flex items-center p-3 border-b border-gray-100 hover:bg-gray-50';

                                    userElement.innerHTML = `
                                ${user.image ? 
                                    `<img src="${user.image}" class="w-8 h-8 rounded-full mr-3" alt="${user.full_name}">` : 
                                    '<div class="w-8 h-8 rounded-full bg-gray-200 mr-3 flex items-center justify-center">' +
                                    '<i class="fas fa-user text-gray-500 text-sm"></i></div>'
                                }
                                <div>
                                    <div class="font-medium text-sm">${user.full_name}</div>
                                    <div class="text-gray-500 text-xs">${user.email}</div>
                                </div>
                            `;

                                    searchResults.appendChild(userElement);
                                });
                            })
                            .catch(error => {
                                searchResults.innerHTML = `
                            <div class="p-3 text-center text-red-500">
                                <i class="fas fa-exclamation-circle mr-1"></i> Search failed
                            </div>`;
                                console.error('Search error:', error);
                            });
                    }, 300);
                });

                // Hide results when clicking outside
                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                        searchResults.classList.add('hidden');
                    }
                });

                // Mobile-specific touch handling
                if ('ontouchstart' in window) {
                    searchInput.addEventListener('focus', function() {
                        if (searchInput.value.trim().length >= 2) {
                            searchResults.classList.remove('hidden');
                        }
                    });
                }
            });
        });

        // Chat Code Start Here
        function setupEventListeners() {
            const usersListView = document.getElementById('usersListView');
            const chatView = document.getElementById('chatView');
            const backButton = document.getElementById('backButton');
            const userItems = document.querySelectorAll('.user-item');
            const messageInput = document.getElementById('messageInput');
            const sendButton = document.querySelector('.message-input-container button');
            const chatArea = document.getElementById('chatArea');
            const chatAvatarContainer = document.getElementById('chatAvatarContainer'); // Changed this


            // Handle user selection
            userItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Set current chat user
                    currentChatUserId = this.dataset.userId;
                    const userName = this.querySelector('.font-medium').textContent;
                    const userImage = this.querySelector('img').src;
                    // const chatAvatar = document.getElementById('chatAvatar');
                    // Update UI
                    if (chatAvatarContainer) {
                        chatAvatarContainer.innerHTML = `
                    <img src="${userImage}" alt="${userName}" class="w-10 h-10 rounded-full">
                `;
                    }
                    document.getElementById('chatUserName').textContent = userName;
                    // chatAvatar.outerHTML =
                    //     `<img src="${userImage}" alt="${userName}" class="w-10 h-10 rounded-full">`;

                    const messageInputContainer = document.querySelector('.message-input-container');
                    messageInputContainer.classList.remove('hidden');

                    // chatAvatar.classList.remove('hidden');
                    messageInput.disabled = false;

                    // Load chat history
                    loadChatHistory(currentChatUserId);

                    // Mobile view handling
                    if (window.innerWidth < 768) {
                        usersListView.classList.add('hidden');
                        usersListView.classList.remove('flex');
                        chatView.classList.remove('hidden');
                        chatView.classList.add('flex');
                    }
                });
            });

            // Handle back button on mobile
            backButton.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    usersListView.classList.remove('hidden');
                    usersListView.classList.add('flex');
                    chatView.classList.add('hidden');
                    chatView.classList.remove('flex');
                }
            });

            // Handle message sending via button click
            sendButton.addEventListener('click', sendCurrentMessage);

            // Handle message sending via Enter key
            messageInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    sendCurrentMessage();
                }
            });
        }

        function sendCurrentMessage() {
            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value.trim();

            if (message && currentChatUserId) {
                sendMessage(message);
                messageInput.value = '';
            }
        }

        function sendMessage(message) {
            if (socket.readyState === WebSocket.OPEN && currentChatUserId) {
                // Generate a temporary ID for the message before we get the real one from server
                const tempMessageId = 'temp-' + Date.now();

                // Send the message
                socket.send(JSON.stringify({
                    type: 'message',
                    sender_id: currentUserId,
                    receiver_id: currentChatUserId,
                    message: message,
                    temp_id: tempMessageId // Send temporary ID to match later
                }));

                document.getElementById('messageInput').value = '';
            } else {
                console.error('WebSocket is not connected or no chat selected');
            }
        }

        function handleIncomingMessage(data) {
            switch (data.type) {
                case 'message':
                    const isSender = data.sender_id == currentUserId;
                    const otherUserId = isSender ? data.receiver_id : data.sender_id;

                    const showUnreadCount = !isSender;
                    updateChatListItem(
                        otherUserId,
                        data.message,
                        data.created_at,
                        isSender,
                        showUnreadCount ? data.unread_count : 0
                    );

                    // Only display if:
                    // 1. It's to/from the current chat user AND we don't have it already
                    // 2. Or it's our own message in the current chat (for confirmation)
                    const isCurrentChatMessage = data.sender_id === currentChatUserId ||
                        data.receiver_id === currentChatUserId;

                    const alreadyExists = document.querySelector(`[data-message-id="${data.temp_id || data.message_id}"]`);
                    getMessageNotificationCount(data.receiver_id)
                    if (isCurrentChatMessage && !alreadyExists) {
                        appendMessage(
                            data.sender_id,
                            data.message,
                            data.created_at,
                            isSender,
                            isSender,
                            data.message_id,
                            data.senderAvatar
                        );

                        if (!isSender) markMessageAsRead(data.message_id);
                    }

                    // Update temporary ID if this is our message
                    if (data.temp_id && isSender) {
                        updateMessageId(data.temp_id, data.message_id);
                    }
                    break;

                case 'delivery':
                    updateMessageStatus(data.message_id, data.status);
                    break;

                default:
                    console.log('Unhandled message type:', data.type);
            }
        }

        function updateChatListItem(userId, message, timestamp, isSender, unreadCount) {
            const userElement = document.getElementById(`user-${userId}`);
            if (!userElement) return;

            // Hide PHP-rendered message
            const phpMessageDiv = userElement.querySelector('.php-last-message');
            if (phpMessageDiv) {
                phpMessageDiv.classList.add('hidden');
            }

            // Show and update WebSocket message
            const wsMessageDiv = userElement.querySelector('.websocket-last-message');
            if (wsMessageDiv) {
                wsMessageDiv.classList.remove('hidden');

                // Format the message text
                const messageText = isSender ? `You: ${message}` : message;

                // Create the badge only if unreadCount > 0 and current user is receiver
                const badge = unreadCount > 0 && !isSender ?
                    `<span class="bg-green-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">${unreadCount}</span>` :
                    '';

                // Update the content
                wsMessageDiv.innerHTML = `
            <p class="text-sm text-gray-600 truncate">${messageText}</p>
            <span class="time">${formatTime(timestamp)}</span>
            ${badge}
        `;
            }

            // Update timestamp in the header if needed
            const timeElement = userElement.querySelector('.text-xs.text-gray-500');
            if (timeElement) {
                timeElement.textContent = formatTime(timestamp);
            }
        }

        function updateMessageId(tempId, realId) {
            const messageDiv = document.querySelector(`[data-message-id="${tempId}"]`);
            if (messageDiv) {
                messageDiv.dataset.messageId = realId;
            }
        }

        function appendMessage(senderId, message, timestamp, isSender = false, isRead = true, messageId = null,
            senderAvatar = null) {
            const chatArea = document.getElementById('chatArea');
            const messageDiv = document.createElement('div');

            if (messageId) messageDiv.dataset.messageId = messageId;

            messageDiv.className = `flex ${isSender ? 'justify-end' : ''} mb-4`;
            messageDiv.innerHTML = `
            ${!isSender ? `
                                                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-2 mt-1">
                                                                    <img src="${senderAvatar}" 
                                                         alt="User avatar" 
                                                         class="w-full h-full object-cover rounded-full">
                                                                </div>
                                                            ` : ''}
            <div>
                <div class="${isSender ? 'bg-green-100' : 'bg-white'} rounded-lg ${isSender ? 'rounded-tr-none' : 'rounded-tl-none'} p-3 shadow-sm max-w-xs md:max-w-md">
                    <p class="text-gray-800">${message}</p>
                    <p class="text-xs text-gray-500 mt-1 text-right">
                        ${formatTime(timestamp)}
                        ${isSender ? `<i class="fas fa-check-double message-status ${isRead ? 'delivered' : 'sent'} ml-1"></i>` : ''}
                    </p>
                </div>
            </div>
        `;

            chatArea.appendChild(messageDiv);
            scrollToBottom();
        }

        function formatTime(timestamp) {
            return new Date(timestamp).toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
        }


        function loadChatHistory(userId) {
            fetch(`/messages/${userId}`)
                .then(response => response.json())
                .then(messages => {
                    const chatArea = document.getElementById('chatArea');
                    chatArea.innerHTML = '';

                    messages.forEach(msg => {
                        const isSender = msg.sender_id == currentUserId;
                        appendMessage(
                            msg.sender_id,
                            msg.message,
                            msg.created_at,
                            isSender,
                            msg.is_read,
                            msg.id,
                            msg.sender_avatar
                        );
                    });

                    scrollToBottom();
                });
        }

        function markMessageAsRead(messageId) {
            fetch(`/messages/${messageId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            });
        }

        function updateMessageStatus(messageId, status) {
            // Find all check icons for this message and update their color
            document.querySelectorAll(`[data-message-id="${messageId}"] .message-status`).forEach(icon => {
                icon.classList.toggle('delivered', status === 'delivered');
                icon.classList.toggle('sent', status !== 'delivered');
            });
        }

        function scrollToBottom() {
            const chatArea = document.getElementById('chatArea');
            chatArea.scrollTop = chatArea.scrollHeight;
        }
    </script>
    @yield('scripts')
</body>

</html>
