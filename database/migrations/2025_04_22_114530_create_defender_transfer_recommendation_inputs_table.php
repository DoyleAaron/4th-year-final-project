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
        Schema::create('defender_transfer_recommendation_inputs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rk')->nullable();
            $table->string('player');
            $table->string('nation')->nullable();
            $table->string('pos')->nullable();
            $table->string('squad')->nullable();
 
            $table->integer('born')->nullable();
            $table->float('nineties')->nullable();
            $table->integer('tkl')->nullable();
            $table->integer('tklw')->nullable();
            $table->integer('def_3rd')->nullable();
            $table->integer('mid_3rd')->nullable();
            $table->integer('att_3rd')->nullable();
            $table->integer('tkl_1')->nullable(); 
            $table->integer('att')->nullable();
            $table->float('tkl_pct')->nullable();  
            $table->integer('lost')->nullable();
            $table->integer('blocks')->nullable();
            $table->integer('sh')->nullable();
            $table->integer('pass')->nullable();
            $table->integer('int')->nullable();
            $table->integer('tkl_plus_int')->nullable();
            $table->integer('clr')->nullable();
            $table->integer('err')->nullable();
            $table->integer('matches')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('defender_transfer_recommendation_inputs');
    }
};
