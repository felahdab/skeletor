<?php

namespace Modules\Transformation\Providers;

use Illuminate\Support\ServiceProvider;

use Livewire\Livewire;
use Illuminate\Support\Facades\Blade;
use Modules\Transformation\Http\Middleware\RestrictVisibility;

class TransformationServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Transformation';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'transformation';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
        $this->registerCommands();
        $this->registerDocumentation();
        $this->registerPermanentMiddlewareForLivewire();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register commands.
     *
     * @return void
     */
    public function registerDocumentation()
    {
        $this->publishes([
            module_path($this->moduleName, 'Resources/docs') => base_path('resources/docs/1.0/' . $this->moduleNameLower),
        ], 'doc-for-larecipe');
    }

    /**
     * Register commands.
     *
     * @return void
     */
    public function registerCommands()
    {
        $this->commands([
            \Modules\Transformation\Console\GenerateStatistics::class,
            \Modules\Transformation\Console\RecalculerTransformation::class,
            \Modules\Transformation\Console\SearchOrphanRecords::class,
            \Modules\Transformation\Console\SuppressDoublons::class,
            \Modules\Transformation\Console\RenamePermissionsToTransformationModuleCommand::class
        ]);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'),
            $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);

        Blade::componentNamespace('Modules\\Transformation\\Views\\Components', 'transformation');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'Resources/lang'));
        }
    }

    public function registerPermanentMiddlewareForLivewire()
    {
        Livewire::addPersistentMiddleware(RestrictVisibility::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }

    protected function discoverEventsWithin(): array
    {
        return [
            $this->app->path('Listeners'),
        ];
    }
}
