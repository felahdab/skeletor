<?php

namespace Modules\Transformation\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Events\UnUtilisateurDoitEtreArchiveEvent;
use App\Events\UnUtilisateurDoitEtreRestaureEvent;

use Modules\Transformation\Events\UnLivretDeTransformationAChangeEvent;
use Modules\Transformation\Events\UserProposedSomeValidationEvent;

use Modules\Transformation\Listeners\HandleUserProposedSomeValidationEvent;
use Modules\Transformation\Listeners\HistoriserUnChangementDuLivretDeTransformationListener;
use Modules\Transformation\Listeners\LancerLaMiseAJourDuTauxDeTransformationListener;
use Modules\Transformation\Listeners\UnUtilisateurDoitEtreArchiveListener;
use Modules\Transformation\Listeners\UnUtilisateurDoitEtreRestaureListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UnUtilisateurDoitEtreArchiveEvent::class => [
            UnUtilisateurDoitEtreArchiveListener::class
        ],
        UnUtilisateurDoitEtreRestaureEvent::class => [
            UnUtilisateurDoitEtreRestaureListener::class
        ],
        UnLivretDeTransformationAChangeEvent::class => [
            HistoriserUnChangementDuLivretDeTransformationListener::class,
            LancerLaMiseAJourDuTauxDeTransformationListener::class
        ],
        UserProposedSomeValidationEvent::class => [
            HandleUserProposedSomeValidationEvent::class,
        ],
    ];
}
