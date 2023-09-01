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
        Schema::create('rh_personnes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('prenom', 100)->nullable(false)->default("");
            $table->string('display_name', 200)->nullable(false)->default("");
            $table->string('matricule', 20)->nullable(true)->default("");
            $table->date('date_embarq')->nullable(true);
            $table->date('date_debarq')->nullable(true);
            $table->string('photo', 256)->nullable(true);
            $table->foreignId('grade_id')->nullable(true);
            $table->foreignId('specialite_id')->nullable(true);
            $table->foreignId('diplome_id')->nullable(true);
            $table->foreignId('secteur_id')->nullable(true);
            $table->foreignId('unite_id')->nullable(true);
            $table->foreignId('unite_destination_id')->nullable(true);
            $table->string('user_comment', 500)->nullable();
            $table->string('nid', 15)->nullable(true);
            $table->boolean('comete')->default(false);
            $table->boolean('socle')->default(false);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rh_personnes');
    }
};
