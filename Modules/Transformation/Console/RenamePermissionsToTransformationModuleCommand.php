<?php

namespace Modules\Transformation\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

class RenamePermissionsToTransformationModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transformation:rename-transformation-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rename Transformation module permissions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $routes = Route::getRoutes()->getRoutes();

        foreach ($routes as $route) {
            if (
                $route->getName() != '' &&
                array_key_exists('middleware', $route->getAction())  &&
                $route->getAction()['middleware']['0'] == 'web'
            ) {
                if (str_contains($route->getName(), 'transformation::')) {
                    $this->info($route->getName());
                    $toname = $route->getName();
                    $fromname = explode('::', $route->getName())[1];

                    $permission = Permission::where('name', $fromname)->first();
                    if ($permission) {
                        $this->warn('Renaming: ' . $fromname . "->" . $toname);
                        $permission->name = $toname;
                        $permission->save();
                    }
                }

            }
        }
        $fromname = 'transformation.updatelivret';
        $permission = Permission::where('name', $fromname)->first();
        if ($permission) {
            $toname = 'transformation::' . $fromname;
            $this->warn($fromname . "->" . $toname);
            $permission->name = $toname;
            $permission->save();
        }

        $this->info('Permission renamed.');
    }
}
