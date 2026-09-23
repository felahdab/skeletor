<?php

namespace App\Listeners;

use Exception;
use App\Events\RabbitMQMessageReceivedEvent;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use App\Models\Poseidoninstance;

class RabbitMQPongListener
{
    /**
     * Handle the event.
     */
    public function handle(RabbitMQMessageReceivedEvent $event): void
    {
        try {
            $message = $event->message;
            $routingKey = $message->getRoutingKey();

            if (! Str::contains($routingKey, "test.pong"))
            {
                return;
            }

            $sourceNode = $event->sourceNode();
            $body = $message->getBody();
                        
            $pong_id = "no message id in ping";
            if ($message->has('message_id')){
                $pong_id = $message->get('message_id');
            }

            $timestamp = 0;
            if ($message->has('timestamp')){
                $timestamp = $message->get('timestamp');
            }

            $content = json_decode($body, true);

            $node_description = Arr::get($content, 'node_description');
            if ($node_description == null )
            {
                logger()->warning('Received a test.pong message without a node description', $content);
                return;
            }

            $remote_instance = Poseidoninstance::firstOrCreate([
                'nom' => $node_description['nom']
            ]);

            $remote_instance->last_seen = Carbon::now();
            $remote_instance->node_description = $node_description;
            $remote_instance->versions = Arr::get($node_description, 'details');
            $remote_instance->save();

        } catch (Exception $e) {
            logger()->error("Erreur lors du traitement du message RabbitMQ : " . $e->getMessage());
        }
    }
}
