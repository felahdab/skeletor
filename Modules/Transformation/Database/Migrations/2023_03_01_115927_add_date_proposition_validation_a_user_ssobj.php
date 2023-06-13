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
        Schema::table('transformation_user_sous_objectif', function (Blueprint $table) {
            $table->date('date_proposition_validation')->nullable(true)->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transformation_user_sous_objectif', function (Blueprint $table) {
            $table->dropColumn('date_proposition_validation');
        });
    }
};
