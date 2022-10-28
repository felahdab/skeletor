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
        Schema::create('annudef_entries', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('titre', 200)->nullable(false)->default('');
            $table->string('nom', 200)->nullable(false)->default('');
            $table->string('prenom', 200)->nullable(false)->default('');
            $table->string('gradelong', 200)->nullable(false)->default('');
            $table->string('gradecourt', 200)->nullable(false)->default('');
            $table->string('nid', 200)->nullable(false)->default('');
            $table->string('nomcomplet', 200)->nullable(false)->default('');
            $table->string('nomaffiche', 200)->nullable(false)->default('');
            $table->string('uid', 200)->nullable(false)->default('');
            $table->string('email', 200)->nullable(false)->default('');
            $table->string('unites', 200)->nullable(false)->default('');
            $table->string('status', 200)->nullable(false)->default('');
            $table->string('prenomusuel', 200)->nullable(false)->default('');
            $table->string('categorystatus', 200)->nullable(false)->default('');
            $table->string('categoryrank', 200)->nullable(false)->default('');
            $table->string('familyname', 200)->nullable(false)->default('');
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('annudef_entries');
    }
};
