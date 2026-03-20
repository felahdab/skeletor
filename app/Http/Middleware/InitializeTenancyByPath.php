<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath as BaseMiddleware;

class InitializeTenancyByPath extends BaseMiddleware
{
    public function handle(Request $request, \Closure $next)
    {
        if (config('skeletor.multi_tenancy')) {
            return parent::handle($request, $next);
        }

        return $next($request);
    }
}
