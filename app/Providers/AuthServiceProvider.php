<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models;
use App\Policies;
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
        Models\User::class => Policies\UserPolicy::class,
        Models\Remotesystem::class => Policies\RemotesystemPolicy::class,
        Models\MindefConnectUser::class => Policies\MindefConnectUserPolicy::class,
        Permission::class => Policies\PermissionPolicy::class,
        Role::class => Policies\RolePolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Implicitly grant "admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            if ($user->email == "florian.el-ahdab@intradef.gouv.fr" or $user->email == "sandrine.zambelli@intradef.gouv.fr")
		return true;
        });
        Gate::before(function ($user, $ability) {
            return $user->IsSuperAdmin() ? true : null;
        });    
    }
}
