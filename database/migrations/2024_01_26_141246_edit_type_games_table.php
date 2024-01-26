<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditTypeGamesTable extends Migration
{
    public function up()
    {
        Schema::table('type_games', function (Blueprint $table) {
            $table->string('icon', 200)->nullable();
            $table->string('banner_mobile', 2000)->nullable();
            $table->string('banner_pc', 2000)->nullable();
            $table->integer('recomendado')->nullable();
        });
    }

    public function down()
    {
        Schema::table('type_games', function (Blueprint $table) {
            $table->dropColumn('icon');
            $table->dropColumn('banner_mobile');
            $table->dropColumn('banner_pc');
            $table->dropColumn('recomendado');
        });
    }
}
