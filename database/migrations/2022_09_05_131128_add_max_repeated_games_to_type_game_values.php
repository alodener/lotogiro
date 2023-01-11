<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaxRepeatedGamesToTypeGameValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('type_game_values', function (Blueprint $table) {
            $table->integer('max_repeated_games')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('type_game_values', function (Blueprint $table) {
            $table->dropcolumn('max_repeated_games');
        });
    }
}
