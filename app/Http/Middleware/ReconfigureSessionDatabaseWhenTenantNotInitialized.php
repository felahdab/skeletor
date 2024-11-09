<?php

namespace App\Http\Middleware;

use Closure;


class ReconfigureSessionDatabaseWhenTenantNotInitialized
{
    public function handle($request, Closure $next)
    {
        $tenant = null;
        if (function_exists('tenant')){
            $tenant = tenant();
        }

        if ($tenant == null){
            # C'est là.
            app('config')->set('session.connection','pgsql');
        }

        $response = $next($request);

        return $response ;
    }
}

