<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\User;
use App\Jobs\CalculateUserTransformationRatios;

class RecalculTxTransfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ffast:recalcultxtransfo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalcul de tous les taux de transformation de tous les users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach (User::withTrashed()->get() as $user) 
            CalculateUserTransformationRatios::dispatch($user);
        
        return Command::SUCCESS;
    }
}
