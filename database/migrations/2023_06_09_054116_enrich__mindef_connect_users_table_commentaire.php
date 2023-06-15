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
        Schema::table('mindef_connect_users', function (Blueprint $table) {
            $table->string('commentaire')->nullable(true)->default(NULL); 
        });
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mindef_connect_users', function (Blueprint $table) {
            $table->dropColumn('commentaire');
        });
    }
};
