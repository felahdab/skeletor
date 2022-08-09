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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('grade_libcourt', 10)->nullable(false)->default("");
            $table->string('grade_liblong', 100)->nullable(false)->default("");
            $table->integer('ordre_classmt')->nullable(false);
        });
		
		Schema::create('specialites', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('specialite_libcourt', 20)->nullable(false)->default("");
            $table->string('specialite_liblong', 256)->nullable(false)->default("");
        });
		
		Schema::create('diplomes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('diplome_libcourt', 10)->nullable(false)->default("");
            $table->string('diplome_liblong', 150)->nullable(false)->default("");
			$table->integer('ordre_classmt')->nullable(false);
        });
		
		Schema::create('unites', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('unite_libcourt', 10)->nullable(false)->default("");
            $table->string('unite_liblong', 150)->nullable(false)->default("");
        });
		
		Schema::create('secteurs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('secteur_libcourt', 20)->nullable(false)->default("");
            $table->string('secteur_liblong', 256)->nullable(false)->default("");
			$table->foreignId('service_id')->nullable(false);
        });
		
		Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('service_libcourt', 15)->nullable(false)->default("");
            $table->string('service_liblong', 256)->nullable(false)->default("");
			$table->foreignId('groupement_id')->nullable(false);
        });
		
		Schema::create('groupements', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('groupement_libcourt', 15)->nullable(false)->default("");
            $table->string('groupement_liblong', 256)->nullable(false)->default("");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grades');
		Schema::dropIfExists('specialites');
		Schema::dropIfExists('diplomes');
		Schema::dropIfExists('unites');
		Schema::dropIfExists('secteurs');
		Schema::dropIfExists('services');
		Schema::dropIfExists('groupements');
    }
};
