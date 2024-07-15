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
        Schema::table('transformation_user_stage', function (Blueprint $table) {
            $table->string('commentaire', 1500)->change();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transformation_user_stage', function (Blueprint $table) {
            $table->string('commentaire', 500)->change();
            });
    }
};

