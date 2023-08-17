<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPremioMaximoToBichaoModalidades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bichao_modalidades', function (Blueprint $table) {
            $table->float('premio_maximo', 8, 2)->nullable()->after('multiplicador_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bichao_modalidades', function (Blueprint $table) {
            $table->dropColumn('premio_maximo');
        });
    }
}
