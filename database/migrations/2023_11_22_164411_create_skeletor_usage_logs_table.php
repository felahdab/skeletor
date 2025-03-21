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
        Schema::create('skeletor_usage_logs', function (Blueprint $table) {
            $table->id();
            $table->string('uri', length: 2048);
            $table->string('route');
            $table->string('session')->nullable();
            $table->string('source')->nullable();
            $table->string('user-agent');
            $table->string('user-email');
            $table->integer('status');
            $table->ipAddress('ip');
            $table->string('method');
            $table->float('response_time', 5, 3)->default(0);
            $table->unsignedInteger('counter');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skeletor_usage_logs');
    }
};
