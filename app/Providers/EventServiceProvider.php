<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use SocialiteProviders\Keycloak\KeycloakExtendSocialite;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            'SocialiteProviders\Keycloak\KeycloakExtendSocialite@handle',
        ],
        \App\Events\UserProposedSomeValidationEvent::class => [
            [\App\Listeners\HandleUserProposedSomeValidationEvent::class, "handle"]
        ]
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
