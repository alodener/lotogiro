<?php

use App\Models\System;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTypeTableWithdrawRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('available_withdraw')->nullable()->default(null);
        });

        Schema::table('withdraw_request', function (Blueprint $table) {
            $table->string('type')->nullable()->default(null);
        });

        System::firstOrCreate([
            'nome_config'   => 'Valor Minimo',
            'value'         => '50'
        ]);

        System::firstOrCreate([
            'nome_config'   => 'Horario Maximo',
            'value'         => '22'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('withdraw_request', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
