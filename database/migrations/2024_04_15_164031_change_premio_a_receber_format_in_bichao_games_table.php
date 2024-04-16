<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePremioAReceberFormatInBichaoGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bichao_games', function (Blueprint $table) {
            // Alterar a coluna para aceitar formato varchar
            $table->string('premio_a_receber', 10)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bichao_games', function (Blueprint $table) {
            // Reverter a alteração
            $table->decimal('premio_a_receber', 10, 2)->nullable()->change();
        });
    }
}
