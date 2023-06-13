<?php

namespace Modules\Transformation\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Carbon;

use App\Models\User;
use Modules\Transformation\Entities\Fonction;

class CalculateUserNbJoursValidation implements ShouldQueue
{
    use Dispatchable, Batchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->batch()?->cancelled())
        {
            return;
        }
        
        $user = $this->user;
        if ($user->date_archivage != null)
            return;
            
        // $this->info("Cal du nombre de jour pour les validations de sous objectifs pour: " . $user->id);

        foreach($user->sous_objectifs as $sousobj){
            $workitem = $sousobj->pivot;
            $workitem->nb_jours_pour_validation=0;
            if ($workitem->date_validation != null) {
                $date_embarq = new Carbon($user->date_embarq);
                $date_validation = new Carbon($workitem->date_validation);                   
                $nb_jours = $date_embarq->diffInDays($date_validation, false);
                if ($nb_jours > 0) $workitem->nb_jours_pour_validation=$nb_jours;
            }
            $workitem->save();
        }

        foreach($user->fonctions as $fonction){
            $workitem = $fonction->pivot;
            $workitem->nb_jours_pour_validation=0;
            if ($workitem->date_lache != null){
                $date_lache   = new Carbon($workitem->date_lache );
                $date_embarq = new Carbon($user->date_embarq);                    
                $nb_jours = $date_embarq->diffInDays($date_lache, false);                    
                if ($nb_jours > 0) $workitem->nb_jours_pour_validation=$nb_jours;
            }
            $workitem->save();
        }

        return;
    }
}
