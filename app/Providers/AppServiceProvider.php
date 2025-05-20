<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use Illuminate\Routing\Route;

use Dedoc\Scramble\Scramble;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;

use Illuminate\Support\Facades\Blade;

use App\Scopes\ScopedMacro;
use Filament\Pages\Dashboard;

use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;

use App\Filament\PanelRegistry\ModuleDefinedMenusRegistry;
use App\Filament\PanelRegistry\DirectMenuItem;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Scramble::ignoreDefaultRoutes();
        $this->app->singleton(ModuleDefinedMenusRegistry::class, function () 
        {
            return new ModuleDefinedMenusRegistry();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        if (config('app.env') != 'production') {
            //logger('Setting non production global destination email adres.');
            $email=config('skeletor.destinataire_email_non_production');
            Mail::alwaysTo($email);
        }

        if (config('app.env') != 'production') {
            FilamentView::registerRenderHook(
                'panels::body.start',
                static fn (): string => Blade::render("<x-banner-non-production/>")
            );
        }

        FilamentView::registerRenderHook(
            PanelsRenderHook::SIDEBAR_FOOTER,
            fn (): View => view('layouts.partials.api-documentation-link'),
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
            fn (): View => view('layouts.partials.additionnal-menus', ["menus" => app(ModuleDefinedMenusRegistry::class)->getDirectMenuItems()]),
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::BODY_START,
            fn (): string => Blade::render('@livewire(\'report-bug-or-suggestion\', ["url" => url()->current()])'),
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
            fn (): View => view('layouts.partials.trigger-report-bug-or-suggestion'),
        );

        


        if (config('app.scheme') == 'https')
            \Illuminate\Support\Facades\URL::forceScheme('https');

        Builder::macro('scoped', function ($scope, ...$parameters) {
            $query = $this;
            \assert($query instanceof Builder);
            return (new ScopedMacro($query))($scope, ...$parameters);
        });

        // Scramble::routes(function (Route $route) {
        //     return Str::startsWith($route->uri, config('skeletor.prefixe_instance') . '/api/');
        // });

        Scramble::afterOpenApiGenerated(function (OpenApi $openApi) {
            $openApi->secure(SecurityScheme::http('bearer', 'JWT'));
        });

        $link_config = config("filesystems.links");
        $link_config[base_path( 'public/' . config('skeletor.prefixe_instance'))] = public_path();
        app('config')->set('filesystems.links', $link_config);

        app(ModuleDefinedMenusRegistry::class)->registerDirectMenuItems([
            DirectMenuItem::make()
                ->name('Administration')
                ->visible(fn() => auth()->check() )
                ->children([
                    DirectMenuItem::make()
                        ->name('Panneau d\'administration')
                        ->url(fn() => Dashboard::getUrl(panel: "admin"))
                        ->visible(fn() => auth()->check() && Dashboard::canAccess()),
                    
                ]),
            ]);

    }
}
