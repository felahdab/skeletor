<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('poseidoninstances', function (Blueprint $table) {
            $table->json('node_description')->nullable();
            $table->json('versions')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('poseidoninstances', function (Blueprint $table) {
            $table->dropColumn(['node_description', 'versions']);
        });
    }
};
