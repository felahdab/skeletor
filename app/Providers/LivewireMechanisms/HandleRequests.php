<?php

namespace App\Providers\LivewireMechanisms;

use Livewire\Mechanisms\HandleRequests\HandleRequests as BaseHandleRequests;
use Illuminate\Support\Facades\Route;


class HandleRequests extends BaseHandleRequests
{
    function register()
    {
        app()->singleton(\Livewire\Mechanisms\HandleRequests\HandleRequests::class, $this::class);
    }
    function boot()
    {
        $route_prefix = config('livewire.route_prefix');

        app(\Livewire\Mechanisms\HandleRequests\HandleRequests::class)->setUpdateRoute(function ($handle) use ($route_prefix) {
            return Route::post('/' . $route_prefix . '/livewire/update', $handle)->middleware('web');
        });

        $this->skipRequestPayloadTamperingMiddleware();
    }
}
