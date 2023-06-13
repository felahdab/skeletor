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
        Schema::table('transformation_sous_objectifs', function (Blueprint $table) {
            $table->string('ssobj_lienurl')->nullable(true)->default(NULL); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transformation_sous_objectifs', function (Blueprint $table) {
            $table->dropColumn('ssobj_lienurl');
        });
    }
};
