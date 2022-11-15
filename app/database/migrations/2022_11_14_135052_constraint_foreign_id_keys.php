<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('secteurs', function (Blueprint $table) {
            $table->foreign('service_id')->references('id')->on('services');
        });
        
        Schema::table('services', function (Blueprint $table) {
            $table->foreign('groupement_id')->references('id')->on('groupements');
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('grade_id')->references('id')->on('grades');
            $table->foreign('specialite_id')->references('id')->on('specialites');
            $table->foreign('diplome_id')->references('id')->on('diplomes');
            $table->foreign('secteur_id')->references('id')->on('secteurs');
            $table->foreign('unite_id')->references('id')->on('unites');
            $table->foreign('unite_destination_id')->references('id')->on('unites');
         });
         
        Schema::table('sous_objectifs', function (Blueprint $table) {
            $table->foreign('objectif_id')->references('id')->on('objectifs');
            $table->foreign('lieu_id')->references('id')->on('lieux');
         });
         
        Schema::table('fonctions', function (Blueprint $table) {
            $table->foreign('typefonction_id')->references('id')->on('type_fonctions');
         });
         
        Schema::table('stages', function (Blueprint $table) {
            $table->foreign('typelicence_id')->references('id')->on('type_licences');
         });
         
        Schema::table('tache_objectif', function (Blueprint $table) {
            $table->foreign('tache_id')->references('id')->on('taches');
            $table->foreign('objectif_id')->references('id')->on('objectifs');
        });
        
        Schema::table('compagnonage_tache', function (Blueprint $table) {
            $table->foreign('compagnonage_id')->references('id')->on('compagnonages');
            $table->foreign('tache_id')->references('id')->on('taches');
        });
        
        Schema::table('compagnonage_fonction', function (Blueprint $table) {
            $table->foreign('compagnonage_id')->references('id')->on('compagnonages');
            $table->foreign('fonction_id')->references('id')->on('fonctions');
        });
        
        Schema::table('fonction_stage', function (Blueprint $table) {
            $table->foreign('fonction_id')->references('id')->on('fonctions');
            $table->foreign('stage_id')->references('id')->on('stages');
        });
        
        Schema::table('user_fonction', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('fonction_id')->references('id')->on('fonctions');
        });
        
        Schema::table('user_stage', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('stage_id')->references('id')->on('stages');
        });
        
        Schema::table('user_sous_objectif', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('sous_objectif_id')->references('id')->on('sous_objectifs');
        });
        
        Schema::table('statistiques', function (Blueprint $table) {
            $table->foreign('unite_id')->references('id')->on('unites');
        });
        
        Schema::table('bug_reports', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
        
        Schema::table('transformation_histories', function (Blueprint $table) {
            $table->foreign('modifying_user_id')->references('id')->on('users');
            $table->foreign('modified_user_id')->references('id')->on('users');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transformation_histories', function (Blueprint $table) {
            $table->dropForeign(['modifying_user_id']);
            $table->dropForeign(['modified_user_id']);
        });
        
        Schema::table('bug_reports', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        
        Schema::table('statistiques', function (Blueprint $table) {
            $table->dropForeign(['unite_id']);
        });
        
        Schema::table('user_sous_objectif', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['sous_objectif_id']);
        });
        
        Schema::table('user_stage', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['stage_id']);
        });
        
        Schema::table('user_fonction', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['fonction_id']);
        });
        
        Schema::table('fonction_stage', function (Blueprint $table) {
            $table->dropForeign(['fonction_id']);
            $table->dropForeign(['stage_id']);
        });
        
        Schema::table('compagnonage_fonction', function (Blueprint $table) {
            $table->dropForeign(['compagnonage_id']);
            $table->dropForeign(['fonction_id']);
        });
        
        Schema::table('compagnonage_tache', function (Blueprint $table) {
            $table->dropForeign(['compagnonage_id']);
            $table->dropForeign(['tache_id']);
        });
        
        Schema::table('tache_objectif', function (Blueprint $table) {
            $table->dropForeign(['tache_id']);
            $table->dropForeign(['objectif_id']);
        });
        
        Schema::table('stages', function (Blueprint $table) {
            $table->dropForeign(['typelicence_id']);
        });
         
        Schema::table('fonctions', function (Blueprint $table) {
            $table->dropForeign(['typefonction_id']);
        });         
        
        Schema::table('sous_objectifs', function (Blueprint $table) {
            $table->dropForeign(['objectif_id']);
            $table->dropForeign(['lieu_id']);
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['grade_id']);
            $table->dropForeign(['specialite_id']);
            $table->dropForeign(['diplome_id']);
            $table->dropForeign(['secteur_id']);
            $table->dropForeign(['unite_id']);
            $table->dropForeign(['unite_destination_id']);
        });
        
        Schema::table('secteurs', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
        });
        
        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign(['groupement_id']);
        });
    }
};
