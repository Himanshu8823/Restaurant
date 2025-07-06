<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }
 public function broadcastOrderMessage($message) {
        foreach ($this->clients as $client) {
            $client->send(json_encode(['type' => 'order', 'message' => $message]));
        }
    }
    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }
    public function onMessage(ConnectionInterface $from, $msg) {
        // Handle the incoming message, if needed
        $data = json_decode($msg, true);
    
        // Check if the message has a specific type (e.g., "order")
        foreach ($this->clients as $client) {
            $client->send(json_encode($data));
        }
    }
    
    

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it from the storage
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        // Handle errors, if needed
        echo "An error occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}