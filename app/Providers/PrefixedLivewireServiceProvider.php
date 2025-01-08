<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class PrefixedLivewireServiceProvider extends ServiceProvider
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
            $this->setLivewirePrefixesRoutes();
        }
    }

    protected function setLivewirePrefixesRoutes()
{
    // Define custom livewire routes

    foreach (Route::getRoutes() as $route)
    {
        $prefix = config('skeletor.instance_prefix');
        if (Str::is('livewire/livewire.js', $route->uri()))
        {
            $route->setUri($prefix . '/' . $route->uri());
        }

        if (Str::is('livewire/livewire.min.js.map', $route->uri()))
        {
            $route->setUri($prefix . '/' . $route->uri());
        }

        if (Str::is('livewire/preview-file/{filename}', $route->uri()))
        {
            $route->setUri($prefix . '/' . $route->uri());
        }

        if (Str::is('livewire/update', $route->uri()))
        {
            $route->setUri($prefix . '/' . $route->uri());
        }

        if (Str::is('livewire/upload-file', $route->uri()))
        {
            $route->setUri($prefix . '/' . $route->uri());
        }
    }
} 


}
