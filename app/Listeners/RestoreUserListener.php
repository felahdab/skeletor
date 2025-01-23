<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Service\ArchivesService;
use App\Events\RestoreUserEvent;

//use App\Models\User;

class RestoreUserListener
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
    // public function handle($event)
    public function handle(RestoreUserEvent $event)
    {
        switch ($event->mode)
        {
            case 'archive' :
                ArchivesService::restaurer(["id" => $event->id]);
                break;
            case 'MDC' :
                break;
        }
    }
}
