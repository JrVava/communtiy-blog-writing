<?php

namespace App\WebSockets;

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

        // Prepare response
        $response = [
        'type' => 'message',
        'message_id' => $messageModel->id,
        'sender_id' => $senderId,
        'receiver_id' => $receiverId,
        'message' => $message,
        'created_at' => $messageModel->created_at->toDateTimeString()
    ];

        // Send to receiver if online
        if (isset($this->userConnections[$receiverId])) {
        $this->userConnections[$receiverId]->send(json_encode($response));
    }

        // Send delivery confirmation to sender
       if (isset($this->userConnections[$senderId])) {
        $this->userConnections[$senderId]->send(json_encode($response));
    }

    // Send delivery confirmation to sender
    $from->send(json_encode([
        'type' => 'delivery',
        'message_id' => $messageModel->id,
        'status' => isset($this->userConnections[$receiverId]) ? 'delivered' : 'sent'
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