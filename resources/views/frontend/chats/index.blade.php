@extends('layouts.frontend')
@section('title', 'On Track Eductaion - Messaging')
@section('content')
    <div class="container mx-auto px-4 mt-[50px] md:mt-0 py-6 flex flex-col md:flex-row gap-6">
        <div class="flex h-[80vh] w-full shadow-lg">
            <!-- Left Sidebar - Users List -->
            <div class="h-full border-r border-gray-300 bg-white flex flex-col mobile-users-view" id="usersListView">
                <!-- User header -->
                <div class="bg-gray-100 p-3 flex justify-between items-center">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center mr-2">
                            <img src="@if (isset(Auth::user()->currentProfileImage->path)) {{ Storage::url(Auth::user()->currentProfileImage->path) }} @else {{ secure_asset('assets/img/dummy-user.jpg') }} @endif"
                                alt="User" class="w-8 h-8 rounded-full mt-1">
                        </div>
                        <span class="font-medium">My Profile</span>
                    </div>
                    <div class="flex space-x-4 text-gray-500">
                    </div>
                </div>

                <!-- Chats List -->
                <div class="flex-1 overflow-y-auto">
                    <!-- Chat list items -->
                    @foreach ($friends as $friend)
                        <div class="chat-list-item flex items-center p-3 border-b border-gray-100 cursor-pointer user-item"
                            id="user-{{ $friend['id'] }}" data-user-id="{{ $friend['id'] }}">
                            <div class="relative mr-3">
                                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                                    <img src="{{ $friend['avatar'] }}" alt="User" class="w-8 h-8 rounded-full mt-1">
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <h3 class="font-medium">{{ $friend['full_name'] }}</h3>
                                    <span class="text-xs text-gray-500">10:30 AM</span>
                                </div>
                                <div class="flex justify-between items-center php-last-message">
                                    <p class="text-sm text-gray-600 truncate">
                                        @if ($friend['is_sender'])
                                            You:
                                        @endif
                                        {{ $friend['last_message'] ? Str::limit($friend['last_message'], 30) : 'No messages yet' }}
                                    </p>
                                    <span
                                        class="time">{{ $friend['last_message_time'] ? $friend['last_message_time']->diffForHumans() : '' }}</span>
                                    </p>
                                    @if ($friend['unread_count'])
                                        <span
                                            class="bg-green-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">{{ $friend['unread_count'] }}</span>
                                    @endif
                                </div>
                                <div class="flex justify-between items-center websocket-last-message hidden"></div>
                            </div>
                        </div>
                    @endforeach
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
                        <div id="chatAvatarContainer" class="w-10 h-10 rounded-full bg-gray-100 overflow-hidden mr-3">
                            <i id="chatAvatarIcon" class="text-gray-400 text-lg"></i>
                        </div>
                        <div>
                            <h2 class="font-medium" id="chatUserName"></h2>
                        </div>
                    </div>
                </div>

                <!-- Messages area -->
                <div class="flex-1 overflow-y-auto p-4 bg-[#e5ddd5] bg-opacity-30" id="chatArea">
                </div>

                <!-- Message input -->
                <!-- Replace the current message input div with this -->
                <div class="message-input-container hidden">
                    <div class="bg-gray-100 p-3 flex items-center">
                        <input type="text" placeholder="Type a message"
                            class="flex-1 bg-white rounded-lg py-2 px-4 focus:outline-none" id="messageInput">
                        <button class="ml-2 text-gray-500 hover:text-gray-700">
                            <i class="fas fa-paper-plane text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize WebSocket connection
            // initializeWebSocket();
            if (window.innerWidth < 768) {
                const chatArea = document.getElementById('chatView');
                chatArea.classList.add('hidden');
            }

            // Set up UI event handlers
            setupEventListeners();
        });
    </script>
@endsection
@endsection
