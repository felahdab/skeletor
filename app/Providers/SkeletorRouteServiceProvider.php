<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Livewire\Mechanisms\HandleRequests\EndpointResolver;

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

        $livewire_prefix = Str::after(EndpointResolver::prefix(), '/');

        foreach (Route::getRoutes() as $route) {
            if (Str::is('filament/exports/{export}/download', $route->uri())) {
                $route->setUri($prefix.'/'.$route->uri());
            }
            if (Str::is('filament/imports/{import}/failed-rows/download', $route->uri())) {
                $route->setUri($prefix.'/'.$route->uri());
            }
            if (Str::is("{$livewire_prefix}/livewire.js", $route->uri())) {
                $route->setUri($prefix.'/'.$route->uri());
            }
            if (Str::is("{$livewire_prefix}/livewire.min.js", $route->uri())) {
                $route->setUri($prefix.'/'.$route->uri());
            }
            if (Str::is("{$livewire_prefix}/livewire.min.js.map", $route->uri())) {
                $route->setUri($prefix.'/'.$route->uri());
            }
            if (Str::is("{$livewire_prefix}/preview-file/{filename}", $route->uri())) {
                $route->setUri($prefix.'/'.$route->uri());
            }
            if (Str::is("{$livewire_prefix}/update", $route->uri())) {
                $route->setUri($prefix.'/'.$route->uri());
            }
            if (Str::is("{$livewire_prefix}/upload-file", $route->uri())) {
                $route->setUri($prefix.'/'.$route->uri());
            }
            if (Str::is("{$livewire_prefix}/css/{component}.css", $route->uri())) {
                $route->setUri($prefix.'/'.$route->uri());
            }
            if (Str::is("{$livewire_prefix}/css/{component}.global.css", $route->uri())) {
                $route->setUri($prefix.'/'.$route->uri());
            }
            if (Str::is("{$livewire_prefix}/js/{component}.js", $route->uri())) {
                $route->setUri($prefix.'/'.$route->uri());
            }
            if (Str::is("{$livewire_prefix}/livewire.csp.min.js.map", $route->uri())) {
                $route->setUri($prefix.'/'.$route->uri());
            }
            if (Str::is('tenancy/assets/{path?}', $route->uri())) {
                $route->setUri($prefix.'/'.$route->uri());
            }
        }
    }
}
