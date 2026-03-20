<?php

namespace App\Providers;

use App\Filament\PanelRegistry\DirectMenuItem;
use App\Filament\PanelRegistry\ModuleDefinedMenusRegistry;
use App\Filament\PanelRegistry\ModuleDefinedPreferedPagesRegistry;
use App\Scopes\ScopedMacro;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Filament\Pages\Dashboard;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        Scramble::ignoreDefaultRoutes();
        $this->app->singleton(ModuleDefinedMenusRegistry::class, function () {
            return new ModuleDefinedMenusRegistry();
        });
        $this->app->singleton(ModuleDefinedPreferedPagesRegistry::class, function () {
            return new ModuleDefinedPreferedPagesRegistry();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Paginator::useBootstrap();

        if ('production' != config('app.env')) {
            // logger('Setting non production global destination email adres.');
            $email = config('skeletor.destinataire_email_non_production');
            Mail::alwaysTo($email);
        }

        if ('production' != config('app.env')) {
            FilamentView::registerRenderHook(
                'panels::body.start',
                static fn (): string => Blade::render('<x-banner-non-production/>')
            );
        }

        FilamentView::registerRenderHook(
            PanelsRenderHook::SIDEBAR_FOOTER,
            fn (): View => view('layouts.partials.api-documentation-link'),
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
            fn (): View => view('layouts.partials.additionnal-menus', ['menus' => app(ModuleDefinedMenusRegistry::class)->getDirectMenuItems()]),
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::BODY_START,
            fn (): string => Blade::render('@livewire(\'report-bug-or-suggestion\', ["url" => url()->current()])'),
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
            fn (): View => view('layouts.partials.trigger-report-bug-or-suggestion'),
        );

        if ('https' == config('app.scheme')) {
            URL::forceScheme('https');
        }

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

        $link_config = config('filesystems.links');
        $link_config[base_path('public/'.config('skeletor.prefixe_instance'))] = public_path();
        app('config')->set('filesystems.links', $link_config);

        app(ModuleDefinedMenusRegistry::class)->registerDirectMenuItems([
            DirectMenuItem::make()
                ->name('Administration')
                ->visible(fn () => auth()->check())
                ->children([
                    DirectMenuItem::make()
                        ->name('Panneau d\'administration')
                        ->url(fn () => Dashboard::getUrl(panel: 'Skeletor'))
                        ->visible(fn () => auth()->check() && Dashboard::canAccess()),
                ]),
        ]);
    }
}
