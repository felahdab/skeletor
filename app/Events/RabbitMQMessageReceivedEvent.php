<?php

namespace App\Events;

use PhpAmqpLib\Message\AMQPMessage;
use Illuminate\Support\Str;

class RabbitMQMessageReceivedEvent
{
     public function __construct(public AMQPMessage $message) 
     {

     }

     public function sourceNode(): string
     {
          $routing_key = $this->message->getRoutingKey();
          return explode('.', $routing_key)[0] ?? '';
     }

     public function destinationNode(): string
     {
          $routing_key = $this->message->getRoutingKey();
          return explode('.', $routing_key)[1] ?? '';
     }

     public static function make(AMQPMessage $message)
     {
          return new static($message);
     }
}