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
        Schema::create('mindef_connect_users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('email')->unique();
            $table->string('nom')->default('');
            $table->string('prenom')->default('');
            $table->string('main_department_number')->default('');
            $table->string('personal_title')->default('');
            $table->string('rank')->default('');
            $table->string('short_rank')->default('');
            $table->string('display_name')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mindef_connect_users');
    }
};
