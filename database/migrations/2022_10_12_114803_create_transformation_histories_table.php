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
        Schema::create('transformation_histories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('modifying_user', 500)->nullable(true);
            $table->string('modified_user', 500)->nullable(true);
            $table->string('event')->nullable(false);
            $table->text('event_details')->nullable(false)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transformation_histories');
    }
};
