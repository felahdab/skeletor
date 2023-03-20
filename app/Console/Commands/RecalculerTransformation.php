<?php

namespace App\Console\Commands;
use App\Models\User;

use App\Jobs\CalculateUserTransformationRatios;
use App\Jobs\CalculateUserNbJoursValidation;

use Illuminate\Console\Command;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Throwable;

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
        
        $joblist=[];

        foreach ($users as $user) {
            $this->info("Job d'arriere plan: calcul du nombre de jours pour validation des sous objectifs et des fonctions: " . $user->id);
            $joblist[]= new CalculateUserNbJoursValidation($user);
        } 

        $batch_nb_jours=Bus::batch($joblist)
            ->then(function(Batch $batch)
            {
                return;
            })
            ->catch(function(Batch $batch, Throwable $e)
            {
                return;
            })
            ->finally(function(Batch $batch)
            {
                return;
            })
            ->name("Calcul des durees de validation.")
            ->dispatch();

        $joblist=[];
        
        foreach ($users as $user) {
            if ($user->date_archivage != null)
                continue;
            $this->info("Job d'arriere plan: calcul du taux de transformation: " . $user->id);
            $joblist[]= new CalculateUserTransformationRatios($user);
        }

        $batch_tx_transfo=Bus::batch($joblist)
            ->then(function(Batch $batch)
            {
                return;
            })
            ->catch(function(Batch $batch, Throwable $e)
            {
                return;
            })
            ->finally(function(Batch $batch)
            {
                return;
            })
            ->name("Calcul des taux de transformation.")
            ->dispatch();
        
        return Command::SUCCESS;
    }
}
