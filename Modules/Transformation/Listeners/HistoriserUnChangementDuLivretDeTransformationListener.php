<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\UnLivretDeTransformationAChangeEvent;
use App\Models\TransformationHistory;
use App\Dto\ChangementLivretDeTransformationDto;

class HistoriserUnChangementDuLivretDeTransformationListener
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
        $changementDuLivret = $event->data;
        
        TransformationHistory::create([
            "modifying_user" => $changementDuLivret->modifying_user->display_name,
            "modified_user" => $changementDuLivret->modified_user->display_name,
            "event" => $changementDuLivret->action,
            "event_details" => $changementDuLivret->details,
        ]);
    }
}
