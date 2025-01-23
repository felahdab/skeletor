<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForceJsonMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Str::contains($request->header('accept'), ['/json', '+json'])){
            $request->headers->set('accept', 'application/json, ' . $request->header('accept'));
        }
        return $next($request);
    }
}