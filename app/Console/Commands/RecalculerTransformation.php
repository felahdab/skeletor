<?php

namespace App\Console\Commands;
use App\Models\User;
use App\Jobs\CalculateUserTransformationRatios;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\DB;

class RecalculerTransformation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ffast:recalculertransformation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalcule les taux de transformation et les durees de validation pour tous les utilisateurs';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ini_set("memory_limit", "512000000");
        $users=User::withTrashed()->get();
        
        foreach ($users as $user) {

            if ($user->date_archivage != null)
                continue;
                
            $this->info("Cal du nombre de jour pour les validations de sous objectifs pour: " . $user->id);

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
        }        

        foreach ($users as $user) {
            if ($user->date_archivage != null)
                continue;
            $this->info("Cal du nombre de jour pour les validations des fonctions pour: " . $user->id);
            
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
        }
        
        foreach ($users as $user) {
            if ($user->date_archivage != null)
                continue;
            $this->info("Dispatching: " . $user->id);
            CalculateUserTransformationRatios::dispatch($user);
        }
        
        return Command::SUCCESS;
    }
}
