<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\RabbitMQService;
use App\Service\NodeDescriptorService;

class SkeletorSendRabbitMQPongCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skeletor:send-rabbitmq-pong {--destination=broadcast}';

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

        $node_description = NodeDescriptorService::describeCurrentNode();

        $content = [
            "message" => "pong",
            "node_description" => $node_description
        ];

        $message = RabbitMQService::makeMessage($content);
        RabbitMQService::publishMessage($message, destination_node: $destinationNode, routing_key: "test.pong");

    }
}
