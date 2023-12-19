<?php

namespace App\Providers;

use Livewire\LivewireServiceProvider as BaseLivewireServiceProvider;
use Livewire\ComponentHookRegistry;

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
            \Livewire\Mechanisms\CompileLivewireTags\CompileLivewireTags::class,
            \Livewire\Mechanisms\ComponentRegistry::class,
            \Livewire\Mechanisms\RenderComponent::class,
            \Livewire\Mechanisms\DataStore::class,
        ];
    }

    protected function bootFeatures()
    {
        foreach([
            \Livewire\Features\SupportWireModelingNestedComponents\SupportWireModelingNestedComponents::class,
            \Livewire\Features\SupportMultipleRootElementDetection\SupportMultipleRootElementDetection::class,
            \Livewire\Features\SupportDisablingBackButtonCache\SupportDisablingBackButtonCache::class,
            \Livewire\Features\SupportNestedComponentListeners\SupportNestedComponentListeners::class,
            \Livewire\Features\SupportMorphAwareIfStatement\SupportMorphAwareIfStatement::class,
            \Livewire\Features\SupportAutoInjectedAssets\SupportAutoInjectedAssets::class,
            \Livewire\Features\SupportComputed\SupportLegacyComputedPropertySyntax::class,
            \Livewire\Features\SupportNestingComponents\SupportNestingComponents::class,
            \Livewire\Features\SupportScriptsAndAssets\SupportScriptsAndAssets::class,
            \Livewire\Features\SupportBladeAttributes\SupportBladeAttributes::class,
            \Livewire\Features\SupportConsoleCommands\SupportConsoleCommands::class,
            \Livewire\Features\SupportPageComponents\SupportPageComponents::class,
            \Livewire\Features\SupportReactiveProps\SupportReactiveProps::class,
            \Livewire\Features\SupportFileDownloads\SupportFileDownloads::class,
            \Livewire\Features\SupportJsEvaluation\SupportJsEvaluation::class,
            \Livewire\Features\SupportQueryString\SupportQueryString::class,
            \App\Providers\LivewireFeatures\SupportFileUploads::class,
            \Livewire\Features\SupportTeleporting\SupportTeleporting::class,
            \Livewire\Features\SupportLazyLoading\SupportLazyLoading::class,
            \Livewire\Features\SupportFormObjects\SupportFormObjects::class,
            \Livewire\Features\SupportAttributes\SupportAttributes::class,
            \Livewire\Features\SupportPagination\SupportPagination::class,
            \Livewire\Features\SupportValidation\SupportValidation::class,
            \Livewire\Features\SupportRedirects\SupportRedirects::class,
            \Livewire\Features\SupportStreaming\SupportStreaming::class,
            \Livewire\Features\SupportNavigate\SupportNavigate::class,
            \Livewire\Features\SupportEntangle\SupportEntangle::class,
            \Livewire\Features\SupportLocales\SupportLocales::class,
            \Livewire\Features\SupportTesting\SupportTesting::class,
            \Livewire\Features\SupportModels\SupportModels::class,
            \Livewire\Features\SupportEvents\SupportEvents::class,

            // Some features we want to have priority over others...
            \Livewire\Features\SupportLifecycleHooks\SupportLifecycleHooks::class,
            \Livewire\Features\SupportLegacyModels\SupportLegacyModels::class,
            \Livewire\Features\SupportWireables\SupportWireables::class,
        ] as $feature) {
            app('livewire')->componentHook($feature);
        }

        ComponentHookRegistry::boot();
    }
}
