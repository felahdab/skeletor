<?php

namespace Modules\Transformation\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Modules\Transformation\Events\UserProposedSomeValidationEvent;

class HandleUserProposedSomeValidationEvent
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
    public function handle(UserProposedSomeValidationEvent $event): void
    {
        //
    }
}
