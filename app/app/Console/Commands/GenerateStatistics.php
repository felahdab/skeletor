<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

use App\Models\Unite;
use App\Models\User;
use App\Models\Statistique;

use DateTime;

class GenerateStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ffast:makestatistics 
                              {unite=2}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date_stat = Carbon::now();
        
        $periode = $date_stat->year . "/" . $date_stat->month;
        
        if ($this->confirm("Ceci va recalculer les statistiques pour la période: " . $periode))
        {
            $existing_stats_for_period = Statistique::all()->where('periode', $periode);
            foreach ($existing_stats_for_period as $stat)
            {
                $dbrecord = Statistique::find($stat->id);
                print_r($dbrecord->id . "\r\n");
                $dbrecord->delete();
            }
            
            $date_max = Carbon::now()->lastOfMonth();
            $date_min = Carbon::now()->firstOfMonth();
            $this->info("Statistiques du " . $date_min . " jusqu'au " . $date_max);
            
            $unite = Unite::find($this->argument('unite'));
            $this->info("Pour l'unite: " . $unite->unite_libcourt);

            $users = User::where('unite_id', $unite->id)
                ->where('date_debarq', '>', $date_min)
                ->where('date_debarq', '<=', $date_max)
                ->whereNotIn('unite_destination_id',[1,2,19]) // Les 2 GTR et hors escouade
                ->whereNotNull('unite_destination_id')
                ->get();
                
            // $this->info($users);
            
            foreach ($users as $user)
            {
                $this->info($user->displayString());
                $date_embarq = new Carbon($user->date_embarq);
                $date_debarq = new Carbon($user->date_debarq);
                $nb_jour_gtr = $date_debarq->diffInDays($date_embarq);
                $this->info($nb_jour_gtr);
                
                $nb_stage_total = 0;
                $nb_stage_total = $user->stages()->get()->count();
                
                $nb_stage_valides = 0;
                $nb_stage_valides = $user->stages()->wherePivotNotNull('date_validation')->get()->count();
                $taux_validation_stage = 0;
                if ($nb_stage_total>0)
                    $taux_validation_stage = 100 * $nb_stage_valides / $nb_stage_total;
                
                $sous_objs = $user->coll_sous_objectifs();
                $total_des_coeff = $sous_objs->sum('ssobj_coeff');
                // $this->info($total_des_coeff);
                
                $sous_objs_valides = $user->sous_objectifs()
                                    ->whereNotNull('date_validation')->get();
                $coeff_valides = $sous_objs_valides->sum('ssobj_coeff');
                // $this->info($coeff_valides);
                
                $taux_validation_coeff=0;
                if ($total_des_coeff>0)
                    $taux_validation_coeff = 100 * $coeff_valides / $total_des_coeff;
                
                $taux_transfo=0;
                if ($nb_stage_total>0 and $total_des_coeff>0){
                    $taux_transfo = 100 * ($nb_stage_valides + $coeff_valides) / ($nb_stage_total + $total_des_coeff) ;
                }
                
                $nb_jour_quai=0;
                $fonction_a_quai = $user->fonctionAQuai();
                if (!is_null($fonction_a_quai)){
                    if (!is_null($fonction_a_quai->pivot->date_lache)){
                        $date_validation = new Carbon($fonction_a_quai->pivot->date_lache);
                        $nb_jour_quai= $date_validation->diffInDays($date_embarq);
                        $this->info($nb_jour_quai);
                    }    
                }
                
                $nb_jour_mer= 0;
                $fonction_a_mer = $user->fonctionAMer();
                if (!is_null($fonction_a_mer)){
                    if (!is_null($fonction_a_mer->pivot->date_lache)){
                        $date_validation = new Carbon($fonction_a_mer->pivot->date_lache);
                        $nb_jour_mer= $date_validation->diffInDays($date_embarq);
                        $this->info($nb_jour_mer);
                    }    
                }
                
                $nb_jour_metier = 0;
                $fonctions_metier = $user->fonctionsMetier();
                if (!is_null($fonctions_metier)){
                    $latest_validation_date = $fonctions_metier
                        ->orderBy('pivot_date_lache','desc')
                        ->wherePivotNotNull('date_lache')
                        ->get()->first();
                    
                    if (!is_null($latest_validation_date)){
                        $date_validation = new Carbon($latest_validation_date->pivot->date_lache);
                        $nb_jour_metier= $date_validation->diffInDays($date_embarq);
                        $this->info($nb_jour_metier);
                    }
                }
                
                $stat = Statistique::create([
                    'date_stat'                 => $date_stat,
                    'unite_id'                  => $unite->id,
                    'name'                      => $user->name,
                    'prenom'                    => $user->prenom,
                    'date_debarq'               => $user->date_debarq,
                    'nb_jour_gtr'               => $nb_jour_gtr,
                    'grade'                     => $user->displayGrade(),
                    'diplome'                   => $user->displayDiplome(),
                    'specialite'                => $user->displaySpecialite(),
                    'secteur'                   => $user->displaySecteur(),
                    'service'                   => $user->displayService(),
                    'gpmt'                      => $user->groupement()->groupement_libcourt,
                    'taux_stage_valides'        => $taux_validation_stage,
                    'taux_comp_valides'         => $taux_validation_coeff,
                    'taux_de_transformation'    => $taux_transfo,
                    'nb_jour_pour_lache_quai'   => $nb_jour_quai,
                    'nb_jour_pour_lache_mer'    => $nb_jour_mer,
                    'nb_jour_pour_lache_metier' => $nb_jour_metier,]
                );
            }
            return 0;
        }
    }
}
