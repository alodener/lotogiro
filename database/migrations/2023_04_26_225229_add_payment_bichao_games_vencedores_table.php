<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentBichaoGamesVencedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bichao_games_vencedores', function (Blueprint $table) {
            $table->boolean('payment')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bichao_games_vencedores', function (Blueprint $table) {
            $table->dropColumn('payment');
        });
    }
}
