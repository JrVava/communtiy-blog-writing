<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ secure_asset('assets/img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ secure_asset('assets/img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ secure_asset('assets/img/favicon/favicon-16x16.png') }}">
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
                        <span
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                    </button>
                    <!-- Friend Requests Dropdown -->
                    <div id="usersDropdown"
                        class="absolute right-0 mt-2 w-72 bg-white rounded-lg shadow-lg py-2 hidden">
                        <div class="px-4 py-2 border-b border-gray-100">
                            <h3 class="font-semibold">Friend Requests</h3>
                        </div>
                        <div class="max-h-96 overflow-y-auto">
                            <!-- Friend Request Item -->
                            <div class="px-4 py-3 hover:bg-gray-50 flex items-center">
                                <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="User"
                                    class="w-10 h-10 rounded-full mr-3">
                                <div class="flex-1">
                                    <p class="font-medium">John Doe</p>
                                    <p class="text-sm text-gray-500">Sent you a friend request</p>
                                </div>
                                <div class="flex space-x-2">
                                    <button class="text-green-500 hover:text-green-700">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- More requests... -->
                        </div>
                        <a href="#" class="block px-4 py-2 text-center text-blue-500 hover:bg-gray-50">See All</a>
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

                <a href="{{ route('chats') }}" class="text-gray-600 hover:text-blue-500 transition-colors">
                    <i class="fas fa-comment-dots text-2xl"></i>
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
                    <i class="fas fa-user-circle text-2xl"></i>
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
                <img src="https://communtiy-blog.test/assets/img/logo.png" alt="Community Logo" class="h-8">
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
                    <i class="fas fa-user-circle text-xl"></i>
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
    @yield('scripts')
    <script>
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
    </script>
</body>

</html>
