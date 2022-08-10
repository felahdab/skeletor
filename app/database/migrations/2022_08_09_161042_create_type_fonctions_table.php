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
        Schema::create('type_fonctions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->string('typfonction_libcourt', 100)->nullable(false);
			$table->string('typfonction_liblong', 256)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_fonctions');
    }
};
