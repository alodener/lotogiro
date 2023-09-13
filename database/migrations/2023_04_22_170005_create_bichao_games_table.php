<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBichaoGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bichao_games', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('modalidade_id');
            $table->foreign('modalidade_id')->references('id')->on('bichao_modalidades');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('horario_id');
            $table->foreign('horario_id')->references('id')->on('bichao_horarios');
            $table->float('valor', 8, 2);
            $table->string('comission_percentage', 255);
            $table->float('comission_value', 8, 2)->default(0);
            $table->boolean('comission_payment')->default(false);
            $table->float('comission_value_pai', 8, 2)->default(0);
            $table->string('game_1', 50)->nullable();
            $table->string('game_2', 50)->nullable();
            $table->string('game_3', 50)->nullable();
            $table->boolean('premio_1')->default(false);
            $table->boolean('premio_2')->default(false);
            $table->boolean('premio_3')->default(false);
            $table->boolean('premio_4')->default(false);
            $table->boolean('premio_5')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bichao_games');
    }
}
