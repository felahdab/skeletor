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
         
        
        Schema::table('bug_reports', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bug_reports', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
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
