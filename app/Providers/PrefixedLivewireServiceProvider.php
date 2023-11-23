<?php

namespace App\Providers;

use Livewire\LivewireServiceProvider as BaseLivewireServiceProvider;


class PrefixedLivewireServiceProvider extends BaseLivewireServiceProvider
{
    protected function getMechanisms()
    {
        return [
            \Livewire\Mechanisms\PersistentMiddleware\PersistentMiddleware::class,
            \Livewire\Mechanisms\HandleComponents\HandleComponents::class,
            \App\Providers\LivewireMechanisms\HandleRequests::class,
            \App\Providers\LivewireMechanisms\FrontendAssets::class,
            \Livewire\Mechanisms\ExtendBlade\ExtendBlade::class,
            \Livewire\Mechanisms\CompileLivewireTags::class,
            \Livewire\Mechanisms\ComponentRegistry::class,
            \Livewire\Mechanisms\RenderComponent::class,
            \Livewire\Mechanisms\DataStore::class,
        ];
    }
}
