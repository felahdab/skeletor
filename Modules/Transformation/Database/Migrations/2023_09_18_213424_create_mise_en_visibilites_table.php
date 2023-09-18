<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transformation_mise_en_visibilites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unite_id')->references('id')->on('unites');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->boolean('sans_dates')->default(false)->nullable(false);
            $table->date('date_debut')->nullable(true);
            $table->date('date_fin')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transformation_mise_en_visibilites');
    }
};
