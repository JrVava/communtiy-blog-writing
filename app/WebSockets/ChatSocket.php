<?php

namespace App\WebSockets;

use App\Models\Follow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use App\Models\Message;
use App\Models\User;

class ChatSocket implements MessageComponentInterface
{
    protected $clients;
    protected $userConnections;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        $this->userConnections = [];
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);

        if (!$data) {
            $from->send(json_encode(['error' => 'Invalid JSON']));
            return;
        }

        switch ($data['type'] ?? '') {
            case 'auth':
                $this->authenticateUser($from, $data['user_id']);
                break;

            case 'message':
                $this->handleChatMessage($from, $data);
                break;

            case 'follow_request':
                $this->handleFollowRequest($from, $data);
                break;

            case 'follow_response':
                $this->handleFollowResponse($from, $data);
                break;

            case 'notification':
                $this->getNotification($from, $data);
                break;
            case 'ping':
                $from->send(json_encode(['type' => 'pong']));
                break;

            default:
                $from->send(json_encode(['error' => 'Unknown message type']));
        }
    }

    protected function authenticateUser($conn, $userId)
    {
        $this->userConnections[$userId] = $conn;
        $conn->send(json_encode([
            'type' => 'system',
            'message' => 'Authentication successful'
        ]));
    }

    protected function getNotification($from, $data)
    {
        if (!isset($data['post_id'], $data['post_owner_id'], $data['user_id'], $data['type'])) {
            $from->send(json_encode(['error' => 'Missing required fields']));
            return;
        }

        // Don't notify if user is reacting to their own post
        if ($data['user_id'] == $data['post_owner_id']) {
            return;
        }

        // Get post owner's connection if available
        if (isset($this->userConnections[$data['post_owner_id']])) {
            $postOwnerConnection = $this->userConnections[$data['post_owner_id']];

            // Send notification to post owner
            $postOwnerConnection->send(json_encode([
                'type' => 'notification', // reaction_notification
                'post_id' => $data['post_id'],
                'post_owner_id' => $data['post_owner_id'],
                'user_id' => $data['user_id']
            ]));
        }
    }

    protected function handleFollowRequest($from, $data)
    {
        $followerId = $data['follower_id'];
        $followingId = $data['following_id'] != Auth::id() ? $data['following_id'] : Auth::id();

        // Get the count of pending requests for the user being followed
        $pendingCount = Follow::where('following_id', $followingId)
            ->where('status', Follow::STATUS_PENDING)
            ->count();

        // Notify the user being followed
        if (isset($this->userConnections[$followingId])) {
            $this->userConnections[$followingId]->send(json_encode([
                'type' => 'follow_request',
                'follower_id' => $followerId,
                'following_id' => $followingId,
                'follower_name' => User::find($followerId)->full_name,
                'follower_avatar' => isset(User::find($followerId)->currentProfileImage->path) ? Storage::url(User::find($followerId)->currentProfileImage->path) : secure_asset('assets/img/dummy-user.jpg'),
                'timestamp' => now()->toDateTimeString(),
                'pending_count' => $pendingCount
            ]));
        }
    }

    protected function handleFollowResponse($from, $data)
    {
        $followerId = $data['follower_id'];
        $followingId = $data['following_id'];
        $action = $data['action']; // 'accept' or 'decline'

        // Notify the original requester about the response
        if (isset($this->userConnections[$followerId])) {
            $this->userConnections[$followerId]->send(json_encode([
                'type' => 'follow_response',
                'following_id' => $followingId,
                'action' => $action,
                'following_name' => User::find($followingId)->name,
                'timestamp' => now()->toDateTimeString()
            ]));
        }
    }

    protected function handleChatMessage($from, $data)
    {
        $message = $data['message'];
        $senderId = $data['sender_id'];
        $receiverId = $data['receiver_id'];

        // Save to database
        $messageModel = Message::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'message' => $message,
            'is_read' => false
        ]);

        // Get total unread messages count for this conversation
        $unReadMessages = Message::where('receiver_id', $receiverId)
            ->where('sender_id', $senderId)
            ->where('is_read', false)
            ->count();

        // Get the last message between these users
        $lastMessage = Message::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)
                ->where('receiver_id', $receiverId);
        })
            ->orWhere(function ($query) use ($senderId, $receiverId) {
                $query->where('sender_id', $receiverId)
                    ->where('receiver_id', $senderId);
            })
            ->latest()
            ->first();

        // Prepare response
        $response = [
            'type' => 'message',
            'message_id' => $messageModel->id,
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'message' => $message,
            'created_at' => $messageModel->created_at->toDateTimeString(),
            'is_read' => false,
            'unread_count' => $unReadMessages,
            'last_message' => $lastMessage->message,
            'senderAvatar' => isset(User::find($senderId)->currentProfileImage->path) ? Storage::url(User::find($senderId)->currentProfileImage->path) : secure_asset('assets/img/dummy-user.jpg'),
        ];

        // Send to receiver if online
        if (isset($this->userConnections[$receiverId])) {
            $this->userConnections[$receiverId]->send(json_encode($response));
        }

        // Send delivery confirmation to sender
        if (isset($this->userConnections[$senderId])) {
            $this->userConnections[$senderId]->send(json_encode(value: $response));
        }

        // Send delivery confirmation to sender
        $from->send(json_encode([
            'type' => 'delivery',
            'message_id' => $messageModel->id,
            'status' => isset($this->userConnections[$receiverId]) ? 'delivered' : 'sent',
            'unread_count' => $unReadMessages,
            'last_message' => $lastMessage->message
        ]));
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);

        // Remove from user connections
        if ($userId = array_search($conn, $this->userConnections)) {
            unset($this->userConnections[$userId]);
        }

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}