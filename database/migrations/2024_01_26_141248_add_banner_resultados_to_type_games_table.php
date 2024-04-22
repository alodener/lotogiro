<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBannerResultadosToTypeGames extends Migration
{
    public function up()
    {
        Schema::table('type_games', function (Blueprint $table) {
            $table->string('banner_resultados', 2000)->nullable();
        });
    }

    public function down()
    {
        Schema::table('type_games', function (Blueprint $table) {
            $table->dropColumn('banner_resultados');
        });
    }
}
