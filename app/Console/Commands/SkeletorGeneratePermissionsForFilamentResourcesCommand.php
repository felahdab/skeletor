<?php

namespace App\Console\Commands;

use Filament\Facades\Filament;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;

class SkeletorGeneratePermissionsForFilamentResourcesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skeletor:generate-permissions-for-filament-resources-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genere les permissions correspondant aux ressources Filament declarées';

    protected $verbs = [
        'index',
        'create',
        'store',
        'update',
        'delete',
        'deleteAny',
        'restore',
        'forceDelete',
        'forceDeleteAny',
        'reorder',
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach ($this->getResources() as $resource) {
            $model = $resource::getModel();
            $this->info($model);
            $policy = Gate::getPolicyFor($model);
            if (null != $policy) {
                $this->info($policy->getSlug());

                foreach ($this->verbs as $verb) {
                    $permission_name = $policy->getSlug().'.'.$verb;
                    $this->info($permission_name.' should exist.');

                    Permission::firstOrCreate(['guard_name' => 'web', 'name' => $permission_name]);
                }
            }
        }
    }

    public function getResources()
    {
        $resources = [];
        foreach (Filament::getPanels() as $panel) {
            $resources = array_merge($resources, $panel->getResources());
        }

        return array_unique($resources);
    }
}
