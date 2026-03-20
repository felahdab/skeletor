<?php

namespace App\Http\Middleware;

class SetTenantAwareKeycloakCallbackRedirect
{
    public function handle($request, \Closure $next)
    {
        $tenant = null;
        if (function_exists('tenant')) {
            $tenant = tenant();
        }

        if ($tenant) {
            app('config')->set('services.keycloak.redirect', route('keycloak.login.perform'));
        }

        return $next($request);
    }
}
