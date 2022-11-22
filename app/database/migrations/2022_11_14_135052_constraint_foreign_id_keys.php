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
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
        
        Schema::table('services', function (Blueprint $table) {
            $table->foreign('groupement_id')->references('id')->on('groupements')->onDelete('cascade');
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('set null');
            $table->foreign('specialite_id')->references('id')->on('specialites')->onDelete('set null');
            $table->foreign('diplome_id')->references('id')->on('diplomes')->onDelete('set null');
            $table->foreign('secteur_id')->references('id')->on('secteurs')->onDelete('restrict');
            $table->foreign('unite_id')->references('id')->on('unites')->onDelete('restrict');
            $table->foreign('unite_destination_id')->references('id')->on('unites')->onDelete('restrict');
         });
         
        Schema::table('sous_objectifs', function (Blueprint $table) {
            $table->unsignedBigInteger('lieu_id')->nullable(true)->change();
            $table->foreign('objectif_id')->references('id')->on('objectifs')->onDelete('cascade');
            $table->foreign('lieu_id')->references('id')->on('lieux');
         });
         
        Schema::table('fonctions', function (Blueprint $table) {
            $table->unsignedBigInteger('typefonction_id')->nullable(true)->change();
            $table->foreign('typefonction_id')->references('id')->on('type_fonctions');
         });
         
        Schema::table('stages', function (Blueprint $table) {
            $table->unsignedBigInteger('typelicence_id')->nullable(true)->change();
            $table->foreign('typelicence_id')->references('id')->on('type_licences')->onDelete('restrict');
         });
         
        Schema::table('tache_objectif', function (Blueprint $table) {
            $table->foreign('tache_id')->references('id')->on('taches')->onDelete('cascade');
            $table->foreign('objectif_id')->references('id')->on('objectifs')->onDelete('cascade');
        });
        
        Schema::table('compagnonage_tache', function (Blueprint $table) {
            $table->foreign('compagnonage_id')->references('id')->on('compagnonages')->onDelete('cascade');
            $table->foreign('tache_id')->references('id')->on('taches')->onDelete('cascade');
        });
        
        Schema::table('compagnonage_fonction', function (Blueprint $table) {
            $table->foreign('compagnonage_id')->references('id')->on('compagnonages')->onDelete('cascade');
            $table->foreign('fonction_id')->references('id')->on('fonctions')->onDelete('cascade');
        });
        
        Schema::table('fonction_stage', function (Blueprint $table) {
            $table->foreign('fonction_id')->references('id')->on('fonctions')->onDelete('cascade');
            $table->foreign('stage_id')->references('id')->on('stages')->onDelete('cascade');
        });
        
        Schema::table('user_fonction', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('fonction_id')->references('id')->on('fonctions')->onDelete('cascade');
        });
        
        Schema::table('user_stage', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('stage_id')->references('id')->on('stages')->onDelete('cascade');
        });
        
        Schema::table('user_sous_objectif', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sous_objectif_id')->references('id')->on('sous_objectifs')->onDelete('cascade');
        });
        
        Schema::table('statistiques', function (Blueprint $table) {
            $table->foreign('unite_id')->references('id')->on('unites')->onDelete('cascade');
        });
        
        Schema::table('bug_reports', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        Schema::table('transformation_histories', function (Blueprint $table) {
            $table->foreign('modifying_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('modified_user_id')->references('id')->on('users')->onDelete('cascade');
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
