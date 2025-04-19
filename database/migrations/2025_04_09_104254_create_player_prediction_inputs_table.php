<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('player_prediction_inputs', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('venue')->nullable();
            $table->string('result')->nullable();
            $table->string('team')->nullable();
            $table->string('opponent')->nullable();
            $table->boolean('started')->nullable();
            $table->string('position')->nullable();
            $table->float('minutes_played')->nullable();
            $table->float('goals')->nullable();
            $table->float('assists')->nullable();
            $table->string('player_name')->nullable();
            $table->boolean('clean_sheet')->nullable();
            $table->float('fantasy_points')->nullable();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->unsignedBigInteger('player_code')->nullable();
            $table->unsignedBigInteger('opponent_id')->nullable();
            $table->unsignedBigInteger('venue_id')->nullable();
            $table->boolean('started_id')->nullable();
            $table->float('player_goals_form')->nullable();
            $table->float('player_assists_form')->nullable();
            $table->float('player_minutes_form')->nullable();
            $table->float('player_ycard_form')->nullable();
            $table->float('player_rcard_form')->nullable();
            $table->float('player_clean_sheet_form')->nullable();
            $table->float('player_fp_form')->nullable();
            $table->float('team_form_rating')->nullable();
            $table->float('opponent_form_rating')->nullable();
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_prediction_inputs');
    }
};
