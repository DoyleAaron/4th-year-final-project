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
    Schema::table('player_prediction_inputs', function (Blueprint $table) {
        $table->unsignedBigInteger('fixture_id')->nullable();
        $table->foreign('fixture_id')->references('id')->on('fixtures')->onDelete('set null');
    });

    Schema::table('goalkeeper_predictions_input', function (Blueprint $table) {
        $table->unsignedBigInteger('fixture_id')->nullable();
        $table->foreign('fixture_id')->references('id')->on('fixtures')->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prediction_inputs', function (Blueprint $table) {
            //
        });
    }
};
