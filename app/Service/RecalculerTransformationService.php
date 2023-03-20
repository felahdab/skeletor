<?php
namespace App\Service;

use App\Models\User;

use App\Jobs\CalculateUserTransformationRatios;
use App\Jobs\CalculateUserNbJoursValidation;

use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

class RecalculerTransformationService
{
    public static function handle()
    {
        $users=User::withTrashed()->get();
        
        $joblist=[];

        foreach ($users as $user) {
            // $this->info("Job d'arriere plan: calcul du nombre de jours pour validation des sous objectifs et des fonctions: " . $user->id);
            $joblist[]= new CalculateUserNbJoursValidation($user);
        } 

        $batch_nb_jours=Bus::batch($joblist)
            // ->then(function(Batch $batch)
            // {
            //     return;
            // })
            // ->catch(function(Batch $batch, Throwable $e)
            // {
            //     return;
            // })
            // ->finally(function(Batch $batch)
            // {
            //     return;
            // })
            ->name("Calcul des durees de validation.")
            ->dispatch();

        $nb_jours_batch_id=$batch_nb_jours->id;

        $joblist=[];
        
        foreach ($users as $user) {
            if ($user->date_archivage != null)
                continue;
            // $this->info("Job d'arriere plan: calcul du taux de transformation: " . $user->id);
            $joblist[]= new CalculateUserTransformationRatios($user);
        }

        $batch_tx_transfo=Bus::batch($joblist)
            // ->then(function(Batch $batch)
            // {
            //     return;
            // })
            // ->catch(function(Batch $batch, Throwable $e)
            // {
            //     return;
            // })
            // ->finally(function(Batch $batch)
            // {
            //     return;
            // })
            ->name("Calcul des taux de transformation.")
            ->dispatch();

        $tx_transfo_batch_id=$batch_tx_transfo->id;

        return [
            'nb_jours_batch_id'   => $nb_jours_batch_id,
            'tx_transfo_batch_id' => $tx_transfo_batch_id
        ];
    }
}