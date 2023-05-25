<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\UnLivretDeTransformationAChangeEvent;

use App\Jobs\CalculateUserTransformationRatios;



class LancerLaMiseAJourDuTauxDeTransformationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UnLivretDeTransformationAChangeEvent $event): void
    {
        CalculateUserTransformationRatios::dispatch($event->data->modified_user);
    }
}
