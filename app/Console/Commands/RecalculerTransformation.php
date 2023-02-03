<?php

namespace App\Console\Commands;
use App\Models\User;
use App\Jobs\CalculateUserTransformationRatios;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

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
        foreach (User::withTrashed()->get() as $user) {
            if ($user->date_archivage != null)
                continue;
            $this->info("Cal du nombre de jour pour les validations de sous objectifs pour: " . $user->id);
            $date_embarq = new Carbon($user->date_embarq);
            foreach($user->sous_objectifs as $sousobj){
                $workitem = $sousobj->pivot;
                if ($workitem->date_validation != null) {
                    $date_validation = new Carbon($workitem->date_validation);
                    
                    $nb_jours = $date_validation->diffInDays($date_embarq);
                    
                    $workitem->nb_jours_pour_validation=$nb_jours;
                    $workitem->save();
                }
                else {
                    $workitem->nb_jours_pour_validation=0;
                    $workitem->save();
                }
            }
        }
        
        foreach (User::withTrashed()->get() as $user) {
            if ($user->date_archivage != null)
                continue;
            $this->info("Cal du nombre de jour pour les validations des fonctions pour: " . $user->id);
            $date_embarq = new Carbon($user->date_embarq);
            foreach($user->fonctions as $fonction){
                $workitem = $fonction->pivot;
                if ($workitem->date_lache != null){
                    $date_lache   = new Carbon($workitem->date_lache );
                    
                    $nb_jours = $date_lache->diffInDays($date_embarq);
                    
                    $workitem->nb_jours_pour_validation=$nb_jours;
                    $workitem->save();
                }
                else {
                    $workitem->nb_jours_pour_validation=0;
                    $workitem->save();
                }
            }
        }
        
        foreach (User::withTrashed()->get() as $user) {
            if ($user->date_archivage != null)
                continue;
            $this->info("Dispatching: " . $user->id);
            CalculateUserTransformationRatios::dispatch($user);
        }
        
        return Command::SUCCESS;
    }
}
