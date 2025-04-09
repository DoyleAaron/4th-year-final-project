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
        Schema::create('goalkeeper_predictions_input', function (Blueprint $table) {
            $table->id();
        $table->string('result')->nullable();
        $table->string('team')->nullable();
        $table->string('opponent')->nullable();
        $table->boolean('started')->nullable();
        $table->string('position')->nullable();
        $table->float('minutes_played')->nullable();
        $table->float('sota')->nullable();
        $table->float('ga')->nullable();
        $table->float('saves')->nullable();
        $table->float('save_percentage')->nullable();
        $table->float('cs')->nullable();
        $table->string('player_name')->nullable();
        $table->float('fantasy_points')->nullable();
        $table->float('player_saves_form')->nullable();
        $table->float('player_clean_sheet_form')->nullable();
        $table->float('player_goals_against_form')->nullable();
        $table->float('player_fp_form')->nullable();
        $table->integer('team_form_rating')->nullable();
        $table->integer('opponent_form_rating')->nullable();
        $table->unsignedBigInteger('team_id')->nullable();
        $table->unsignedBigInteger('player_code')->nullable();
        $table->unsignedBigInteger('opponent_id')->nullable();
        $table->boolean('started_id')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goalkeeper_predictions_input');
    }
};
