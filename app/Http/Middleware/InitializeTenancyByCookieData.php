<?php

declare(strict_types=1);

namespace App\Http\Middleware;
use Stancl\Tenancy\Middleware\IdentificationMiddleware;

use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Contracts\Tenant;
use Stancl\Tenancy\Contracts\TenantResolver;
use Stancl\Tenancy\Tenancy;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedByRequestDataException;

use Illuminate\Support\Facades\Log;

class InitializeTenancyByCookieData extends IdentificationMiddleware implements TenantResolver
{

    /** @var string|null */
    public static $cookieParameter = 'tenant';

    /** @var callable|null */
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
            Log::info("Found a corresponding tenant: " . $tenant->id);
            return $tenant;
        }

        throw new TenantCouldNotBeIdentifiedByRequestDataException($payload);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (config('skeletor.multi_tenancy'))
        {
            if (tenant()){
                // Un tenant a déjà été identifié par une étape précédente. On passe simplement la requête à la suite.
                return $next($request);
            }

            if ($cookiePayload = $request->cookie(static::$cookieParameter))
            {
                if (tenancy()->find($cookiePayload)){
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
