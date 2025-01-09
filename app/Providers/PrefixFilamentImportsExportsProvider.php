<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class PrefixFilamentImportsExportsProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    public function map()
    {
        // Check Cached not necessary if extends RouteServiceProvider
        if (! App::routesAreCached())
        {
            $this->setFilamentImportsExportsRoutes();
        }
    }

    protected function setFilamentImportsExportsRoutes()
{
    // Define custom livewire routes

    foreach (Route::getRoutes() as $route)
    {
        $prefix = config('skeletor.instance_prefix');
        if (Str::is('filament/exports/{export}/download', $route->uri()))
        {
            $route->setUri($prefix . '/' . $route->uri());
        }

        if (Str::is('filament/imports/{import}/failed-rows/download', $route->uri()))
        {
            $route->setUri($prefix . '/' . $route->uri());
        }
    }
} 


}
