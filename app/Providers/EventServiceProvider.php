<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Listeners\RestoreUserListener;
use App\Listeners\DeleteUserListener;

use SocialiteProviders\Keycloak\KeycloakExtendSocialite;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return true;
    }
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            'SocialiteProviders\Keycloak\KeycloakExtendSocialite@handle',
        ],
        Illuminate\Foundation\Http\Events\RequestHandled::class => [
            'App\Listeners\RecordUsageDataListener@handle',
        ],
        RestoreUserEvent::class => [
            RestoreUserListener::class
        ],
        DeleteUserEvent::class => [
            DeleteUserListener::class
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
