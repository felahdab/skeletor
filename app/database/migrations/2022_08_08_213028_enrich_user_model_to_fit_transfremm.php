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
        Schema::table('users', function (Blueprint $table) {
            $table->string('prenom', 100)->nullable(false)->default("");
            $table->string('matricule', 20)->nullable(true)->default("");
            $table->date('date_embarq')->nullable(true);
            $table->date('date_debarq')->nullable(true);
            $table->string('photo', 256)->nullable(true);
            $table->foreignId('grade_id')->nullable(true);
            $table->foreignId('specialite_id')->nullable(true);
            $table->foreignId('diplome_id')->nullable(true);
            $table->foreignId('secteur_id')->nullable(true);
            $table->foreignId('unite_id')->nullable(true);
            $table->foreignId('unite_destination_id')->nullable(true);
            $table->string('user_comment', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('prenom');
            $table->dropColumn('matricule');
            $table->dropColumn('date_embarq');
            $table->dropColumn('date_debarq');
            $table->dropColumn('photo');
            $table->dropColumn('grade_id');
            $table->dropColumn('specialite_id');
            $table->dropColumn('diplome_id');
            $table->dropColumn('secteur_id');
            $table->dropColumn('unite_id');
            $table->dropColumn('unite_destination_id');
            $table->dropColumn('user_comment');
        });
    }
};
