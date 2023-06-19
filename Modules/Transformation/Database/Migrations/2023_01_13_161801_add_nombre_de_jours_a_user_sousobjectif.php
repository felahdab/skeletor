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
        Schema::table('transformation_user_sous_objectifs', function (Blueprint $table) {
            $table->integer('nb_jours_pour_validation')->nullable(true)->default(0); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transformation_user_sous_objectifs', function (Blueprint $table) {
            $table->dropColumn('nb_jours_pour_validation');
        });
    }
};
