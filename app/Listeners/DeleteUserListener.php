<?php

namespace App\Listeners;

use App\Events\DeleteUserEvent;
use App\Service\ArchivesService;

class DeleteUserListener
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(DeleteUserEvent $event): void
    {
        switch ($event->mode) {
            case 'archive':
                ArchivesService::supprimer(['id' => $event->id]);

                break;

            case 'MDC':
                break;
        }
    }
}
