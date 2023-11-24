<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route as RouteFacade;

use Illuminate\Support\ServiceProvider;

use Livewire\Livewire;
use Illuminate\Support\Facades\Route;

class PrefixedLivewireServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }
    public function register()
    {
        Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/ffast/livewire/update', $handle);
        });

        // Livewire::setUploadFileRoute(function ($handle) {
        //     return Route::post('/ffast/livewire/upload-file', $handle);
        // });

        Livewire::setScriptRoute(function ($handle) {
            return Route::get('/ffast/livewire/livewire.js', $handle);
        });

        return;

        $prefix = config('livewire.route_prefix');

        RouteFacade::prefix($prefix)->group(function () {
            parent::registerRoutes();
        });
    }
}
