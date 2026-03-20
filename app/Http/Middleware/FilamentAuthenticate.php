<?php

namespace App\Http\Middleware;

use Filament\Http\Middleware\Authenticate;
use Illuminate\Http\Request;

class FilamentAuthenticate extends Authenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     */
    protected function redirectTo($request): ?string
    {
        return route('login');
    }
}
