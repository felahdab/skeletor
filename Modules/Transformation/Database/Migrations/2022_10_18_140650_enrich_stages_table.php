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
        Schema::table('transformation_stages', function (Blueprint $table) {
            $table->float('stage_duree', 10,2)->nullable(true);
            $table->string('stage_lieu', 100)->nullable(true);
            $table->integer('stage_capamax')->nullable(true);
            $table->date('stage_date_fin_licence')->nullable(true);
            $table->string('stage_commentaire', 500)->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transformation_stages', function (Blueprint $table) {
            $table->dropColumn('stage_duree');
            $table->dropColumn('stage_lieu');
            $table->dropColumn('stage_capamax');
            $table->dropColumn('stage_date_fin_licence');
            $table->dropColumn('stage_commentaire');
        });
    }
};
