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
            app('config')->set('session.connection','mysql');
        }

        $response = $next($request);

        return $response ;
    }
}

