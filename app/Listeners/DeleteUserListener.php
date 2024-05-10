<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Service\ArchivesService;
use App\Events\DeleteUserEvent;

class DeleteUserListener
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
    public function handle(DeleteUserEvent $event): void
    {
        switch ($event->mode)
        {
            case 'archive' :
                ArchivesService::supprimer(["id" => $event->id]);
                break;
            case 'MDC' :
                break;
        }
    }
}
