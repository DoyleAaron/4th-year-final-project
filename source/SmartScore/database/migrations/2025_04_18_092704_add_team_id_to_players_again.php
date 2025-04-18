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
    Schema::table('players', function (Blueprint $table) {
        if (!Schema::hasColumn('players', 'team_id')) {
            $table->foreignId('team_id')->nullable()->constrained()->on('teams')->onDelete('cascade');
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('players', function (Blueprint $table) {
        $table->dropForeign(['team_id']);
        $table->dropColumn('team_id');
    });
}
};
