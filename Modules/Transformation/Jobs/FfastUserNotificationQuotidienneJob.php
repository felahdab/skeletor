<?php

namespace Modules\Transformation\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\User;

use Illuminate\Support\Carbon;

class FfastUserNotificationQuotidienneJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use Batchable;

    public $user=null;
    public $start_datetime=null;
    public $end_datetime=null;
    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->user=$user;
        $this->start_datetime = Carbon::yesterday();
        $this->end_datetime   = Carbon::today();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $modification_sous_objectifs=$this->user
                                    ->sous_objectifs()
                                    ->get()
                                    ->where("pivot.updated_at", ">", $this->start_datetime)
                                    ->where("pivot.updated_at", "<", $this->end_datetime);
        

    }

    public function build_notification_for_fonctions()
    {
        if (! $this->user->settings()->get('ffast.notifications.pour_fonctions.daily'))
            return;
        
        if (empty($this->user->settings()->get('ffast.notifications.pour_compagnonnages.liste_fonctions')))
            return;


    }

    public function build_notification_for_compagnonnages()
    {
        if (! $this->user->settings()->get('ffast.notifications.pour_compagnonnages.daily'))
            return;

        if (empty($this->user->settings()->get('ffast.notifications.pour_compagnonnages.liste_compagnonnages')))
            return;
        

    }

    public function build_notification_for_services()
    {
        if (! $this->user->settings()->get('ffast.notifications.pour_services.daily'))
            return;

        if (empty($this->user->settings()->get('ffast.notifications.pour_services.liste_services')))
            return;


    }
}
