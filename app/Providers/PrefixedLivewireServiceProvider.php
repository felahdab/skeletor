<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route as RouteFacade;

use Livewire\LivewireServiceProvider;

class PrefixedLivewireServiceProvider extends LivewireServiceProvider
{
    protected function registerRoutes()
    {
        $prefix = config('livewire.route_prefix');
        
        RouteFacade::prefix($prefix)->group(function() {
            parent::registerRoutes();
        });

    }
}
