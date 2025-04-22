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
        Schema::create('goalkeeper_transfer_recommendation_inputs', function (Blueprint $table) {
            $table->id();
            $table->string('rk')->nullable();
            $table->string('player');
            $table->string('nation')->nullable();
            $table->string('pos')->nullable();
            $table->string('squad')->nullable();
            $table->integer('born')->nullable();
            $table->integer('mp')->nullable();
            $table->integer('starts')->nullable();
            $table->integer('min')->nullable();
            $table->float('nineties')->nullable();
            $table->integer('ga')->nullable();    
            $table->float('ga90')->nullable();   
            $table->integer('sota')->nullable();  
            $table->integer('saves')->nullable();
            $table->float('save_pct')->nullable(); 
            $table->integer('w')->nullable();
            $table->integer('d')->nullable(); 
            $table->integer('l')->nullable(); 
            $table->integer('cs')->nullable(); 
            $table->float('cs_pct')->nullable();
            $table->integer('pkatt')->nullable();
            $table->integer('pka')->nullable();
            $table->integer('pksv')->nullable();
            $table->integer('pkm')->nullable();  
            $table->float('save_pct_2')->nullable();
            $table->integer('matches')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goalkeeper_transfer_recommendation_inputs');
    }
};
