<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\URL;

class SetTenantDefaultForRoutesMiddleware
{
    public function handle($request, \Closure $next)
    {
        $tenant = null;
        if (function_exists('tenant')) {
            $tenant = tenant();
        }

        if ($tenant) {
            URL::defaults(['tenant' => tenant()->id]);
        }

        return $next($request);
    }
}
