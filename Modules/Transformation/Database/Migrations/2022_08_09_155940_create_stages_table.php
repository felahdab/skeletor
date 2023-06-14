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
        Schema::create('transformation_stages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->string('stage_libcourt', 50)->nullable(false);
			$table->string('stage_liblong', 256)->nullable(false);
			$table->boolean('transverse')->nullable(false)->default(false);
			$table->foreignId('typelicence_id')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transformation_stages');
    }
};
