<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Url;

class SetTenantDefaultForRoutesMiddleware
{
    public function handle($request, Closure $next)
    {
        $tenant = null;
        if (function_exists('tenant')){
            $tenant = tenant();
        }

        if ($tenant){
            Url::defaults([ 'tenant' => tenant()->id ]);
        }

        $response = $next($request);

        return $response ;
    }
}