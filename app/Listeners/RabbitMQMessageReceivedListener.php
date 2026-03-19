<?php

namespace App\Listeners;

use Exception;
use App\Events\RabbitMQMessageReceivedEvent;

class RabbitMQMessageReceivedListener
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
            $body = $message->getBody();
            logger()->info("RabbitMQMessageReceivedEvent : " . $body . " with routing key : " . $message->getRoutingKey() . " and properties : " . json_encode($message->get_properties()));

            if ($event->destinationNode() === "broadcast")
            {
                logger()->info("Message broadcast.");
                // Traitez le message en fonction de vos besoins
            }

            if ($event->destinationNode() === config('services.rabbitmq.source_nodename'))
            {
                logger()->info("Message adressé");
                // Traitez le message en fonction de vos besoins
            }
        } catch (Exception $e) {
            logger()->error("Erreur lors du traitement du message RabbitMQ : " . $e->getMessage());
        }
    }
}
