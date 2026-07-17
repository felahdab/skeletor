<?php
namespace App\Service;

class NodeDescriptorService
{
    public static function describeCurrentNode(): array
    {
        return [
            'nom' => config('services.rabbitmq.source_nodename'),
        ];
    }
}