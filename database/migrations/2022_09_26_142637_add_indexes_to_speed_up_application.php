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
        Schema::table('user_fonction', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('fonction_id');
        });
        Schema::table('fonctions', function (Blueprint $table) {
            $table->index('typefonction_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_fonction', function (Blueprint $table) {
            $table->dropIndex(['fonction_id']);
            $table->dropIndex(['user_id']);
        });
        Schema::table('fonctions', function (Blueprint $table) {
            $table->dropIndex(['typefonction_id']);
        });
    }
};
