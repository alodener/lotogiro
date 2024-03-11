<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataSorteioToBichaoResultadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bichao_resultados', function (Blueprint $table) {
            $table->datetime('data_sorteio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bichao_resultados', function (Blueprint $table) {
            $table->dropColumn('data_sorteio');
        });
    }
}