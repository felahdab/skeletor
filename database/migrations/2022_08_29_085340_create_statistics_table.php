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
        Schema::create('transformation_statistiques', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('date_stat')->nullable();
            $table->foreignId('unite_id')->nullable(false);
            $table->string('name', 250)->nullable(false);
            $table->string('prenom', 250)->nullable(false);
            $table->date('date_debarq')->nullable(false);
            $table->integer('nb_jour_gtr')->nullable(false);
            $table->string('grade', 250)->nullable(false);
            $table->string('diplome', 250)->nullable(false);
            $table->string('specialite', 250)->nullable(false);
            $table->string('secteur', 250)->nullable(false);
            $table->string('service', 250)->nullable(false);
            $table->string('gpmt', 250)->nullable(false);
            $table->float('taux_stage_valides', 4,2)->default(0);
            $table->float('taux_comp_valides', 4,2)->default(0);
            $table->float('taux_de_transformation', 4,2)->default(0);
            $table->integer('nb_jour_pour_lache_quai')->default(0);
            $table->integer('nb_jour_pour_lache_mer')->default(0);
            $table->integer('nb_jour_pour_lache_metier')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transformation_statistiques');
    }
};
