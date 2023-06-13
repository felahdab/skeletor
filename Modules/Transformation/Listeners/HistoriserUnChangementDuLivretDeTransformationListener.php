<?php

namespace Modules\Transformation\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Modules\Transformation\Events\UnLivretDeTransformationAChangeEvent;
use Modules\Transformation\Entities\TransformationHistory;
use Modules\Transformation\Dto\ChangementLivretDeTransformationDto;

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
