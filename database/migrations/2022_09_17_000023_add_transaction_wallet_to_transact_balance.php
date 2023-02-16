<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionWalletToTransactBalance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transact_balance', function (Blueprint $table) {
            $table->string('wallet', 50)->default('balance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transact_balance', function (Blueprint $table) {
            $table->dropColumn('wallet');
        });
    }
}
