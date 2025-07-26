@extends('layouts.frontend')
@section('title','On Track Eductaion - Messaging')
@section('content')
<div class="container mx-auto px-4 mt-[50px] md:mt-0 py-6 flex flex-col md:flex-row gap-6">
    <div class="flex h-screen w-full shadow-lg">
        <!-- Left Sidebar - Users List -->
        <div class="h-full border-r border-gray-300 bg-white flex flex-col mobile-users-view" id="usersListView">
            <!-- User header -->
            <div class="bg-gray-100 p-3 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center mr-2">
                        <i class="fas fa-user text-gray-600"></i>
                    </div>
                    <span class="font-medium">My Profile</span>
                </div>
                <div class="flex space-x-4 text-gray-500">
                    <i class="fas fa-users"></i>
                    <i class="fas fa-comment-dots"></i>
                    <i class="fas fa-ellipsis-vertical"></i>
                </div>
            </div>

            <!-- Search -->
            <div class="p-2 bg-white border-b border-gray-200">
                <div class="relative">
                    <input type="text" placeholder="Search or start new chat"
                        class="w-full bg-gray-100 rounded-lg py-2 px-4 pl-10 text-sm focus:outline-none">
                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-500 text-sm"></i>
                </div>
            </div>

            <!-- Chats List -->
            <div class="flex-1 overflow-y-auto">
                <!-- Chat list items -->
                <div class="chat-list-item flex items-center p-3 border-b border-gray-100 cursor-pointer user-item"
                    data-user="john">
                    <div class="relative mr-3">
                        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                            <i class="fas fa-user text-green-600"></i>
                        </div>
                        <span
                            class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <h3 class="font-medium">John Doe</h3>
                            <span class="text-xs text-gray-500">10:30 AM</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-sm text-gray-600 truncate">Hey, how are you doing? 😊</p>
                            <span
                                class="bg-green-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">3</span>
                        </div>
                    </div>
                </div>

                <div class="chat-list-item flex items-center p-3 border-b border-gray-100 cursor-pointer user-item"
                    data-user="sarah">
                    <div class="relative mr-3">
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <h3 class="font-medium">Sarah Smith</h3>
                            <span class="text-xs text-gray-500">Yesterday</span>
                        </div>
                        <p class="text-sm text-gray-600 truncate">Meeting at 2pm tomorrow</p>
                    </div>
                </div>

                <div class="chat-list-item flex items-center p-3 border-b border-gray-100 cursor-pointer user-item"
                    data-user="group">
                    <div class="relative mr-3">
                        <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                            <i class="fas fa-users text-purple-600"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <h3 class="font-medium">Work Group</h3>
                            <span class="text-xs text-gray-500">Yesterday</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-sm text-gray-600 truncate">Alex: I'll send the files</p>
                            <span class="text-xs text-gray-400"><i class="fas fa-check-double"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel - Chat Area -->
        <div class="h-full flex flex-col bg-gray-50 mobile-chat-view" id="chatView">
            <!-- Chat header with back button for mobile -->
            <div class="bg-gray-100 p-3 flex justify-between items-center border-b border-gray-200">
                <div class="flex items-center">
                    <button id="backButton" class="md:hidden mr-2 text-gray-500">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                        <i class="fas fa-user text-green-600" id="chatAvatar"></i>
                    </div>
                    <div>
                        <h2 class="font-medium" id="chatUserName">John Doe</h2>
                        <p class="text-xs text-gray-500" id="chatStatus">Online</p>
                    </div>
                </div>
                <div class="flex space-x-4 text-gray-500">
                    <i class="fas fa-search"></i>
                    <i class="fas fa-phone"></i>
                    <i class="fas fa-video"></i>
                    <i class="fas fa-ellipsis-vertical"></i>
                </div>
            </div>

            <!-- Messages area -->
            <div class="flex-1 overflow-y-auto p-4 bg-[#e5ddd5] bg-opacity-30" id="chatArea">
                <!-- Date divider -->
                <div class="flex justify-center my-4">
                    <span class="px-3 py-1 text-xs text-gray-600 bg-gray-200 rounded-full">Today</span>
                </div>

                <!-- Received message -->
                <div class="flex mb-4">
                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-2 mt-1">
                        <i class="fas fa-user text-green-600 text-sm"></i>
                    </div>
                    <div>
                        <div class="bg-white rounded-lg rounded-tl-none p-3 shadow-sm max-w-xs md:max-w-md">
                            <p class="text-gray-800">Hey there! How's it going?</p>
                            <p class="text-xs text-gray-500 mt-1 text-right">10:30 AM</p>
                        </div>
                    </div>
                </div>

                <!-- Sent message -->
                <div class="flex justify-end mb-4">
                    <div>
                        <div class="bg-green-100 rounded-lg rounded-tr-none p-3 shadow-sm max-w-xs md:max-w-md">
                            <p class="text-gray-800">I'm doing great! Working on that project we discussed.</p>
                            <p class="text-xs text-gray-500 mt-1 text-right">10:32 AM <i
                                    class="fas fa-check-double text-blue-500 ml-1"></i></p>
                        </div>
                    </div>
                </div>

                <!-- Received message -->
                <div class="flex mb-4">
                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-2 mt-1">
                        <i class="fas fa-user text-green-600 text-sm"></i>
                    </div>
                    <div>
                        <div class="bg-white rounded-lg rounded-tl-none p-3 shadow-sm max-w-xs md:max-w-md">
                            <p class="text-gray-800">That's awesome! Can you share your progress?</p>
                            <p class="text-xs text-gray-500 mt-1 text-right">10:33 AM</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Message input -->
            {{-- <div class="bg-gray-100 p-3 flex items-center">
                <div class="flex space-x-2 text-gray-500 mr-2">
                    <i class="fas fa-face-smile text-xl"></i>
                    <i class="fas fa-paperclip text-xl"></i>
                </div>
                <input type="text" placeholder="Type a message"
                    class="flex-1 bg-white rounded-lg py-2 px-4 focus:outline-none" id="messageInput">
                <button class="ml-2 text-gray-500 hover:text-gray-700">
                    <i class="fas fa-microphone text-xl"></i>
                </button>
            </div> --}}
            <!-- Replace the current message input div with this -->
            <div class="message-input-container">
                <div class="bg-gray-100 p-3 flex items-center">
                    <div class="flex space-x-2 text-gray-500 mr-2">
                        <i class="fas fa-face-smile text-xl"></i>
                        <i class="fas fa-paperclip text-xl"></i>
                    </div>
                    <input type="text" placeholder="Type a message"
                        class="flex-1 bg-white rounded-lg py-2 px-4 focus:outline-none" id="messageInput">
                    <button class="ml-2 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-microphone text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const usersListView = document.getElementById('usersListView');
            const chatView = document.getElementById('chatView');
            const backButton = document.getElementById('backButton');
            const userItems = document.querySelectorAll('.user-item');

            // Initialize view based on screen size
            function initView() {
                if (window.innerWidth >= 768) {
                    // Desktop - show both views
                    usersListView.style.display = 'flex';
                    chatView.style.display = 'flex';
                } else {
                    // Mobile - show only users list initially
                    usersListView.style.display = 'flex';
                    chatView.style.display = 'none';
                }
            }

            // Handle user selection
            userItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Update active state
                    userItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');

                    // Update chat header
                    const userName = this.querySelector('.font-medium').textContent;
                    document.getElementById('chatUserName').textContent = userName;

                    // On mobile, switch to chat view
                    if (window.innerWidth < 768) {
                        usersListView.style.display = 'none';
                        chatView.style.display = 'flex';
                    }
                });
            });

            // Handle back button
            backButton.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    usersListView.style.display = 'flex';
                    chatView.style.display = 'none';
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                initView();
            });

            // Initialize the view
            initView();

            // Select first user by default
            if (userItems.length > 0) {
                userItems[0].classList.add('active');
            }
        });

        // Add this to your existing script
        document.getElementById('messageInput').addEventListener('focus', function() {
            if (window.innerWidth < 768) {
                // Scroll to bottom when input is focused
                setTimeout(() => {
                    document.getElementById('chatArea').scrollTop = document.getElementById('chatArea')
                        .scrollHeight;
                }, 300);
            }
        });
    </script>
@endsection
@endsection
