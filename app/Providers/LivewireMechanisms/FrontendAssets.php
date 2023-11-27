<?php

namespace App\Providers\LivewireMechanisms;

use Livewire\Mechanisms\FrontendAssets\FrontendAssets as BaseFrontendAssets;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;
use function Livewire\on;

class FrontendAssets extends BaseFrontendAssets
{
    public function register()
    {
        app()->singleton(\Livewire\Mechanisms\FrontendAssets\FrontendAssets::class, $this::class);
    }
    public function boot()
    {
        $route_prefix = config('livewire.route_prefix');

        app(\Livewire\Mechanisms\FrontendAssets\FrontendAssets::class)->setScriptRoute(function ($handle) use($route_prefix ) {
            return Route::get('/' . $route_prefix . '/livewire/livewire.js', $handle);
        });

        Blade::directive('livewireScripts', [static::class, 'livewireScripts']);
        Blade::directive('livewireScriptConfig', [static::class, 'livewireScriptConfig']);
        Blade::directive('livewireStyles', [static::class, 'livewireStyles']);

        on('flush-state', function () {
            $instance = app(\Livewire\Mechanisms\FrontendAssets\FrontendAssets::class);

            $instance->hasRenderedScripts = false;
            $instance->hasRenderedStyles = false;
        });
    }
}
