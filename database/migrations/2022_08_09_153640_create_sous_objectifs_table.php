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
        Schema::create('sous_objectifs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->string('ssobj_lib', 500);
			$table->decimal('ssobj_coeff', 10,2)->nullable(false)->default(1.0);
			$table->float('ssobj_duree', 10,2)->nullable(false)->default(0.0);
			$table->foreignId('objectif_id')->nullable()->default(null);
			$table->foreignId('lieu_id')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sous_objectifs');
    }
};
