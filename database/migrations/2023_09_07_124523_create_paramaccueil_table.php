<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paramaccueils', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('paramaccueil_image', 500);
            $table->string('paramaccueil_texte', 500);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paramaccueils');
    }
};
