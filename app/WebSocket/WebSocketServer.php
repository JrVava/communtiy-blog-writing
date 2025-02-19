<?php

namespace App\WebSocket;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use SplObjectStorage;

class WebSocketServer implements MessageComponentInterface
{
    protected $clients;
    protected $users;
    public function __construct()
    {
        $this->clients = new SplObjectStorage;
        $this->users = [];
    }

    public function onOpen(ConnectionInterface $conn)
    {
        parse_str($conn->httpRequest->getUri()->getQuery(), $query);
        $user_id = $query['user_id'] ?? null;

        if ($user_id) {
            $this->users[$user_id] = $conn;
        }

        $this->clients->attach($conn);
        echo "New connection: {$conn->resourceId} (User ID: {$user_id})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);

        if ($data['type'] === 'follow_request') {
            $toUserId = $data['to_user_id'] ?? null;

            if (isset($this->users[$toUserId])) {
                $this->users[$toUserId]->send(json_encode($data));
            }
        } elseif ($data['type'] === 'chat_message') {
            $toUserId = $data['to_user_id'] ?? null;

            if (isset($this->users[$toUserId])) {
                $this->users[$toUserId]->send(json_encode($data));
            }
        } elseif ($data['type'] === 'get_notification') {
            $userId = $data['userId'] ?? null;

            if (isset($this->users[$userId])) {
                $this->users[$userId]->send(json_encode($data));
            }
        }
    }


    public function onClose(ConnectionInterface $conn)
    {
        foreach ($this->users as $userId => $userConn) {
            if ($userConn === $conn) {
                unset($this->users[$userId]);
                break;
            }
        }

        $this->clients->detach($conn);
        echo "Connection closed: {$conn->resourceId}\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Error: " . $e->getMessage() . "\n";
        $conn->close();
    }
}
