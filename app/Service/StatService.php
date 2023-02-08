<?php
namespace App\Service;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Statistique;

class StatService
{
    public static function statuser(User $user)
    {
        $date_stat = Carbon::now();
        // nb de jours passés au GTR
        $date_embarq = new Carbon($user->date_embarq);
        $date_debarq = new Carbon($user->date_debarq);
        $nb_jour_gtr = $date_debarq->diffInDays($date_embarq);
        // tx transfo stage
        $nb_stage_total = 0;
        $nb_stage_total = $user->stages()->get()->count();
        $nb_stage_valides = 0;
        $nb_stage_valides = $user->stages()->wherePivotNotNull('date_validation')->get()->count();
        $taux_validation_stage = 0;
        if ($nb_stage_total>0)
            $taux_validation_stage = 100 * $nb_stage_valides / $nb_stage_total;
        // tx transfo compagnonnage
        $sous_objs = $user->coll_sous_objectifs();
        $total_des_coeff = $sous_objs->sum('ssobj_coeff');
        $sous_objs_valides = $user->sous_objectifs()
                            ->whereNotNull('date_validation')->get();
        $coeff_valides = $sous_objs_valides->sum('ssobj_coeff');
        $taux_validation_coeff=0;
        if ($total_des_coeff>0)
            $taux_validation_coeff = 100 * $coeff_valides / $total_des_coeff;
        // temps de lacher en jours foncquai
        $nb_jour_quai=0;
        $fonction_a_quai = $user->fonctionAQuai();
        if (!is_null($fonction_a_quai)){
            if (!is_null($fonction_a_quai->pivot->date_lache)){
                $date_validation = new Carbon($fonction_a_quai->pivot->date_lache);
                $nb_jour_quai= $date_validation->diffInDays($date_embarq);
            }    
        }
        // temps de lacher en jours foncmer
        $nb_jour_mer= 0;
        $fonction_a_mer = $user->fonctionAMer();
        if (!is_null($fonction_a_mer)){
            $latest_validation_date = $fonction_a_mer
                ->orderBy('pivot_date_lache','desc')
                ->wherePivotNotNull('date_lache')
                ->get()->first();
            
            if (!is_null($latest_validation_date)){
                $date_validation = new Carbon($latest_validation_date->pivot->date_lache);
                $nb_jour_mer= $date_validation->diffInDays($date_embarq);
            }    
        }
        // temps de lacher en jours foncmetier
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
            }
        }
// voir si unite id toujours utile? 
        $uniteid= $user->unite_id;       
        if ($uniteid==Null)
            $uniteid=2;
        
        $stat = Statistique::create([
            'date_stat'                 => $date_stat,
            'unite_id'                  => $user->unite_id,
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
            'taux_de_transformation'    => $user->taux_de_transformation,
            'nb_jour_pour_lache_quai'   => $nb_jour_quai,
            'nb_jour_pour_lache_mer'    => $nb_jour_mer,
            'nb_jour_pour_lache_metier' => $nb_jour_metier,]
        );
    }

    public static function GenerateStatistics($date_calcul)
    {
        $date_max = $date_calcul->copy()->lastOfMonth();
        $date_min = $date_calcul->copy()->firstOfMonth();
        $period =$date_calcul->format("Y") . "-" . $date_calcul->format("m");

        $existing_stats_for_period = Statistique::all()->where('periode', $period);
        foreach ($existing_stats_for_period as $stat)
        {
            $dbrecord = Statistique::find($stat->id);
            $dbrecord->delete();
        }
        
        $users = User::withTrashed()
            ->where('date_debarq', '>', $date_min)
            ->where('date_debarq', '<=', $date_max)
            ->get();
        foreach ($users as $user)
        {
            StatService::statuser($user);
        }
    }
}