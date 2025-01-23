<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\URL;

class SetTenantDefaultForRoutesMiddleware
{
    public function handle($request, Closure $next)
    {
        $tenant = null;
        if (function_exists('tenant')){
            $tenant = tenant();
        }

        if ($tenant){
            URL::defaults([ 'tenant' => tenant()->id ]);
        }

        $response = $next($request);

        return $response ;
    }
}