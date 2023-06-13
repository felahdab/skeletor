<?php

namespace Modules\Transformation\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use Modules\Transformation\Events\UnLivretDeTransformationAChangeEvent;
use Modules\Transformation\Events\UserProposedSomeValidationEvent;

use Modules\Transformation\Listeners\HandleUserProposedSomeValidationEvent;
use Modules\Transformation\Listeners\HistoriserUnChangementDuLivretDeTransformationListener;
use Modules\Transformation\Listeners\LancerLaMiseAJourDuTauxDeTransformationListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UnLivretDeTransformationAChangeEvent::class => [
            HistoriserUnChangementDuLivretDeTransformationListener::class,
            LancerLaMiseAJourDuTauxDeTransformationListener::class
        ],
        UserProposedSomeValidationEvent::class => [
            HandleUserProposedSomeValidationEvent::class,
        ],
    ];
}
