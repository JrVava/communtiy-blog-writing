<?php
namespace App\WebSocket;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use SplObjectStorage;

class WebSocketServer implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Extract user_id from query string
        $queryString = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryString, $queryParams);
        $userId = $queryParams['user_id'] ?? null;

        // Store connection with user_id
        $this->clients->attach($conn, ['user_id' => $userId]);
        echo "New connection (User ID: $userId, Resource ID: {$conn->resourceId})\n";

        // Notify other users about the refresh
        foreach ($this->clients as $client) {
            if ($client !== $conn) { // Don't send to the user who refreshed
                $client->send(json_encode([
                    'type' => 'refresh_alert',
                    'message' => "User $userId has refreshed their page.",
                    'user_id' => $userId
                ]));
            }
        }
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        echo "📩 Received Message: " . $msg . "\n"; // Debug incoming messages
        $data = json_decode($msg, true);
    
        if (!$data || !isset($data['to_user_id'], $data['from_user_id'])) {
            echo "⚠️ Invalid message format\n";
            return;
        }

        $sent = false;
        foreach ($this->clients as $client) {
            $clientData = $this->clients[$client];
    
            if (isset($clientData['user_id']) && $clientData['user_id'] == $data['to_user_id']) {
                echo "📤 Sending message to user {$data['to_user_id']}\n";
                $client->send(json_encode([
                    'message' => 'You have a new follow request!',
                    'from_user_id' => $data['from_user_id']
                ]));
                $sent = true;
            }
        }
    
        if (!$sent) {
            echo "⚠️ No active connection found for user {$data['to_user_id']}\n";
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "A user disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
        $conn->close();
    }
}
