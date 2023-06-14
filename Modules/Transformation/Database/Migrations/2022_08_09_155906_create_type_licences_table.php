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
        Schema::create('transformation_type_licences', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->string('typlicense_libcourt',50)->nullable(false);
			$table->string('typlicense_liblong',500)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transformation_type_licences');
    }
};

