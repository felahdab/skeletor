<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class SkeletorRouteServiceProvider extends ServiceProvider
{
    public function map()
    {
        if (! App::routesAreCached()){
            $this->setSkeletorRoutes();
        }
       
    }

    public function setSkeletorRoutes()
    {
        $prefix = config('skeletor.instance_prefix');

        foreach (Route::getRoutes() as $route)
        {
            if (Str::is('filament/exports/{export}/download', $route->uri()))
            {
                $route->setUri($prefix . '/' . $route->uri());
            }
            if (Str::is('filament/imports/{import}/failed-rows/download', $route->uri()))
            {
                $route->setUri($prefix . '/' . $route->uri());
            }
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
