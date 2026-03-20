<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stancl\Tenancy\Contracts\Tenant;
use Stancl\Tenancy\Contracts\TenantResolver;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedByRequestDataException;
use Stancl\Tenancy\Middleware\IdentificationMiddleware;
use Stancl\Tenancy\Tenancy;

class InitializeTenancyByCookieData extends IdentificationMiddleware implements TenantResolver
{
    /** @var null|string */
    public static $cookieParameter = 'tenant';

    /** @var null|callable */
    public static $onFail;

    /** @var Tenancy */
    protected $tenancy;

    /** @var TenantResolver */
    protected $resolver;

    public function __construct(Tenancy $tenancy)
    {
        $this->tenancy = $tenancy;
        $this->resolver = $this;
    }

    public function resolve(...$args): Tenant
    {
        $payload = $args[0];

        if ($payload && $tenant = tenancy()->find($payload)) {
            Log::info('Found a corresponding tenant: '.$tenant->id);

            return $tenant;
        }

        throw new TenantCouldNotBeIdentifiedByRequestDataException($payload);
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if (config('skeletor.multi_tenancy')) {
            if (tenant()) {
                // Un tenant a déjà été identifié par une étape précédente. On passe simplement la requête à la suite.
                return $next($request);
            }

            if ($cookiePayload = $request->cookie(static::$cookieParameter)) {
                if (tenancy()->find($cookiePayload)) {
                    return $this->initializeTenancy($request, $next, $cookiePayload);
                }
            }
        }

        return $next($request);
    }

    // protected function getPayload(Request $request): ?string
    // {
    //     $tenant = null;

    //     if ($request->cookie(static::$cookieParameter))
    //     {
    //         return $request->cookie(static::$cookieParameter);
    //     }

    //     return $tenant;
    // }
}
