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
        Schema::create('transformation_fonctions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->string('fonction_libcourt', 100)->nullable(false);
			$table->string('fonction_liblong', 256)->nullable(false);
			$table->foreignId('typefonction_id')->nullable(false);
			$table->boolean('fonction_lache')->nullable(false)->default(false);
			$table->boolean('fonction_double')->nullable(false)->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transformation_fonctions');
    }
};
