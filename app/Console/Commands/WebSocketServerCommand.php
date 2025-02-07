<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use App\WebSocket\WebSocketServer;

class WebSocketServerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websocket:serve {--port=8082 : The port to serve the WebSocket server on}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the WebSocket server';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $port = $this->option('port');
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new WebSocketServer() // Your custom WebSocket handler
                )
            ),
            $port
        );

        $server->run();
    }
}
