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
        'statistiques'
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->renames as $to) {
            $from = 'transformation_' . $to;
            Schema::rename($from, $to);
        }
    }
};
