<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOldValueAndValueAToWithdrawRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('withdraw_request', function (Blueprint $table) {
            //
            $table->string('old_value', 100)->after('value');
            $table->string('value_a', 100)->after('old_value');
            $table->string('pagamento_automatico', 4)->after('value_a');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('withdraw_request', function (Blueprint $table) {
            //
        });
    }
}
