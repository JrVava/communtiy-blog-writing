@extends('layouts.frontend')
@section('title', 'On Track Eductaion - Messaging')
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
                    @foreach ($friends as $friend)
                        <div class="chat-list-item flex items-center p-3 border-b border-gray-100 cursor-pointer user-item"
                            data-user="john" data-user-id="{{ $friend->id }}">
                            <div class="relative mr-3">
                                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="fas fa-user text-green-600"></i>
                                </div>
                                <span
                                    class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <h3 class="font-medium">{{ $friend->full_name }}</h3>
                                    <span class="text-xs text-gray-500">10:30 AM</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <p class="text-sm text-gray-600 truncate">Hey, how are you doing? 😊</p>
                                    <span
                                        class="bg-green-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">3</span>
                                </div>
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
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                            <i class="fas fa-user text-green-600" id="chatAvatar"></i>
                        </div>
                        <div>
                            <h2 class="font-medium" id="chatUserName">John Doe</h2>
                            <p class="text-xs text-gray-500" id="chatStatus">Online</p>
                        </div>
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
                <!-- Replace the current message input div with this -->
                <div class="message-input-container">
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
        const currentUserId = "{{ auth()->id() }}";
        let currentChatUserId = null;
        let socket;

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize WebSocket connection
            initializeWebSocket();

            // Set up UI event handlers
            setupEventListeners();
        });

        function initializeWebSocket() {
            socket = new WebSocket('ws://127.0.0.1:8082');

            socket.onopen = function() {
                console.log('WebSocket connection established');
                authenticateUser();
            };

            socket.onmessage = function(event) {
                const data = JSON.parse(event.data);
                handleIncomingMessage(data);
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

        function setupEventListeners() {
            const usersListView = document.getElementById('usersListView');
            const chatView = document.getElementById('chatView');
            const backButton = document.getElementById('backButton');
            const userItems = document.querySelectorAll('.user-item');
            const messageInput = document.getElementById('messageInput');
            const sendButton = document.querySelector('.message-input-container button');
            const chatArea = document.getElementById('chatArea');

            // Handle user selection
            userItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Set current chat user
                    currentChatUserId = this.dataset.userId;
                    const userName = this.querySelector('.font-medium').textContent;

                    // Update UI
                    document.getElementById('chatUserName').textContent = userName;
                    messageInput.disabled = false;

                    // Load chat history
                    loadChatHistory(currentChatUserId);

                    // Mobile view handling
                    if (window.innerWidth < 768) {
                        usersListView.style.display = 'none';
                        chatView.style.display = 'flex';
                    }
                });
            });

            // Handle back button on mobile
            backButton.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    usersListView.style.display = 'flex';
                    chatView.style.display = 'none';
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

                // Add message to UI immediately with temporary ID
                // appendMessage(
                //     currentUserId,
                //     message,
                //     new Date().toISOString(),
                //     true,
                //     false,
                //     tempMessageId
                // );

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
                
                // Only display if:
                // 1. It's to/from the current chat user AND we don't have it already
                // 2. Or it's our own message in the current chat (for confirmation)
                const isCurrentChatMessage = data.sender_id === currentChatUserId || 
                                           data.receiver_id === currentChatUserId;
                
                const alreadyExists = document.querySelector(`[data-message-id="${data.temp_id || data.message_id}"]`);
                
                if (isCurrentChatMessage && !alreadyExists) {
                    appendMessage(
                        data.sender_id,
                        data.message,
                        data.created_at,
                        isSender,
                        isSender,
                        data.message_id
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

        function updateMessageId(tempId, realId) {
            const messageDiv = document.querySelector(`[data-message-id="${tempId}"]`);
            if (messageDiv) {
                messageDiv.dataset.messageId = realId;
            }
        }

        function appendMessage(senderId, message, timestamp, isSender = false, isRead = true, messageId = null) {
        const chatArea = document.getElementById('chatArea');
        const messageDiv = document.createElement('div');
        
        if (messageId) messageDiv.dataset.messageId = messageId;
        
        messageDiv.className = `flex ${isSender ? 'justify-end' : ''} mb-4`;
        messageDiv.innerHTML = `
            ${!isSender ? `
                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-2 mt-1">
                    <i class="fas fa-user text-green-600 text-sm"></i>
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
        return new Date(timestamp).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
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
                        msg.id
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
@endsection
@endsection
