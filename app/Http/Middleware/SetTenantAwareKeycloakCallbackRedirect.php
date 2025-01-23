<?php

namespace App\Http\Middleware;

use Closure;

class SetTenantAwareKeycloakCallbackRedirect
{
    public function handle($request, Closure $next)
    {
        $tenant = null;
        if (function_exists('tenant')){
            $tenant = tenant();
        }

        if ($tenant){
            app('config')->set('services.keycloak.redirect', route('keycloak.login.perform'));
        }

        $response = $next($request);

        return $response ;
    }
}