<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;


use App\Events\BugOrSuggestionReportEvent;

class BugOrSuggestionReportListener
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
    public function handle(BugOrSuggestionReportEvent $event): void
    {
        if (config('skeletor.reseau_de_deploiement') != 'intradef') {
            return;
        }
        
        $TULEAP_TOKEN = config('skeletor.services.tuleap.token');
        $TULEAP_URL = config('skeletor.services.tuleap.url');
        $TULEAP_TRACKER_BUGREPORT = config('skeletor.services.tuleap.tracker_bugreport');
        
        $response = Http::withoutVerifying()
            ->withHeaders(["X-Auth-AccessKey" => $TULEAP_TOKEN])
            ->post($TULEAP_URL  . "api/artifacts", [
                "tracker" =>  ["id" => $TULEAP_TRACKER_BUGREPORT ],
                "values_by_field" => [
                    "commentaire"    => [ "value" => $event->commentaire ],
                    "url"=>  ["value"  => $event->url ],
                    "user"=> ["value" => $event->user->display_name ]
                ]
            ]);
    }
}
