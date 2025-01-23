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
            // C'est necessaire lorsque skeletor.multi_tenancy est à true car le TenancyServiceProvider reconfigure la connection
            // des sessions pour utiliser la base 'tenant' par défaut.
            // Donc quand on n'est pas dans un tenant, il faut repartir sur la base centrale.
            # C'est là.
            app('config')->set('session.connection', config('database.default'));
        }

        $response = $next($request);

        return $response ;
    }
}

