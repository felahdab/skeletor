<?php

namespace Modules\Transformation\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Modules\Transformation\Entities\User;
use Modules\Transformation\Scopes\MemeUniteOuRenduVisible;

class RestrictVisibility
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ( ! auth()->user()->can('transformation::view_all_users')) {
            User::addGlobalScope(new MemeUniteOuRenduVisible(null));
        }   
        return $next($request);
    }
}
