<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public $renames = [
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
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->renames as $from) {
            $to = 'transformation_' . $from;
            Schema::rename($from, $to);
        }
        Schema::rename('transformation_user_sous_objectif', 'transformation_user_sous_objectifs');

        $r=DB::select('select batch from migrations where migration LIKE "2022_11_14_135052_constraint_foreign_id_keys"');
        $batch = $r[0]->batch;
        DB::insert('insert into migrations (migration, batch) values (?,?)', ['2022_11_14_135053_constraint_foreign_id_keys',$batch]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('transformation_user_sous_objectifs', 'transformation_user_sous_objectif');
        foreach ($this->renames as $to) {
            $from = 'transformation_' . $to;
            Schema::rename($from, $to);
        }
    }
};
