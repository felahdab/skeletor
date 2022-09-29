<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Jobs\CalculateUserTransformationRatios;

use App\Events\UserTransformationUpdated;

use App\Models\User;

class UpdateUserTransformationRatio
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UserTransformationUpdated $event)
    {
        $user = $event->user;
        
        CalculateUserTransformationRatios::dispatch($user);
    }
}
