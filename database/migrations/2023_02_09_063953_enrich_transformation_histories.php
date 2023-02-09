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
        Schema::table('transformation_histories', function (Blueprint $table) {
            $table->string('modifying_user', 500)->nullable(true);
            $table->string('modified_user', 500)->nullable(true);
        }
        Schema::table('transformation_histories', function (Blueprint $table) {
            $table->string('modifying_user_id')->nullable(true)->change();
            $table->string('modified_user_id')->nullable(true)->change();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transformation_histories', function (Blueprint $table) {
            $table->dropColumn('modifying_user');
            $table->dropColumn('modified_user');
        }
        Schema::table('transformation_histories', function (Blueprint $table) {
            $table->string('modifying_user_id')->nullable(false)->change();
            $table->string('modified_user_id')->nullable(false)->change();
        });
    }};
