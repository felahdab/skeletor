<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Scopes\MemeUnite;
use Illuminate\Http\Request;

class RestrictVisibility
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        if (!auth()->user()->can('view_all_users')) {
            User::addGlobalScope(new MemeUnite(null));
        }

        return $next($request);
    }
}
