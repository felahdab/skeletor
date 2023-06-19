<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach(['transformation_tache_objectif', 'transformation_compagnonage_tache', 'transformation_compagnonage_fonction'] as $tablename)
        {
            Schema::table($tablename, function (Blueprint $table) {
                $table->integer('ordre')->nullable(true)->default(0); 
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach(['transformation_tache_objectif', 'transformation_compagnonage_tache', 'transformation_compagnonage_fonction'] as $tablename)
        {
            Schema::table($tablename, function (Blueprint $table) {
                $table->dropColumn('ordre'); 
            });
        }
    }
};
