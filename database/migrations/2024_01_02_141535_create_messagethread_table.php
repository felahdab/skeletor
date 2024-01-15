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
        Schema::create('message_thread', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('chat_thread_id')->references('id')->on('chat_threads');
            $table->foreignId('chat_message_id')->references('id')->on('chat_messages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_thread');
    }
};
