<?php

namespace App\Console\Commands;

use App\WebSockets\ChatSocket;
use Illuminate\Console\Command;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use App\WebSocket\Chat;
use Illuminate\Support\Facades\Log;

class WebSocketServer extends Command
{
    protected $signature = 'websocket:serve {--port=8082 : The port to serve the WebSocket server on}';
    protected $description = 'Start the WebSocket server';

    public function handle()
    {
        $port = $this->option('port');
        $this->info("Starting WebSocket server on port {$port}...");
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new ChatSocket() // Your custom WebSocket handler
                )
            ),
            $port,
        );

        $server->run();
    }
}