<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
        return;
        foreach ($this->renames as $from) {
            $to = 'transformation_' . $from;
            Schema::rename($from, $to);
        }
        Schema::rename('transformation_user_sous_objectif', 'transformation_user_sous_objectifs');
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
