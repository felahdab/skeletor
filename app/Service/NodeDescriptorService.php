<?php
namespace App\Service;

use Nwidart\Modules\Facades\Module;

class NodeDescriptorService
{
    public static function describeCurrentNode(): array
    {
        $modules = [];

        foreach (Module::allEnabled() as $module) {
            $modules[$module->getName()] = $module->get('version', '');
        }

        return [
            'nom' => config('services.rabbitmq.source_nodename'),
            'details' => [
                'skeletor' => config('app.version'),
                'modules' => $modules,
            ],
        ];
    }
}