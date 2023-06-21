<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use Nwidart\Modules\Facades\Module;

class AdaptionDuSchemaDeBase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ffast:modularisation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commande ephemere d adaptation du schema de base et de l historique des migrations';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $renames = [
            'fonctions',
            'compagnonages',
            'compagnonage_fonction',
            'compagnonage_tache',
            'sous_objectifs',
            'objectifs',
            'taches',
            'tache_objectif',
            'type_fonctions',
            'user_fonction',
            'user_sous_objectif',
            'fonction_stage',
            'stages',
            'user_stage',
            'type_licences',
            'statistiques',
            'transformation_histories',
            'archives'
        ];

        foreach ($renames as $from) {
            $to = 'transformation_' . $from;
            Schema::rename($from, $to);
        }
        Schema::rename('transformation_user_sous_objectif', 'transformation_user_sous_objectifs');

        $r=DB::select('select batch from migrations where migration LIKE "2022_11_14_135052_constraint_foreign_id_keys"');
        $batch = $r[0]->batch;
        DB::insert('insert into migrations (migration, batch) values (?,?)', ['2022_11_14_135053_constraint_foreign_id_keys',$batch]);
        return 0;

        $from=module_path('Transformation', 'Database/Migrations/2022_11_14_135053_constraint_foreign_id_keys.php.stub');
        $to=module_path('Transformation', 'Database/Migrations/2022_11_14_135053_constraint_foreign_id_keys.php');
        rename($from, $to);

        $command_path = app_path('Console/Commands/AdaptionDuSchemaDeBase.php');
        unlink($command_path);
    }
}
