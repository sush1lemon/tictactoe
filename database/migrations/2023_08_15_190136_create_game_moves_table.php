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
        Schema::create('game_moves', function (Blueprint $table) {
            $table->id();
            $table->uuid('game_id')->references('id')->on('games')->onDelete('cascade');;
            $table->integer('game_round');
            $table->uuid('player_id')->references('id')->on('players')->onDelete('cascade');
            $table->tinyInteger('position');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_moves');
    }
};
