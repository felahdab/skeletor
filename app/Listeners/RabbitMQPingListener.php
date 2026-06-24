<?php

namespace App\Listeners;

use Exception;
use App\Events\RabbitMQMessageReceivedEvent;
use App\Service\RabbitMQService;
use Illuminate\Support\Str;

class RabbitMQPingListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RabbitMQMessageReceivedEvent $event): void
    {
        try {
            $message = $event->message;
            $sourceNode = $event->sourceNode();

            $body = $message->getBody();
            $routingKey = $message->getRoutingKey();

            if (! Str::contains($routingKey, "test.ping"))
            {
                return;
            }
            
            if ($event->destinationNode() === "broadcast")
            {
                logger()->info("Received broadcast ping ");
            }
            if ($event->destinationNode() === config('services.rabbitmq.source_nodename'))
            {
                logger()->info("Received adressed ping ");
            }

            $ping_id = "no message id in ping";
            
            if ($message->has('message_id')){
                $ping_id = $message->get('message_id');
            }

            $timestamp = 0;
            if ($message->has('timestamp')){
                $timestamp = $message->get('timestamp');
            }

            $content = [
                "message" => "pong",
                "in_reply_to" => $ping_id,
                "ping_timestamp" => $timestamp
            ];

            $message = RabbitMQService::makeMessage($content);
            RabbitMQService::publishMessage($message, destination_node: $sourceNode, routing_key: "test.pong");

        } catch (Exception $e) {
            logger()->error("Erreur lors du traitement du message RabbitMQ : " . $e->getMessage());
        }
    }
}
