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
        Schema::create('transformation_compagnonage_tache', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->foreignId('compagnonage_id');
			$table->foreignId('tache_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transformation_compagnonage_tache');
    }
};
