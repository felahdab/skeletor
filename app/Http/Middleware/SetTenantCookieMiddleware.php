<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SetTenantCookieMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $tenant = null;
        if (function_exists('tenant')){
            $tenant = tenant();
        }
        if ($tenant && method_exists($response, 'cookie')){
            $cookie = cookie('tenant', tenant()->id, 60);
            $response->cookie($cookie);
        }

        return $response ;
    }
}