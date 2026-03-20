<?php

namespace App\Providers;

use App\Models\MindefConnectUser;
use App\Models\Remotesystem;
use App\Models\User;
use App\Policies\MindefConnectUserPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RemotesystemPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Remotesystem::class => RemotesystemPolicy::class,
        MindefConnectUser::class => MindefConnectUserPolicy::class,
        Permission::class => PermissionPolicy::class,
        Role::class => RolePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        // Implicitly grant "admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->IsSuperAdmin() ? true : null;
        });
    }
}
