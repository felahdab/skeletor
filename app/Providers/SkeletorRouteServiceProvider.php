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
        if (!App::routesAreCached()) {
            $this->setSkeletorRoutes();
        }
    }

    public function setSkeletorRoutes()
    {
        $prefix = config('skeletor.prefixe_instance');

        foreach (Route::getRoutes() as $route) {
            if (Str::is('filament/exports/{export}/download', $route->uri())) {
                $route->setUri($prefix.'/'.$route->uri());
            }
            if (Str::is('filament/imports/{import}/failed-rows/download', $route->uri())) {
                $route->setUri($prefix.'/'.$route->uri());
            }
            if (Str::is('livewire-c76b996c/livewire.js', $route->uri())) {
                $route->setUri($prefix.'/'.$route->uri());
            }
            if (Str::is('livewire-c76b996c/livewire.min.js', $route->uri())) {
                $route->setUri($prefix.'/'.$route->uri());
            }
            if (Str::is('livewire-c76b996c/livewire.min.js.map', $route->uri())) {
                $route->setUri($prefix.'/'.$route->uri());
            }
            if (Str::is('livewire-c76b996c/preview-file/{filename}', $route->uri())) {
                $route->setUri($prefix.'/'.$route->uri());
            }
            if (Str::is('livewire-c76b996c/update', $route->uri())) {
                $route->setUri($prefix.'/'.$route->uri());
            }
            if (Str::is('livewire-c76b996c/upload-file', $route->uri())) {
                $route->setUri($prefix.'/'.$route->uri());
            }
            if (Str::is('livewire-c76b996c/css/{component}.css', $route->uri())) {
                $route->setUri($prefix.'/'.$route->uri());
            }
            if (Str::is('livewire-c76b996c/css/{component}.global.css', $route->uri())) {
                $route->setUri($prefix.'/'.$route->uri());
            }
            if (Str::is('livewire-c76b996c/js/{component}.js', $route->uri())) {
                $route->setUri($prefix.'/'.$route->uri());
            }
            if (Str::is('livewire-c76b996c/livewire.csp.min.js.map', $route->uri())) {
                $route->setUri($prefix.'/'.$route->uri());
            }
            if (Str::is('tenancy/assets/{path?}', $route->uri())) {
                $route->setUri($prefix.'/'.$route->uri());
            }
        }
    }
}
