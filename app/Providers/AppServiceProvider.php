<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use Illuminate\Routing\Route;

use Dedoc\Scramble\Scramble;
//use Dedoc\Scramble\Support\Generator\OpenApi;
//use Dedoc\Scramble\Support\Generator\SecurityScheme;

use App\Scopes\ScopedMacro;

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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        if (env('APP_ENV') != 'production') {
            //logger('Setting non production global destination email adres.');
            $email=config('skeletor.destinataire_email_non_production');
            Mail::alwaysTo($email);
        }

        if (env('APP_SCHEME') == 'https')
            \Illuminate\Support\Facades\URL::forceScheme('https');

        Builder::macro('scoped', function ($scope, ...$parameters) {
            $query = $this;
            \assert($query instanceof Builder);
            return (new ScopedMacro($query))($scope, ...$parameters);
        });

        // Scramble::routes(function (Route $route) {
        //     return Str::startsWith($route->uri, config('skeletor.prefixe_instance') . '/api/');
        // });

        // Scramble::afterOpenApiGenerated(function (OpenApi $openApi) {
        //     $openApi->secure(SecurityScheme::http('bearer', 'JWT'));
        // });
    }
}
