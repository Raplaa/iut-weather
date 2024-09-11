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
        Schema::create('place_user', function (Blueprint $table) {
            $table->foreignId('place_id')->references('id')->on('places')->onDelete('cascade');
            $table->foreignId('user_id')->references('id')->on('places')->onDelete('cascade');
            $table->boolean('is_favorite')->default(false);
            $table->boolean('send_forecast')->default(false);
            $table->primary(['place_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('place_user');
    }
};
