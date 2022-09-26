<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\User;
use App\Models\Fonction;

class CalculateUserTransformationRatios implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        
        $user = $this->user;
        $fonctions = $user->fonctions()->get();
        
        foreach($fonctions as $fonction)
        {
            $taux = $user->pourcentage_valides_pour_fonction($fonction);
            $workitem = $fonction->pivot;
            $workitem->taux_de_transformation = $taux;
            $workitem->save();
        }
        $taux_global = $user->taux_de_transformation();
        $user->taux_de_transformation = $taux_global;
        $user->save();
        return;
    }
}
