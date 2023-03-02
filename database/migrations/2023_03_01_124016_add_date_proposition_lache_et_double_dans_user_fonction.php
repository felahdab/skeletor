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
            $table->date('date_proposition_double')->nullable(true)->default(null);
            $table->date('date_proposition_lache')->nullable(true)->default(null);
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
            $table->dropColumn('date_proposition_double');
            $table->dropColumn('date_proposition_lache');
        });
    }
};
