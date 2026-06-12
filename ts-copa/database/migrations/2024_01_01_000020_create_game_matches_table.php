<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_team_id')->constrained('teams');
            $table->foreignId('away_team_id')->constrained('teams');
            $table->dateTime('match_date');
            $table->integer('home_score')->nullable();
            $table->integer('away_score')->nullable();
            $table->decimal('prize_pool', 10, 2)->nullable();
            $table->string('status')->default('apostas'); // apostas | em_andamento | finalizado
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_matches');
    }
};
