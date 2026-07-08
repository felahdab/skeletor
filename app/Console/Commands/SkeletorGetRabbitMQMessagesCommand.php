<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Event;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

use App\Events\RabbitMQMessageReceivedEvent;

class SkeletorGetRabbitMQMessagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skeletor:get-rabbitmq-messages {--limit=100}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cette commande récupère les messages de RabbitMQ.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $config = config('services.rabbitmq');
        $connection = new AMQPStreamConnection($config['host'],
                                                $config['port'],
                                                $config['user'],
                                                $config['password'],
                                                $config['vhost']);
        $channel = $connection->channel();
        $count = 0;

        while ($count < $this->option('limit')) {
            $message = $channel->basic_get($config['incoming_queue']);
            if ($message == null)
            { 
                break;
            }
            
            $this->info("Message reçu : " . $message->getBody() . " Routing key : " . $message->getRoutingKey());

            Event::dispatch(RabbitMQMessageReceivedEvent::make($message));

            $channel->basic_ack($message->getDeliveryTag());
        
            $count++;
        }
        $channel->close();
        $connection->close();
    }
}
