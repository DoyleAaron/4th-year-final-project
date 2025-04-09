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
    Schema::create('players', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('nation')->nullable();
        $table->string('position')->nullable();
        $table->string('squad')->nullable();
        $table->string('age')->nullable();
        $table->integer('born')->nullable();
        $table->integer('matches_played')->nullable();
        $table->integer('starts')->nullable();
        $table->integer('minutes')->nullable();
        $table->float('goals')->nullable();
        $table->float('assists')->nullable();
        $table->float('xg')->nullable();
        $table->float('npxg')->nullable();
        $table->float('xag')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
