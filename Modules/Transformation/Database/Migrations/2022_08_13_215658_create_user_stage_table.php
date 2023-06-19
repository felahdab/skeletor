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
        Schema::create('transformation_user_stage', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->foreignId('user_id');
			$table->foreignId('stage_id');
			$table->string('commentaire', 250)->nullable(true)->default(null);
			$table->date('date_validation')->nullable(true)->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transformation_user_stage');
    }
};
