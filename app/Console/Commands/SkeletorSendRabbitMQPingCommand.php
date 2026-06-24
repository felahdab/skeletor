<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\RabbitMQService;


class SkeletorSendRabbitMQPingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skeletor:send-rabbitmq-ping {--destination=broadcast}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cette commande permet d envoyer un ping par rabbitmq';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $destinationNode = $this->option('destination');
        $this->info($destinationNode);

        $message = RabbitMQService::makeMessage(["message" => "ping"]);
        RabbitMQService::publishMessage($message, destination_node: $destinationNode, routing_key: "test.ping");

    }
}
