<?php
namespace App\Service;

use Illuminate\Support\Str;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQService
{

    public static function makeMessage(array $content): AMQPMessage
    {
        $message = new AMQPMessage(json_encode($content, JSON_PRETTY_PRINT));
        $message->set('timestamp', time());
        $message->set('message_id', (string) Str::uuid());

        return $message;
    }

    public static function publishMessage(AMQPMessage $message, string $destination_node='broadcast', string $routing_key='')
    {
        $config = config('services.rabbitmq');

        $routing_key = $config['source_nodename'] . '.' . $destination_node . ($routing_key ? '.' . $routing_key : '');

        logger()->info("Publishing message to RabbitMQ with routing key '$routing_key'", ['message_id' => $message->get('message_id')]);

        $connection = new AMQPStreamConnection($config['host'], $config['port'], $config['user'], $config['password'], $config['vhost']);
        $channel = $connection->channel();
        $channel->exchange_declare($config['outgoing_exchange'], 'fanout', passive: false, durable: true, auto_delete: false);
        $channel->basic_publish($message, exchange: $config['outgoing_exchange'], routing_key: $routing_key);
        
        $channel->close();
        $connection->close();
    }
}