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
            $table->decimal('taux_de_transformation', 10,2)->nullable(true)->default(0);
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
            $table->dropColumn('taux_de_transformation');
        });
    }
};
