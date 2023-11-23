<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\User;
use App\Scopes\MemeUnite;

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
            User::addGlobalScope(new MemeUnite(null));
        }   
        return $next($request);
    }
}
