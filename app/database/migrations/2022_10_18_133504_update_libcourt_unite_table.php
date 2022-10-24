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
        //ALTER TABLE `unites` CHANGE `unite_libcourt` `unite_libcourt` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''; 
        Schema::table('unites', function (Blueprint $table) {
        $table->string('unite_libcourt', 50)->nullable(false)->default("")->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unites', function (Blueprint $table) {
        $table->string('unite_libcourt', 50)->nullable(false)->default("")->change();
        });
    }
};
