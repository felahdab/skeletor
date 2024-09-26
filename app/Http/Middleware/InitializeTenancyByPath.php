<?php

namespace App\Http\Middleware;

use Stancl\Tenancy\Middleware\InitializeTenancyByPath as BaseMiddleware;

use Closure;
use Illuminate\Http\Request;


class InitializeTenancyByPath extends BaseMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if (config('skeletor.multi_tenancy')){
            return parent::handle($request, $next);
        }

        return $next($request);
    }
}
