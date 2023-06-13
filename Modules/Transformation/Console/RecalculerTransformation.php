<?php

namespace Modules\Transformation\Console;

use App\Service\RecalculerTransformationService;

use Illuminate\Console\Command;

class RecalculerTransformation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transformation:recalculertransformation';

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

        RecalculerTransformationService::handle();
        
        return Command::SUCCESS;
    }
}
