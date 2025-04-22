<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transfer_rec_inputs', function (Blueprint $table) {
            $table->bigIncrements('id');
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
            $table->integer('gls')->nullable();
            $table->integer('ast')->nullable();
            $table->integer('g_plus_a')->nullable();
            $table->integer('g_minus_pk')->nullable();
            $table->integer('pk')->nullable();
            $table->integer('pkatt')->nullable();
            $table->integer('crdy')->nullable();
            $table->integer('crdr')->nullable();
            $table->float('xg')->nullable();
            $table->float('npxg')->nullable();
            $table->float('xag')->nullable();
            $table->float('npxg_plus_xag')->nullable();
            $table->integer('prgc')->nullable();
            $table->integer('prgp')->nullable();
            $table->integer('prgr')->nullable();
            $table->float('gls_1')->nullable();
            $table->float('ast_1')->nullable();
            $table->float('g_plus_a_1')->nullable();
            $table->float('g_minus_pk_1')->nullable();
            $table->float('g_plus_a_minus_pk')->nullable();
            $table->float('xg_1')->nullable();
            $table->float('xag_1')->nullable();
            $table->float('xg_plus_xag')->nullable();
            $table->float('npxg_1')->nullable();
            $table->float('npxg_plus_xag_1')->nullable();
            $table->integer('matches')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advanced_player_stats');
    }
};
