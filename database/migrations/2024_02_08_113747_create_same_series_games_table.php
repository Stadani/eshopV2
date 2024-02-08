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
        Schema::create('same_series_games', function (Blueprint $table) {
            $table->foreignId('original_id')->constrained('games')->cascadeOnDelete();
            $table->foreignId('series_id')->constrained('games')->cascadeOnDelete();;
            $table->timestamps();
            $table->unique(['original_id', 'series_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('same_series_games');
    }
};
