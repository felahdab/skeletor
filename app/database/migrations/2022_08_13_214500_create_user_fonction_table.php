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
        Schema::create('user_fonction', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->foreignId('user_id');
			$table->foreignId('fonction_id');
			$table->date('date_lache')->nullable(true)->default(null);
			$table->string('valideur_lache',255)->nullable(true)->default(null);
			$table->string('commentaire_lache', 255)->nullable(true)->default(null);
			$table->date('date_double')->nullable(true)->default(null);
			$table->string('valideur_double',255)->nullable(true)->default(null);
			$table->string('commentaire_double', 255)->nullable(true)->default(null);
			$table->date('validation')->nullable(true)->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_fonction');
    }
};
