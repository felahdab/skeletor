<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

class CreateRoutePermissionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:create-permission-routes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a permission routes.';

    /**
     * Create a new command instance.
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
                '' != $route->getName()
                && key_exists('middleware', $route->getAction())
                && 'web' == $route->getAction()['middleware']['0']
            ) {
                $permission = Permission::where('name', $route->getName())->first();

                if (is_null($permission)) {
                    Permission::create(['name' => $route->getName()]);
                }
            }
        }

        $this->info('Permission routes added successfully.');

        return 0;
    }
}
